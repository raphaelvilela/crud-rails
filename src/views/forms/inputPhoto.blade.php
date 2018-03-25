@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("adm.forms.formField",["name" => $name, "label" => $label, "errors" => $errors])

    @if(isset($model->photo->mini_url))
        <img class="img-fluid img-thumbnail" src="{{$model->photo->thumb_url}}"/>
    @endif

    <input type="file" name="photo" id="photo" class="form-control" value="{{old("photo")}}"/>
    <input type="hidden" name="{{$name}}" id="{{$name}}" value="{{ $model[$name] }}"/>
@endcomponent