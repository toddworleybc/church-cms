@extends('admin.layouts.admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Members</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route("staff.create") }}" class="btn btn-light btns__icon"> <span data-feather="plus-circle"></span> New Staff Member</a>
    </div>
</div>



@if (count($staffAll))


<staff-table-component
staff = "{{ json_encode($staffAll) }}"
></staff-table-component>

@else

<div class="bg-light px-2 py-4 text-secondary">
    Create Your First Staff Member!
</div>

@endif





{{-- Teaching Example --}}
{{-- @if (count($teachingsAll))
<teaching-table-component teachings-data="{{ json_encode($teachingsAll) }}"></teaching-table-component>
<div class="d-flex justify-content-end border-top">
    <div class="my-4">
        {{ $teachings->links() }}
    </div>
</div>
@else
<div class="bg-light px-2 py-4 text-secondary">
    Create Your First Teaching!
</div>
@endif --}}





@endsection
