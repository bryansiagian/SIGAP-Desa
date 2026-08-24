<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGAP Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center px-6">

        <a href="{{ route('welcome') ?? url('/') }}" class="mb-6">
            <span class="font-semibold text-xl">SIGAP Desa</span>
        </a>

        <div class="w-full max-w-sm bg-white border rounded-lg p-6 shadow-sm">
            {{ $slot }}
        </div>

    </div>
</body>
</html>
