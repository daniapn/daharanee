<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
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


        <!-- Detail Pesanan -->
        <div class="mb-6 space-y-3 text-sm sm:text-base">
            <div>
                <span class="font-semibold">No. Meja:</span> {{ $order->meja }}
            </div>
            <div>
                <span class="font-semibold">Waktu Pemesanan:</span> {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}
            </div>
            <div>
                <span class="font-semibold">Pesanan:</span>
                <ul class="list-disc list-inside text-sm ml-2">
                    @foreach ($order->items as $item)
                        <li>{{ $item->menu->nama }} x{{ $item->qty }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="font-semibold text-right">
                Total: Rp{{ number_format($order->total_harga, 0, ',', '.') }},00
            </div>
        </div>

        <!-- Form Konfirmasi -->
        <form action="{{ route('proses.konfirmasi.pembayaran', $order->id) }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="metode_pembayaran" class="block font-semibold mb-1">Metode Pembayaran:</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#4a2c19]" required>
                    <option value="">Pilih Metode</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS</option>
                    <option value="debit card">Debit Card</option>
                    <option value="credit card">Credit Card</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-[#4a2c19] hover:bg-[#3b1f10] text-white py-3 rounded-full text-base font-semibold shadow-md transition duration-200">
                    Konfirmasi Pembayaran 
                </button>
            </div>
        </form>
    </div>

</body>
</html>
