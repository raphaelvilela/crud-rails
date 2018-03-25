<?php

namespace RaphaelVilela\CrudRails\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;
use Illuminate\Http\Request;

abstract class ModelController extends Controller
{
    public static $VIEW_RESPONSE_TYPE = "view";
    public static $JSON_RESPONSE_TYPE = "json";

    var $model;
    var $model_code;
    var $can_upload_file;
    var $response_type;
    var $model_views_path;

    private function extractCode($resouceClass)
    {
        $model_name_parts = explode("\\", $resouceClass);
        $model_name = array_pop($model_name_parts);
        $model_name = preg_replace('/([A-Z])/', ' $1', $model_name);
        return strtolower(str_replace(" ", "_", trim($model_name)));
    }

    function __construct($resouceClass, $canUploadFile = false)
    {
        $this->middleware('auth');
        $this->model = new $resouceClass;
        $this->model_code = $this->extractCode($resouceClass);
        $this->can_upload_file = $canUploadFile;
        $this->response_type = self::$VIEW_RESPONSE_TYPE;
        $this->model_views_path = 'adm.resources.' . $this->model_code;
    }

    public function setResponseType($response_type)
    {
        $this->response_type = $response_type;
    }

    protected function decorateView(Request $request, $view)
    {
        return $view;
    }

    public function paginate()
    {
        return $this->model->paginate(50);
    }

    public function index(Request $request)
    {
        $this->checkIndexGate($request);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            $view = view($this->model_views_path . '.index')
                ->with("paginate_models", $this->paginate())
                ->with("model_code", $this->model_code);
            return $this->decorateView($request, $view);
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json($this->model);
        }
    }

    public function edit(Request $request, $id)
    {

        $this->model = $this->model->find($id);
        $this->unmountModel($request, $this->model);

        $this->checkEditGate($request);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            $view = view($this->model_views_path . '.form')
                ->with("model", $this->model)
                ->with("model_code", $this->model_code)
                ->with("action", route($this->model_code . ".update", ['id' => $id]));
            return $this->decorateView($request, $view);
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json($this->model);
        }
    }

    public function show(Request $request, $id)
    {
        return $this->edit($request, $id);

    }


    public function checkCreateGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    public function beforeCreate(Request $request)
    {
    }

    public function create(Request $request)
    {
        $this->beforeCreate($request);
        $this->checkCreateGate($request);

        $view = view($this->model_views_path . ".form")
            ->with("model", $this->model)
            ->with("model_code", $this->model_code)
            ->with("action", route($this->model_code . ".store"));

        return $this->decorateView($request, $view);
    }

    public function beforeStore(Request $request)
    {
    }

    public function beforeMount(Request $request)
    {
    }

    public function mountModel(Request $request)
    {
        $except = $this->model->autoSyncFields;

        //Verifica se existem campos vazios que são foreign keys.
        $nullRelations = [];
        foreach ($request->all() as $key => $parameter) {
            if (($parameter == '') && strpos($key, "_id") == true) {
                $except[] = $key;
                $nullRelations[] = $key;
            }
        }

        $except[] = 'photo';
        $this->model->fill($request->except($except));

        //Altera pra null o valor dos relacionamentos vazios.
        foreach ($nullRelations As $nullRelation) {
            $this->model[$nullRelation] = null;
        }

        //Modelo pode receber arquivos?
        if ($this->can_upload_file) {

            //Foi enviado uma nova foto válida?
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photo = PhotoRepository::createPhotoFromLocalFile($request->file('photo'), "/photos");
                $this->model->photo_id = $photo->id;
            }
        }
    }

    public function unmountModel(Request $request)
    {

    }

    public function checkStoreGate(Request $request)
    {
    }

    public function store(Request $request)
    {
        if (isset($this->model->rules)) {
            $this->validate($request, $this->model->rules);
        }

        $this->beforeMount($request);
        $this->mountModel($request);
        $this->beforeStore($request);

        //Verifica se existe permissão para criar model.
        $this->checkStoreGate($request);

        $this->model->save();

        if (isset($this->model->autoSyncFields)) {
            foreach ($this->model->autoSyncFields as $field) {
                $valuesToSync = $request->only([$field])[$field];
                if ($valuesToSync != null) {
                    call_user_func(array($this->model, $field))->sync($valuesToSync);
                }
            }
        }

        $this->afterStore($request);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            return redirect()->route($this->model_code . '.index')
                ->with("success", trans('actions.entity.created', ['entity' => trans_choice('entities.' . $this->model_code, 1)]));
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json([
                    'status' => 'success',
                    'msg' => trans('actions.entity.created', ['entity' => trans_choice('entities.' . $this->model_code, 1)])
                ]
            );
        }
    }

    public function afterStore(Request $request)
    {
    }
    public function beforeDestroy(Request $request)
    {
    }
    public function afterDestroy(Request $request)
    {
    }

    public function beforeUpdate(Request $request)
    {
    }

    public function afterUpdate(Request $request)
    {
    }

    public function checkIndexGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    public function checkEditGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    public function checkUpdateGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->model->rules);

        $this->model = $this->model->find($id);
        $this->mountModel($request);
        $this->beforeUpdate($request);

        $this->checkUpdateGate($request);

        $this->model->save();

        if (isset($this->model->autoSyncFields)) {
            foreach ($this->model->autoSyncFields as $field) {
                $valuesToSync = $request->only([$field])[$field];
                if ($valuesToSync != null) {
                    call_user_func(array($this->model, $field))->sync($valuesToSync);
                }
            }
        }

        $this->afterUpdate($request);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            return redirect()->route($this->model_code . '.index')
                ->with("success", trans('actions.entity.updated', ['entity' => trans_choice('entities.' . $this->model_code, 1)]));
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json([
                    'status' => 'success',
                    'msg' => trans('actions.entity.updated', ['entity' => trans_choice('entities.' . $this->model_code, 1)])
                ]
            );
        }

    }

    public function checkDestroyGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para destroy.
        return $this->checkStoreGate($request);
    }

    public function destroy(Request $request, $id)
    {
        $this->model = $this->model->find($id);
        $this->checkDestroyGate($request);

        $this->beforeDestroy($request);
        $this->model->delete();
        $this->afterDestroy($request);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            return redirect()->route($this->model_code . '.index')
                ->with("success", trans('actions.entity.deleted', ['entity' => trans_choice('entities.' . $this->model_code, 1)]));
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json([
                    'status' => 'success',
                    'msg' => trans('actions.entity.deleted', ['entity' => trans_choice('entities.' . $this->model_code, 1)])
                ]
            );
        }

    }
}
