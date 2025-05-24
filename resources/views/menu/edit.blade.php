<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Daharané</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }

        .text-coklat { color: #4a2c19; }
        .border-coklat { border-color: #4a2c19; }
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
        <div class="bg-white rounded-2xl shadow-2xl w-[70%] xl:w-[50%] p-10 mx-auto my-10 relative">
            
            <!-- Tombol Kembali -->
            <a href="{{ route('menu.index') }}" class="absolute top-6 left-6 bg-white rounded-full shadow-md p-2 hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-coklat" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharanee" class="mx-auto w-40 mb-2">
            </div>

            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-coklat">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold">Nama Menu</label>
                    <input type="text" name="nama" value="{{ old('nama', $menu->nama) }}" class="w-full p-2 border border-coklat rounded">
                </div>

                <div>
                    <label class="block font-semibold">Kategori</label>
                    <select name="kategori_id" class="w-full p-2 border border-coklat rounded">
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $menu->kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold">Harga</label>
                    <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}" class="w-full p-2 border border-coklat rounded">
                </div>

                <div>
                    <label class="block font-semibold">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $menu->stok) }}" class="w-full p-2 border border-coklat rounded">
                </div>

                <div>
                    <label class="block font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full p-2 border border-coklat rounded">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold">Gambar (opsional)</label>
                    <input type="file" name="gambar" class="w-full p-2 border border-coklat rounded">
                    @if($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="Gambar Saat Ini" class="w-40 mt-2 rounded">
                    @endif
                </div>

                <div class="text-right mt-6">
                    <button type="submit" class="btn-coklat rounded-xl px-4 py-2">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>
