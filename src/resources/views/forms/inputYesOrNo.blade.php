@php ($label = (isset($label)?$label:null))
@php ($errors = (isset($errors)?$errors:null))
@component("crud-rails::forms.formField",["name" => $name, "label" => $label, "errors" => $errors])
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-lg btn-secondary {{(($model[$name] !== 0)?"active":"")}}">
            <input type="radio" name="{{$name}}" value="1" {{(($model[$name] !== 0)?"checked":"")}} autocomplete="off">
            <i class="fas fa-check text-white"></i>
            Sim
        </label>
        <label class="btn btn-lg btn-secondary {{(($model[$name] === 0)?"active":"")}}">
            <input type="radio" name="{{$name}}" value="0" {{(($model[$name] === 0)?"checked":"")}} autocomplete="off">
            <i class="fas fa-times text-white"></i>
            Não
        </label>
    </div>
@endcomponent