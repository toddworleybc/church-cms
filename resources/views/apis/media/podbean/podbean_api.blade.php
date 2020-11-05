@php
    use Illuminate\Support\Facades\Http;


    $client_id = env('PODBEAN_CLIENT_ID');
    $client_secret = env('PODBEAN_CLIENT_SECRET');
    $limit = 3;
    $offset = isset($_GET['nextPage']) ? intval($_GET['nextPage']) * $limit : 0;
    $nextPage = isset($_GET['nextPage']) ? intval($_GET['nextPage']) + 1 : 1;

    // Get Credintials
     $creditals = Http::withBasicAuth($client_id, $client_secret)->post('https://api.podbean.com/v1/oauth/token', [
         'grant_type' => 'client_credentials'
     ])->json();


    // get episodes response
     $response = Http::get('https://api.podbean.com/v1/episodes', [
         'access_token' => $creditals['access_token'],
         'offset'       => $offset,
         'limit'        => $limit
     ])->json();



    $has_more = $response['has_more'] ? $nextPage : 0;


@endphp

@if ($nextPage === 1)
    <div class="modal-header">
        <h5 class="modal-title media-modal__main-title" id="">Podbean Audio</h5>
    </div>
@endif



<div class="modal-body">
    <div id="vid-{{ $response['episodes'][0]['id'] ?? '' }}" data-np="{{ $has_more ?? '' }}" class="media-modal__body">

        @foreach ($response['episodes'] as $audio)

        @php
        $date = date('M d, Y', $audio['publish_time']);
        $audioId = $audio['id'];
        @endphp

        <div data-media-id="{{ $audioId ?? '' }}" data-audio-url="{{ $audio['player_url'] ?? '' }}" class="media-modal__media">

            <div class="media-modal__title">
                <h5>{{ $audio['title'] ?? 'No Title' }}</h5>
                <p>Published: {{ $date ?? 'No Date' }}</p>
            </div>

            <div class="embed-responsive embed-responsive-16by9 media-modal__iframe">
                <iframe id="audio_iframe" src="{{ $audio['player_url'] }}" width="100%" height="100" //
                    frameborder="0" scrolling="no">
                </iframe>
            </div>

            <div class="custom-control custom-radio mt-3 media-modal__input-container">
                <input type="radio" id="yt-{{ $audioId ?? '' }}" name="yt_vid" value="{{ $audioId ?? '' }}"
                    class="custom-control-input">
                <label class="custom-control-label" for="yt-{{ $audioId ?? '' }}">Select audio</label>
            </div>

        </div>

        @endforeach

    </div>
</div>









