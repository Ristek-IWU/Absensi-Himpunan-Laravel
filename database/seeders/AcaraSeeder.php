<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AcaraSeeder extends Seeder
{
    public function run(): void
    {
        $acara = [
            [
                'nama_acara' => 'Rapat Koordinasi Pengurus HIMA IF',
                'deskripsi' => 'Rapat bulanan koordinasi seluruh pengurus untuk evaluasi kegiatan bulan ini',
                'tanggal' => now()->addDays(2)->format('Y-m-d'),
                'waktu_mulai' => '14:00:00',
                'waktu_selesai' => '16:00:00',
                'tempat' => 'Ruang Sekretariat HIMA IF',
                'qr_token' => Str::random(32),
                'status' => 'aktif',
                'jenis_acara' => 'Rapat',
                'target_peserta' => 13,
                'dibuat_oleh' => 1, // Admin
            ],
            [
                'nama_acara' => 'Pelatihan Web Development',
                'deskripsi' => 'Workshop pelatihan web development untuk pengurus divisi Riset Teknologi',
                'tanggal' => now()->addDays(5)->format('Y-m-d'),
                'waktu_mulai' => '09:00:00',
                'waktu_selesai' => '15:00:00',
                'tempat' => 'Lab Komputer Lantai 3',
                'qr_token' => Str::random(32),
                'status' => 'aktif',
                'jenis_acara' => 'Pelatihan',
                'target_peserta' => 20,
                'dibuat_oleh' => 1,
            ],
            [
                'nama_acara' => 'Seminar Teknologi AI dan Machine Learning',
                'deskripsi' => 'Seminar nasional tentang perkembangan AI dan implementasi Machine Learning',
                'tanggal' => now()->addDays(10)->format('Y-m-d'),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '17:00:00',
                'tempat' => 'Auditorium Kampus',
                'qr_token' => Str::random(32),
                'status' => 'aktif',
                'jenis_acara' => 'Seminar',
                'target_peserta' => 200,
                'dibuat_oleh' => 1,
            ],
            [
                'nama_acara' => 'Bakti Sosial HIMA IF',
                'deskripsi' => 'Kegiatan bakti sosial ke panti asuhan dan santunan anak yatim',
                'tanggal' => now()->addDays(15)->format('Y-m-d'),
                'waktu_mulai' => '07:00:00',
                'waktu_selesai' => '13:00:00',
                'tempat' => 'Panti Asuhan Al-Ikhlas',
                'qr_token' => Str::random(32),
                'status' => 'aktif',
                'jenis_acara' => 'Kegiatan',
                'target_peserta' => 30,
                'dibuat_oleh' => 1,
            ],
            [
                'nama_acara' => 'Rapat Evaluasi Semester',
                'deskripsi' => 'Rapat evaluasi kinerja pengurus HIMA IF semester ini',
                'tanggal' => now()->subDays(7)->format('Y-m-d'),
                'waktu_mulai' => '13:00:00',
                'waktu_selesai' => '16:00:00',
                'tempat' => 'Ruang Rapat Prodi IF',
                'qr_token' => Str::random(32),
                'status' => 'selesai',
                'jenis_acara' => 'Rapat',
                'target_peserta' => 13,
                'dibuat_oleh' => 1,
            ],
        ];

        foreach ($acara as $data) {
            DB::table('tb_acara')->insert(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
