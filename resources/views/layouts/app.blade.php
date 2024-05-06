<!DOCTYPE html>
<html x-data="data" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/1.11/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/1.11/simplemde.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Scripts -->
    <script src="{{ asset('js/init-alpine.js') }}"></script>
    @stack('styles')
</head>

<body>
    <div class="flex h-screen bg-gray-200" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        @include('layouts.navigation')
        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        @include('layouts.navigation-mobile')
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.top-menu')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    @if (isset($header))
                        <h2 class="my-6 text-2xl font-semibold text-gray-700">
                            {{ $header }}
                        </h2>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('modals')
    @stack('scripts')
</body>

</html>
