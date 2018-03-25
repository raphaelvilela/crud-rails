
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{$name}}"
		class="control-label col-md-3 col-sm-3 col-12">{{$label or
		trans('validation.attributes.' . $name)}}</label>
	<div class="col-12">
		<div>
			<select id="example-getting-started" multiple="multiple" name="{{$name}}[]" class="bootstrap-multi-select ">
				@foreach( $options as $key => $option )
				    <option value="{{$key}}" {{ in_array($key,  array_merge((old($name) != null)?old($name):[], isset($model[$name])?(($model[$name])->pluck(['id'])->toArray()):[]))?'selected="selected"':''}}>{{$option}}</option>
				@endforeach
			</select>
		</div>
		@if ($errors->has($name)) 
			<span class="text-danger">
			<strong>{{ $errors->first($name) }}</strong>
			</span> 
		@endif
	</div>
</div>