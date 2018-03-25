<div class="form-group">
    <label for="{{$name}}" class="control-label col-12 {{ $errors->has($name) ? '  is-invalid' : '' }}">
        {{$label or trans('validation.attributes.' . $name)}}
    </label>
    <div class="col-12">
        {{$slot}}
        @if ($errors->has($name))
            <p class="text-danger p-2">
                <strong>{{ $errors->first($name) }}</strong>
            </p>
        @endif
    </div>
</div>
