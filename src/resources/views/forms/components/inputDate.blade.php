@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $field_config->name, "label" => $field_config->label, "errors" => $errors])
    <input id="{{$field_config->name}}" name="{{$field_config->name}}" type="text" class="form-control" data-mask-type="date" value="{!! (old($field_config->name) != null)?old($field_config->name):$field_config->value  !!}">
@endcomponent