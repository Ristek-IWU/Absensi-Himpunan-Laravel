<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('tb_acara')
            ->leftJoin('users', 'tb_acara.dibuat_oleh', '=', 'users.id')
            ->select('tb_acara.*', 'users.name as created_by_name');
        
        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where('tb_acara.nama_acara', 'like', "%{$search}%");
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('tb_acara.status', $request->status);
        }
        
        // Filter by jenis
        if ($request->jenis_acara) {
            $query->where('tb_acara.jenis_acara', $request->jenis_acara);
        }
        
        $acaraList = $query->orderBy('tb_acara.tanggal', 'desc')->paginate(9);
        
        $totalAcara = DB::table('tb_acara')->count();
        $acaraAktif = DB::table('tb_acara')->where('status', 'aktif')->count();
        $acaraSelesai = DB::table('tb_acara')->where('status', 'selesai')->count();
        
        // Total presensi across all acara
        $totalPresensi = DB::table('tb_presensi_pengurus')->count();
        
        return view('acara.index', compact('acaraList', 'totalAcara', 'acaraAktif', 'acaraSelesai', 'totalPresensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('acara.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'jenis_acara' => 'required',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'target_peserta' => 'nullable|integer',
        ]);

        try {
            // Generate QR Token
            $qrToken = Str::random(32) . '_' . time();

            DB::table('tb_acara')->insert([
                'nama_acara' => $request->nama_acara,
                'jenis_acara' => $request->jenis_acara,
                'tanggal' => $request->tanggal,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'tempat' => $request->tempat,
                'deskripsi' => $request->deskripsi ?? '',
                'target_peserta' => $request->target_peserta ?? 0,
                'qr_token' => $qrToken,
                'status' => 'aktif',
                'dibuat_oleh' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('acara.index')->with('success', 'Acara berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan acara: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $acara = DB::table('tb_acara')
            ->leftJoin('users', 'tb_acara.dibuat_oleh', '=', 'users.id')
            ->select('tb_acara.*', 'users.name as created_by_name')
            ->where('tb_acara.id_acara', $id)
            ->first();

        if (!$acara) {
            return redirect()->route('acara.index')->with('error', 'Acara tidak ditemukan');
        }

        // Get presensi for this acara
        $presensiList = DB::table('tb_presensi_pengurus')
            ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->where('tb_presensi_pengurus.id_acara', $id)
            ->select(
                'tb_presensi_pengurus.*',
                'users.name',
                'tb_pengurus.nim',
                'tb_pengurus.divisi',
                'tb_pengurus.jabatan'
            )
            ->orderBy('tb_presensi_pengurus.jam_scan', 'asc')
            ->get();

        // Stats
        $totalPengurus = DB::table('tb_pengurus')->where('status', 'Aktif')->count();
        $totalHadir = $presensiList->where('status_kehadiran', 'Hadir')->count();
        $persentaseKehadiran = $totalPengurus > 0 ? round(($totalHadir / $totalPengurus) * 100, 2) : 0;

        // Stats object
        $stats = (object) [
            'hadir' => $presensiList->where('status_kehadiran', 'Hadir')->count(),
            'terlambat' => $presensiList->where('status_kehadiran', 'Terlambat')->count(),
            'izin' => $presensiList->where('status_kehadiran', 'Izin')->count(),
            'sakit' => $presensiList->where('status_kehadiran', 'Sakit')->count(),
        ];
        
        $totalPresensi = $presensiList->count();

        // Stats per divisi
        $statsDivisi = DB::table('tb_pengurus')
            ->leftJoin('tb_presensi_pengurus', function($join) use ($id) {
                $join->on('tb_pengurus.id_pengurus', '=', 'tb_presensi_pengurus.id_pengurus')
                     ->where('tb_presensi_pengurus.id_acara', '=', $id);
            })
            ->select(
                'tb_pengurus.divisi',
                DB::raw('COUNT(DISTINCT tb_pengurus.id_pengurus) as total_pengurus'),
                DB::raw('COUNT(DISTINCT tb_presensi_pengurus.id_presensi) as total_hadir')
            )
            ->where('tb_pengurus.status', 'Aktif')
            ->groupBy('tb_pengurus.divisi')
            ->get()
            ->map(function($item) {
                $item->persentase = $item->total_pengurus > 0 
                    ? round(($item->total_hadir / $item->total_pengurus) * 100, 2) 
                    : 0;
                return $item;
            });

        return view('acara.show', compact('acara', 'presensiList', 'totalPengurus', 'totalHadir', 'persentaseKehadiran', 'statsDivisi', 'stats', 'totalPresensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acara = DB::table('tb_acara')->where('id_acara', $id)->first();

        if (!$acara) {
            return redirect()->route('acara.index')->with('error', 'Acara tidak ditemukan');
        }

        return view('acara.edit', compact('acara'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'jenis_acara' => 'required',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'status' => 'required',
            'deskripsi' => 'nullable|string',
            'target_peserta' => 'nullable|integer',
        ]);

        try {
            DB::table('tb_acara')->where('id_acara', $id)->update([
                'nama_acara' => $request->nama_acara,
                'jenis_acara' => $request->jenis_acara,
                'tanggal' => $request->tanggal,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'tempat' => $request->tempat,
                'deskripsi' => $request->deskripsi ?? '',
                'target_peserta' => $request->target_peserta ?? 0,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

            return redirect()->route('acara.index')->with('success', 'Acara berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate acara: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $acara = DB::table('tb_acara')->where('id_acara', $id)->first();
            
            if (!$acara) {
                return redirect()->route('acara.index')->with('error', 'Acara tidak ditemukan');
            }

            // Check if there are presensi records
            $hasPresensi = DB::table('tb_presensi_pengurus')->where('id_acara', $id)->exists();
            
            if ($hasPresensi) {
                return redirect()->route('acara.index')->with('error', 'Tidak dapat menghapus acara yang sudah memiliki data presensi');
            }

            DB::table('tb_acara')->where('id_acara', $id)->delete();

            return redirect()->route('acara.index')->with('success', 'Acara berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('acara.index')->with('error', 'Gagal menghapus acara: ' . $e->getMessage());
        }
    }

    /**
     * Display QR Code for acara
     */
    public function qrcode(string $id)
    {
        $acara = DB::table('tb_acara')->where('id_acara', $id)->first();

        if (!$acara) {
            return redirect()->route('acara.index')->with('error', 'Acara tidak ditemukan');
        }

        // Generate QR Code
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(400)
            ->margin(2)
            ->generate($acara->qr_token);

        return view('acara.qrcode', compact('acara', 'qrCode'));
    }
}
