@extends('../layouts/admin/admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Teachings</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route("teachings.create") }}" class="btn btn-light btns__icon"> <span data-feather="plus-circle"></span> New Teaching</a>
    </div>
</div>


<teaching-table-component teachings-data="{{ json_encode($teachings) }}"></teaching-table-component>




@endsection
