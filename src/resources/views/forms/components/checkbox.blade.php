
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{$name}}"
		class="control-label col-md-3 col-sm-3 col-12">{{$label or
		trans('validation.attributes.' . $name)}}</label>
	<div class="col-12">
		<div>
			
			@foreach( $options as $key => $option )
				<label class="checkbox{{ (isset($inline) && $inline === true)?'-inline':''}}">
					<input type="checkbox" value="{{$key}}" name="{{$name}}[]" {{ in_array($key, isset($model)?(($model[$name])->pluck(['id'])->toArray()):[])?'checked="checked"':''}}/> {{$option}}
				</label>
			@endforeach
			
		</div>
		@if ($errors->has($name)) 
			<span class="text-danger"> <strong>
				{{ $errors->first($name) }}</strong>
			</span> 
		@endif
	</div>
</div>