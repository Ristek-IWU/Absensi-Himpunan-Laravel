<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Verify QR Code and save attendance
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // Validate request
        $request->validate([
            'qr_token' => 'required|string'
        ]);

        $qrToken = $request->qr_token;

        try {
            // 1. Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }

            $user = Auth::user();

            // 2. Get pengurus data from logged user
            $pengurus = DB::table('tb_pengurus')
                ->where('user_id', $user->id)
                ->first();

            if (!$pengurus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar sebagai pengurus'
                ], 403);
            }

            // 3. Verify QR token and get event
            $acara = DB::table('tb_acara')
                ->where('qr_token', $qrToken)
                ->where('status', 'aktif')
                ->first();

            if (!$acara) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau acara sudah tidak aktif'
                ], 404);
            }

            // 4. Check if already scanned for this event
            $existingPresensi = DB::table('tb_presensi_pengurus')
                ->where('id_pengurus', $pengurus->id_pengurus)
                ->where('id_acara', $acara->id_acara)
                ->first();

            if ($existingPresensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi untuk acara ini',
                    'data' => [
                        'nama' => $user->name,
                        'acara' => $acara->nama_acara,
                        'status' => $existingPresensi->status_kehadiran,
                        'jam_scan' => $existingPresensi->jam_scan
                    ]
                ], 400);
            }

            // 5. Check if event is today and within time range
            $today = date('Y-m-d');
            $now = date('H:i:s');

            if ($acara->tanggal != $today) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acara belum berlangsung atau sudah selesai (tanggal tidak sesuai)'
                ], 400);
            }

            // 6. Determine attendance status based on scan time
            $waktuMulai = Carbon::parse($acara->waktu_mulai);
            $waktuSelesai = Carbon::parse($acara->waktu_selesai);
            $scanTime = Carbon::parse($now);
            
            // Grace period: 15 minutes after start time
            $batasTerlambat = $waktuMulai->copy()->addMinutes(15);

            $statusKehadiran = 'Hadir';
            if ($scanTime->gt($batasTerlambat)) {
                $statusKehadiran = 'Terlambat';
            }

            // Check if event already ended
            if ($scanTime->gt($waktuSelesai)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acara sudah berakhir. Presensi ditutup.'
                ], 400);
            }

            // 7. Save attendance to database
            $presensiId = DB::table('tb_presensi_pengurus')->insertGetId([
                'id_pengurus' => $pengurus->id_pengurus,
                'id_acara' => $acara->id_acara,
                'tanggal' => $today,
                'jam_scan' => $now,
                'qr_scan_time' => now(),
                'status_kehadiran' => $statusKehadiran,
                'keterangan' => 'Scan via QR Code',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 8. Get current attendance stats for this event
            $totalHadir = DB::table('tb_presensi_pengurus')
                ->where('id_acara', $acara->id_acara)
                ->count();

            $totalPengurus = DB::table('tb_pengurus')->count();

            // 9. Return success response
            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil disimpan!',
                'data' => [
                    'id_presensi' => $presensiId,
                    'nama' => $user->name,
                    'nim' => $pengurus->nim,
                    'divisi' => $pengurus->divisi,
                    'acara' => $acara->nama_acara,
                    'status' => $statusKehadiran,
                    'jam_scan' => $now,
                    'tanggal' => Carbon::parse($today)->isoFormat('D MMMM Y')
                ],
                'stats' => [
                    'total_hadir' => $totalHadir,
                    'total_pengurus' => $totalPengurus,
                    'persentase' => round(($totalHadir / $totalPengurus) * 100, 1)
                ]
            ], 200);

        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('QR Verification Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses presensi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attendance history for logged user
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function history()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        $pengurus = DB::table('tb_pengurus')
            ->where('user_id', $user->id)
            ->first();

        if (!$pengurus) {
            return response()->json([
                'success' => false,
                'message' => 'Pengurus not found'
            ], 404);
        }

        $history = DB::table('tb_presensi_pengurus')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->where('tb_presensi_pengurus.id_pengurus', $pengurus->id_pengurus)
            ->select(
                'tb_presensi_pengurus.*',
                'tb_acara.nama_acara',
                'tb_acara.tempat',
                'tb_acara.jenis_acara'
            )
            ->orderBy('tb_presensi_pengurus.tanggal', 'desc')
            ->orderBy('tb_presensi_pengurus.jam_scan', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    /**
     * Get today's attendance for display on scanner page
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function todayScans()
    {
        $today = date('Y-m-d');

        $scans = DB::table('tb_presensi_pengurus')
            ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->where('tb_presensi_pengurus.tanggal', $today)
            ->select(
                'tb_presensi_pengurus.*',
                'users.name',
                'tb_pengurus.divisi',
                'tb_acara.nama_acara'
            )
            ->orderBy('tb_presensi_pengurus.jam_scan', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $scans
        ]);
    }
}
