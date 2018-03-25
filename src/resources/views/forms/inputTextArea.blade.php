<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{$name}}" class="control-label col-12">{{$label or trans('validation.attributes.' . $name)}}</label>
    <div class="col-12">
        <textarea
                id="{{$name}}"
                name="{{$name}}"
                type="text"
                class="form-control"
                data-mask-type="{{$mask or ''}}"
                placeholder="{{$placeholder or ''}}"
                rows="10">{{ (old($name) != null)?old($name):$model[$name] }}</textarea>
        @if ($errors->has($name))
            <span class="text-danger">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>