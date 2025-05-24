<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $kategori }} - Daharané</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center">

@php
    $cart = session('cart', []);
@endphp


<div class="max-w-5xl mx-auto px-4 pt-0 pb-24">

    <!-- Logo -->
     
    <div class="flex flex-col items-center mb-0 select-none">
        <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharane" class="mb-0 w-48 h-40 object-contain" />
    </div>

    <div class="flex items-center justify-between mb-8 gap-4">
        <a href="{{ route('customer.search') }}" class="bg-white rounded-full shadow-md p-2 hover:bg-gray-100 transition">
            <svg class="w-6 h-6 text-[#4a2c19]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

    <!-- Search Bar -->
    <form action="{{ route('customer.search') }}" method="GET" class="flex-1">
        <div class="relative">
            <input type="text" name="query" placeholder="Cari menu favorit..."
                class="w-full rounded-full border border-[#4a2c19] bg-white py-3 pl-5 pr-12 text-[#4a2c19] placeholder-[#9c7d64] focus:outline-none focus:ring-2 focus:ring-[#4a2c19] text-base shadow-sm"
                />
            <button type="submit" aria-label="Cari"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4a2c19] text-lg">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

    <!-- Menu Grid -->
    <section class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm leading-relaxed text-[#4a2c19]">
        @foreach ($menus as $menu)
            @php
                $qty = isset($cart[$menu->id]) && isset($cart[$menu->id]['qty']) ? $cart[$menu->id]['qty'] : 0;
            @endphp
            <article class="bg-white rounded-xl shadow-md flex gap-3 p-3 border border-[#4a2c19] {{ $menu->stok === 0 ? 'opacity-90 grayscale' : '' }}">
                <div class="w-32 h-32 flex-shrink-0">
                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}"
                        class="w-full h-full rounded-lg object-cover">
                </div>

                <div class="flex flex-col justify-between w-full">
                    <div>
                        <h2 class="text-lg font-semibold mb-1">{{ $menu->nama }}</h2>
                        <p class="mb-2 text-sm">{{ $menu->deskripsi ?? 'Menu spesial dari Daharane.' }}</p>
                    </div>

                    <div class="flex items-center justify-between font-semibold text-base">
                        <span>Rp{{ number_format($menu->harga, 0, ',', '.') }},00</span>
                        @if ($menu->stok > 0)
                            <div class="flex items-center border border-[#4a2c19] rounded-full px-3 py-0.5 text-[#4a2c19] select-none"
                                 data-stok="{{ $menu->stok }}">
                                <button type="button" class="text-lg font-bold leading-none px-2 decrement" data-id="{{ $menu->id }}">−</button>
                                <span class="px-3 quantity" data-id="{{ $menu->id }}">{{ $qty }}</span>
                                <button type="button" class="text-lg font-bold leading-none px-2 increment" data-id="{{ $menu->id }}">+</button>
                            </div>
                        @else
                            <span class="text-sm italic text-gray-500">Habis</span>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </section>

    <!-- Floating Cart -->
    <a href="{{ route('customer.cart') }}"
       class="fixed bottom-6 right-6 bg-[#4a2c19] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:bg-[#3b1f10] transition duration-200"
       aria-label="Keranjang Belanja">
        <i class="fas fa-shopping-cart text-xl"></i>
    </a>
</div>

<!-- Script: Interaktif + / - -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function syncQuantity(id, qty) {
            fetch('/keranjang/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ id, qty }),
            }).then(res => res.json()).then(data => {
                console.log('Updated:', data);
                if (qty === 0) location.reload();
            });
        }

        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const qtyEl = document.querySelector(`.quantity[data-id="${id}"]`);
                let qty = parseInt(qtyEl.textContent);
                const max = parseInt(button.closest('[data-stok]').dataset.stok);
                if (qty < max) {
                    qty++;
                    qtyEl.textContent = qty;
                    syncQuantity(id, qty);
                }
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const qtyEl = document.querySelector(`.quantity[data-id="${id}"]`);
                let qty = parseInt(qtyEl.textContent);
                if (qty > 1) {
                    qty--;
                    qtyEl.textContent = qty;
                    syncQuantity(id, qty);
                } else if (qty === 1) {
                    qtyEl.textContent = 0;
                    syncQuantity(id, 0);
                }
            });
        });
    });
</script>

</body>
</html>
