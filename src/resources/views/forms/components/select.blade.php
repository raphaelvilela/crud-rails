@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $field_config->name, "label" => $field_config->label, "errors" => $errors])

    <div class="{{isset($newAction)?"input-group":""}}">
        <select class='form-control' id='{{$field_config->name}}' name='{{$field_config->name}}'>
            <option value=""></option>
            @foreach( $field_config->options as $key => $option )
                <option
                        value="{!! $key  !!}"
                        {{(
                            (old($field_config->name) != null && old($field_config->name) == $key) ||
                            (isset($field_config->value) && $field_config->value == $key))?'selected="selected"':''}}>
                    {!! $option !!}
                </option>
            @endforeach
        </select>
        @if(isset($newAction))
            <a href="{{$newAction}}" class="input-group-addon btn btn-primary btn-sm">+</a>
        @endif
    </div>

@endcomponent