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

    <script src="https://cdn.tiny.cloud/1/yu92hhddx8t10u7t6y7tc30xxexavdzyi8x05s2w89vy1dq4/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    @yield('scripts')

</head>

<body>
    <div id="admin-app">

        @include('admin.inc.nav')

        <div class="container-fluid">
            <div class="row">

                @include('admin.inc.sidebar')

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>{{-- admin-app  --}}
</body>

</html>
