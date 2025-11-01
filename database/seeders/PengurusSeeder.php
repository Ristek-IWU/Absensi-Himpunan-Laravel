<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        $periode = '2024/2025';
        
        $pengurus = [
            // BPH
            [
                'user_id' => 3, // Budi Santoso
                'nim' => '2101001',
                'divisi' => 'BPH',
                'jabatan' => 'Ketua Umum',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2021',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2003-05-15',
                'alamat' => 'Jl. Merdeka No. 10',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'status' => 'Aktif',
            ],
            [
                'user_id' => 4, // Ahmad Ridwan
                'nim' => '2101002',
                'divisi' => 'BPH',
                'jabatan' => 'Wakil Ketua',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2021',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-07-20',
                'alamat' => 'Jl. Sudirman No. 25',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'status' => 'Aktif',
            ],
            
            // Sekretaris
            [
                'user_id' => 5, // Siti Nurhaliza
                'nim' => '2102003',
                'divisi' => 'Sekretaris',
                'jabatan' => 'Koordinator',
                'periode' => $periode,
                'jenis_kelamin' => 'Perempuan',
                'angkatan' => '2021',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2003-03-10',
                'alamat' => 'Jl. Ahmad Yani No. 15',
                'kota' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'status' => 'Aktif',
            ],
            [
                'user_id' => 6, // Dewi Lestari
                'nim' => '2202004',
                'divisi' => 'Sekretaris',
                'jabatan' => 'Anggota',
                'periode' => $periode,
                'jenis_kelamin' => 'Perempuan',
                'angkatan' => '2022',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2004-08-25',
                'alamat' => 'Jl. Malioboro No. 50',
                'kota' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'status' => 'Aktif',
            ],
            
            // Bendahara
            [
                'user_id' => 7, // Rahmat Hidayat
                'nim' => '2101005',
                'divisi' => 'Bendahara',
                'jabatan' => 'Koordinator',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2021',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2003-11-12',
                'alamat' => 'Jl. Pemuda No. 30',
                'kota' => 'Semarang',
                'provinsi' => 'Jawa Tengah',
                'status' => 'Aktif',
            ],
            
            // Riset Teknologi
            [
                'user_id' => 8, // Andi Firmansyah
                'nim' => '2102006',
                'divisi' => 'Riset Teknologi',
                'jabatan' => 'Koordinator',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2021',
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2003-09-05',
                'alamat' => 'Jl. Gatot Subroto No. 45',
                'kota' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'status' => 'Aktif',
            ],
            [
                'user_id' => 9, // Reza Pratama
                'nim' => '2202007',
                'divisi' => 'Riset Teknologi',
                'jabatan' => 'Anggota',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2022',
                'tempat_lahir' => 'Makassar',
                'tanggal_lahir' => '2004-04-18',
                'alamat' => 'Jl. Pettarani No. 20',
                'kota' => 'Makassar',
                'provinsi' => 'Sulawesi Selatan',
                'status' => 'Aktif',
            ],
            
            // PSDM
            [
                'user_id' => 10, // Fitri Rahmawati
                'nim' => '2102008',
                'divisi' => 'PSDM',
                'jabatan' => 'Koordinator',
                'periode' => $periode,
                'jenis_kelamin' => 'Perempuan',
                'angkatan' => '2021',
                'tempat_lahir' => 'Palembang',
                'tanggal_lahir' => '2003-06-30',
                'alamat' => 'Jl. Sudirman No. 60',
                'kota' => 'Palembang',
                'provinsi' => 'Sumatera Selatan',
                'status' => 'Aktif',
            ],
            [
                'user_id' => 11, // Dimas Prakoso
                'nim' => '2202009',
                'divisi' => 'PSDM',
                'jabatan' => 'Anggota',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2022',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2004-02-14',
                'alamat' => 'Jl. Ijen No. 35',
                'kota' => 'Malang',
                'provinsi' => 'Jawa Timur',
                'status' => 'Aktif',
            ],
            
            // Kominfo
            [
                'user_id' => 12, // Indah Permata
                'nim' => '2102010',
                'divisi' => 'Kominfo',
                'jabatan' => 'Koordinator',
                'periode' => $periode,
                'jenis_kelamin' => 'Perempuan',
                'angkatan' => '2021',
                'tempat_lahir' => 'Denpasar',
                'tanggal_lahir' => '2003-12-08',
                'alamat' => 'Jl. Sunset Road No. 88',
                'kota' => 'Denpasar',
                'provinsi' => 'Bali',
                'status' => 'Aktif',
            ],
            [
                'user_id' => 13, // Fajar Nugroho
                'nim' => '2202011',
                'divisi' => 'Kominfo',
                'jabatan' => 'Anggota',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2022',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '2004-01-22',
                'alamat' => 'Jl. Slamet Riyadi No. 100',
                'kota' => 'Surakarta',
                'provinsi' => 'Jawa Tengah',
                'status' => 'Aktif',
            ],
            
            // Biztalent
            [
                'user_id' => 14, // Maya Anggraini
                'nim' => '2102012',
                'divisi' => 'Biztalent',
                'jabatan' => 'Koordinator',
                'periode' => $periode,
                'jenis_kelamin' => 'Perempuan',
                'angkatan' => '2021',
                'tempat_lahir' => 'Balikpapan',
                'tanggal_lahir' => '2003-10-17',
                'alamat' => 'Jl. Jenderal Sudirman No. 75',
                'kota' => 'Balikpapan',
                'provinsi' => 'Kalimantan Timur',
                'status' => 'Aktif',
            ],
            [
                'user_id' => 15, // Yoga Aditya
                'nim' => '2202013',
                'divisi' => 'Biztalent',
                'jabatan' => 'Anggota',
                'periode' => $periode,
                'jenis_kelamin' => 'Laki-laki',
                'angkatan' => '2022',
                'tempat_lahir' => 'Banjarmasin',
                'tanggal_lahir' => '2004-05-09',
                'alamat' => 'Jl. Ahmad Yani Km. 5',
                'kota' => 'Banjarmasin',
                'provinsi' => 'Kalimantan Selatan',
                'status' => 'Aktif',
            ],
        ];

        foreach ($pengurus as $data) {
            DB::table('tb_pengurus')->insert(array_merge($data, [
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
