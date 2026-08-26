<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGAP Desa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|fraunces:500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-paper text-soil">
    <div class="min-h-screen flex flex-col items-center justify-center px-6">

        <a href="{{ route('welcome') }}" class="mb-6">
            <span class="font-display font-semibold text-xl">SIGAP Desa</span>
        </a>

        <div class="w-full max-w-sm bg-surface border border-soil/10 rounded-xl p-6 shadow-sm">
            {{ $slot }}
        </div>

    </div>
</body>
</html>
