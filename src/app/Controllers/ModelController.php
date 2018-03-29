<?php

namespace RaphaelVilela\CrudRails\App\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RaphaelVilela\CrudRails\App\Repositories\PhotoRepository;

abstract class ModelController extends Controller
{
    public static $VIEW_RESPONSE_TYPE = "view";
    public static $JSON_RESPONSE_TYPE = "json";

    var $model;
    var $model_code;
    var $response_type;
    var $model_views_path;

    function __construct($resouceClass, $response_type = null)
    {
        $this->model = new $resouceClass;
        $this->model_code = $this->extractCode($resouceClass);

        if ($response_type == null) {
            $this->response_type = self::$VIEW_RESPONSE_TYPE;
        } else {
            $this->response_type = $response_type;
        }

        $this->model_views_path = config('crud-rails.forms.views-path') . '.' . $this->model_code;
    }

    /**
     * Define o código do modelo a ser utilizado com base em sua classe.
     * @param $resouceClass
     * @return string
     */
    private function extractCode($resouceClass)
    {
        $model_name_parts = explode("\\", $resouceClass);
        $model_name = array_pop($model_name_parts);
        $model_name = preg_replace('/([A-Z])/', ' $1', $model_name);
        return strtolower(str_replace(" ", "_", trim($model_name)));
    }

    /**
     * Ponto de extensão que permite adicionar parâmetros à view.
     * @param Request $request
     * @param $view
     * @return mixed
     */
    protected function decorateView(Request $request, $view)
    {
        return $view;
    }

    /**
     * Converte uma requisição em um objeto modelo.
     * @param Request $request
     */
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

        //O modelo possui uma foto?
        if (method_exists($this->model, "photo")) {

            //Foi enviado uma nova foto válida?
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

                //Armazena foto no repositório.
                $photo = PhotoRepository::createPhotoFromLocalFile($request->file('photo'), "/photos");
                $this->model->photo_id = $photo->id;
            }
        }
    }

    /**
     * Ponto de extenção que permite executar comandos antes de montar o objeto modelo.
     * @param Request $request
     */
    public function beforeMount(Request $request)
    {
    }

    /**
     * Converte um objeto modelo em atributos da requisição.
     * @param Request $request
     */
    public function unmountModel(Request $request)
    {

    }


    //################## INDEX BLOCK ################################//

    /**
     * Lista os registros.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->checkIndexGate($request);
        $paginate = $this->paginate($request);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            $view = view($this->getIndexViewName())
                ->with("paginate_models", $paginate)
                ->with("model_code", $this->model_code)
                ->with("list_config", $this->configureList($request));
            return $this->decorateView($request, $view);
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json($paginate);
        }
    }

    /**
     * Ponto de extensão que permite substituir a view utilizada no comando Index.
     * @return string
     */
    public function getIndexViewName(){
        return "crud-rails::forms.list";
    }

    /**
     * Realiza a paginação dos Elementos a serem exibidos na listagem.
     * Caso existam filtros, deve-se aplicá-los aqui.
     * @return mixed
     */
    public function paginate(Request $request)
    {
        return $this->model->paginate(50);
    }

    /**
     * Verifica se requisição possui permissão de listagem de registros.
     * @param Request $request
     */
    public function checkIndexGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    /**
     * Configura a lista de registros.
     * @param Request $request
     * @return array
     */
    public abstract function configureList(Request $request): array;

    //################## EDIT BLOCK ################################//

    /**
     * Exibe formulário de edição do registro.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $this->model = $this->model->find($id);

        $this->checkEditGate($request);

        $this->unmountModel($request, $this->model);

        if ($this->response_type == self::$VIEW_RESPONSE_TYPE) {
            $view = view("crud-rails::forms.form")
                ->with("form_config", $this->configureEditForm($request))
                ->with("model", $this->model)
                ->with("model_code", $this->model_code)
                ->with("action", route($this->model_code . ".update", ['id' => $id]));
            return $this->decorateView($request, $view);
        }

        if ($this->response_type == self::$JSON_RESPONSE_TYPE) {
            return response()->json($this->model);
        }
    }

    /**
     * Verifica se a requisição possui permissão para editar o registro.
     * @param Request $request
     */
    public function checkEditGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    /**
     * Configura o formulário de edição do CRUD.
     * @param Request $request
     * @return array
     */
    public function configureEditForm(Request $request): array
    {
        return $this->configureCreateForm($request);
    }

    //################## SHOW BLOCK ################################//

    /**
     * Exibe os dados do registro.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $this->checkShowGate($request);
        return $this->edit($request, $id);
    }

    /**
     * Verifica se requisição possui permissão para exibir o registro.
     * @param Request $request
     */
    public function checkShowGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    /**
     * Configura o formulário de criação do CRUD.
     * @param Request $request
     * @return array
     */
    public abstract function configureCreateForm(Request $request): array;

    //################## CREATE BLOCK ################################//

    /**
     * Exibe formulário de criação do registro.
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $this->checkCreateGate($request);
        $this->beforeCreate($request);

        $view = view("crud-rails::forms.form")
            ->with("form_config", $this->configureCreateForm($request))
            ->with("model", $this->model)
            ->with("model_code", $this->model_code)
            ->with("action", route($this->model_code . ".store"));

        return $this->decorateView($request, $view);
    }

    /**
     * Verifica se requisição possui permissão para criar registro.
     * @param Request $request
     */
    public function checkCreateGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    /**
     * Ponto de extenção que permite executar comandos antes da ação do método create.
     * @param Request $request
     */
    public function beforeCreate(Request $request)
    {
    }


    //################## STORE BLOCK ################################//

    /**
     * Salva um novo registro.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateStoreRequest($request);
        $this->beforeMount($request);
        $this->mountModel($request);
        $this->beforeStore($request);

        //Verifica se existe permissão para criar registro.
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

    /**
     * Verifica se requisição possui permissão para armazenar novo registro.
     * @param Request $request
     */
    public function checkStoreGate(Request $request)
    {
    }

    /**
     * Ponto de extenção que permite executar comandos antes da ação do método store.
     * @param Request $request
     */
    public function beforeStore(Request $request)
    {
    }

    /**
     * Ponto de extenção que permite executar comandos após da ação do método store.
     * @param Request $request
     */
    public function afterStore(Request $request)
    {
    }

    /**
     * Ponto de extenção que permite definir validações da requisição antes da ação do método store.
     * @param Request $request
     */
    public abstract function validateStoreRequest(Request $request);


    //################## UPDATE BLOCK ################################//

    /**
     * Atualiza um registro.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validateUpdateRequest($request);
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

    /**
     * Verifica se requisição possui permissão para atualizar o registro.
     * @param Request $request
     */
    public function checkUpdateGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para update.
        return $this->checkStoreGate($request);
    }

    /**
     * Ponto de extenção que permite executar comandos antes da ação do método update.
     * @param Request $request
     */
    public function beforeUpdate(Request $request)
    {
    }

    /**
     * Ponto de extenção que permite executar comandos após da ação do método store.
     * @param Request $request
     */
    public function afterUpdate(Request $request)
    {
    }

    /**
     * Ponto de extenção que permite definir validações da requisição antes da ação do método update.
     * @param Request $request
     */
    public function validateUpdateRequest(Request $request){
        //Como padrão é usado a mesma regra de validação da criação.
        return $this->validateStoreRequest($request);
    }


    //################## DESTROY BLOCK ################################//

    /**
     * Apaga um registro.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Verifica se requisição possui permissão para apagar o registro.
     * @param Request $request
     */
    public function checkDestroyGate(Request $request)
    {
        //Utiliza o mesmo GATE de store para destroy.
        return $this->checkStoreGate($request);
    }

    /**
     * Ponto de extenção que permite executar comandos antes da ação do método destroy.
     * @param Request $request
     */
    public function beforeDestroy(Request $request)
    {
    }

    /**
     * Ponto de extenção que permite executar comandos após da ação do método destroy.
     * @param Request $request
     */
    public function afterDestroy(Request $request)
    {
    }

}
