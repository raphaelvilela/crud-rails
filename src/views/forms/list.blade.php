@extends('adm.themes.' . config("ui.admin.theme") . '.layout')

@section('content')

    <h1 class="hidden-xs">{{$product_site->name or ""}} <small >Lista de {{trans_choice('entities.' . $model_code, 2)}} <a href="{{route($model_code . ".create", ['ongCode' => Route::current()->parameter('ongCode')])}}" class="btn btn-success"><i class="fa fa-plus"></i></a></small></h1>

    @if (session()->has('success'))
        <div class="alert alert-success animated fadeIn">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
                {!! session()->get('success') !!}
            </strong>
        </div>
    @endif

    @if (session()->has('errors'))
        <div class="alert alert-danger animated fadeIn">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
                {!! session()->get('errors') !!}
            </strong>
        </div>
    @endif

    {{$paginate_models->links('vendor.pagination.bootstrap-4')}}
    @yield('list-table')
    {{$paginate_models->links('vendor.pagination.bootstrap-4')}}

@endsection
