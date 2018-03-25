{{--

    Este input deve ser utilizado quando existem 2 campos na tabela:
     um para data, que segue o padrão de nomenclatura FIELD_date
     um para hora, que segue o padrão de nomenclatura FIELD_hour

    É necessário que o controller possua um mutator para ajustar o
    formato da data, pois ele sempre será enviado no formato brasileiro.

--}}
<div class="form-group{{ ($errors->has($name. '_date') || $errors->has($name. '_hour'))  ? ' has-error' : '' }}">

    <label for="{{$name}}"
           class="control-label col-md-3 col-sm-3 col-12">{{$label or trans('validation.attributes.' . $name)}}</label>
    <div class="col-md-6 col-12">
        <div class="input-group">
            <div class="input-group-addon hidden-sm-down" style="width: 2.6rem"><i
                        class="fa fa-calendar"></i></div>

            <input id="{{$name}}_date" name="{{$name}}_date" type="text" class="form-control" data-mask-type="date"
                   value="{{ (old($name . '_date') != null)?old($name . '_date'):$model[$name . '_date']}}">


            <select id="{{$name}}_hour" name="{{$name}}_hour" class="form-control">
                <option value="{{ (isset($model)?$model[$name . '_hour']:old($name . '_hour')) }}">{{ (old($name . '_hour') != null)?old($name . '_hour'):$model[$name . '_hour']}}</option>
                <option value="06:00">06:00</option>
                <option value="06:30">06:30</option>
                <option value="07:00">07:00</option>
                <option value="07:30">07:30</option>
                <option value="08:00">08:00</option>
                <option value="08:30">08:30</option>
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
                <option value="18:30">18:30</option>
                <option value="19:00">19:00</option>
                <option value="19:30">19:30</option>
                <option value="20:00">20:00</option>
                <option value="20:30">20:30</option>
                <option value="21:00">21:00</option>
                <option value="21:30">21:30</option>
                <option value="22:00">22:00</option>
                <option value="22:30">22:30</option>
                <option value="23:00">23:00</option>
                <option value="23:30">23:30</option>
                <option value="00:00">00:00</option>
                <option value="00:30">00:30</option>
                <option value="01:00">01:00</option>
                <option value="01:30">01:30</option>
                <option value="02:00">02:00</option>
                <option value="02:30">02:30</option>
                <option value="03:00">03:00</option>
                <option value="03:30">03:30</option>
                <option value="04:00">04:00</option>
                <option value="04:30">04:30</option>
                <option value="05:00">05:00</option>
                <option value="05:30">05:30</option>
            </select>
        </div>
    </div>

    <div class="col-md-offset-3 col-md-6 col-12">
        @if ($errors->has($name . '_date'))
            <span class="text-danger">
                    <strong>{{ $errors->first($name . '_date') }}</strong>
            </span>
        @endif
        @if ($errors->has($name . '_hour'))
            <span class="text-danger">
                    <strong>{{ $errors->first($name . '_hour') }}</strong>
            </span>
        @endif
    </div>
</div>
