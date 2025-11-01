@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Mahasiswa Baru</h1>
        <p class="mt-2 text-sm text-gray-700">Lengkapi form di bawah untuk menambahkan mahasiswa</p>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- NIM -->
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">
                        NIM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nim" 
                           name="nim" 
                           value="{{ old('nim') }}"
                           required
                           placeholder="Contoh: 2024001"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('nim') border-red-300 @enderror">
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}"
                           required
                           placeholder="Nama lengkap mahasiswa"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('nama') border-red-300 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           placeholder="email@example.com"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-300 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                        No. HP
                    </label>
                    <input type="text" 
                           id="no_hp" 
                           name="no_hp" 
                           value="{{ old('no_hp') }}"
                           placeholder="08xxxxxxxxxx"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('no_hp') border-red-300 @enderror">
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" 
                                   name="jenis_kelamin" 
                                   value="L" 
                                   {{ old('jenis_kelamin', 'L') == 'L' ? 'checked' : '' }}
                                   class="form-radio text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" 
                                   name="jenis_kelamin" 
                                   value="P" 
                                   {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}
                                   class="form-radio text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Lahir
                    </label>
                    <input type="date" 
                           id="tanggal_lahir" 
                           name="tanggal_lahir" 
                           value="{{ old('tanggal_lahir') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tanggal_lahir') border-red-300 @enderror">
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas -->
                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select id="kelas_id" 
                            name="kelas_id" 
                            required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('kelas_id') border-red-300 @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList ?? [] as $kelas)
                            <option value="{{ $kelas->id_kelas }}" {{ old('kelas_id') == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jurusan -->
                <div>
                    <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Jurusan <span class="text-red-500">*</span>
                    </label>
                    <select id="jurusan_id" 
                            name="jurusan_id" 
                            required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('jurusan_id') border-red-300 @enderror">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusanList ?? [] as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                    Alamat Lengkap
                </label>
                <textarea id="alamat" 
                          name="alamat" 
                          rows="3"
                          placeholder="Alamat lengkap mahasiswa"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('alamat') border-red-300 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                    Foto Profil
                </label>
                <div class="mt-1 flex items-center">
                    <div id="preview-container" class="hidden mr-4">
                        <img id="foto-preview" class="h-20 w-20 rounded-full object-cover" alt="Preview">
                    </div>
                    <input type="file" 
                           id="foto" 
                           name="foto" 
                           accept="image/*"
                           onchange="previewImage(event)"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('foto') border-red-300 @enderror">
                </div>
                <p class="mt-1 text-sm text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('status') border-red-300 @enderror">
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('mahasiswa.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('foto-preview').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
