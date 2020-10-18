@include('bible.bible')
@php
use Illuminate\Http\Request;
use Book\Bible\Bible;
$bible = new Bible();
$request = new Request();
$verses = $request->json();
@endphp


@foreach ($verses as $vs)
    <div id={{"scripture-" . $vs['id'] ?? '' }}>
        <h4>{{ $vs['book'] ?? "" }} {{ $vs['chapter'] ?? "" }}{{ $vs['startVs'] ? ":" . $vs['startVs'] : "" }}{{ $vs['endVs'] ? "-" . $vs['endVs'] : "" }}</h4>

        @php
            $bible->getScriptures($vs['book'], $vs['chapter'], $vs['startVs'], $vs['endVs']);
        @endphp
    </div>
@endforeach























