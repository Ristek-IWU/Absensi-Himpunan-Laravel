@extends('layouts.admin')

@section('title', 'Edit Pengurus')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('pengurus.index') }}" 
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Data Pengurus</h1>
        <p class="mt-2 text-sm text-gray-700">Perbarui informasi pengurus HIMA IF</p>
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
    <form action="{{ route('pengurus.update', $pengurus->id_pengurus) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Data Akun -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Data Akun</h3>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $pengurus->name) }}"
                           required 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $pengurus->email) }}"
                           required 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-300 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                        No. HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="no_hp" 
                           id="no_hp" 
                           value="{{ old('no_hp', $pengurus->no_hp) }}"
                           required
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('no_hp') border-red-300 @enderror">
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Pengurus -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Data Pengurus</h3>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">
                        NIM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nim" 
                           id="nim" 
                           value="{{ old('nim', $pengurus->nim) }}"
                           required 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('nim') border-red-300 @enderror">
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">
                        Divisi <span class="text-red-500">*</span>
                    </label>
                    <select name="divisi" 
                            id="divisi" 
                            required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('divisi') border-red-300 @enderror">
                        <option value="">Pilih Divisi</option>
                        @foreach($divisiList as $divisi)
                            <option value="{{ $divisi }}" {{ old('divisi', $pengurus->divisi) == $divisi ? 'selected' : '' }}>
                                {{ $divisi }}
                            </option>
                        @endforeach
                    </select>
                    @error('divisi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="jabatan" 
                           id="jabatan" 
                           value="{{ old('jabatan', $pengurus->jabatan) }}"
                           required 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('jabatan') border-red-300 @enderror">
                    @error('jabatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">
                        Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="periode" 
                           id="periode" 
                           value="{{ old('periode', $pengurus->periode) }}"
                           required 
                           placeholder="2024/2025"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('periode') border-red-300 @enderror">
                    @error('periode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1">
                        Angkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="angkatan" 
                           id="angkatan" 
                           value="{{ old('angkatan', $pengurus->angkatan) }}"
                           required 
                           placeholder="2024"
                           maxlength="4"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('angkatan') border-red-300 @enderror">
                    @error('angkatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_kelamin" 
                            id="jenis_kelamin" 
                            required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('jenis_kelamin') border-red-300 @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pengurus->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pengurus->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('status') border-red-300 @enderror">
                        <option value="Aktif" {{ old('status', $pengurus->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status', $pengurus->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="Alumni" {{ old('status', $pengurus->status) == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data Pribadi (Optional) -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Data Pribadi (Opsional)</h3>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tempat Lahir
                    </label>
                    <input type="text" 
                           name="tempat_lahir" 
                           id="tempat_lahir" 
                           value="{{ old('tempat_lahir', $pengurus->tempat_lahir ?? '') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tempat_lahir') border-red-300 @enderror">
                    @error('tempat_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Lahir
                    </label>
                    <input type="date" 
                           name="tanggal_lahir" 
                           id="tanggal_lahir" 
                           value="{{ old('tanggal_lahir', $pengurus->tanggal_lahir ?? '') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tanggal_lahir') border-red-300 @enderror">
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat
                    </label>
                    <textarea name="alamat" 
                              id="alamat" 
                              rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('alamat') border-red-300 @enderror">{{ old('alamat', $pengurus->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">
                        Kota
                    </label>
                    <input type="text" 
                           name="kota" 
                           id="kota" 
                           value="{{ old('kota', $pengurus->kota ?? '') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('kota') border-red-300 @enderror">
                    @error('kota')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Provinsi
                    </label>
                    <input type="text" 
                           name="provinsi" 
                           id="provinsi" 
                           value="{{ old('provinsi', $pengurus->provinsi ?? '') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('provinsi') border-red-300 @enderror">
                    @error('provinsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Pos
                    </label>
                    <input type="text" 
                           name="kode_pos" 
                           id="kode_pos" 
                           value="{{ old('kode_pos', $pengurus->kode_pos ?? '') }}"
                           maxlength="10"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('kode_pos') border-red-300 @enderror">
                    @error('kode_pos')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Profil
                    </label>
                    @if($pengurus->foto)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="Foto saat ini" class="h-24 w-24 rounded-full object-cover">
                            <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                        </div>
                    @endif
                    <input type="file" 
                           name="foto" 
                           id="foto" 
                           accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('foto') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                    @error('foto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 bg-gray-50 px-6 py-4 rounded-lg">
            <a href="{{ route('pengurus.index') }}" 
               class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection
