@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("adm.forms.formField",["name" => $name, "label" => $label, "errors" => $errors])

    <div class="{{isset($newAction)?"input-group":""}}">
        <select class='form-control' id='{{$name}}' name='{{$name}}'>
            <option value=""></option>
            @foreach( $options as $key => $option )
                <option value="{!! $key  !!}" {{((old($name) != null && old($name) == $key) || (isset($model) && $model[$name] == $key))?'selected="selected"':''}}>{!! $option !!}
                </option>
            @endforeach
        </select>
        @if(isset($newAction))
            <a href="{{$newAction}}" class="input-group-addon btn btn-primary btn-sm">+</a>
        @endif
    </div>

@endcomponent