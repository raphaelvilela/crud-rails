@extends(config("crud-rails.forms.page-layout"))

@section('content')

    <h1 class="hidden-xs">{{$product_site->name or ""}}
        <small>Lista de {{trans_choice('entities.' . $model_code, 2)}} <a
                    href="{{route($model_code . ".create", ['ongCode' => Route::current()->parameter('ongCode')])}}"
                    class="btn btn-success"><i class="fa fa-plus"></i></a></small>
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
        @foreach($list_config->columns as $column_name)
            <th>{{$column_name}}</th>
        @endforeach
        <th>Ações</th>
        </thead>
        @foreach($paginate_models as $model)
            <tr>
                @foreach($list_config->values($model) as $column_value)
                    <td>{{$column_value}}</td>
                @endforeach
                <td>
                    <a class="btn btn-success btn-sm" href="{{route($model_code . '.edit', ['id' => $model->id])}}">
                        <i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span>
                    </a>
                    <form class="d-inline-block"
                          method="post"
                          action="{{route($model_code . '.destroy',['id'=>$model->id])}}">
                        <input type="hidden" name="_method" value="DELETE"/>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{$paginate_models->links('vendor.pagination.bootstrap-4')}}

@endsection
