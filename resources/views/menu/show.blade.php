<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu - Daharané</title>

    <!-- Bootstrap & Tailwind CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Playfair Display', serif;
        }

        .btn-coklat {
            background-color: white;
            color: #4a2c19;
            border: 1px solid #4a2c19;
            transition: all 0.3s ease;
        }

        .btn-coklat:hover {
            background-color: #4a2c19;
            color: white;
        }
    </style>
</head>
<body>

<div class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-2xl p-8 relative mx-4 sm:mx-8 my-10">

            <!-- Tombol Kembali -->
            <a href="{{ route('menu.index') }}" class="absolute top-6 left-6 bg-white rounded-full shadow-md p-2 hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#4a2c19]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Logo -->
            <div class="text-center mb-6">
                <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharanee" class="mx-auto w-40 mb-2">
            </div>

            <!-- Detail Menu -->
            <div class="space-y-4 text-[#4a2c19]">

                <div><strong>ID Menu:</strong> {{ $menu->id }}</div>
                <div><strong>ID Kategori:</strong> {{ $menu->kategori_id }}</div>
                <div><strong>Nama Menu:</strong> {{ $menu->nama }}</div>
                <div><strong>Harga:</strong> Rp{{ number_format($menu->harga, 0, ',', '.') }}</div>
                <div><strong>Stok:</strong> {{ $menu->stok }}</div>
                <div><strong>Deskripsi:</strong> {{ $menu->deskripsi }}</div>

                <div>
                    <strong>Gambar:</strong><br>
                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="Gambar Menu" class="mt-2 rounded-xl w-full max-h-80 object-cover">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
