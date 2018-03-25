@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("adm.forms.formField",["name" => $name, "label" => $label, "errors" => $errors])

    <input id="{{$name}}"
           name="{{$name}}"
           @if(isset($readonly)) readonly='' @endif
           type="text"
           class="form-control"
           data-mask-type="{{$mask or ''}}"
           placeholder="{{$placeholder or ''}}"
           value="{{ (old($name) != null)?old($name):$model[$name] }}"/>

@endcomponent