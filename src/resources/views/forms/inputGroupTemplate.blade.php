@extends("crud-rails::forms.inputTemplate")
<div class="input-group">
    <div class="input-group-addon hidden-sm-down" style="width: 2.6rem"><i
                class="fa fa-map-marker"></i></div>
    <input id="cep" name="cep" type="text" class="form-control" maxlength="10" required autofocus data-mask-type="cep"
           value="{{ (session('cep') !== null)?session('cep'):($user->addresses()->first())?$user->addresses()->first()->cep:old('cep') }}">
    <div class="input-group-btn" style="width: 2.6rem">
        <btn class="btn btn-success" id="cep_go"><i class="fa fa-arrow-right"></i></btn>
    </div>
</div>