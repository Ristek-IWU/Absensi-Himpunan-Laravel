@extends('layouts.admin')

@section('title', 'Laporan Kehadiran')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<!-- Page header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Laporan Kehadiran</h1>
    <p class="mt-2 text-sm text-gray-700">Lihat dan export data kehadiran mahasiswa</p>
</div>

<!-- Filter -->
<div class="bg-white shadow-sm rounded-lg p-6 mb-6 no-print">
    <form method="GET" action="{{ route('laporan.index') }}" id="filterForm" class="space-y-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div>
                <label for="dari_tanggal" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" 
                       id="dari_tanggal" 
                       name="dari_tanggal" 
                       value="{{ request('dari_tanggal', now()->startOfMonth()->format('Y-m-d')) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="sampai_tanggal" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" 
                       id="sampai_tanggal" 
                       name="sampai_tanggal" 
                       value="{{ request('sampai_tanggal', now()->format('Y-m-d')) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select id="kelas" 
                        name="kelas"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="Semua Kelas">Semua Kelas</option>
                    <option value="BPH" {{ request('kelas') == 'BPH' ? 'selected' : '' }}>BPH</option>
                    <option value="Sekretaris" {{ request('kelas') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                    <option value="Bendahara" {{ request('kelas') == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                    <option value="Riset Teknologi" {{ request('kelas') == 'Riset Teknologi' ? 'selected' : '' }}>Riset Teknologi</option>
                    <option value="PSDM" {{ request('kelas') == 'PSDM' ? 'selected' : '' }}>PSDM</option>
                    <option value="Kominfo" {{ request('kelas') == 'Kominfo' ? 'selected' : '' }}>Kominfo</option>
                    <option value="Biztalent" {{ request('kelas') == 'Biztalent' ? 'selected' : '' }}>Biztalent</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" 
                        name="status"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="Semua Status">Semua Status</option>
                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <button type="submit" 
                    class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Tampilkan Laporan
            </button>

            <div class="flex gap-2">
                <button type="button" onclick="exportExcel()"
                   class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Export Excel
                </button>

                <button type="button" onclick="window.print()"
                   class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-indigo-500">
        <p class="text-sm font-medium text-gray-600">Total Presensi</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPresensi }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
        <p class="text-sm font-medium text-gray-600">Hadir</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $hadir }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ $totalPresensi > 0 ? round(($hadir / $totalPresensi) * 100, 1) : 0 }}%</p>
    </div>
        <p class="text-xs text-gray-500 mt-1">{{ $summary['persentase_hadir'] ?? 0 }}%</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
        <p class="text-sm font-medium text-gray-600">Izin</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $summary['izin'] ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
        <p class="text-sm font-medium text-gray-600">Sakit</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $summary['sakit'] ?? 0 }}</p>
    </div>
</div>

<!-- Chart Section -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
    <!-- Kehadiran per Hari (7 hari terakhir) -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Kehadiran per Hari (7 Hari Terakhir)</h3>
        <div class="h-64">
            <canvas id="chartPerHari"></canvas>
        </div>
    </div>

    <!-- Kehadiran per Kelas/Divisi -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Kehadiran per Kelas/Divisi</h3>
        <div class="h-64">
            <canvas id="chartPerKelas"></canvas>
        </div>
    </div>
</div>

<!-- Detail Table -->
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Detail Kehadiran</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        NIM / Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kelas
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Waktu
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Keterangan
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($presensi as $data)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $data->nama_pengurus }}</div>
                            <div class="text-sm text-gray-500">{{ $data->nim }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $data->divisi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $data->jam_scan ? \Carbon\Carbon::parse($data->jam_scan)->format('H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($data->status_kehadiran == 'hadir')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                            @elseif($data->status_kehadiran == 'izin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Izin</span>
                            @elseif($data->status_kehadiran == 'sakit')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Sakit</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Alpha</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($data->keterangan ?? '-', 30) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>Tidak ada data untuk ditampilkan</p>
                            <p class="text-sm mt-1">Ubah filter untuk melihat data lainnya</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($presensi->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $presensi->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
// Chart.js Configuration
const chartColors = {
    primary: '#6366f1',
    success: '#10b981',
    warning: '#f59e0b',
    danger: '#ef4444',
    info: '#3b82f6'
};

// Chart Per Hari (Line Chart)
const ctxPerHari = document.getElementById('chartPerHari').getContext('2d');
const chartPerHari = new Chart(ctxPerHari, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($chartPerHari, 'tanggal')) !!},
        datasets: [{
            label: 'Hadir',
            data: {!! json_encode(array_column($chartPerHari, 'hadir')) !!},
            borderColor: chartColors.success,
            backgroundColor: chartColors.success + '20',
            tension: 0.3,
            fill: true
        }, {
            label: 'Izin',
            data: {!! json_encode(array_column($chartPerHari, 'izin')) !!},
            borderColor: chartColors.info,
            backgroundColor: chartColors.info + '20',
            tension: 0.3,
            fill: true
        }, {
            label: 'Sakit',
            data: {!! json_encode(array_column($chartPerHari, 'sakit')) !!},
            borderColor: chartColors.warning,
            backgroundColor: chartColors.warning + '20',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Chart Per Kelas (Bar Chart)
const ctxPerKelas = document.getElementById('chartPerKelas').getContext('2d');
const chartPerKelas = new Chart(ctxPerKelas, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($chartPerKelas, 'kelas')) !!},
        datasets: [{
            label: 'Hadir',
            data: {!! json_encode(array_column($chartPerKelas, 'hadir')) !!},
            backgroundColor: chartColors.success,
        }, {
            label: 'Izin',
            data: {!! json_encode(array_column($chartPerKelas, 'izin')) !!},
            backgroundColor: chartColors.info,
        }, {
            label: 'Sakit',
            data: {!! json_encode(array_column($chartPerKelas, 'sakit')) !!},
            backgroundColor: chartColors.warning,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            x: {
                stacked: false,
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Export Excel Function
function exportExcel() {
    const form = document.getElementById('filterForm');
    const params = new URLSearchParams(new FormData(form));
    window.location.href = "{{ route('laporan.export') }}?" + params.toString();
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
    
    .bg-white {
        box-shadow: none !important;
    }
}
</style>
@endpush

@endsection
