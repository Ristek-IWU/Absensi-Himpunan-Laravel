<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('tb_presensi_pengurus')
            ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->select(
                'tb_presensi_pengurus.*',
                'users.name as nama_pengurus',
                'tb_pengurus.nim',
                'tb_pengurus.divisi',
                'tb_acara.nama_acara',
                'tb_acara.tanggal'
            );

        // Filter tanggal
        if ($request->dari_tanggal) {
            $query->where('tb_acara.tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->sampai_tanggal) {
            $query->where('tb_acara.tanggal', '<=', $request->sampai_tanggal);
        }

        // Filter kelas/divisi
        if ($request->kelas && $request->kelas != 'Semua Kelas') {
            $query->where('tb_pengurus.divisi', $request->kelas);
        }

        // Filter status
        if ($request->status && $request->status != 'Semua Status') {
            $query->where('tb_presensi_pengurus.status_kehadiran', $request->status);
        }

        // Get stats (clone query untuk menghindari duplikasi)
        $statsQuery = clone $query;
        $presensiList = $statsQuery->get();
        
        $totalPresensi = $presensiList->count();
        $hadir = $presensiList->where('status_kehadiran', 'Hadir')->count();
        $izin = $presensiList->where('status_kehadiran', 'Izin')->count();
        $sakit = $presensiList->where('status_kehadiran', 'Sakit')->count();

        // Pagination
        $presensi = $query->orderBy('tb_acara.tanggal', 'desc')
                         ->orderBy('tb_presensi_pengurus.jam_scan', 'desc')
                         ->paginate(15)
                         ->withQueryString();

        // Chart data - Kehadiran per hari (7 hari terakhir)
        $chartPerHari = DB::table('tb_presensi_pengurus')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->select(
                DB::raw('DATE_FORMAT(tb_acara.tanggal, "%d/%m") as tanggal'),
                DB::raw('SUM(CASE WHEN tb_presensi_pengurus.status_kehadiran = "Hadir" THEN 1 ELSE 0 END) as hadir'),
                DB::raw('SUM(CASE WHEN tb_presensi_pengurus.status_kehadiran = "Izin" THEN 1 ELSE 0 END) as izin'),
                DB::raw('SUM(CASE WHEN tb_presensi_pengurus.status_kehadiran = "Sakit" THEN 1 ELSE 0 END) as sakit')
            )
            ->where('tb_acara.tanggal', '>=', now()->subDays(7))
            ->groupBy('tb_acara.tanggal')
            ->orderBy('tb_acara.tanggal', 'asc')
            ->get()
            ->toArray();

        // Chart data - Kehadiran per kelas/divisi
        $chartPerKelas = DB::table('tb_presensi_pengurus')
            ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
            ->select(
                DB::raw('COALESCE(tb_pengurus.divisi, "Lainnya") as kelas'),
                DB::raw('SUM(CASE WHEN tb_presensi_pengurus.status_kehadiran = "Hadir" THEN 1 ELSE 0 END) as hadir'),
                DB::raw('SUM(CASE WHEN tb_presensi_pengurus.status_kehadiran = "Izin" THEN 1 ELSE 0 END) as izin'),
                DB::raw('SUM(CASE WHEN tb_presensi_pengurus.status_kehadiran = "Sakit" THEN 1 ELSE 0 END) as sakit')
            )
            ->groupBy('tb_pengurus.divisi')
            ->get()
            ->toArray();

        return view('laporan.index', compact(
            'presensi',
            'totalPresensi',
            'hadir',
            'izin',
            'sakit',
            'chartPerHari',
            'chartPerKelas'
        ));
    }

    public function export(Request $request)
    {
        $query = DB::table('tb_presensi_pengurus')
            ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->select(
                'tb_acara.tanggal',
                'tb_acara.nama_acara',
                'tb_pengurus.nim',
                'users.name',
                'tb_pengurus.divisi',
                'tb_presensi_pengurus.jam_scan',
                'tb_presensi_pengurus.status_kehadiran',
                'tb_presensi_pengurus.keterangan'
            );

        // Apply filters
        if ($request->dari_tanggal) {
            $query->where('tb_acara.tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->sampai_tanggal) {
            $query->where('tb_acara.tanggal', '<=', $request->sampai_tanggal);
        }
        if ($request->kelas && $request->kelas != 'Semua Kelas') {
            $query->where('tb_pengurus.divisi', $request->kelas);
        }
        if ($request->status && $request->status != 'Semua Status') {
            $query->where('tb_presensi_pengurus.status_kehadiran', $request->status);
        }

        $data = $query->orderBy('tb_acara.tanggal', 'desc')->get();

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'LAPORAN KEHADIRAN HIMA IF');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set period
        $period = 'Periode: ';
        if ($request->dari_tanggal && $request->sampai_tanggal) {
            $period .= date('d/m/Y', strtotime($request->dari_tanggal)) . ' - ' . date('d/m/Y', strtotime($request->sampai_tanggal));
        } else {
            $period .= 'Semua Data';
        }
        $sheet->setCellValue('A2', $period);
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Column headers
        $headers = ['TANGGAL', 'NIM / NAMA', 'KELAS', 'WAKTU', 'STATUS', 'KETERANGAN'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '4', $header);
            $column++;
        }

        // Style header
        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Data rows
        $row = 5;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, date('d/m/Y', strtotime($item->tanggal)));
            $sheet->setCellValue('B' . $row, $item->nim . ' / ' . $item->name);
            $sheet->setCellValue('C' . $row, $item->divisi);
            $sheet->setCellValue('D' . $row, date('H:i', strtotime($item->jam_scan)));
            $sheet->setCellValue('E' . $row, $item->status_kehadiran);
            $sheet->setCellValue('F' . $row, $item->keterangan ?? '-');
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Style data rows
        $sheet->getStyle('A5:F' . ($row - 1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Generate file
        $filename = 'Laporan_Kehadiran_' . date('Y-m-d_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
