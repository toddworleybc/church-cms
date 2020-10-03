<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RCF Dashboard</title>


    {{-- Main Scripts  --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>

    @yield('scripts')

</head>

<body>
    <div id="admin-app">

        @include('inc.admin.nav')

        <div class="container-fluid">
            <div class="row">

                @include('inc.admin.sidebar')

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>{{-- admin-app  --}}
</body>

</html>
