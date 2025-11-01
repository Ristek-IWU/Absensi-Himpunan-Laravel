@extends('layouts.admin')

@section('title', 'Sistem Presensi QR Code')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Sistem Presensi QR Code</h2>
            <p class="text-gray-600">Pilih mode: Scan untuk absen atau Tampilkan QR untuk acara</p>
        </div>

        <!-- Mode Selection (Initial State) -->
        <div id="mode-selection">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Scan Mode Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all cursor-pointer border-2 border-transparent hover:border-indigo-500 transform hover:scale-105" onclick="selectMode('scan')">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-8 text-center">
                        <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm rounded-full p-6 mb-4">
                            <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Scan QR Code</h3>
                        <p class="text-indigo-100 text-sm mb-6">Untuk Pengurus yang ingin melakukan presensi</p>
                        <div class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Buka Kamera
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center">
                                <svg class="mr-2 h-4 w-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Aktifkan kamera HP
                            </li>
                            <li class="flex items-center">
                                <svg class="mr-2 h-4 w-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Scan QR yang ditampilkan panitia
                            </li>
                            <li class="flex items-center">
                                <svg class="mr-2 h-4 w-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Presensi otomatis tersimpan
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Display QR Mode Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all cursor-pointer border-2 border-transparent hover:border-green-500 transform hover:scale-105" onclick="selectMode('display')">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-center">
                        <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm rounded-full p-6 mb-4">
                            <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Tampilkan QR Code</h3>
                        <p class="text-green-100 text-sm mb-6">Untuk Panitia/Admin menampilkan QR acara</p>
                        <div class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-lg font-semibold">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Pilih Acara
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center">
                                <svg class="mr-2 h-4 w-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pilih acara dari list
                            </li>
                            <li class="flex items-center">
                                <svg class="mr-2 h-4 w-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Tampilkan QR di layar/proyektor
                            </li>
                            <li class="flex items-center">
                                <svg class="mr-2 h-4 w-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pengurus scan untuk absen
                            </li>
                        </ul>
                    </div>
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
                    Kembali ke Pilihan
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="mr-2 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Scanner QR Code - Mode Absensi
                    </h3>
                </div>

                <div class="relative bg-gray-900 min-h-[400px]">
                    <div id="reader" class="w-full"></div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-3">
                        <button id="start-button" onclick="startScanner()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mulai Scan
                        </button>

                        <button id="stop-button" onclick="stopScanner()" class="hidden inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                            </svg>
                            Stop Scan
                        </button>

                        <select id="camera-select" onchange="changeCamera()" class="text-sm border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Kamera...</option>
                        </select>
                    </div>
                    <p class="text-xs text-gray-600">Arahkan kamera ke QR code yang ditampilkan panitia</p>
                </div>
            </div>
        </div>

        <!-- Display QR Section (Hidden Initially) -->
        <div id="display-section" class="hidden">
            <div class="mb-4">
                <button onclick="backToSelection()" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Pilihan
                </button>
            </div>

            <!-- Event Selection -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Pilih Acara untuk Ditampilkan</h3>
                </div>
                <div class="p-6">
                    <select id="event-select" onchange="loadEventQR()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">-- Pilih Acara --</option>
                        @foreach($acaraList ?? [] as $acara)
                        <option value="{{ $acara->id_acara }}" data-token="{{ $acara->qr_token }}" data-name="{{ $acara->nama_acara }}">
                            {{ $acara->nama_acara }} - {{ \Carbon\Carbon::parse($acara->tanggal)->format('d/m/Y') }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- QR Display -->
            <div id="qr-display-container" class="hidden">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-2xl overflow-hidden border-4 border-green-200">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 text-center">
                        <h2 id="event-name" class="text-3xl font-bold text-white mb-2">Nama Acara</h2>
                        <p class="text-green-100">Scan QR code ini untuk melakukan presensi</p>
                    </div>

                    <div class="p-12 text-center">
                        <div class="inline-block p-8 bg-white rounded-2xl shadow-xl">
                            <div id="qr-code-display" class="flex items-center justify-center min-h-[300px] min-w-[300px]">
                                <!-- QR Code will be generated here -->
                            </div>
                        </div>
                        <p class="mt-6 text-gray-600 text-sm">Arahkan kamera HP ke QR code di atas</p>
                    </div>

                    <div class="bg-green-50 px-8 py-4 border-t-2 border-green-200 flex justify-center gap-4">
                        <button onclick="printQR()" class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-green-50 border-2 border-green-600">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Cetak QR
                        </button>
                        <button onclick="fullscreenQR()" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            Fullscreen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include html5-qrcode Library for Scanner -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<!-- Include QRCode.js for Generator -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
let html5QrcodeScanner = null;
let isScanning = false;
let currentQRCode = null;

// Mode Selection
function selectMode(mode) {
    document.getElementById('mode-selection').classList.add('hidden');
    
    if (mode === 'scan') {
        document.getElementById('scanner-section').classList.remove('hidden');
    } else if (mode === 'display') {
        document.getElementById('display-section').classList.remove('hidden');
    }
}

// Back to selection
function backToSelection() {
    // Stop scanner if running
    if (isScanning && html5QrcodeScanner) {
        stopScanner();
    }
    
    document.getElementById('mode-selection').classList.remove('hidden');
    document.getElementById('scanner-section').classList.add('hidden');
    document.getElementById('display-section').classList.add('hidden');
    document.getElementById('qr-display-container').classList.add('hidden');
}

// ===== SCANNER MODE FUNCTIONS =====

// Get available cameras
function getCameras() {
    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            const select = document.getElementById('camera-select');
            select.innerHTML = '';
            
            devices.forEach((device, index) => {
                const option = document.createElement('option');
                option.value = device.id;
                option.text = device.label || `Kamera ${index + 1}`;
                select.appendChild(option);
            });
        }
    }).catch(err => {
        console.error('Error getting cameras:', err);
    });
}

// Start scanner
function startScanner() {
    const cameraId = document.getElementById('camera-select').value;
    if (!cameraId) {
        alert('Pilih kamera terlebih dahulu');
        return;
    }

    html5QrcodeScanner = new Html5Qrcode("reader");
    
    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 }
    };

    html5QrcodeScanner.start(cameraId, config, onScanSuccess, onScanFailure)
        .then(() => {
            isScanning = true;
            document.getElementById('start-button').classList.add('hidden');
            document.getElementById('stop-button').classList.remove('hidden');
        })
        .catch(err => {
            console.error('Error starting scanner:', err);
            alert('Gagal memulai kamera. Pastikan browser memiliki izin akses kamera.');
        });
}

// Stop scanner
function stopScanner() {
    if (!isScanning || !html5QrcodeScanner) return;

    html5QrcodeScanner.stop().then(() => {
        isScanning = false;
        document.getElementById('start-button').classList.remove('hidden');
        document.getElementById('stop-button').classList.add('hidden');
    }).catch(err => {
        console.error('Error stopping scanner:', err);
    });
}

// Change camera
function changeCamera() {
    if (isScanning) {
        stopScanner();
        setTimeout(() => startScanner(), 500);
    }
}

// On scan success
function onScanSuccess(decodedText, decodedResult) {
    stopScanner();
    
    // Show loading state
    showLoading('Memverifikasi QR Code...');
    
    // Send to server for verification
    fetch('/api/presensi/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ qr_token: decodedText })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            // Play success sound
            playSound('success');
            
            // Show success modal
            showSuccessModal(data.data, data.stats);
            
            // Refresh today's scans
            loadTodayScans();
        } else {
            // Play error sound
            playSound('error');
            
            // Show error message
            showErrorModal(data.message);
        }
    })
    .catch(error => {
        hideLoading();
        playSound('error');
        console.error('Error:', error);
        showErrorModal('Terjadi kesalahan saat memverifikasi QR code. Silakan coba lagi.');
    });
}

// On scan failure
function onScanFailure(error) {
    // Silent - scanning in progress
}

// ===== DISPLAY QR MODE FUNCTIONS =====

// Load event QR code
function loadEventQR() {
    const select = document.getElementById('event-select');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption.value) {
        document.getElementById('qr-display-container').classList.add('hidden');
        return;
    }

    const token = selectedOption.getAttribute('data-token');
    const eventName = selectedOption.getAttribute('data-name');
    
    // Update event name
    document.getElementById('event-name').textContent = eventName;
    
    // Clear previous QR
    const container = document.getElementById('qr-code-display');
    container.innerHTML = '';
    
    // Generate new QR code
    currentQRCode = new QRCode(container, {
        text: token,
        width: 300,
        height: 300,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
    
    // Show container
    document.getElementById('qr-display-container').classList.remove('hidden');
}

// Print QR code
function printQR() {
    window.print();
}

// Fullscreen QR
function fullscreenQR() {
    const container = document.getElementById('qr-display-container');
    if (container.requestFullscreen) {
        container.requestFullscreen();
    } else if (container.webkitRequestFullscreen) {
        container.webkitRequestFullscreen();
    } else if (container.msRequestFullscreen) {
        container.msRequestFullscreen();
    }
}

// Initialize when scanner mode is selected
document.addEventListener('DOMContentLoaded', function() {
    // Get cameras when page loads
    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            const select = document.getElementById('camera-select');
            devices.forEach((device, index) => {
                const option = document.createElement('option');
                option.value = device.id;
                option.text = device.label || `Kamera ${index + 1}`;
                select.appendChild(option);
            });
        }
    }).catch(err => {
        console.error('Error:', err);
    });
    
    // Load today's scans on page load
    loadTodayScans();
});

// ===== UI HELPER FUNCTIONS =====

// Show loading overlay
function showLoading(message = 'Loading...') {
    const overlay = document.createElement('div');
    overlay.id = 'loading-overlay';
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.innerHTML = `
        <div class="bg-white rounded-lg p-8 text-center">
            <svg class="animate-spin h-12 w-12 mx-auto mb-4 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-700 font-medium">${message}</p>
        </div>
    `;
    document.body.appendChild(overlay);
}

// Hide loading overlay
function hideLoading() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) overlay.remove();
}

// Show success modal
function showSuccessModal(data, stats) {
    const modal = document.createElement('div');
    modal.id = 'success-modal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all animate-bounce-in">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-white rounded-full p-3">
                        <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-center text-2xl font-bold text-white">Presensi Berhasil!</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold text-gray-900">${data.nama}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-gray-600">NIM:</span>
                        <span class="font-semibold text-gray-900">${data.nim}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-gray-600">Divisi:</span>
                        <span class="font-semibold text-gray-900">${data.divisi}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-gray-600">Acara:</span>
                        <span class="font-semibold text-gray-900">${data.acara}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold ${data.status === 'Hadir' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${data.status}
                        </span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-gray-600">Waktu Scan:</span>
                        <span class="font-semibold text-gray-900">${data.jam_scan}</span>
                    </div>
                </div>
                
                ${stats ? `
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-4 mb-4">
                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Statistik Kehadiran</h4>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-600">Total Hadir:</span>
                        <span class="text-sm font-bold text-indigo-600">${stats.total_hadir} / ${stats.total_pengurus}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: ${stats.persentase}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 text-right">${stats.persentase}% kehadiran</p>
                </div>
                ` : ''}
                
                <button onclick="closeSuccessModal()" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all font-semibold">
                    Tutup
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Show error modal
function showErrorModal(message) {
    const modal = document.createElement('div');
    modal.id = 'error-modal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-white rounded-full p-3">
                        <svg class="h-16 w-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-center text-2xl font-bold text-white">Presensi Gagal</h3>
            </div>
            <div class="p-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <p class="text-red-700">${message}</p>
                </div>
                <button onclick="closeErrorModal()" class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-3 rounded-lg hover:from-red-600 hover:to-pink-700 transition-all font-semibold">
                    Tutup
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Close modals
function closeSuccessModal() {
    const modal = document.getElementById('success-modal');
    if (modal) modal.remove();
    backToSelection();
}

function closeErrorModal() {
    const modal = document.getElementById('error-modal');
    if (modal) modal.remove();
}

// Play sound notification
function playSound(type) {
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    if (type === 'success') {
        // Success sound: Happy beep
        oscillator.frequency.value = 800;
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.1);
        
        setTimeout(() => {
            const osc2 = audioContext.createOscillator();
            const gain2 = audioContext.createGain();
            osc2.connect(gain2);
            gain2.connect(audioContext.destination);
            osc2.frequency.value = 1000;
            gain2.gain.setValueAtTime(0.3, audioContext.currentTime);
            osc2.start(audioContext.currentTime);
            osc2.stop(audioContext.currentTime + 0.15);
        }, 100);
    } else if (type === 'error') {
        // Error sound: Low buzz
        oscillator.frequency.value = 200;
        oscillator.type = 'sawtooth';
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.3);
    }
}

// Load today's scans
function loadTodayScans() {
    // This function can be implemented to fetch and display today's scans
    // For now, we'll skip it to keep things simple
    console.log('Loading today scans...');
}
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #qr-display-container, #qr-display-container * {
        visibility: visible;
    }
    #qr-display-container {
        position: absolute;
        left: 0;
        top: 0;
    }
}

@keyframes bounce-in {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.animate-bounce-in {
    animation: bounce-in 0.5s ease-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
    20%, 40%, 60%, 80% { transform: translateX(10px); }
}

.animate-shake {
    animation: shake 0.5s;
}
</style>

@endsection
