<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

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
        <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-4xl p-8 my-10 relative">
            
            <!-- Tombol Kembali -->
            <a href="{{ route('dashboard') }}" class="absolute top-6 left-6 bg-white rounded-full shadow-md p-2 hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-coklat" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharanee" class="mx-auto w-40 mb-2">
            </div>

            <!-- Tabel Menu -->
            <div class="overflow-x-auto">
                <table class="w-full text-coklat">
                    <thead>
                        <tr class="bg-white rounded-xl shadow-md">
                            <th colspan="3" class="rounded-xl overflow-hidden p-0">
                                <div class="grid grid-cols-3 divide-x divide-coklat border border-coklat rounded-xl text-center">
                                    <div class="px-6 py-3 font-semibold">Id Menu</div>
                                    <div class="px-6 py-3 font-semibold">Menu</div>
                                    <div class="px-6 py-3 font-semibold">Aksi</div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="space-y-4">
                        @forelse($menus as $menu)
                        <tr>
                            <td colspan="3">
                                <div class="grid grid-cols-3 bg-white border border-coklat rounded-xl text-center shadow-sm">
                                    <div class="px-6 py-3">{{ $menu->id }}</div>
                                    <div class="px-6 py-3">
                                        <a href="{{ route('menu.show', $menu->id) }}" class="text-[#4a2c19] hover:underline hover:font-semibold transition">
                                            {{ $menu->nama }}
                                        </a>
                                    </div>
                                    <div class="px-6 py-3 space-x-4">
                                        <a href="{{ route('menu.edit', $menu->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-500 hover:underline btn-hapus">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 py-6">Belum ada menu.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tombol Tambah -->
            <div class="text-right mt-8">
                <a href="{{ route('menu.create') }}" class="btn-coklat rounded-xl px-4 py-2">
                    Tambah Menu
                </a>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert untuk flash message
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // SweetAlert konfirmasi sebelum hapus
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Menu akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4a2c19',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

</body>
</html>
