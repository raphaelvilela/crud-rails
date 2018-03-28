@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $field_config->name, "label" => $field_config->label, "errors" => $errors])
    <input id="{{$field_config->name}}"
           name="{{$field_config->name}}"
           type="text"
           class="form-control"
           data-mask-type="{{$field_config->mask or ''}}"
           placeholder="{{$field_config->placeholder or ''}}"
           value="{{ (old($field_config->value) != null)?old($field_config->value):$field_config->value }}"/>
@endcomponent