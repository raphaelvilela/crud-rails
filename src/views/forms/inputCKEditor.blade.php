@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("adm.forms.formField",["name" => $name, "label" => $label, "errors" => $errors])
    <textarea
            id="{{$name}}"
            name="{{$name}}"
            type="text"
            class="form-control"
            data-mask-type="{{$mask or ''}}"
            placeholder="{{$placeholder or ''}}"
            rows="10">{{ (old($name) != null)?old($name):$model[$name] }}</textarea>
@endcomponent

@push("onLoadScript")
    CKEDITOR.replace('{{$name}}', {
        customConfig: '/js/adm/ckeditor-config.js'
    });
@endpush