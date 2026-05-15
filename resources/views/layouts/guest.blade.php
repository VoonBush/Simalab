<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIMALAB') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-inter antialiased">
    <x-splash-screen />
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center">
                            <img src="{{ asset('img/LogoLab.png') }}" class="w-15 h-15 object-contain" alt="Logo">
                        </div>
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">SIMALAB</h2>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Laboratorium Teknik Digital, Jurusan Teknik Elektro, Universitas Lampung.</p>
                </div>

                <div class="mt-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
             <img src="{{ asset('img/FotoAslab.jpeg') }}" class="h-full w-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-blue-600/20 mix-blend-multiply"></div>
        </div>
    </div>
</body>
</html>
