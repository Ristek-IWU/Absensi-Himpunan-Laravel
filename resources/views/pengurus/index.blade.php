@extends('layouts.admin')

@section('title', 'Data Pengurus')

@section('content')
<!-- Page header -->
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Data Pengurus HIMA IF</h1>
        <p class="mt-2 text-sm text-gray-700">Kelola data pengurus Himpunan Mahasiswa Informatika</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('pengurus.create') }}" 
           class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Tambah Pengurus
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="bg-white shadow-sm rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('pengurus.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="NIM, nama, atau divisi..."
                       class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
            <select id="divisi" 
                    name="divisi"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Semua Divisi</option>
                @foreach($divisiList ?? [] as $divisi)
                    <option value="{{ $divisi }}" {{ request('divisi') == $divisi ? 'selected' : '' }}>
                        {{ $divisi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
            <select id="periode" 
                    name="periode"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Semua Periode</option>
                <option value="2024/2025" {{ request('periode') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                <option value="2023/2024" {{ request('periode') == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" 
                    class="flex-1 inline-flex justify-center items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Filter
            </button>
            @if(request()->hasAny(['search', 'divisi', 'periode']))
                <a href="{{ route('pengurus.index') }}" 
                   class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Stats per Divisi -->
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik per Divisi</h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4">
        @foreach($statsDivisi ?? [] as $stat)
        <div class="text-center p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg border border-indigo-200">
            <p class="text-xs font-medium text-indigo-600 uppercase tracking-wide">{{ $stat->divisi }}</p>
            <p class="text-3xl font-bold text-indigo-900 mt-2">{{ $stat->total }}</p>
            <p class="text-xs text-indigo-700 mt-1">pengurus</p>
        </div>
        @endforeach
    </div>
    <div class="grid grid-cols-2 gap-4 mt-4">
        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800">Total Pengurus</p>
            <p class="text-2xl font-bold text-green-900 mt-1">{{ $totalPengurus ?? 0 }}</p>
        </div>
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
            <p class="text-sm font-medium text-blue-800">Pengurus Aktif</p>
            <p class="text-2xl font-bold text-blue-900 mt-1">{{ $pengurusAktif ?? 0 }}</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                        Pengurus
                    </th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        NIM
                    </th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Divisi
                    </th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jabatan
                    </th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                        Periode
                    </th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">
                        Angkatan
                    </th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pengurusList ?? [] as $pengurus)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($pengurus->foto)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $pengurus->foto) }}" alt="{{ $pengurus->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ substr($pengurus->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $pengurus->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $pengurus->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $pengurus->nim }}</div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                            @if($pengurus->divisi == 'BPH') bg-purple-100 text-purple-800
                            @elseif($pengurus->divisi == 'Sekretaris') bg-blue-100 text-blue-800
                            @elseif($pengurus->divisi == 'Bendahara') bg-green-100 text-green-800
                            @elseif($pengurus->divisi == 'Riset Teknologi') bg-indigo-100 text-indigo-800
                            @elseif($pengurus->divisi == 'PSDM') bg-yellow-100 text-yellow-800
                            @elseif($pengurus->divisi == 'Kominfo') bg-pink-100 text-pink-800
                            @else bg-orange-100 text-orange-800
                            @endif">
                            {{ $pengurus->divisi }}
                        </span>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="truncate block max-w-[120px]">{{ $pengurus->jabatan ?? '-' }}</span>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                        {{ $pengurus->periode }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                        {{ $pengurus->angkatan }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                            @if($pengurus->status == 'Aktif') bg-green-100 text-green-800
                            @elseif($pengurus->status == 'Non-Aktif') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $pengurus->status }}
                        </span>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                               class="inline-flex items-center p-1 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded view-detail-btn"
                               title="Lihat Detail"
                               data-id="{{ $pengurus->id_pengurus }}"
                               data-name="{{ $pengurus->name }}"
                               data-email="{{ $pengurus->email }}"
                               data-no-hp="{{ $pengurus->no_hp }}"
                               data-nim="{{ $pengurus->nim }}"
                               data-divisi="{{ $pengurus->divisi }}"
                               data-jabatan="{{ $pengurus->jabatan ?? '-' }}"
                               data-periode="{{ $pengurus->periode }}"
                               data-angkatan="{{ $pengurus->angkatan }}"
                               data-jenis-kelamin="{{ $pengurus->jenis_kelamin ?? '-' }}"
                               data-tempat-lahir="{{ $pengurus->tempat_lahir ?? '-' }}"
                               data-tanggal-lahir="{{ $pengurus->tanggal_lahir ?? '-' }}"
                               data-alamat="{{ $pengurus->alamat ?? '-' }}"
                               data-kota="{{ $pengurus->kota ?? '-' }}"
                               data-provinsi="{{ $pengurus->provinsi ?? '-' }}"
                               data-kode-pos="{{ $pengurus->kode_pos ?? '-' }}"
                               data-status="{{ $pengurus->status }}"
                               data-foto="{{ $pengurus->foto ? asset('storage/' . $pengurus->foto) : '' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            <a href="{{ route('pengurus.edit', $pengurus->id_pengurus) }}" 
                               class="inline-flex items-center p-1 text-yellow-600 hover:text-yellow-900 hover:bg-yellow-50 rounded"
                               title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <form action="{{ route('pengurus.destroy', $pengurus->id_pengurus) }}" 
                                  method="POST" 
                                  class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="inline-flex items-center p-1 text-red-600 hover:text-red-900 hover:bg-red-50 rounded delete-btn"
                                        data-name="{{ $pengurus->name }}"
                                        title="Hapus">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data pengurus</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan pengurus baru.</p>
                        <div class="mt-6">
                            <a href="{{ route('pengurus.create') }}" 
                               class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Tambah Pengurus
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($pengurusList) && $pengurusList->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $pengurusList->links() }}
    </div>
    @endif
</div>

<!-- Modal Detail Pengurus -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 shadow-lg rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Detail Pengurus</h3>
            <button type="button" class="close-modal text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="mt-4">
            <!-- Profile Section -->
            <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                <div class="flex-shrink-0">
                    <img id="modal-foto" class="h-24 w-24 rounded-full object-cover border-4 border-indigo-100" src="" alt="Foto Pengurus">
                    <div id="modal-foto-placeholder" class="h-24 w-24 rounded-full bg-indigo-600 flex items-center justify-center border-4 border-indigo-100">
                        <span id="modal-initial" class="text-white font-bold text-3xl"></span>
                    </div>
                </div>
                <div>
                    <h4 id="modal-name" class="text-2xl font-bold text-gray-900"></h4>
                    <p id="modal-email" class="text-gray-600 mt-1"></p>
                    <div class="mt-2">
                        <span id="modal-status-badge" class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"></span>
                    </div>
                </div>
            </div>

            <!-- Data Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">NIM</p>
                    <p id="modal-nim" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">No. HP</p>
                    <p id="modal-no-hp" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">Divisi</p>
                    <p id="modal-divisi" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">Jabatan</p>
                    <p id="modal-jabatan" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">Periode</p>
                    <p id="modal-periode" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">Angkatan</p>
                    <p id="modal-angkatan" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</p>
                    <p id="modal-jenis-kelamin" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs font-medium text-gray-500 uppercase">Tempat, Tanggal Lahir</p>
                    <p id="modal-ttl" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                    <p class="text-xs font-medium text-gray-500 uppercase">Alamat</p>
                    <p id="modal-alamat" class="mt-1 text-sm font-semibold text-gray-900"></p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="close-modal px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 font-medium">
                    Tutup
                </button>
                <a id="modal-edit-link" href="#" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Edit Data
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal Detail Pengurus
    const modal = document.getElementById('detailModal');
    const closeButtons = document.querySelectorAll('.close-modal');
    
    // Open modal when view detail button clicked
    document.querySelectorAll('.view-detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            const data = {
                id: this.dataset.id,
                name: this.dataset.name,
                email: this.dataset.email,
                noHp: this.dataset.noHp,
                nim: this.dataset.nim,
                divisi: this.dataset.divisi,
                jabatan: this.dataset.jabatan,
                periode: this.dataset.periode,
                angkatan: this.dataset.angkatan,
                jenisKelamin: this.dataset.jenisKelamin,
                tempatLahir: this.dataset.tempatLahir,
                tanggalLahir: this.dataset.tanggalLahir,
                alamat: this.dataset.alamat,
                kota: this.dataset.kota,
                provinsi: this.dataset.provinsi,
                kodePos: this.dataset.kodePos,
                status: this.dataset.status,
                foto: this.dataset.foto
            };
            
            // Populate modal
            document.getElementById('modal-name').textContent = data.name;
            document.getElementById('modal-email').textContent = data.email;
            document.getElementById('modal-nim').textContent = data.nim;
            document.getElementById('modal-no-hp').textContent = data.noHp;
            document.getElementById('modal-divisi').textContent = data.divisi;
            document.getElementById('modal-jabatan').textContent = data.jabatan;
            document.getElementById('modal-periode').textContent = data.periode;
            document.getElementById('modal-angkatan').textContent = data.angkatan;
            document.getElementById('modal-jenis-kelamin').textContent = data.jenisKelamin;
            
            // TTL
            let ttl = data.tempatLahir;
            if (data.tanggalLahir && data.tanggalLahir !== '-') {
                ttl += ', ' + data.tanggalLahir;
            }
            document.getElementById('modal-ttl').textContent = ttl;
            
            // Alamat lengkap
            let alamatLengkap = data.alamat;
            if (data.kota && data.kota !== '-') {
                alamatLengkap += ', ' + data.kota;
            }
            if (data.provinsi && data.provinsi !== '-') {
                alamatLengkap += ', ' + data.provinsi;
            }
            if (data.kodePos && data.kodePos !== '-') {
                alamatLengkap += ' ' + data.kodePos;
            }
            document.getElementById('modal-alamat').textContent = alamatLengkap;
            
            // Status badge
            const statusBadge = document.getElementById('modal-status-badge');
            statusBadge.textContent = data.status;
            statusBadge.className = 'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ';
            if (data.status === 'Aktif') {
                statusBadge.className += 'bg-green-100 text-green-800';
            } else if (data.status === 'Non-Aktif') {
                statusBadge.className += 'bg-red-100 text-red-800';
            } else {
                statusBadge.className += 'bg-gray-100 text-gray-800';
            }
            
            // Foto
            const fotoImg = document.getElementById('modal-foto');
            const fotoPlaceholder = document.getElementById('modal-foto-placeholder');
            if (data.foto) {
                fotoImg.src = data.foto;
                fotoImg.classList.remove('hidden');
                fotoPlaceholder.classList.add('hidden');
            } else {
                fotoImg.classList.add('hidden');
                fotoPlaceholder.classList.remove('hidden');
                document.getElementById('modal-initial').textContent = data.name.charAt(0).toUpperCase();
            }
            
            // Edit link
            document.getElementById('modal-edit-link').href = `/pengurus/${data.id}/edit`;
            
            // Show modal
            modal.classList.remove('hidden');
        });
    });
    
    // Close modal
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            const name = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data pengurus <strong>${name}</strong> akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
