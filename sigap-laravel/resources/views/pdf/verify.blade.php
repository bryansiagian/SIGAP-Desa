<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Surat — SIGAP Desa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|fraunces:500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-paper text-soil min-h-screen flex items-center justify-center px-6">
    <x-ui.card class="max-w-sm w-full text-center">
        <div class="w-12 h-12 rounded-full bg-padi/10 flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-padi" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="font-display text-lg font-semibold mb-1">Surat Terverifikasi</h1>
        <p class="text-sm text-soil/60 mb-5">Dokumen ini sah dan diterbitkan oleh SIGAP Desa</p>

        <div class="text-left text-sm space-y-2 border-t border-soil/10 pt-4">
            <div class="flex justify-between">
                <span class="text-soil/50">Nomor Surat</span>
                <span class="font-medium">{{ $submission->nomor_surat }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-soil/50">Jenis Layanan</span>
                <span class="font-medium">{{ $submission->serviceType->nama_layanan }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-soil/50">Atas Nama</span>
                <span class="font-medium">{{ $submission->submitter->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-soil/50">Tanggal Terbit</span>
                <span class="font-medium">{{ $submission->updated_at->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </x-ui.card>
</body>
</html>
