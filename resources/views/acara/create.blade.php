@extends('layouts.admin')

@section('title', 'Tambah Acara')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('acara.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-4">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Acara
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Tambah Acara Baru</h1>
        <p class="mt-2 text-sm text-gray-700">Buat acara baru untuk presensi pengurus HIMA IF</p>
    </div>

    <!-- Form -->
    <form action="{{ route('acara.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Informasi Acara -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Acara</h3>
                    <p class="mt-1 text-sm text-gray-500">Detail tentang acara yang akan dilaksanakan</p>
                </div>

                <div class="px-6 py-5 space-y-6">
                    <!-- Nama Acara -->
                    <div>
                        <label for="nama_acara" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_acara" id="nama_acara" required value="{{ old('nama_acara') }}" placeholder="Contoh: Rapat Koordinasi Bulanan" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('nama_acara')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Acara -->
                    <div>
                        <label for="jenis_acara" class="block text-sm font-medium text-gray-700 mb-1">
                            Jenis Acara <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_acara" id="jenis_acara" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Jenis Acara</option>
                            <option value="Rapat" {{ old('jenis_acara') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                            <option value="Pelatihan" {{ old('jenis_acara') == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                            <option value="Seminar" {{ old('jenis_acara') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="Kegiatan" {{ old('jenis_acara') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="Lainnya" {{ old('jenis_acara') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_acara')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi (Optional) -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi Acara
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsi singkat tentang acara (opsional)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Waktu & Tempat -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Waktu & Tempat</h3>
                    <p class="mt-1 text-sm text-gray-500">Jadwal dan lokasi pelaksanaan acara</p>
                </div>

                <div class="px-6 py-5 space-y-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu Mulai & Selesai -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" required value="{{ old('waktu_mulai') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('waktu_mulai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-1">
                                Waktu Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="waktu_selesai" id="waktu_selesai" required value="{{ old('waktu_selesai') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('waktu_selesai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tempat -->
                    <div>
                        <label for="tempat" class="block text-sm font-medium text-gray-700 mb-1">
                            Tempat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tempat" id="tempat" required value="{{ old('tempat') }}" placeholder="Contoh: Ruang Laboratorium Informatika" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('tempat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pengaturan Lainnya -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pengaturan Lainnya</h3>
                    <p class="mt-1 text-sm text-gray-500">Pengaturan tambahan untuk acara</p>
                </div>

                <div class="px-6 py-5 space-y-6">
                    <!-- Target Peserta -->
                    <div>
                        <label for="target_peserta" class="block text-sm font-medium text-gray-700 mb-1">
                            Target Jumlah Peserta
                        </label>
                        <input type="number" name="target_peserta" id="target_peserta" value="{{ old('target_peserta') }}" placeholder="Contoh: 50" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada target</p>
                        @error('target_peserta')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Status "Aktif" untuk acara yang dapat digunakan untuk presensi</p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 bg-gray-50 px-6 py-4 rounded-lg">
                <a href="{{ route('acara.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Acara
                </button>
            </div>
        </form>
    </div>
@endsection
