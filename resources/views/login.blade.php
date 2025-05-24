<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login Admin - Daharané</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[url('{{ asset('bg_fixy.jpg') }}')] bg-cover bg-center flex items-center justify-center">

    <!-- Form Container with Logo inside -->
    <div class="bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-3xl shadow-2xl w-full max-w-md
                sm:p-10 sm:max-w-lg flex flex-col items-center">

        <!-- Logo inside container -->
        <img src="{{ asset('logo_fix.png') }}" alt="Logo Daharanee"
             class="w-45 h-32 object-contain " />

        @if (session('success'))
            <div class="mb-6 text-green-700 font-semibold bg-green-100 px-4 py-3 rounded-md shadow-sm w-full text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 text-red-700 font-semibold bg-red-100 px-4 py-3 rounded-md shadow-sm w-full text-center">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->has('login'))
            <div class="mb-6 text-red-700 font-semibold bg-red-100 px-4 py-3 rounded-md shadow-sm w-full text-center">
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6 w-full">
            @csrf
            <div>
                <label for="username" class="block text-gray-800 font-semibold mb-2">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}"
                       class="w-full px-5 py-3 border border-gray-300 rounded-xl text-gray-700
                              focus:outline-none focus:ring-4 focus:ring-orange-300
                              placeholder-gray-400 transition duration-150" placeholder="Masukkan username" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-gray-800 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-5 py-3 border border-gray-300 rounded-xl text-gray-700
                              focus:outline-none focus:ring-4 focus:ring-orange-300
                              placeholder-gray-400 transition duration-150" placeholder="Masukkan password" required>
            </div>

            <button type="submit"
                    class="w-full bg-[#4a2c19] hover:bg-[#633b27] text-white font-bold py-3 rounded-xl
                           transition duration-200 focus:outline-none focus:ring-4 focus:ring-orange-400">
                Login
            </button>
        </form>
    </div>

</body>
</html>
