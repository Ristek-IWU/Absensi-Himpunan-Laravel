@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="mt-2 text-sm text-gray-700">Selamat datang di Sistem Absensi Himpunan Mahasiswa Informatika</p>
</div>

<!-- ACARA SEDANG BERLANGSUNG - HIGHLIGHT DENGAN QR CODE -->
@if($acaraBerlangsung)
<div class="mb-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl overflow-hidden">
    <div class="px-8 py-6">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 bg-white rounded-full p-2 mr-3 animate-pulse">
                <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <circle cx="10" cy="10" r="8"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">ACARA SEDANG BERLANGSUNG</h2>
                <p class="text-indigo-100 text-sm">Scan QR Code sekarang untuk presensi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Info Acara -->
            <div class="lg:col-span-2 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6">
                <h3 class="text-3xl font-bold text-white mb-4">{{ $acaraBerlangsung->nama_acara }}</h3>
                
                <div class="space-y-3 text-white">
                    <div class="flex items-center">
                        <svg class="mr-3 h-6 w-6 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-lg">{{ \Carbon\Carbon::parse($acaraBerlangsung->tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="mr-3 h-6 w-6 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-lg">{{ substr($acaraBerlangsung->waktu_mulai, 0, 5) }} - {{ substr($acaraBerlangsung->waktu_selesai, 0, 5) }} WIB</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="mr-3 h-6 w-6 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-lg">{{ $acaraBerlangsung->tempat }}</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="mr-3 h-6 w-6 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="text-lg font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">{{ $acaraBerlangsung->jenis_acara }}</span>
                    </div>
                </div>

                @if($acaraBerlangsung->deskripsi)
                <div class="mt-4 p-4 bg-white bg-opacity-10 rounded-lg">
                    <p class="text-white text-sm leading-relaxed">{{ $acaraBerlangsung->deskripsi }}</p>
                </div>
                @endif

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('acara.show', $acaraBerlangsung->id_acara) }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition-colors">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Detail Acara
                    </a>
                    <a href="{{ route('presensi.scan') }}" class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-colors">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        Buka Scanner
                    </a>
                </div>
            </div>

            <!-- QR Code -->
            <div class="flex items-center justify-center">
                <div class="bg-white rounded-2xl p-6 shadow-2xl">
                    <div class="text-center mb-3">
                        <p class="text-sm font-bold text-gray-900">SCAN SEKARANG</p>
                        <p class="text-xs text-gray-500">Arahkan kamera ke QR ini</p>
                    </div>
                    <div class="bg-white p-3 rounded-xl border-4 border-indigo-200">
                        {!! $qrCodeBerlangsung !!}
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2 font-mono">Token: {{ substr($acaraBerlangsung->qr_token, 0, 8) }}...</p>
                </div>
            </div>
        </div>

        <!-- Kehadiran per Divisi untuk Acara Berlangsung -->
        <div class="mt-6 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6">
            <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Kehadiran Per Divisi
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($kehadiranPerDivisi as $divisi)
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-white font-semibold text-sm">{{ $divisi->divisi }}</span>
                        <span class="text-white text-xs">{{ $divisi->persentase }}%</span>
                    </div>
                    <div class="w-full bg-white bg-opacity-20 rounded-full h-2 mb-1">
                        <div class="bg-white h-2 rounded-full" style="width: {{ $divisi->persentase }}%"></div>
                    </div>
                    <p class="text-indigo-100 text-xs">{{ $divisi->total_hadir }} / {{ $divisi->total_pengurus }} hadir</p>
                </div>
                @empty
                <div class="col-span-4 text-center text-white text-sm py-4">
                    Belum ada yang hadir
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endif

<!-- Stats cards -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Pengurus -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pengurus</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $totalPengurus ?? 0 }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <a href="{{ route('pengurus.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Lihat semua →
            </a>
        </div>
    </div>

    <!-- Hadir Hari Ini -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-md bg-green-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Hadir Hari Ini</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $hadirHariIni ?? 0 }}</div>
                            <div class="ml-2 text-sm text-gray-500">({{ $persentaseHadir ?? 0 }}%)</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <a href="{{ route('presensi.pengurus.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500">
                Lihat presensi →
            </a>
        </div>
    </div>

    <!-- Total Acara Aktif -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-md bg-yellow-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Acara Aktif</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $totalAcara ?? 0 }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <a href="{{ route('acara.index') }}" class="text-sm font-medium text-yellow-600 hover:text-yellow-500">
                Kelola acara →
            </a>
        </div>
    </div>

    <!-- Scan QR -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-md bg-purple-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Scan QR Code</dt>
                        <dd class="flex items-baseline">
                            <div class="text-sm font-medium text-gray-900">Absen Sekarang</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <a href="{{ route('presensi.scan') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">
                Mulai scan →
            </a>
        </div>
    </div>
</div>

<!-- Grid 2 Kolom: Acara Mendatang & Aktivitas Terbaru -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Acara Mendatang -->
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Acara Mendatang
            </h3>
        </div>
        <div class="p-6">
            @forelse($acaraMendatang as $acara)
            <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900">{{ $acara->nama_acara }}</h4>
                        <div class="mt-2 space-y-1">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($acara->tanggal)->isoFormat('D MMM Y') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ substr($acara->waktu_mulai, 0, 5) }} - {{ substr($acara->waktu_selesai, 0, 5) }} WIB
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $acara->tempat }}
                            </div>
                        </div>
                    </div>
                    <div class="ml-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $acara->jenis_acara }}
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('acara.show', $acara->id_acara) }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                        Lihat detail →
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Tidak ada acara mendatang</p>
                <a href="{{ route('acara.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Buat Acara Baru
                </a>
            </div>
            @endforelse
        </div>
        @if($acaraMendatang->count() > 0)
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('acara.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Lihat semua acara →
            </a>
        </div>
        @endif
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Aktivitas Presensi Terbaru
            </h3>
        </div>
        <div class="p-6">
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @forelse($recentActivities as $activity)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                        @if($activity->status_kehadiran == 'Hadir') bg-green-500
                                        @elseif($activity->status_kehadiran == 'Terlambat') bg-yellow-500
                                        @elseif($activity->status_kehadiran == 'Izin') bg-blue-500
                                        @else bg-red-500
                                        @endif">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                    <div>
                                        <p class="text-sm text-gray-900 font-medium">{{ $activity->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity->nama_acara }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                            @if($activity->divisi == 'BPH') bg-purple-100 text-purple-800
                                            @elseif($activity->divisi == 'Sekretaris') bg-blue-100 text-blue-800
                                            @elseif($activity->divisi == 'Bendahara') bg-green-100 text-green-800
                                            @elseif($activity->divisi == 'Riset Teknologi') bg-indigo-100 text-indigo-800
                                            @elseif($activity->divisi == 'PSDM') bg-yellow-100 text-yellow-800
                                            @elseif($activity->divisi == 'Kominfo') bg-pink-100 text-pink-800
                                            @else bg-orange-100 text-orange-800
                                            @endif">
                                            {{ $activity->divisi }}
                                        </span>
                                    </div>
                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                        <time>{{ \Carbon\Carbon::parse($activity->qr_scan_time ?? $activity->tanggal.' '.$activity->jam_scan)->diffForHumans() }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Belum ada aktivitas</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
        @if(count($recentActivities ?? []) > 0)
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('presensi.pengurus.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Lihat semua →
            </a>
        </div>
        @endif
    </div>
</div>

@endsection
