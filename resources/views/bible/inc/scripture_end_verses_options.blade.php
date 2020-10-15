{{-- Gets verses for selected book --}}
@php
    $verses = $bible->getAllChapterVerses($book, $chapter);
    $vsNum = $startVs + 1;
    $vsCount = count($verses['verses']);
@endphp


@for ($i = $vsNum; $i <= $vsCount; $i++)
    <option value="none" selected hidden>Verse</option>
    <option value="{{ $i }}">{{ $i }}</option>
@endfor
