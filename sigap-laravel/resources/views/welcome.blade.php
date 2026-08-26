<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGAP Desa — Layanan Publik Desa Tanpa Ribet</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|fraunces:500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-paper text-soil">

    <nav class="border-b border-soil/10">
        <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="font-display font-semibold text-lg">SIGAP Desa</span>
            <div class="flex gap-2 items-center text-sm">
                <a href="{{ route('login') }}" class="px-4 py-2 text-soil/70 hover:text-soil">Masuk</a>
                <x-ui.button variant="primary" href="{{ route('register') }}" as="a">Daftar</x-ui.button>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-5xl mx-auto px-6 pt-20 pb-16">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block text-xs font-semibold tracking-widest uppercase text-clay mb-4">
                    Platform Layanan Desa
                </span>
                <h1 class="font-display text-4xl md:text-5xl font-semibold leading-tight mb-5">
                    Urus surat desa,<br>tanpa antre di balai desa
                </h1>
                <p class="text-soil/70 mb-8 max-w-md">
                    Ajukan pengaduan, perizinan usaha, dan layanan administrasi lainnya dari rumah. Pantau statusnya kapan saja, seperti melacak paket.
                </p>
                <div class="flex gap-3">
                    <x-ui.button variant="primary" href="{{ route('register') }}" as="a" class="px-6 py-3">
                        Ajukan Layanan
                    </x-ui.button>
                    <x-ui.button variant="outline" href="{{ route('login') }}" as="a" class="px-6 py-3">
                        Sudah Punya Akun
                    </x-ui.button>
                </div>
            </div>

            {{-- Signature: kartu status bergaya "lacak pengajuan", pakai badge stempel --}}
            <x-ui.card class="rotate-1">
                <p class="text-xs uppercase tracking-wide text-soil/50 mb-3">Contoh Pengajuan</p>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-soil/10">
                        <div>
                            <p class="font-medium text-sm">Surat Pengantar KTP</p>
                            <p class="text-xs text-soil/50">Diajukan 2 hari lalu</p>
                        </div>
                        <x-ui.badge status="selesai" />
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-soil/10">
                        <div>
                            <p class="font-medium text-sm">Perizinan Usaha Mikro</p>
                            <p class="text-xs text-soil/50">Diajukan kemarin</p>
                        </div>
                        <x-ui.badge status="diproses" />
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm">Pengaduan Jalan Rusak</p>
                            <p class="text-xs text-soil/50">Diajukan hari ini</p>
                        </div>
                        <x-ui.badge status="diajukan" />
                    </div>
                </div>
            </x-ui.card>
        </div>
    </section>

    {{-- Layanan --}}
    <section class="max-w-5xl mx-auto px-6 py-16 border-t border-soil/10">
        <h2 class="font-display text-2xl font-semibold mb-8">Yang bisa diurus di sini</h2>
        <div class="grid md:grid-cols-3 gap-5">
            <x-ui.card>
                <div class="w-10 h-10 rounded-lg bg-clay/10 flex items-center justify-center mb-4">
                    <span class="text-clay font-display font-semibold">01</span>
                </div>
                <h3 class="font-medium mb-1.5">Pengaduan Masyarakat</h3>
                <p class="text-sm text-soil/60">Laporkan jalan rusak, sampah, atau masalah lingkungan lain. Pantau tindak lanjutnya.</p>
            </x-ui.card>
            <x-ui.card>
                <div class="w-10 h-10 rounded-lg bg-padi/10 flex items-center justify-center mb-4">
                    <span class="text-padi font-display font-semibold">02</span>
                </div>
                <h3 class="font-medium mb-1.5">Perizinan Usaha Mikro</h3>
                <p class="text-sm text-soil/60">Ajukan izin usaha tanpa harus datang berkali-kali ke kantor desa.</p>
            </x-ui.card>
            <x-ui.card>
                <div class="w-10 h-10 rounded-lg bg-panen/10 flex items-center justify-center mb-4">
                    <span class="text-panen font-display font-semibold">03</span>
                </div>
                <h3 class="font-medium mb-1.5">Layanan Lainnya</h3>
                <p class="text-sm text-soil/60">Surat pengantar, keterangan, dan layanan lain sesuai kebutuhan desa masing-masing.</p>
            </x-ui.card>
        </div>
    </section>

    <footer class="border-t border-soil/10 py-6 text-center text-sm text-soil/50">
        SIGAP Desa — IT Fest 2026
    </footer>

</body>
</html>
