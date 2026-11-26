<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - POS Barokah Mart</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white p-10 rounded-xl shadow-lg text-center max-w-md">
        <h1 class="text-7xl font-bold text-red-600 mb-4">
            403
        </h1>

        <h2 class="text-2xl font-bold mb-3">
            Akses Ditolak!
        </h2>

        <p class="text-gray-600 mb-6">
            Maaf, Anda tidak memiliki izin untuk
            mengakses halaman ini.
        </p>

        <a href="{{ route('dashboard') }}"
            class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            Kembali ke Dashboard
        </a>
    </div>

</body>

</html>