@extends(config("crud-rails.forms.page-layout"))

@section('content')

    <h1 class="hidden-xs">{{$product_site->name or ""}}
        <small>Lista de {{trans_choice('entities.' . $model_code, 2)}}</small>
    </h1>

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

    <table class="table table-sm table-striped">
        <thead>
        @foreach($list_config["columns"] as $column_name)
            <th>{{$column_name}}</th>
        @endforeach
        </thead>
        @foreach($paginate_models as $model)
            <tr>
                @foreach((  ($list_config["values"])($model)) as $column_value)
                    <td>{{$column_value}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>

    {{$paginate_models->links(config("crud-rails.forms.pagination-layout"))}}

@endsection