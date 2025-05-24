<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Selesai - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center flex items-center justify-center">

        <div class="bg-white rounded-3xl shadow-lg w-full max-w-2xl p-4 sm:p-6 lg:p-8 text-[#4a2c19] relative">
            <div class="mb-6">
                <a href="{{ route('detailpesanan') }}" class="inline-flex items-center gap-2 text-[#4a2c19] transition">
                    <div class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                </a>
            <div class="text-center">
                <img src="{{ asset('logo_fix.png') }}" alt="Logo" class="mx-auto h-20 ">
            </div>
        </div>

        <!-- Form Konfirmasi -->
        <form action="{{ route('proses.konfirmasi.selesai', $order->id) }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-4 text-sm sm:text-base">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between border-b py-2">
                        <div>
                            <p>{{ $item->menu->nama }}</p>
                            <p class="text-gray-600 text-xs sm:text-sm">Jumlah: {{ $item->qty }}</p>
                        </div>
                        <div>
                            <input type="checkbox" name="disajikan[]" value="{{ $item->id }}" class="w-5 h-5" required>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-6">
                <button type="submit" class="w-full bg-[#4a2c19] hover:bg-[#3b1f10] text-white py-3 rounded-full text-base font-semibold shadow-md transition duration-200">
                    Konfirmasi Selesai
                </button>
            </div>
        </form>
    </div>

</body>
</html>
