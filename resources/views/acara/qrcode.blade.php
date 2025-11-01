<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $acara->nama_acara }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 20px; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Actions (No Print) -->
        <div class="no-print mb-6 flex items-center justify-between">
            <a href="{{ route('acara.show', $acara->id_acara) }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg text-white hover:bg-opacity-30 transition-all">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            <div class="flex gap-3">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg text-white hover:bg-opacity-30 transition-all">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak QR
                </button>

                <button onclick="downloadQR()" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg text-white hover:bg-opacity-30 transition-all">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </button>
            </div>
        </div>

        <!-- QR Code Card -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ $acara->nama_acara }}</h1>
                            <div class="flex items-center gap-4 text-indigo-100">
                                <span class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($acara->tanggal)->isoFormat('D MMMM Y') }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ substr($acara->waktu_mulai, 0, 5) }} - {{ substr($acara->waktu_selesai, 0, 5) }} WIB
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white bg-opacity-20 backdrop-blur-sm">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $acara->tempat }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Display -->
                <div class="p-12 text-center">
                    <div class="inline-block p-8 bg-white rounded-2xl shadow-inner border-4 border-gray-100">
                        <div id="qrcode" class="flex items-center justify-center">
                            {!! $qrCode !!}
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="mt-8 max-w-2xl mx-auto">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Cara Melakukan Presensi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-indigo-100 rounded-full p-2 mr-3">
                                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">1. Buka Kamera</p>
                                        <p class="text-xs text-gray-600">Gunakan smartphone Anda</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-purple-100 rounded-full p-2 mr-3">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">2. Scan QR Code</p>
                                        <p class="text-xs text-gray-600">Arahkan ke QR code di atas</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-green-100 rounded-full p-2 mr-3">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">3. Konfirmasi</p>
                                        <p class="text-xs text-gray-600">Presensi Anda tersimpan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Token Info -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 font-mono">QR Token: {{ $acara->qr_token }}</p>
                        <p class="text-xs text-gray-400 mt-1">Generated at {{ \Carbon\Carbon::parse($acara->created_at)->isoFormat('D MMMM Y HH:mm') }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Jenis Acara: <span class="font-semibold text-gray-900">{{ $acara->jenis_acara }}</span></span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Target: <span class="font-semibold text-gray-900">{{ $acara->target_peserta ?? 'Semua Pengurus' }}</span></span>
                        </div>

                        <div class="text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($acara->status == 'aktif') bg-green-100 text-green-800
                                @elseif($acara->status == 'selesai') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($acara->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo/Branding -->
            <div class="text-center mt-8">
                <p class="text-white text-lg font-semibold drop-shadow-lg">HIMA IF - Himpunan Mahasiswa Informatika</p>
                <p class="text-white text-sm opacity-90 mt-1">Sistem Presensi QR Code</p>
            </div>
        </div>
    </div>

    <script>
        function downloadQR() {
            // Get the QR code SVG
            const svg = document.querySelector('#qrcode svg');
            if (!svg) {
                alert('QR Code tidak ditemukan');
                return;
            }

            // Create a canvas
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas size (increase for better quality)
            const size = 1000;
            canvas.width = size;
            canvas.height = size;

            // Convert SVG to data URL
            const svgData = new XMLSerializer().serializeToString(svg);
            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(svgBlob);

            // Create image from SVG
            const img = new Image();
            img.onload = function() {
                // Draw white background
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, size, size);
                
                // Draw QR code
                ctx.drawImage(img, 0, 0, size, size);
                
                // Convert canvas to blob and download
                canvas.toBlob(function(blob) {
                    const downloadUrl = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = 'qrcode-{{ Str::slug($acara->nama_acara) }}.png';
                    link.href = downloadUrl;
                    link.click();
                    
                    URL.revokeObjectURL(downloadUrl);
                    URL.revokeObjectURL(url);
                });
            };
            img.src = url;
        }

        // Auto refresh every 5 minutes to keep session alive
        setInterval(function() {
            fetch('{{ route('acara.qrcode', $acara->id_acara) }}', {
                method: 'HEAD',
                credentials: 'same-origin'
            });
        }, 300000); // 5 minutes
    </script>
</body>
</html>
