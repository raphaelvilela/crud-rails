<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{$name}}" class="control-label col-md-3 col-sm-3 col-12">{{$label or trans('validation.attributes.' . $name)}}</label>
    <div class="col-12">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input id="{{$name}}" name="{{$name}}" type="text" class="form-control" data-mask-type="money"
                   value="{{ (old($name)!= null)?old($name):$model[$name] }}"/>
        </div>
        @if ($errors->has($name))
            <span class="text-danger">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>