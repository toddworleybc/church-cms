@extends('admin.layouts.admin-app')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Teachings</h1>
    @include("admin.inc.message")
    <div>
        <a href="{{ route("teachings.create") }}" class="btn btn-light btns__icon"> <span data-feather="plus-circle"></span> New Teaching</a>
    </div>
</div>






@if (count($teachings->items()))


    @php

        $staffNames = [];



        foreach ($teachings->items() as $teaching) {


            if($teaching->staff) {
                $staffNames[] = $teaching->staff->name;
            } else {
                $staffNames[] = null;
            }

        }

      // fix pagintion range top of the table to the left - blue box
        $showRange = ($teachings->lastItem() - $teachings->count()) + 1;

    @endphp


    <div class="admin-table__pag-filters">
        <p class="alert alert-info">Showing {{ $showRange }} - {{ $teachings->lastItem() }} teachings out of {{ $teachings->total() }}</p>
        <teachings-filter-component
         filter = "{{ $filter ?? '' }}"
         order-by = "{{ $orderBy ?? '' }}"
         direction = "{{ $direction ?? '' }}"
        ></teachings-filter-component>
    </div>

    <teaching-table-component
        staff-names-data = "{{ json_encode($staffNames) }}"
        teachings-data="{{ json_encode($teachings->items()) }}"
    ></teaching-table-component>

    <div class="admin-table__pagination">
        @if ($teachings->hasPages())
            <p class="text-secondary mb-1">Pages:</p>
        @endif

        {{ $teachings->links() }}
    </div>

    @else
    <div class="bg-light px-2 py-4 text-secondary">
        Create Your First Teaching!
    </div>
@endif





@endsection
