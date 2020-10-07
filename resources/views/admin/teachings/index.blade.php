@extends('../layouts/admin/admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Teachings</h1>
    <div>
        <button class="btn btn-light btns__icon"> <span data-feather="plus-circle"></span> New Teaching</button>
    </div>
</div>



<teachings-create-component
     csrf = {{ csrf_token() }}
     action = {{ route('teachings.store') }}
></teachings-create-component>



@endsection
