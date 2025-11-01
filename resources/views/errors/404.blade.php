<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-hima-if.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            <div class="mb-8">
                <img src="{{ asset('images/logo-hima-if.png') }}" alt="Logo HIMA IF" class="mx-auto h-24 w-24 mb-6">
                <h1 class="text-9xl font-bold text-indigo-600 mb-4">404</h1>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    Halaman Tidak Ditemukan
                </h2>
                <p class="text-gray-600 mb-8">
                    Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-150 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
