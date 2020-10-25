@include('bible.bible')
@php
use Book\Bible\Bible;
$bible = new Bible();
@endphp


{{-- get bible book options --}}
@if (!$book)
    @include('bible.inc.scripture_books_options')
@endif

{{-- get chapter book options --}}
@if ($book && !$chapter)
    @include('bible.inc.scripture_chapters_options')
@endif

{{-- get verse options --}}
@if ($book && $chapter && !$startVs)
    @include('bible.inc.scripture_start_verses_options')
@endif
{{-- get final verse options --}}
@if ($book && $chapter && $startVs)
    @include('bible.inc.scripture_end_verses_options')
@endif














