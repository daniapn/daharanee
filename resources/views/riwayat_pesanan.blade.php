<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center flex items-center justify-center">
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-2xl p-4 sm:p-6 lg:p-8 text-[#4a2c19] relative my-10">
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

        <!-- Informasi Pemesanan -->
        <div class="mb-6 space-y-3 text-sm sm:text-base">
            <p><strong>Nomor Meja:</strong> {{ $order->meja ?? '-' }}</p>
            <p><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $order->tanggal_selesai ? \Carbon\Carbon::parse($order->tanggal_selesai)->format('d-m-Y H:i') : '-' }}</p>
            <p><strong>Status:</strong> {{ $order->status_pesanan }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->metode_pembayaran) }}</p>
        </div>

        <!-- Detail Item Pesanan -->
        <h2 class="font-semibold text-lg mb-3">Detail Pesanan:</h2>
        <div class="space-y-4 text-sm sm:text-base">
            @foreach ($order->items as $item)
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b pb-2">
                    <div>
                        <p class="font-medium">{{ $item->menu->nama }}</p>
                        <p class="text-gray-600 text-xs sm:text-sm">
                            Qty: {{ $item->qty }} | Harga Satuan: Rp {{ number_format($item->menu->harga, 0, ',', '.'),00}}
                        </p>
                    </div>
                    <div class="text-right mt-2 sm:mt-0">
                        <p class="text-base font-semibold">Rp {{ number_format($item->menu->harga * $item->qty, 0, ',', '.') }},00</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="text-right mt-6">
            <p class="font-bold text-xl">
                Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }},00
            </p>
        </div>

    </div>
</body>
</html>
