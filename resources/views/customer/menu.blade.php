<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu - Daharané</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<div class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center">
<body class="font-['Playfair_Display']">
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center flex items-center justify-center">
    <div class="max-w-5xl mx-auto px-4 pt-0 pb-24">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-0 select-none">
            <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharane" class="mb-0 w-48 h-40 object-contain" />
        </div>

        <!-- Search -->
        <form action="{{ route('customer.search') }}" method="GET" class="mb-10 px-2">
            <div class="relative w-full max-w-2xl mx-auto" onclick="this.closest('form').submit()">
                <input
                    type="text"
                    name="query"
                    placeholder="Cari menu favorit..."
                    class="w-full rounded-full border border-[#4a2c19] bg-white py-3 pl-5 pr-12 text-[#4a2c19] placeholder-[#9c7d64] focus:outline-none focus:ring-2 focus:ring-[#4a2c19] text-base shadow-sm cursor-pointer"
                    readonly
                />
                <button type="submit" aria-label="Cari"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4a2c19] text-lg pointer-events-none">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Menu Grid -->
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @foreach ($menus as $menu)
                <article class="bg-white rounded-xl shadow-md flex gap-3 p-3 border border-[#4a2c19] {{ $menu->stok === 0 ? 'opacity-90 grayscale' : '' }}">
                    <!-- Gambar -->
                    <div class="w-32 h-32 flex-shrink-0">
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}"
                            class="w-full h-full rounded-lg object-cover">
                    </div>

                    <div class="flex flex-col justify-between text-[#4a2c19] text-sm leading-relaxed w-full">
                        <div>
                            <h2 class="text-lg font-semibold mb-1">{{ $menu->nama }}</h2>
                            <p class="mb-2 text-sm">{{ $menu->deskripsi ?? 'Menu spesial dari Daharane.' }}</p>
                        </div>

                        <div class="flex items-center justify-between font-semibold text-base">
                            <span>Rp{{ number_format($menu->harga, 0, ',', '.') }},00</span>

                            @if ($menu->stok > 0)
                                @php
                                    $qty = isset($cart[$menu->id]) ? $cart[$menu->id]['qty'] : 0;
                                @endphp
                                <div class="flex items-center border border-[#4a2c19] rounded-full px-3 py-0.5 text-[#4a2c19] select-none"
                                     data-stok="{{ $menu->stok }}">
                                    <button type="button" class="text-lg font-bold leading-none px-2 decrement">−</button>
                                    <span class="px-3 quantity" data-menu-id="{{ $menu->id }}">{{ $qty }}</span>
                                    <button type="button" class="text-lg font-bold leading-none px-2 increment">+</button>
                                </div>
                            @else
                                <span class="text-sm italic text-gray-500">Habis</span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <!-- Keranjang Button -->
        <a href="{{ route('customer.cart') }}"
           class="fixed bottom-6 right-6 bg-[#4a2c19] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:bg-[#3b1f10] transition duration-200"
           aria-label="Keranjang Belanja">
            <i class="fas fa-shopping-cart text-xl"></i>
        </a>
    </div>
</div>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const controls = document.querySelectorAll('[data-stok]');

        controls.forEach(control => {
            const incrementBtn = control.querySelector('.increment');
            const decrementBtn = control.querySelector('.decrement');
            const quantityEl = control.querySelector('.quantity');
            const menuId = quantityEl.dataset.menuId;
            const max = parseInt(control.dataset.stok);
            let quantity = parseInt(quantityEl.textContent);

            incrementBtn.addEventListener('click', () => {
                if (quantity < max) {
                    quantity++;
                    quantityEl.textContent = quantity;

                    fetch(`/keranjang/tambah/${menuId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ qty: 1 })
                    }).then(res => res.json()).then(console.log);
                }
            });

            decrementBtn.addEventListener('click', () => {
                if (quantity > 0) {
                    quantity--;
                    quantityEl.textContent = quantity;

                    if (quantity === 0) {
                        fetch(`/keranjang/hapus/${menuId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        }).then(res => res.json()).then(console.log);
                    } else {
                        fetch(`/keranjang/update`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ id: menuId, qty: quantity })
                        }).then(res => res.json()).then(console.log);
                    }
                }
            });
        });
    });
</script>

</body>
</html>
