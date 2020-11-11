@php
use Illuminate\Support\Facades\Http;


$api_key = env('YOUTUBE_API_KEY');
$channel_id = env("YOUTUBE_CHANNEL_ID");
$maxResults = 6;
$videos = [];
$nextPage = isset($_GET['nextPage']) ? $_GET['nextPage'] : NULL;


$response = HTTP::get('https://www.googleapis.com/youtube/v3/search', [
    'part' => 'snippet',
    'channelId' => $channel_id,
    'key' => $api_key,
    'maxResults' => $maxResults,
    'order' => 'date',
    'pageToken' => $nextPage
])->json();



// dd($response);
$videos = $response['items'];
$nextPageToken = isset($response['nextPageToken']) ? $response['nextPageToken'] : 0;


@endphp

    @if (!$nextPage)

        <div class="modal-header">
            <h5 class="modal-title media-modal__main-title" id="">{{ $videos[0]['snippet']['channelTitle'] ?? 'No title' }}</h5>
        </div>

    @endif



<div class="modal-body">
    <div id="vid-{{ $nextPageToken ?? '' }}" data-np="{{ $nextPageToken ?? '' }}" class="media-modal__body">

@foreach ($videos as $key => $video)

        @php
            $date = date_create($video['snippet']['publishedAt']);
            $date = date_format($date, 'M d, Y');
            $videoId = isset($video['id']['videoId']) ? $video['id']['videoId'] : '';
        @endphp

            <div data-media-id="{{ $videoId ?? '' }}" class="media-modal__media">

                <div class="media-modal__title">
                    <h5>{{ $video['snippet']['title'] ?? 'No Title' }}</h5>
                    <p>Published: {{ $date ?? 'No Date' }}</p>
                </div>

                <div class="embed-responsive embed-responsive-16by9 media-modal__iframe">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $videoId ?? '' }}"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>

                <div class="custom-control custom-radio mt-3 media-modal__input-container">
                    <input type="radio" id="yt-{{ $videoId ?? '' }}" name="yt_vid" value="{{ $videoId ?? '' }}" class="custom-control-input">
                    <label class="custom-control-label" for="yt-{{ $videoId ?? '' }}">Select Video</label>
                </div>

            </div>

@endforeach

        </div>
    </div>
