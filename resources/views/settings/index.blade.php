@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<!-- Page header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Pengaturan Sistem</h1>
    <p class="mt-2 text-sm text-gray-700">Kelola konfigurasi sistem absensi</p>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Sidebar Menu -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <nav class="flex flex-col">
                <a href="#umum" 
                   onclick="showTab('umum')"
                   id="tab-umum"
                   class="tab-link flex items-center px-6 py-3 text-sm font-medium border-l-4 border-indigo-600 bg-indigo-50 text-indigo-700">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan Umum
                </a>
                <a href="#absensi" 
                   onclick="showTab('absensi')"
                   id="tab-absensi"
                   class="tab-link flex items-center px-6 py-3 text-sm font-medium border-l-4 border-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aturan Absensi
                </a>
                <a href="#notifikasi" 
                   onclick="showTab('notifikasi')"
                   id="tab-notifikasi"
                   class="tab-link flex items-center px-6 py-3 text-sm font-medium border-l-4 border-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    Notifikasi
                </a>
                <a href="#backup" 
                   onclick="showTab('backup')"
                   id="tab-backup"
                   class="tab-link flex items-center px-6 py-3 text-sm font-medium border-l-4 border-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    Backup & Restore
                </a>
            </nav>
        </div>
    </div>

    <!-- Content Area -->
    <div class="lg:col-span-2">
        <!-- Pengaturan Umum -->
        <div id="content-umum" class="tab-content">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pengaturan Umum</h3>
                </div>
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="umum">

                    <div>
                        <label for="app_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Aplikasi
                        </label>
                        <input type="text" 
                               id="app_name" 
                               name="app_name" 
                               value="{{ $settings['app_name'] ?? 'Absensi HIMA IF' }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Organisasi
                        </label>
                        <input type="text" 
                               id="organization_name" 
                               name="organization_name" 
                               value="{{ $settings['organization_name'] ?? 'Himpunan Mahasiswa Informatika' }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email Kontak
                        </label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_email" 
                               value="{{ $settings['contact_email'] ?? '' }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">
                            No. Telepon
                        </label>
                        <input type="text" 
                               id="contact_phone" 
                               name="contact_phone" 
                               value="{{ $settings['contact_phone'] ?? '' }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['address'] ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Aturan Absensi -->
        <div id="content-absensi" class="tab-content hidden">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Aturan Absensi</h3>
                </div>
                <form action="{{ route('settings.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="absensi">

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="jam_masuk" class="block text-sm font-medium text-gray-700 mb-1">
                                Jam Masuk
                            </label>
                            <input type="time" 
                                   id="jam_masuk" 
                                   name="jam_masuk" 
                                   value="{{ $settings['jam_masuk'] ?? '07:00' }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="jam_keluar" class="block text-sm font-medium text-gray-700 mb-1">
                                Jam Keluar
                            </label>
                            <input type="time" 
                                   id="jam_keluar" 
                                   name="jam_keluar" 
                                   value="{{ $settings['jam_keluar'] ?? '16:00' }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="toleransi_keterlambatan" class="block text-sm font-medium text-gray-700 mb-1">
                                Toleransi Keterlambatan (menit)
                            </label>
                            <input type="number" 
                                   id="toleransi_keterlambatan" 
                                   name="toleransi_keterlambatan" 
                                   value="{{ $settings['toleransi_keterlambatan'] ?? 15 }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="batas_presensi" class="block text-sm font-medium text-gray-700 mb-1">
                                Batas Waktu Presensi (jam setelah masuk)
                            </label>
                            <input type="number" 
                                   id="batas_presensi" 
                                   name="batas_presensi" 
                                   value="{{ $settings['batas_presensi'] ?? 2 }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="auto_alpha" 
                                   {{ ($settings['auto_alpha'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Otomatis tandai alpha jika tidak presensi</span>
                        </label>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifikasi -->
        <div id="content-notifikasi" class="tab-content hidden">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pengaturan Notifikasi</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Notifikasi Email</p>
                            <p class="text-sm text-gray-500">Kirim notifikasi via email</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Notifikasi Keterlambatan</p>
                            <p class="text-sm text-gray-500">Beri tahu saat mahasiswa terlambat</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Laporan Harian</p>
                            <p class="text-sm text-gray-500">Kirim laporan kehadiran setiap hari</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup & Restore -->
        <div id="content-backup" class="tab-content hidden">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Backup & Restore Data</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Backup otomatis dilakukan setiap hari pada pukul 00:00. File backup disimpan selama 30 hari.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Backup Manual</h4>
                        <button type="button" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download Backup Sekarang
                        </button>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Restore Data</h4>
                        <p class="text-sm text-gray-500 mb-3">Upload file backup untuk mengembalikan data</p>
                        <input type="file" 
                               accept=".sql,.zip"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showTab(tabName) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active class from all links
        document.querySelectorAll('.tab-link').forEach(link => {
            link.classList.remove('border-indigo-600', 'bg-indigo-50', 'text-indigo-700');
            link.classList.add('border-transparent', 'text-gray-700');
        });

        // Show selected content
        document.getElementById('content-' + tabName).classList.remove('hidden');

        // Add active class to selected link
        const activeLink = document.getElementById('tab-' + tabName);
        activeLink.classList.add('border-indigo-600', 'bg-indigo-50', 'text-indigo-700');
        activeLink.classList.remove('border-transparent', 'text-gray-700');
    }
</script>
@endpush
@endsection
