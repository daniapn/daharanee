
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Daharané</title>

    <!-- Bootstrap & Tailwind CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

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
        <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-3xl p-8 relative my-10">

            <!-- Tombol Kembali -->
            <a href="{{ route('menu.index') }}" class="absolute top-6 left-6 bg-white rounded-full shadow-md p-2 hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#4a2c19]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharanee" class="mx-auto w-40 mb-2">
            </div>

            <!-- Form Tambah Menu -->
            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-[#4a2c19]">
                @csrf


                <div>
                    <label for="kategori_id" class="block text-sm mb-1">Kategori Menu</label>
                    <select name="kategori_id" id="kategori_id" required class="w-full border border-[#b78b65] rounded-lg px-4 py-2">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                </div>

                <div>
                    <label for="nama" class="block text-sm mb-1">Nama Menu</label>
                    <input type="text" name="nama" id="nama" required class="w-full border border-[#b78b65] rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm mb-1">Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" required class="hidden">
                    <button type="button" onclick="document.getElementById('gambar').click()" class="btn-coklat px-6 py-2 rounded-xl">
                        Pilih Gambar
                    </button>
                    <span id="namaFile" class="block mt-1 text-sm">Belum ada file dipilih</span>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required class="w-full border border-[#b78b65] rounded-lg px-4 py-2 resize-y"></textarea>
                </div>

                <div>
                    <label for="harga" class="block text-sm mb-1">Harga</label>
                    <input type="text" name="harga" id="harga" required class="w-full border border-[#b78b65] rounded-lg px-4 py-2">
                </div>

                <div>
                    <label for="stok" class="block text-sm mb-1">Stok</label>
                    <input type="number" name="stok" id="stok" value="0" min="0" required class="w-full border border-[#b78b65] rounded-lg px-4 py-2">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn-coklat px-6 py-2 rounded-xl">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const inputGambar = document.getElementById('gambar');
    const namaFile = document.getElementById('namaFile');

    inputGambar.addEventListener('change', function () {
        if (this.files.length > 0) {
            namaFile.textContent = this.files[0].name;
        } else {
            namaFile.textContent = "Belum ada file dipilih";
        }
    });
</script>

</body>
</html>
