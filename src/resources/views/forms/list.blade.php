@extends(config("crud-rails.forms.page-layout"))

@section('content')

    <h1 class="hidden-xs">{{$product_site->name or ""}}
        <small>Lista de {{trans_choice('entities.' . $model_code, 2)}}
            <a href="{{route($model_code . ".create")}}" class="btn btn-success">
                <i class="fa fa-plus"></i>
            </a>
        </small>
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
        <th>Ações</th>
        </thead>
        @foreach($paginate_models as $model)
            <tr>
                @foreach((  ($list_config["values"])($model)) as $column_value)
                    <td>{{$column_value}}</td>
                @endforeach

                <td>
                    @foreach($list_config["actions"] as $action)

                        @switch($action["method"])

                            @case("GET")
                            <a class="{!! $action["btn-class"] !!}" title="{!! $action["hint"] or  $action["label"] !!}"
                               href="{!! route($model_code . '.' . $action["model-route"], ["id" => $model->id]) !!}">
                                <i class="{!! $action["icon-class"] !!}"></i>
                                <span class="{!! config('crud-rails.layout-utils.hide-mobile-class') !!}">
                                        {!! $action["label"] !!}
                                    </span>
                            </a>
                            @break

                            @case("POST")
                            <form class="{!! $action["form-class"] !!}"
                                  method="POST"
                                  action="{!! route($model_code . '.' . $action["model-route"], ["id" => $model->id]) !!}">
                                {{ csrf_field() }}
                                <button type="submit" class="{!! $action["btn-class"] !!}">
                                    <i class="{!! $action["icon-class"] !!}"  title="{!! $action["hint"] or  $action["label"] !!}"></i>
                                    <span class="{!! config('crud-rails.layout-utils.hide-mobile-class') !!}">
                                            {!! $action["label"] !!}
                                        </span>
                                </button>
                            </form>
                            @break

                            @case("DELETE")
                            <form class="{!! $action["form-class"] !!}"
                                  method="POST"
                                  action="{!! route($model_code . '.' . $action["model-route"], ["id" => $model->id]) !!}">
                                <input type="hidden" name="_method" value="DELETE"/>
                                {{ csrf_field() }}
                                <button type="submit" class="{!! $action["btn-class"] !!}">
                                    <i class="{!! $action["icon-class"] !!}"></i>
                                    <span class="{!! config('crud-rails.layout-utils.hide-mobile-class') !!}">
                                            {!! $action["label"] !!}
                                        </span>
                                </button>
                            </form>
                            @break

                        @endswitch

                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    {{$paginate_models->links(config("crud-rails.forms.pagination-layout"))}}

@endsection