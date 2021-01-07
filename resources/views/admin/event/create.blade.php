@extends('admin.layouts.admin-app')


@section('scripts')
<script src="https://cdn.tiny.cloud/1/yu92hhddx8t10u7t6y7tc30xxexavdzyi8x05s2w89vy1dq4/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script>
@endsection



@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Event</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route('events.index') }}" class="btn btn-light btns__icon"> <span
                data-feather="arrow-left-circle"></span> Back To Events</a>
    </div>
</div>

@php

    $formErrors = [
        'address' => $errors->get('address'),
        'city' => $errors->get('city'),
        'coordinator' => $errors->get('coordinator'),
        'details' => $errors->get('details'),
        'email'    => $errors->get('email'),
        'name' => $errors->get('name'),
        'phone' => $errors->get('phone'),
        'image' => $errors->get('image'),
        'zip'   => $errors->get('zip'),
    ];



@endphp

<event-form-component
    form-errors={{ json_encode($formErrors) }}
    img-path={{ url('ui-imgs/svgs/select-image.svg') }}
    action={{ route('events.store') }}
    csrf={{ csrf_token() }}
></event-form-component>

@endsection
