@extends('layouts.admin')

@section('title', 'Edit Acara')

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
        <h1 class="text-3xl font-bold text-gray-900">Edit Acara</h1>
        <p class="mt-2 text-sm text-gray-700">Perbarui informasi acara HIMA IF</p>
    </div>

    @if(session('error'))
    <div class="mb-6 rounded-md bg-red-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('acara.update', $acara->id_acara) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

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
                    <input type="text" 
                           name="nama_acara" 
                           id="nama_acara" 
                           required 
                           value="{{ old('nama_acara', $acara->nama_acara) }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('nama_acara') border-red-300 @enderror">
                    @error('nama_acara')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Acara -->
                <div>
                    <label for="jenis_acara" class="block text-sm font-medium text-gray-700 mb-1">
                        Jenis Acara <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_acara" 
                            id="jenis_acara" 
                            required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('jenis_acara') border-red-300 @enderror">
                        <option value="">Pilih Jenis Acara</option>
                        <option value="Rapat" {{ old('jenis_acara', $acara->jenis_acara) == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        <option value="Pelatihan" {{ old('jenis_acara', $acara->jenis_acara) == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                        <option value="Seminar" {{ old('jenis_acara', $acara->jenis_acara) == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="Kegiatan" {{ old('jenis_acara', $acara->jenis_acara) == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Lainnya" {{ old('jenis_acara', $acara->jenis_acara) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_acara')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Acara
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="3" 
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $acara->deskripsi) }}</textarea>
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
                    <input type="date" 
                           name="tanggal" 
                           id="tanggal" 
                           required 
                           value="{{ old('tanggal', $acara->tanggal) }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tanggal') border-red-300 @enderror">
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
                        <input type="time" 
                               name="waktu_mulai" 
                               id="waktu_mulai" 
                               required 
                               value="{{ old('waktu_mulai', substr($acara->waktu_mulai, 0, 5)) }}" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('waktu_mulai') border-red-300 @enderror">
                        @error('waktu_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-1">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" 
                               name="waktu_selesai" 
                               id="waktu_selesai" 
                               required 
                               value="{{ old('waktu_selesai', substr($acara->waktu_selesai, 0, 5)) }}" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('waktu_selesai') border-red-300 @enderror">
                        @error('waktu_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="tempat" class="block text-sm font-medium text-gray-700 mb-1">
                        Tempat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="tempat" 
                           id="tempat" 
                           required 
                           value="{{ old('tempat', $acara->tempat) }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tempat') border-red-300 @enderror">
                    @error('tempat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Status Acara</h3>
                <p class="mt-1 text-sm text-gray-500">Kelola status pelaksanaan acara</p>
            </div>

            <div class="px-6 py-5">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('status') border-red-300 @enderror">
                        <option value="aktif" {{ old('status', $acara->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status', $acara->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status', $acara->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 bg-gray-50 px-6 py-4 rounded-lg">
            <a href="{{ route('acara.index') }}" 
               class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Update Acara
            </button>
        </div>
    </form>
</div>
@endsection
