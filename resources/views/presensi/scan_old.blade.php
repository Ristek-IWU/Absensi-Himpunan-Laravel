@extends('layouts.admin')

@section('title', 'Sistem Presensi QR Code')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Sistem Presensi QR Code</h2>
            <p class="text-gray-600">Pilih mode: Scan untuk absen atau Tampilkan QR untuk acara</p>
        </div>

        <!-- Mode Selection (Initial State) -->
        <div id="mode-selection" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Scan Mode Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer border-2 border-transparent hover:border-indigo-500" onclick="selectMode('scan')">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-8 text-center">
                    <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm rounded-full p-6 mb-4">
                        <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Scan QR Code</h3>
                    <p class="text-indigo-100 text-sm mb-6">Untuk Pengurus yang ingin melakukan presensi</p>
                    <button class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition-colors">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Buka Kamera
                    </button>
                </div>
                <div class="p-6 bg-gray-50">
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="mr-2 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Aktifkan kamera HP
                        </li>
                        <li class="flex items-center">
                            <svg class="mr-2 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Scan QR yang ditampilkan panitia
                        </li>
                        <li class="flex items-center">
                            <svg class="mr-2 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Presensi otomatis tersimpan
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Display QR Mode Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer border-2 border-transparent hover:border-green-500" onclick="selectMode('display')">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-center">
                    <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm rounded-full p-6 mb-4">
                        <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Tampilkan QR Code</h3>
                    <p class="text-green-100 text-sm mb-6">Untuk Panitia/Admin menampilkan QR acara</p>
                    <button class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Pilih Acara
                    </button>
                </div>
                <div class="p-6 bg-gray-50">
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="mr-2 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Pilih acara dari list
                        </li>
                        <li class="flex items-center">
                            <svg class="mr-2 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Tampilkan QR di layar/proyektor
                        </li>
                        <li class="flex items-center">
                            <svg class="mr-2 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Pengurus scan untuk absen
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Scanner Section (Hidden Initially) -->
        <div id="scanner-section" class="hidden">
            <div class="mb-4">
                <button onclick="backToSelection()" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Scanner -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Scanner Header -->
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="mr-2 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                                Scanner QR Code
                            </h3>
                        </div>

                        <!-- Camera Preview -->
                        <div class="relative bg-gray-900">
                            <div id="reader" class="w-full"></div>
                        
                        <!-- Scanning Overlay -->
                        <div id="scanning-overlay" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="text-center text-white">
                                <svg class="animate-spin h-12 w-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-lg font-semibold">Memproses...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Scanner Controls -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <button id="start-button" onclick="startScanner()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Mulai Scan
                                </button>

                                <button id="stop-button" onclick="stopScanner()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors hidden">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                    </svg>
                                    Stop Scan
                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                <label for="camera-select" class="text-sm text-gray-600">Kamera:</label>
                                <select id="camera-select" onchange="changeCamera()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status Indicator -->
                        <div id="scanner-status" class="mt-3 text-sm text-gray-600 flex items-center">
                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                            Scanner tidak aktif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info & Instructions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Instructions Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Panduan
                        </h3>
                    </div>

                    <div class="px-6 py-4 space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-2 mr-3">
                                <span class="text-green-600 font-bold text-sm">1</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Klik "Mulai Scan"</p>
                                <p class="text-xs text-gray-600 mt-1">Izinkan akses kamera jika diminta browser</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-2 mr-3">
                                <span class="text-blue-600 font-bold text-sm">2</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Arahkan Kamera</p>
                                <p class="text-xs text-gray-600 mt-1">Posisikan QR code di dalam frame kotak</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-purple-100 rounded-full p-2 mr-3">
                                <span class="text-purple-600 font-bold text-sm">3</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Tunggu Deteksi</p>
                                <p class="text-xs text-gray-600 mt-1">Scanner akan otomatis mendeteksi QR code</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-full p-2 mr-3">
                                <span class="text-yellow-600 font-bold text-sm">4</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Presensi Tersimpan</p>
                                <p class="text-xs text-gray-600 mt-1">Notifikasi sukses akan muncul otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-lg border-2 border-yellow-200 p-5">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Tips Scanning</h4>
                            <ul class="text-xs text-gray-700 space-y-1 list-disc list-inside">
                                <li>Pastikan pencahayaan cukup terang</li>
                                <li>Jaga jarak kamera 15-30 cm dari QR</li>
                                <li>Pastikan QR code tidak terlipat/rusak</li>
                                <li>Gunakan kamera belakang untuk hasil terbaik</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Device Info -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Informasi Device</h4>
                    <div class="space-y-2 text-xs text-gray-600">
                        <p><span class="font-medium">Browser:</span> <span id="browser-info">-</span></p>
                        <p><span class="font-medium">Platform:</span> <span id="platform-info">-</span></p>
                        <p><span class="font-medium">IP Address:</span> <span id="ip-info">Loading...</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scans -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Presensi Hari Ini</h3>
                </div>

                <div id="recent-scans" class="divide-y divide-gray-200">
                    <!-- Will be populated dynamically -->
                    <div class="px-6 py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="mt-2 text-sm">Belum ada presensi hari ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
        <div class="px-6 py-5">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-center text-xl font-bold text-gray-900 mb-2">Presensi Berhasil!</h3>
            <div id="success-message" class="text-center text-gray-600 mb-4"></div>
            <button onclick="closeModal()" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="error-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
        <div class="px-6 py-5">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-center text-xl font-bold text-gray-900 mb-2">Presensi Gagal</h3>
            <div id="error-message" class="text-center text-gray-600 mb-4"></div>
            <button onclick="closeModal()" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Include html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrcodeScanner = null;
let isScanning = false;

// Get device info
document.getElementById('browser-info').textContent = navigator.userAgent.split(' ').slice(-1)[0];
document.getElementById('platform-info').textContent = navigator.platform;

// Get IP address
fetch('https://api.ipify.org?format=json')
    .then(response => response.json())
    .then(data => {
        document.getElementById('ip-info').textContent = data.ip;
    })
    .catch(() => {
        document.getElementById('ip-info').textContent = 'Tidak dapat dideteksi';
    });

// Start scanner
function startScanner() {
    if (isScanning) return;

    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        rememberLastUsedCamera: true,
        aspectRatio: 1.0
    };

    html5QrcodeScanner = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
            // Populate camera select
            const select = document.getElementById('camera-select');
            select.innerHTML = '';
            cameras.forEach((camera, index) => {
                const option = document.createElement('option');
                option.value = camera.id;
                option.text = camera.label || `Camera ${index + 1}`;
                select.appendChild(option);
            });

            // Start with first camera
            const cameraId = cameras[0].id;
            html5QrcodeScanner.start(
                cameraId,
                config,
                onScanSuccess,
                onScanFailure
            ).then(() => {
                isScanning = true;
                updateScannerStatus(true);
            }).catch(err => {
                console.error('Error starting scanner:', err);
                alert('Gagal memulai kamera. Pastikan Anda memberikan izin akses kamera.');
            });
        }
    }).catch(err => {
        console.error('Error getting cameras:', err);
        alert('Tidak dapat mengakses kamera. Pastikan browser memiliki izin.');
    });
}

// Stop scanner
function stopScanner() {
    if (!isScanning || !html5QrcodeScanner) return;

    html5QrcodeScanner.stop().then(() => {
        isScanning = false;
        updateScannerStatus(false);
    }).catch(err => {
        console.error('Error stopping scanner:', err);
    });
}

// Change camera
function changeCamera() {
    if (!isScanning) return;
    
    stopScanner();
    setTimeout(() => {
        const cameraId = document.getElementById('camera-select').value;
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        };

        html5QrcodeScanner.start(cameraId, config, onScanSuccess, onScanFailure)
            .then(() => {
                isScanning = true;
                updateScannerStatus(true);
            });
    }, 500);
}

// On scan success
function onScanSuccess(decodedText, decodedResult) {
    // Show overlay
    document.getElementById('scanning-overlay').classList.remove('hidden');

    // Verify QR code with server
    fetch('{{ route("presensi.scan.verify") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            qr_token: decodedText,
            device_info: navigator.userAgent,
            latitude: null, // Will be filled if geolocation is enabled
            longitude: null
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('scanning-overlay').classList.add('hidden');
        
        if (data.success) {
            showSuccessModal(data.message, data.data);
            loadRecentScans();
            
            // Stop scanner after successful scan
            setTimeout(() => {
                stopScanner();
            }, 2000);
        } else {
            showErrorModal(data.message);
        }
    })
    .catch(error => {
        document.getElementById('scanning-overlay').classList.add('hidden');
        console.error('Error:', error);
        showErrorModal('Terjadi kesalahan saat memverifikasi QR code.');
    });
}

// On scan failure (not an error, just no QR detected)
function onScanFailure(error) {
    // Ignore, this fires frequently when no QR is in view
}

// Update scanner status
function updateScannerStatus(active) {
    const status = document.getElementById('scanner-status');
    const startBtn = document.getElementById('start-button');
    const stopBtn = document.getElementById('stop-button');

    if (active) {
        status.innerHTML = '<span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>Scanner aktif - Arahkan ke QR code';
        status.className = 'mt-3 text-sm text-green-600 flex items-center font-medium';
        startBtn.classList.add('hidden');
        stopBtn.classList.remove('hidden');
    } else {
        status.innerHTML = '<span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>Scanner tidak aktif';
        status.className = 'mt-3 text-sm text-gray-600 flex items-center';
        startBtn.classList.remove('hidden');
        stopBtn.classList.add('hidden');
    }
}

// Show success modal
function showSuccessModal(message, data) {
    document.getElementById('success-message').innerHTML = `
        <p class="text-lg font-semibold mb-2">${data.acara_name}</p>
        <p>${message}</p>
        <p class="text-sm mt-2">Status: <span class="font-semibold">${data.status_kehadiran}</span></p>
    `;
    document.getElementById('success-modal').classList.remove('hidden');
}

// Show error modal
function showErrorModal(message) {
    document.getElementById('error-message').textContent = message;
    document.getElementById('error-modal').classList.remove('hidden');
}

// Close modal
function closeModal() {
    document.getElementById('success-modal').classList.add('hidden');
    document.getElementById('error-modal').classList.add('hidden');
}

// Load recent scans
function loadRecentScans() {
    fetch('{{ route("presensi.pengurus.index") }}?today=1')
        .then(response => response.text())
        .then(html => {
            // Parse and extract recent scans (simplified)
            // In production, you'd have a dedicated API endpoint
            console.log('Recent scans loaded');
        })
        .catch(error => {
            console.error('Error loading recent scans:', error);
        });
}

// Load recent scans on page load
document.addEventListener('DOMContentLoaded', function() {
    loadRecentScans();
});
</script>
@endsection
