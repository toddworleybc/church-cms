<div class="message" >

    @if (session('danger'))
        <div class="alert alert-danger mb-0" role="alert">
            {{ session('danger') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mb-0" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning mb-0" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info mb-0" role="alert">
            {{ session('info') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-0" role="alert">
            <ul style="list-style: none" class="mb-0 p-0">
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
