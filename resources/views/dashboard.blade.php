<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body>
<div class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center flex items-center justify-center">
    <div class="relative z-10 bg-white shadow-2xl rounded-3xl px-14 py-20 flex flex-col items-center text-center max-w-2xl w-full mx-4">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6 select-none">
            <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharanee" class="mb-5 w-50 h-40 object-contain" />
        </div>

        <!-- Tombol Navigasi -->
        <a href="{{ route('menu.index') }}"
           class="block w-full mb-4 px-6 py-3 text-[#4a2c19] border border-[#4a2c19] rounded-xl text-lg font-medium hover:bg-[#4a2c19] hover:text-white transition duration-200">
            Modifikasi Menu
        </a>
        <a href="{{ route('detailpesanan') }}"
           class="block w-full mb-4 px-6 py-3 text-[#4a2c19] border border-[#4a2c19] rounded-xl text-lg font-medium hover:bg-[#4a2c19] hover:text-white transition duration-200">
            Detail Pesanan
        </a>

        <!-- Logout sebagai teks klik di kanan bawah -->
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" 
            class="mt-6 absolute left-16 bottom-10">
            @csrf
            <button type="submit" class="hidden">Logout</button>
            <a href="#" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
            class="text-red-600 hover:text-red-800 font-semibold cursor-pointer select-none"
            title="Logout">
                Logout
            </a>
        </form>


    </div>
</div>
</body>
</html>
