@extends('admin.layouts.admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Teaching</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route('teachings.index') }}" class="btn btn-light btns__icon"> <span data-feather="arrow-left-circle"></span> Back To Teachings</a>
    </div>
</div>



<teachings-form-component
     csrf = {{ csrf_token() }}
     action = {{ route('teachings.store') }}
></teachings-form-component>



@endsection
