@php
    use Illuminate\Support\Facades\Http;


    $client_id = env('PODBEAN_CLIENT_ID');
    $client_secret = env('PODBEAN_CLIENT_SECRET');

    // Get Credintials
     $creditals = Http::withBasicAuth($client_id, $client_secret)->post('https://api.podbean.com/v1/oauth/token', [
         'grant_type' => 'client_credentials'
     ])->json();


     $access_token = $creditals['access_token'];



     $response = Http::get('https://api.podbean.com/v1/episodes', [
         'access_token' => $access_token
     ])->json();




    // var_dump($response);
    dd($response)

@endphp




