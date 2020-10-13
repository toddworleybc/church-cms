{{-- Gets chapters for selected book --}}
@php
    $chapters = $bible->getAllBookChapters($book);
    $chNum = 1;
@endphp

@foreach ($chapters['chapters'] as $chapters)
    <option value="none" selected hidden>Chapters</option>
    <option value="{{ $chNum }}">{{ $chNum }}</option>
    @php
    $chNum++;
    @endphp
@endforeach



