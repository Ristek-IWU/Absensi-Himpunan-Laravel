<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('tb_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->select(
                'tb_pengurus.*',
                'users.name',
                'users.email',
                'users.no_hp',
                DB::raw('COALESCE(tb_pengurus.foto, users.foto) as foto')
            );
        
        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tb_pengurus.nim', 'like', "%{$search}%")
                  ->orWhere('users.name', 'like', "%{$search}%")
                  ->orWhere('tb_pengurus.divisi', 'like', "%{$search}%");
            });
        }
        
        // Filter by divisi
        if ($request->divisi) {
            $query->where('tb_pengurus.divisi', $request->divisi);
        }
        
        // Filter by periode
        if ($request->periode) {
            $query->where('tb_pengurus.periode', $request->periode);
        }
        
        $pengurusList = $query->orderBy('tb_pengurus.divisi')->orderBy('users.name')->paginate(15);
        
        $divisiList = ['BPH', 'Sekretaris', 'Bendahara', 'Riset Teknologi', 'PSDM', 'Kominfo', 'Biztalent'];
        
        // Stats per divisi
        $statsDivisi = DB::table('tb_pengurus')
            ->select('divisi', DB::raw('COUNT(*) as total'))
            ->where('status', 'Aktif')
            ->groupBy('divisi')
            ->get();
        
        $totalPengurus = DB::table('tb_pengurus')->count();
        $pengurusAktif = DB::table('tb_pengurus')->where('status', 'Aktif')->count();
        
        return view('pengurus.index', compact('pengurusList', 'divisiList', 'statsDivisi', 'totalPengurus', 'pengurusAktif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisiList = ['BPH', 'Sekretaris', 'Bendahara', 'Riset Teknologi', 'PSDM', 'Kominfo', 'Biztalent'];
        return view('pengurus.create', compact('divisiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:tb_pengurus,nim',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'divisi' => 'required',
            'jabatan' => 'required',
            'periode' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'angkatan' => 'required|digits:4',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'No HP wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'divisi.required' => 'Divisi wajib dipilih',
            'jabatan.required' => 'Jabatan wajib diisi',
            'periode.required' => 'Periode wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'angkatan.required' => 'Angkatan wajib diisi',
            'angkatan.digits' => 'Angkatan harus 4 digit (contoh: 2024)',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::beginTransaction();
        try {
            // Upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('pengurus', $filename, 'public');
            }

            // Create user first
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath,
                'role' => 'pengurus',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create pengurus
            DB::table('tb_pengurus')->insert([
                'nim' => $request->nim,
                'user_id' => $userId,
                'divisi' => $request->divisi,
                'jabatan' => $request->jabatan,
                'periode' => $request->periode,
                'jenis_kelamin' => $request->jenis_kelamin,
                'angkatan' => $request->angkatan,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'foto' => $fotoPath,
                'status' => $request->status ?? 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('pengurus.index')->with('success', 'Data pengurus berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            // Delete uploaded file if exists
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengurus = DB::table('tb_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->select('tb_pengurus.*', 'users.name', 'users.email', 'users.no_hp')
            ->where('tb_pengurus.id_pengurus', $id)
            ->first();

        if (!$pengurus) {
            return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan');
        }

        // Get presensi history
        $presensiHistory = DB::table('tb_presensi_pengurus')
            ->join('tb_acara', 'tb_presensi_pengurus.id_acara', '=', 'tb_acara.id_acara')
            ->where('tb_presensi_pengurus.id_pengurus', $id)
            ->select('tb_acara.nama_acara', 'tb_presensi_pengurus.*')
            ->orderBy('tb_presensi_pengurus.tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('pengurus.show', compact('pengurus', 'presensiHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengurus = DB::table('tb_pengurus')
            ->join('users', 'tb_pengurus.user_id', '=', 'users.id')
            ->select('tb_pengurus.*', 'users.name', 'users.email', 'users.no_hp')
            ->where('tb_pengurus.id_pengurus', $id)
            ->first();

        if (!$pengurus) {
            return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan');
        }

        $divisiList = ['BPH', 'Sekretaris', 'Bendahara', 'Riset Teknologi', 'PSDM', 'Kominfo', 'Biztalent'];
        
        return view('pengurus.edit', compact('pengurus', 'divisiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengurus = DB::table('tb_pengurus')->where('id_pengurus', $id)->first();
        
        if (!$pengurus) {
            return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan');
        }

        $request->validate([
            'nim' => 'required|unique:tb_pengurus,nim,' . $id . ',id_pengurus',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pengurus->user_id . ',id',
            'no_hp' => 'required',
            'divisi' => 'required',
            'jabatan' => 'required',
            'periode' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'angkatan' => 'required|digits:4',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Get current foto from database (check both tables)
            $currentUser = DB::table('users')->where('id', $pengurus->user_id)->first();
            $fotoPath = $pengurus->foto ?? $currentUser->foto;
            
            // Upload foto baru jika ada
            if ($request->hasFile('foto')) {
                // Delete old foto
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('pengurus', $filename, 'public');
            }

            // Update user
            DB::table('users')->where('id', $pengurus->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath,
                'updated_at' => now(),
            ]);

            // Update pengurus
            DB::table('tb_pengurus')->where('id_pengurus', $id)->update([
                'nim' => $request->nim,
                'divisi' => $request->divisi,
                'jabatan' => $request->jabatan,
                'periode' => $request->periode,
                'jenis_kelamin' => $request->jenis_kelamin,
                'angkatan' => $request->angkatan,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'foto' => $fotoPath,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('pengurus.index')->with('success', 'Data pengurus berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $pengurus = DB::table('tb_pengurus')->where('id_pengurus', $id)->first();
            
            if (!$pengurus) {
                return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan');
            }
            
            // Delete foto if exists
            if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
                Storage::disk('public')->delete($pengurus->foto);
            }

            // Delete pengurus
            DB::table('tb_pengurus')->where('id_pengurus', $id)->delete();
            
            // Delete user
            DB::table('users')->where('id', $pengurus->user_id)->delete();

            DB::commit();
            return redirect()->route('pengurus.index')->with('success', 'Data pengurus berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('pengurus.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
