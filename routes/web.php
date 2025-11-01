<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $totalPengurus = DB::table('tb_pengurus')->where('status', 'Aktif')->count();
        $totalAcara = DB::table('tb_acara')->where('status', 'aktif')->count();
        
        $today = date('Y-m-d');
        $now = date('H:i:s');
        
        // Acara yang sedang berlangsung SEKARANG
        $acaraBerlangsung = DB::table('tb_acara')
            ->where('status', 'aktif')
            ->where('tanggal', $today)
            ->where('waktu_mulai', '<=', $now)
            ->where('waktu_selesai', '>=', $now)
            ->orderBy('waktu_mulai', 'asc')
            ->first();
        
        // Generate QR Code jika ada acara berlangsung
        $qrCodeBerlangsung = null;
        if ($acaraBerlangsung) {
            $qrCodeBerlangsung = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)
                ->margin(1)
                ->generate($acaraBerlangsung->qr_token);
        }
        
        // Acara mendatang (belum mulai)
        $acaraMendatang = DB::table('tb_acara')
            ->where('status', 'aktif')
            ->where(function($query) use ($today, $now) {
                $query->where('tanggal', '>', $today)
                      ->orWhere(function($q) use ($today, $now) {
                          $q->where('tanggal', '=', $today)
                            ->where('waktu_mulai', '>', $now);
                      });
            })
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->limit(5)
            ->get();
        
        // Daftar hadir per divisi untuk acara yang sedang berlangsung
        $kehadiranPerDivisi = collect([]);
        if ($acaraBerlangsung) {
            $kehadiranPerDivisi = DB::table('tb_pengurus')
                ->leftJoin('tb_presensi_pengurus', function($join) use ($acaraBerlangsung) {
                    $join->on('tb_pengurus.id_pengurus', '=', 'tb_presensi_pengurus.id_pengurus')
                         ->where('tb_presensi_pengurus.id_acara', '=', $acaraBerlangsung->id_acara);
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
        }
        
        // Aktivitas presensi terbaru (semua acara)
        $recentActivities = DB::table('tb_presensi_pengurus')
            ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->select(
                'users.name',
                'tb_pengurus.divisi',
                'tb_acara.nama_acara',
                'tb_presensi_pengurus.tanggal',
                'tb_presensi_pengurus.jam_scan',
                'tb_presensi_pengurus.qr_scan_time',
                'tb_presensi_pengurus.status_kehadiran'
            )
            ->orderBy('tb_presensi_pengurus.created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Total hadir hari ini (untuk stat card)
        $hadirHariIni = DB::table('tb_presensi_pengurus')
            ->where('tanggal', $today)
            ->where('status_kehadiran', 'Hadir')
            ->count();
        
        $persentaseHadir = $totalPengurus > 0 ? round(($hadirHariIni / $totalPengurus) * 100, 2) : 0;
        
        return view('dashboard', [
            'totalPengurus' => $totalPengurus,
            'totalAcara' => $totalAcara,
            'hadirHariIni' => $hadirHariIni,
            'persentaseHadir' => $persentaseHadir,
            'acaraBerlangsung' => $acaraBerlangsung,
            'qrCodeBerlangsung' => $qrCodeBerlangsung,
            'acaraMendatang' => $acaraMendatang,
            'kehadiranPerDivisi' => $kehadiranPerDivisi,
            'recentActivities' => $recentActivities,
        ]);
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengurus Routes - Using Controller
    Route::resource('pengurus', PengurusController::class);

    // Acara Routes - Using Controller
    Route::get('acara/{id}/qrcode', [AcaraController::class, 'qrcode'])->name('acara.qrcode');
    Route::resource('acara', AcaraController::class);

    // Presensi Routes
    Route::prefix('presensi')->name('presensi.')->group(function () {
        // Presensi Pengurus Index
        Route::get('/pengurus', function () {
            $query = DB::table('tb_presensi_pengurus')
                ->join('tb_pengurus', 'tb_presensi_pengurus.id_pengurus', '=', 'tb_pengurus.id_pengurus')
                ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
                ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
                ->select(
                    'tb_presensi_pengurus.*',
                    'users.name as pengurus_name',
                    'tb_pengurus.nim',
                    'tb_pengurus.divisi',
                    'tb_acara.nama_acara',
                    'tb_acara.tempat'
                )
                ->orderBy('tb_presensi_pengurus.tanggal', 'desc')
                ->orderBy('tb_presensi_pengurus.jam_scan', 'desc');
            
            // Filter by date
            if (request('tanggal')) {
                $query->where('tb_presensi_pengurus.tanggal', request('tanggal'));
            }
            
            // Filter by divisi
            if (request('divisi')) {
                $query->where('tb_pengurus.divisi', request('divisi'));
            }
            
            // Filter by acara
            if (request('id_acara')) {
                $query->where('tb_presensi_pengurus.id_acara', request('id_acara'));
            }
            
            // Filter by status
            if (request('status')) {
                $query->where('tb_presensi_pengurus.status_kehadiran', request('status'));
            }
            
            $presensiList = $query->paginate(15);
            
            $acaraList = DB::table('tb_acara')
                ->orderBy('tanggal', 'desc')
                ->limit(20)
                ->get();
            
            // Stats
            $today = request('tanggal', date('Y-m-d'));
            $statsQuery = DB::table('tb_presensi_pengurus')
                ->where('tanggal', $today);
            
            $stats = [
                'hadir' => (clone $statsQuery)->where('status_kehadiran', 'Hadir')->count(),
                'terlambat' => (clone $statsQuery)->where('status_kehadiran', 'Terlambat')->count(),
                'izin' => (clone $statsQuery)->where('status_kehadiran', 'Izin')->count(),
                'alpa' => (clone $statsQuery)->where('status_kehadiran', 'Alpa')->count(),
            ];
            
            return view('presensi.pengurus.index', [
                'presensiList' => $presensiList,
                'acaraList' => $acaraList,
                'stats' => $stats,
            ]);
        })->name('pengurus.index');
        
        Route::get('/scan', function () {
            // Get list of active events for QR display mode
            $acaraList = DB::table('tb_acara')
                ->where('status', 'aktif')
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu_mulai', 'desc')
                ->get();
            
            return view('presensi.scan', [
                'acaraList' => $acaraList
            ]);
        })->name('scan');
        
        Route::post('/scan/verify', function () {
            // QR scan verification logic will be here
            return response()->json(['success' => true]);
        })->name('scan.verify');
    });

    // Laporan Routes
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
    });

    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function () {
            return view('settings.index', [
                'settings' => [
                    'app_name' => 'Absensi HIMA IF',
                    'organization_name' => 'Himpunan Mahasiswa Informatika',
                    'contact_email' => 'admin@himaif.ac.id',
                    'contact_phone' => '081234567890',
                    'address' => '',
                    'jam_masuk' => '07:00',
                    'jam_keluar' => '16:00',
                    'toleransi_keterlambatan' => 15,
                    'batas_presensi' => 2,
                    'auto_alpha' => false,
                ],
            ]);
        })->name('index');
        
        Route::put('/', function () {
            return redirect()->route('settings.index')
                ->with('success', 'Pengaturan berhasil diupdate');
        })->name('update');
    });
});

require __DIR__.'/auth.php';
