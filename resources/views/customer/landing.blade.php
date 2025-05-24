<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="3;url={{ route('customer.menu') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daharané</title>

    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="bg-[#f5e6d3] min-h-screen flex items-center justify-center">

    <div class="flex items-center justify-center w-full h-screen">
        <img src="{{ asset('logo_daharane.png') }}" alt="Logo Daharane"
             class="mx-auto max-w-xs w-2/3 sm:w-1/3 object-contain" />
    </div>

</body>
</html>
