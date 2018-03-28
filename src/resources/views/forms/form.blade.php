@extends(config("crud-rails.forms.page-layout"))

@section('content')

    <div class="row">
        <div class="ml-md-auto col-md-11 col-12">

            <h1 class="hidden-xs">{{$product_site->name or ""}}
                <small>
                    @if($model->id == null)
                        Registrar {{trans_choice('entities.' . $model_code, 1)}}
                    @else
                        Editar {{trans_choice('entities.' . $model_code, 1)}} (código {{$model->id}})
                    @endif
                </small>
            </h1>

            @yield("navForm")

            <br>

            <form class="form-horizontal form-label-left"
                  role="form"
                  method="POST"
                  enctype="multipart/form-data"
                  action="{{ $action }}">

                {{ csrf_field() }}

                @if($model->id != null)
                    <input type="hidden" name="_method" value="PUT">
                @endif

                @foreach($form_config["fields"] as $field_config)
                    @include($field_config->view_component, ["model" => $model, "field_config" => $field_config])
                @endforeach

                @yield('fields')

                @include("crud-rails::forms.components.submit", ["name" => "form_model_submit"])
            </form>
        </div>
    </div>

@endsection
