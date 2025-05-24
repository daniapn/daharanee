<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - Daharané</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center flex items-center justify-center">

<div class="min-h-screen flex items-center justify-center py-10 px-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8 text-[#4a2c19] space-y-6">

        <!-- Logo & Alamat -->
        <div class="text-center space-y-2">
            <a href="{{ route('customer.logoRedirect') }}">
                <img src="{{ asset('logo_fix.png') }}" alt="Logo" class="mx-auto h-24 object-contain" />
            </a>
            <p class="text-sm leading-relaxed">Jl. Veteran, Ketawanggede, Lowokwaru, Kota Malang</p>
        </div>

        <!-- Info Meja & Tanggal -->
        <div class="text-center space-y-1">
            <p class="text-base font-semibold">No. Meja: {{ $order->meja }}</p>
            <p class="text-sm">{{ \Carbon\Carbon::parse($order->created_at)->format('d - m - Y') }}</p>
        </div>

        <hr class="border-[#4a2c19]">

        <!-- Daftar Pesanan -->
        <div class="text-sm space-y-3">
            @foreach ($order->items as $item)
            <div class="grid grid-cols-3 gap-2 items-center">
                <div class="text-left truncate">{{ $item->menu->nama }}</div>
                <div class="text-center">{{ $item->qty }}</div>
                <div class="text-right">Rp{{ number_format($item->menu->harga, 0, ',', '.') }},00</div>
            </div>
            @endforeach
        </div>

        <hr class="border-[#4a2c19]">

        <!-- Total -->
        <div class="grid grid-cols-3 font-semibold text-base items-center">
            <div>Total Harga</div>
            <div class="text-center">{{ $order->items->sum('qty') }}</div>
            <div class="text-right">Rp{{ number_format($order->total_harga, 0, ',', '.') }},00</div>
        </div>

        <p class="text-xs italic text-[#4a2c19]">*Harga yang tertera sudah termasuk PPN</p>

        <hr class="border-[#4a2c19]">

        <!-- Instruksi -->
        <p class="text-center text-sm">Silahkan Melakukan Pembayaran di kasir</p>

        <!-- Bintang -->
        <div class="text-center text-lg text-[#4a2c19]">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>

    </div>
</div>

</body>
</html>
