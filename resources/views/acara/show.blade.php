@extends('layouts.admin')

@section('title', 'Detail Acara')

@section('content')
@php
    // Status badge colors
    $statusBadge = 'bg-gray-500';
    if($acara->status == 'aktif') {
        $statusBadge = 'bg-green-500';
    } elseif($acara->status == 'selesai') {
        $statusBadge = 'bg-blue-500';
    } else {
        $statusBadge = 'bg-red-500';
    }
    
    // Divisi colors mapping
    $divisiColors = [
        'BPH' => 'bg-purple-100 text-purple-700',
        'Sekretaris' => 'bg-blue-100 text-blue-700',
        'Bendahara' => 'bg-green-100 text-green-700',
        'Riset Teknologi' => 'bg-indigo-100 text-indigo-700',
        'PSDM' => 'bg-yellow-100 text-yellow-700',
        'Kominfo' => 'bg-pink-100 text-pink-700'
    ];
    
    // Status colors mapping
    $statusColors = [
        'Hadir' => ['badge' => 'bg-green-100 text-green-700', 'dot' => 'bg-green-500'],
        'Terlambat' => ['badge' => 'bg-yellow-100 text-yellow-700', 'dot' => 'bg-yellow-500'],
        'Izin' => ['badge' => 'bg-blue-100 text-blue-700', 'dot' => 'bg-blue-500'],
        'Sakit' => ['badge' => 'bg-red-100 text-red-700', 'dot' => 'bg-red-500']
    ];
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('acara.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Detail Acara</h1>
        </div>
        
        <div class="flex gap-3">
            @if($acara->status == 'aktif')
            <a href="{{ route('acara.qrcode', $acara->id_acara) }}" target="_blank" 
               class="inline-flex items-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                QR Code
            </a>
            @endif
            
            <a href="{{ route('acara.edit', $acara->id_acara) }}" 
               class="inline-flex items-center px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Hero Card -->
    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-xl p-8">
        <div class="flex items-start gap-4 mb-6">
            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">{{ $acara->nama_acara }}</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 backdrop-blur-sm text-white">
                        <span class="w-2 h-2 {{ $statusBadge }} rounded-full mr-2 animate-pulse"></span>
                        {{ ucfirst($acara->status) }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 backdrop-blur-sm text-white">
                        {{ $acara->jenis_acara }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-white">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 opacity-80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div class="min-w-0">
                    <p class="text-xs text-white text-opacity-80">Tanggal</p>
                    <p class="text-sm font-semibold truncate">{{ \Carbon\Carbon::parse($acara->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 opacity-80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-xs text-white text-opacity-80">Waktu</p>
                    <p class="text-sm font-semibold">{{ substr($acara->waktu_mulai, 0, 5) }} - {{ substr($acara->waktu_selesai, 0, 5) }} WIB</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 opacity-80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div class="min-w-0">
                    <p class="text-xs text-white text-opacity-80">Lokasi</p>
                    <p class="text-sm font-semibold truncate">{{ $acara->tempat }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 opacity-80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <div>
                    <p class="text-xs text-white text-opacity-80">Target Peserta</p>
                    <p class="text-sm font-semibold">{{ $acara->target_peserta ?? 'Semua Pengurus' }}</p>
                </div>
            </div>
        </div>
        
        @if($acara->deskripsi)
        <div class="mt-6 pt-6 border-t border-white border-opacity-20">
            <p class="text-white text-opacity-90 leading-relaxed">{{ $acara->deskripsi }}</p>
        </div>
        @endif
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Hadir</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats->hadir ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Pengurus hadir</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Terlambat</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats->terlambat ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Pengurus terlambat</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Izin</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats->izin ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Pengurus izin</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">Sakit</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats->sakit ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Pengurus sakit</p>
        </div>
    </div>

    <!-- Summary -->
    @if($totalPresensi > 0)
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Presensi</p>
                    <p class="text-3xl font-bold text-white">{{ $totalPresensi }} <span class="text-lg text-gray-400">orang</span></p>
                </div>
            </div>
            
            <div class="text-center sm:text-right">
                <p class="text-sm text-gray-400 mb-1">Tingkat Kehadiran</p>
                <div class="flex items-center gap-2">
                    <div class="w-32 h-3 bg-white bg-opacity-10 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 rounded-full" 
                             style="width: {{ number_format((($stats->hadir ?? 0) / $totalPresensi) * 100, 1) }}%"></div>
                    </div>
                    <p class="text-2xl font-bold text-green-400">{{ number_format((($stats->hadir ?? 0) / $totalPresensi) * 100, 1) }}%</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Presensi Pengurus</h3>
                    <p class="text-sm text-gray-500 mt-1">Rincian kehadiran pengurus pada acara ini</p>
                </div>
                @if($totalPresensi > 0)
                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak
                </button>
                @endif
            </div>
        </div>

        @if($presensiList->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Pengurus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Divisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Waktu Scan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Device</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presensiList as $index => $presensi)
                    @php
                        $divisiClass = $divisiColors[$presensi->divisi] ?? 'bg-orange-100 text-orange-700';
                        $statusStyle = $statusColors[$presensi->status_kehadiran] ?? ['badge' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-500'];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($presensi->pengurus_name, 0, 1)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $presensi->pengurus_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $presensi->nim }}</div>
                                    <div class="md:hidden mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $divisiClass }}">
                                            {{ $presensi->divisi }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold {{ $divisiClass }}">
                                {{ $presensi->divisi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($presensi->qr_scan_time ?? $presensi->created_at)->format('H:i:s') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($presensi->qr_scan_time ?? $presensi->created_at)->isoFormat('D MMMM Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold {{ $statusStyle['badge'] }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $statusStyle['dot'] }}"></span>
                                {{ $presensi->status_kehadiran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 hidden lg:table-cell">
                            <div class="max-w-xs truncate">{{ $presensi->device_info ?? '-' }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Presensi</h3>
            <p class="text-sm text-gray-500 mb-6">Pengurus belum melakukan scan QR code untuk acara ini.</p>
            @if($acara->status == 'aktif')
            <a href="{{ route('acara.qrcode', $acara->id_acara) }}" target="_blank" 
               class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                Tampilkan QR Code
            </a>
            @endif
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($acara->pembuat_name ?? 'A', 0, 1)) }}</span>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Dibuat oleh</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $acara->pembuat_name ?? 'Admin' }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Tanggal dibuat</p>
                <p class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($acara->created_at)->isoFormat('D MMMM Y, HH:mm') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection