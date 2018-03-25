<div id="photo-row" class="form-group{{ $errors->has("photo") ? ' has-error' : '' }}">
    <label for="photo" class="control-label col-md-3 col-sm-3 col-12">{{$label or trans('validation.attributes.photo')}}</label>

    <div class="col-12">
        <input type="file" name="photo" id="photo" class="d-none form-control" value="{{old("photo")}}"/>
        <input type="hidden" name="{{$name}}" id="{{$name}}" class="form-control"
               value="{{ $model[$name] or old($name) }}"/>
        <div class="input-group">

            <input id="photo_callback" class="upload_row_button form-control full-heigth"
                   value="{{(isset($model->photo->name)?$model->photo->name:'Sem foto')}}" placeholder="Vazio"/>

            <a href="javascript:void(0)" class="upload_row_button btn input-group-addon"
               onclick="showFileInputDialog('photo', 'photo_callback');">
                <i class="fas fa-cloud-upload-alt fa-2x"></i>&nbsp;
                <span>Enviar do <br/>computador</span>
            </a>

            <a href="javascript:void(0)" class="upload_row_button btn input-group-addon"
               onclick="showFileInputFromGaleryDialog('photo_id', 'photo_callback');">
                <i class="far fa-image fa-2x"></i>&nbsp;
                <span>Escolher <br/>da Galeria</span>
            </a>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if ($errors->has("photo"))
                <span class="text-danger" id="photo-text-danger">
                <strong>{{ $errors->first("photo") }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
@include('adm.forms.galeryModal', ['tagId' => $tagId])