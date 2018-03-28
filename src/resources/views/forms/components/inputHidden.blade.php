<input type="hidden"
       name="{!! $field_config->name !!}"
       value="{{ (old($field_config->name) != null)?old($field_config->name):$field_config->value }}"/>