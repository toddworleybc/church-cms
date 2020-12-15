@extends('admin.layouts.admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Events</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route("events.create") }}" class="btn btn-light btns__icon"> <span data-feather="plus-circle"></span>
            New Event</a>
    </div>
</div>




@endsection
