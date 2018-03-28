@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $field_config->name, "label" => $field_config->label, "errors" => $errors])

    @if(isset($field_config->photo->mini_url))
        <img class="img-fluid img-thumbnail" src="{{$field_config->photo->mini_url}}"/>
    @endif

    <input type="file" name="photo" id="photo" class="form-control" value="{{old("photo")}}"/>
    <input type="hidden" name="{{$field_config->name}}" id="{{$field_config->name}}"
           value="{{ (old($field_config->name) != null)?old($field_config->name):$field_config->value }}"/>
@endcomponent