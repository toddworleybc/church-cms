

@extends('admin.layouts.admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Teaching</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route('teachings.index') }}" class="btn btn-light btns__icon"> <span data-feather="arrow-left-circle"></span> Back To Teachings</a>
    </div>
</div>

@php

    $formErrors = [
    'title' => $errors->get('title'),
    'speaker' => $errors->get('speaker'),
    'staff_id' => $errors->get('staff_id'),
    'video' => $errors->get('video'),
    'audio' => $errors->get('audio'),
    'before_text' => $errors->get('before_text'),
    'after_text' => $errors->get('after_text'),
    'scripture' => $errors->get('scripture'),
    'publish_date' => $errors->get('publish_date'),
    'description' => $errors->get('description'),
    'ft_image' => $errors->get('ft_image')
    ];

@endphp



<teachings-form-component
    form-errors = "{{ json_encode($formErrors) }}"
    staff-members = "{{ json_encode($staffMembers) }}"
    img-path = {{ url('ui-imgs/svgs/select-image.svg') }}
    teaching-data="{{ json_encode($teaching) }}"
    csrf={{ csrf_token() }}
    action={{ route('teachings.update', $teaching->id) }}
></teachings-form-component>



@endsection




