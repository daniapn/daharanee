<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang - Daharané</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center">
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="bg-white rounded-3xl shadow-lg w-full max-w-md p-6">
        <div class="relative mb-4 h-10">
            <a href="{{ route('customer.menu') }}" class="absolute left-0 top-1/2 transform -translate-y-1/2 p-2 rounded-full bg-white shadow-md hover:bg-gray-100">
                <i class="fas fa-arrow-left text-[#4a2c19]"></i>
            </a>
            <h2 class="text-center text-xl font-semibold text-[#4a2c19]">Keranjang</h2>
        </div>

        @if ($items->isEmpty())
            <p class="text-center text-[#4a2c19]">Keranjang masih kosong.</p>
        @else
            <div class="space-y-4 text-[#4a2c19] text-sm">
                @foreach ($items as $item)
                    <div class="flex items-center gap-3 border border-[#4a2c19] rounded-xl p-2 shadow-sm bg-white">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" class="w-16 h-16 rounded-lg object-cover">
                        <div class="flex-1">
                            <div class="font-semibold">{{ $item->nama }}</div>
                            <div>Rp{{ number_format($item->harga, 0, ',', '.') }},00</div>
                        </div>
                        <div class="flex items-center border border-[#4a2c19] rounded-full px-3 py-0.5">
                            <button type="button" class="text-base font-bold px-2 decrement" data-id="{{ $item->id }}">−</button>
                            <span class="px-2 quantity" data-id="{{ $item->id }}" data-stok="{{ $item->stok }}">{{ $item->qty }}</span>
                            <button type="button" class="text-base font-bold px-2 increment" data-id="{{ $item->id }}">+</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-right text-[#4a2c19] font-semibold text-base">
                Total Harga: <span class="text-lg">Rp{{ number_format($total, 0, ',', '.') }},00</span>
            </div>

            <form action="{{ route('order.store') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit"
                class="w-full bg-[#4a2c19] hover:bg-[#3b1f10] text-white py-3 rounded-full text-base font-semibold shadow-md transition duration-200">
                Buat Pesanan
            </button>
        </form>
        @endif
    </div>
</div>

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
                console.log('Cart updated', data);
                if (qty === 0) {
                    location.reload();
                }
            });
        }

        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const qtyEl = document.querySelector(`.quantity[data-id="${id}"]`);
                let qty = parseInt(qtyEl.textContent);
                const stok = parseInt(qtyEl.dataset.stok);

                const maxStok = parseInt(qtyEl.getAttribute('data-stok'));
                if (qty < maxStok) {
                    qty++;
                    qtyEl.textContent = qty;
                    syncQuantity(id, qty);
  
                } else {
                    alert('Jumlah melebihi stok yang tersedia!');
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
