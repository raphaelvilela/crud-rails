@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $field_config->name, "label" => $field_config->label, "errors" => $errors])
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-lg btn-secondary {{($field_config->value == null || intval($field_config->value) == 1)?"active":""}}">
            <input type="radio" name="{{$field_config->name}}" value="1" {{($field_config->value == null || intval($field_config->value) == 1)?"checked":""}} autocomplete="off">
            <i class="fas fa-check text-white"></i>
            Sim
        </label>
        <label class="btn btn-lg btn-secondary {{($field_config->value != null && intval($field_config->value) == 0)?"active":""}}">
            <input type="radio" name="{{$field_config->name}}" value="0" {{($field_config->value != null && intval($field_config->value) == 0)?"checked":""}} autocomplete="off">
            <i class="fas fa-times text-white"></i>
            Não
        </label>
    </div>
@endcomponent