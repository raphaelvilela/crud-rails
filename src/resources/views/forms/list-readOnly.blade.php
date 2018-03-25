@extends(config("crud-rails.forms.page-layout"))

@section('content')

    <h1 class="hidden-xs">{{$ong->name or ""}} <small >Lista de {{trans_choice('entities.' . $resource, 2)}}</small></h1>
    @yield('list-table')

@endsection