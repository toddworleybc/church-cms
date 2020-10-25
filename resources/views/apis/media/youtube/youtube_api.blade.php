@php
use Illuminate\Support\Facades\Http;


$api_key = env('YOUTUBE_API_KEY');
$channel_id = env("YOUTUBE_CHANNEL_ID");
$maxResults = 6;
$videos = [];

$response = HTTP::get('https://www.googleapis.com/youtube/v3/search', [
    'part' => 'snippet',
    'channelId' => $channel_id,
    'key' => $api_key,
    'maxResults' => $maxResults,
    'order' => 'date'
])->json();

$videos = $response['items'];

// dd($videos);

@endphp


    <div class="modal-header">
        <h5 class="modal-title video-modal__main-title" id="">{{ $video[0]['snippet']['title'] ?? 'Rcf media' }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


<div class="modal-body">
    <div class="video-modal__body">

@foreach ($videos as $key => $video)

    @if ($key)

        @php
            $date = date_create($video['snippet']['publishedAt']);
            $date = date_format($date, 'M d, Y');
            $videoId = $video['id']['videoId'];
        @endphp

            <div class="video-modal__video">

                <div class="video-modal__title">
                    <h5>{{ $video['snippet']['title'] ?? 'No Title' }}</h5>
                    <p>Published: {{ $date ?? 'No Date' }}</p>
                </div>

                <div class="embed-responsive embed-responsive-16by9 video-modal__iframe">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $videoId ?? '' }}"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>

                <div class="custom-control custom-radio mt-3 video-modal__input-container">
                    <input type="radio" id="yt-{{ $videoId ?? '' }}" name="yt_vid" value="{{ $videoId ?? '' }}" class="custom-control-input">
                    <label class="custom-control-label" for="yt-{{ $videoId ?? '' }}">Select Video</label>
                </div>

            </div>

    @endif

@endforeach

        </div>
    </div>
