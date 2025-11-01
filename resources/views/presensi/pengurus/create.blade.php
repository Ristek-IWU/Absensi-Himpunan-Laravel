@extends('layouts.admin')

@section('title', 'Input Presensi')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Input Presensi Mahasiswa</h1>
        <p class="mt-2 text-sm text-gray-700">Catat kehadiran mahasiswa hari ini</p>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <form action="{{ route('presensi.mahasiswa.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Tanggal -->
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="tanggal" 
                       name="tanggal" 
                       value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                       required
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tanggal') border-red-300 @enderror">
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mahasiswa -->
            <div>
                <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Mahasiswa <span class="text-red-500">*</span>
                </label>
                <select id="siswa_id" 
                        name="siswa_id" 
                        required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('siswa_id') border-red-300 @enderror">
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach($mahasiswaList ?? [] as $mahasiswa)
                        <option value="{{ $mahasiswa->id }}" {{ old('siswa_id') == $mahasiswa->id ? 'selected' : '' }}>
                            {{ $mahasiswa->nim }} - {{ $mahasiswa->nama }} ({{ $mahasiswa->kelas->nama ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Pilih mahasiswa yang hadir</p>
            </div>

            <!-- Waktu -->
            <div>
                <label for="waktu" class="block text-sm font-medium text-gray-700 mb-1">
                    Waktu Presensi <span class="text-red-500">*</span>
                </label>
                <input type="time" 
                       id="waktu" 
                       name="waktu" 
                       value="{{ old('waktu', now()->format('H:i')) }}"
                       required
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('waktu') border-red-300 @enderror">
                @error('waktu')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Kehadiran <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none @error('status') border-red-300 @enderror">
                        <input type="radio" 
                               name="status" 
                               value="hadir" 
                               {{ old('status', 'hadir') == 'hadir' ? 'checked' : '' }}
                               class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="flex items-center">
                                    <svg class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-900">Hadir</span>
                                </span>
                                <span class="mt-1 flex items-center text-sm text-gray-500">Kehadiran normal</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-indigo-600 hidden" viewBox="0 0 20 20" fill="currentColor">
                            <circle cx="10" cy="10" r="9" />
                        </svg>
                    </label>

                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                        <input type="radio" 
                               name="status" 
                               value="izin" 
                               {{ old('status') == 'izin' ? 'checked' : '' }}
                               class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-900">Izin</span>
                                </span>
                                <span class="mt-1 flex items-center text-sm text-gray-500">Tidak hadir dengan izin</span>
                            </span>
                        </span>
                    </label>

                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                        <input type="radio" 
                               name="status" 
                               value="sakit" 
                               {{ old('status') == 'sakit' ? 'checked' : '' }}
                               class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-900">Sakit</span>
                                </span>
                                <span class="mt-1 flex items-center text-sm text-gray-500">Tidak hadir karena sakit</span>
                            </span>
                        </span>
                    </label>

                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                        <input type="radio" 
                               name="status" 
                               value="alpha" 
                               {{ old('status') == 'alpha' ? 'checked' : '' }}
                               class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="flex items-center">
                                    <svg class="h-5 w-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-900">Alpha</span>
                                </span>
                                <span class="mt-1 flex items-center text-sm text-gray-500">Tidak hadir tanpa keterangan</span>
                            </span>
                        </span>
                    </label>
                </div>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                    Keterangan
                </label>
                <textarea id="keterangan" 
                          name="keterangan" 
                          rows="3"
                          placeholder="Catatan tambahan (opsional)"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('keterangan') border-red-300 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('presensi.mahasiswa.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Simpan Presensi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-select radio button visual feedback
    document.querySelectorAll('input[type="radio"][name="status"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove checked style from all labels
            document.querySelectorAll('input[type="radio"][name="status"]').forEach(r => {
                r.closest('label').classList.remove('border-indigo-600', 'ring-2', 'ring-indigo-600');
                r.closest('label').querySelector('svg:last-child').classList.add('hidden');
            });
            
            // Add checked style to selected label
            if (this.checked) {
                this.closest('label').classList.add('border-indigo-600', 'ring-2', 'ring-indigo-600');
                this.closest('label').querySelector('svg:last-child').classList.remove('hidden');
            }
        });
        
        // Trigger on page load for pre-selected
        if (radio.checked) {
            radio.closest('label').classList.add('border-indigo-600', 'ring-2', 'ring-indigo-600');
            radio.closest('label').querySelector('svg:last-child').classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection
