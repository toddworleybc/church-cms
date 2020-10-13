{{-- Gets verses for selected book --}}
@php
    $verses = $bible->getAllChapterVerses($book, $chapter);
    $vsNum = 1;
@endphp

@foreach ($verses['verses'] as $verses)
    <option value="none" selected hidden>Verse</option>
    <option value="{{ $vsNum }}">{{ $vsNum }}</option>
    @php
    $vsNum++;
    @endphp
@endforeach
