
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DecoyGuard') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =================================
           DECOYGUARD GLOBAL DARK THEME
        ================================= */

        html {
            background: #080f1c;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #080f1c !important;
            color: #e8eef8;
        }

        .min-h-screen {
            background: #080f1c !important;
        }

        main {
            background: #080f1c !important;
            min-height: calc(100vh - 65px);
        }

        /* NAVIGATION */
        nav {
            background: #0b1422 !important;
            border-bottom: 1px solid #26364b !important;
            color: #e8eef8 !important;
        }

        nav a,
        nav button {
            color: #d1d5db !important;
        }

        nav button {
            background-color: #0e1a2a !important;
            border-color: #2b3b51 !important;
        }

        nav a:hover,
        nav button:hover {
            color: #ffffff !important;
        }

        nav button:hover {
            background-color: #14243a !important;
        }

        nav svg {
            color: #9aabc1 !important;
        }

        nav [class*="text-gray-800"],
        nav [class*="text-gray-700"] {
            color: #e8eef8 !important;
        }

        nav [class*="text-gray-500"],
        nav [class*="text-gray-600"] {
            color: #9aabc1 !important;
        }

        nav [class*="border-t"] {
            border-color: #26364b !important;
        }

        /* NAVIGATION DROPDOWN */
        nav [class*="absolute"] {
            background: #0e1a2a !important;
            border: 1px solid #2b3b51 !important;
        }

        nav [class*="absolute"] a,
        nav [class*="absolute"] button {
            color: #e5e7eb !important;
        }

        /* PAGE HEADER */
        header {
            background: #080f1c !important;
            border-bottom: 1px solid #26364b !important;
            box-shadow: none !important;
        }

        header h1,
        header h2,
        header h3 {
            color: #e8eef8 !important;
        }

        /* INPUTS */
        input,
        select,
        textarea {
            background-color: #0b1422 !important;
            color: #e8eef8 !important;
            border-color: #33465e !important;
        }

        input::placeholder,
        textarea::placeholder {
            color: #8291a8 !important;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 9px;
        }

        ::-webkit-scrollbar-track {
            background: #080f1c;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen">

        {{-- NAVIGATION --}}
        @include('layouts.navigation')

        {{-- PAGE HEADER --}}
        @isset($header)
            <header>
                <div class="max-w-[1500px] mx-auto py-5 px-5 sm:px-7 lg:px-9">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- PAGE CONTENT --}}
        <main>
            {{ $slot }}
        </main>

    </div>

</body>
</html>
