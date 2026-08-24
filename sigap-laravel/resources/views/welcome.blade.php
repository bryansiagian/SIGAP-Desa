<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGAP Desa — Layanan Publik Desa Tanpa Ribet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <nav class="border-b bg-white">
        <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="font-semibold text-lg">SIGAP Desa</span>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Masuk</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Daftar</a>
            </div>
        </div>
    </nav>

    <section class="max-w-5xl mx-auto px-6 py-20 text-center">
        <h1 class="text-4xl font-medium mb-4">Layanan desa, tanpa harus bolak-balik ke balai desa</h1>
        <p class="text-gray-600 max-w-xl mx-auto mb-8">
            Ajukan pengaduan, perizinan usaha, dan berbagai layanan administrasi desa lainnya secara online. Pantau statusnya kapan saja.
        </p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-3 rounded font-medium hover:bg-blue-700">
                Mulai Sekarang
            </a>
            <a href="{{ route('login') }}" class="border px-6 py-3 rounded font-medium hover:bg-gray-100">
                Sudah Punya Akun
            </a>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border rounded-lg p-6">
                <h3 class="font-medium mb-2">Pengaduan Masyarakat</h3>
                <p class="text-sm text-gray-600">Laporkan masalah di lingkungan sekitar dan pantau tindak lanjutnya.</p>
            </div>
            <div class="bg-white border rounded-lg p-6">
                <h3 class="font-medium mb-2">Perizinan Usaha Mikro</h3>
                <p class="text-sm text-gray-600">Ajukan izin usaha tanpa harus datang berkali-kali ke kantor desa.</p>
            </div>
            <div class="bg-white border rounded-lg p-6">
                <h3 class="font-medium mb-2">Layanan Administrasi Lainnya</h3>
                <p class="text-sm text-gray-600">Surat pengantar, keterangan, dan berbagai layanan lain sesuai kebutuhan desa.</p>
            </div>
        </div>
    </section>

    <footer class="border-t py-6 text-center text-sm text-gray-500">
        SIGAP Desa — IT Fest 2026
    </footer>

</body>
</html>
