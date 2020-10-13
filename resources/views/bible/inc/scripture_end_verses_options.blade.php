{{-- Gets verses for selected book --}}
@php
    $verses = $bible->getAllChapterVerses($book, $chapter);
    $vsNum = $startVs;
    $vsCount = count($verses['verses']);
@endphp


@for ($i = $startVs; $i <= $vsCount; $i++)
    <option value="none" selected hidden>Verse</option>
    <option value="{{ $i }}">{{ $i }}</option>
@endfor
