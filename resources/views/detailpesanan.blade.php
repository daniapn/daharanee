<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center">

<div class="min-h-screen flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-3xl shadow-lg w-full max-w-2xl p-6 text-[#4a2c19] relative">

        <!-- Tombol Kembali (di dalam container, kiri atas) -->
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[#4a2c19] transition">
                <div class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
            </a>
        </div>

        <!-- Logo dan Judul -->
        <div class="text-center mb-4">
            <img src="{{ asset('logo_fix.png') }}" alt="Logo" class="mx-auto h-20 mb-2">
        </div>

        <!-- Daftar Pesanan -->
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="border border-[#4a2c19] rounded-xl p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="text-sm">No. Meja: <strong>{{ $order->meja }}</strong></p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</p>
                        </div>
                        <a href="{{ route(
                            $order->status_pesanan === 'Menunggu Pembayaran' ? 'konfirmasi.pembayaran' :
                            ($order->status_pesanan === 'Diproses' ? 'konfirmasi.selesai' : 'riwayat.pesanan'),
                            $order->id
                        ) }}" class="
                            text-sm font-semibold 
                            {{ $order->status_pesanan === 'Menunggu Pembayaran' ? 'text-red-600' : 
                               ($order->status_pesanan === 'Diproses' ? 'text-green-600' : 'text-black') }}
                        ">
                            {{ $order->status_pesanan }}
                        </a>
                    </div>

                    <ul class="text-sm list-disc pl-5">
                        @foreach ($order->items as $item)
                            <li>{{ $item->menu->nama }} x{{ $item->qty }}</li>
                        @endforeach
                    </ul>

                    <p class="text-right font-semibold mt-2">
                        Total: Rp{{ number_format($order->total_harga, 0, ',', '.') }},00
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</div>

</body>
</html>