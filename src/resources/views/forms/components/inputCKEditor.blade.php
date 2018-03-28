@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $field_config->name, "label" => $field_config->label, "errors" => $errors])
    <textarea
            id="{{$field_config->name}}"
            name="{{$field_config->name}}"
            type="text"
            class="form-control"
            placeholder="{{$field_config->placeholder or ''}}"
            rows="10">{!! (old($field_config->value) != null)?old($field_config->value):$field_config->value  !!}</textarea>
@endcomponent

@push("onLoadScript")
    CKEDITOR.replace('{{$name}}', {
        customConfig: '/js/adm/ckeditor-config.js'
    });
@endpush