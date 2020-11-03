@php
    use Illuminate\Support\Facades\Http;


    $response = HTTP::get('https://api.soundcloud.com/tracks/265899677', [
        'client_id' => 'BhajJqlWZTSFOvRxDm5ayVT1DQaJoybO'
    ]);



// https://api.soundcloud.com/tracks?client_id=BhajJqlWZTSFOvRxDm5ayVT1DQaJoybO'

    // echo $response;
    var_dump($response);
// https://api.soundcloud.com/tracks/

@endphp
{{-- <script src="https://connect.soundcloud.com/sdk/sdk-3.3.2.js"></script>
<script> --}}

{{--
    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay"
        src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/265899677&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
    <div
        style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;">
        <a href="https://soundcloud.com/toddworleybc" title="ToddWorleyBc" target="_blank"
            style="color: #cccccc; text-decoration: none;">ToddWorleyBc</a> · <a
            href="https://soundcloud.com/toddworleybc/what-wordpress-theme-should-i-use"
            title="What WordPress Theme Should I Use" target="_blank" style="color: #cccccc; text-decoration: none;">What
            WordPress Theme Should I Use</a>
    </div> --}}




