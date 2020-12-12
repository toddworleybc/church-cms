@extends('admin.layouts.admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Members</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route("staff.create") }}" class="btn btn-light btns__icon"> <span data-feather="plus-circle"></span> New Staff Member</a>
    </div>
</div>

@php
    $positions = [];

    foreach ($staffPositions as $position) {
        $positions[] = $position;
    }


    // fix pagintion range top of the table to the left - blue box
    $showRange = ($staffMembers->lastItem() - $staffMembers->count()) + 1;
@endphp



@if (count($staffMembers->items()))

<div class="admin-table__pag-filters">
    <p class="alert alert-info">Showing {{ $showRange }} - {{ $staffMembers->lastItem() }} staff members out of
    {{ $staffMembers->total() }}</p>
    <staff-filter-component
    staff-positions = "{{ json_encode($positions) }}"
    filter = "{{ $filter }}"
    order-by = "{{ $orderBy }}"
    direction = "{{ $direction }}"
    ></staff-filter-component>
</div>

<staff-table-component
staff-data = "{{ json_encode($staffMembers->items()) }}"
></staff-table-component>

<div class="admin-table__pagination">
    @if ($staffMembers->hasPages())
    <p class="text-secondary mb-1">Pages:</p>
    @endif

    {{ $staffMembers->links() }}
</div>

@else

<div class="bg-light px-2 py-4 text-secondary">
    Create Your First Staff Member!
</div>

@endif




@endsection
