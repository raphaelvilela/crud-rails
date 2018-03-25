@extends('adm.themes.' . config("ui.admin.theme") . '.layout')

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

                @yield('fields')
            </form>
        </div>
    </div>

@endsection
