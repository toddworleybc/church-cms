@extends('admin.layouts.admin-app')



@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Staff Member</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route('staff.index') }}" class="btn btn-light btns__icon"> <span
                data-feather="arrow-left-circle"></span> Back To Staff Members</a>
    </div>
</div>
@php
    $formErrors = [
        'name'     => $errors->get('name'),
        'position' => $errors->get('position'),
        'bio'      => $errors->get('bio'),
        'image'    => $errors->get('image')
    ];

    $teachingsCount = count($staffMember->teachings->all());

@endphp


<staff-form-component
    form-errors = "{{ json_encode($formErrors) }}"
    staff-data = "{{ json_encode($staffMember) }}"
    img-path={{ url('ui-imgs/svgs/select-image.svg') }}
    action={{ route('staff.update', $staffMember->id) }}
    csrf={{ csrf_token() }}
    teachings-count = {{ $teachingsCount }}
></staff-form-component>



@endsection
