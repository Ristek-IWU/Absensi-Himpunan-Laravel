<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin/Superadmin HIMA IF
        DB::table('users')->insert([
            [
                'name' => 'Admin HIMA IF',
                'email' => 'admin@himaif.ac.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'no_hp' => '081234567890',
                'foto' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alif Alfarizi',
                'email' => 'okta@himaif.ac.id',
                'password' => Hash::make('anjay123'),
                'role' => 'pengurus',
                'no_hp' => '081234567892',
                'foto' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Sekretaris',
                'email' => 'sekretaris@himaif.ac.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'no_hp' => '081234567891',
                'foto' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Pengurus HIMA IF - 7 Divisi
        $pengurusUsers = [
            // BPH (Badan Pengurus Harian)
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.bph@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '082345678901',
            ],
            [
                'name' => 'Ahmad Ridwan',
                'email' => 'ahmad.bph@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '082345678902',
            ],
            
            // Sekretaris
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.sekretaris@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '083456789012',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.sekretaris@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '083456789013',
            ],
            
            // Bendahara
            [
                'name' => 'Rahmat Hidayat',
                'email' => 'rahmat.bendahara@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '084567890123',
            ],
            
            // Riset Teknologi
            [
                'name' => 'Andi Firmansyah',
                'email' => 'andi.ristek@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '085678901234',
            ],
            [
                'name' => 'Reza Pratama',
                'email' => 'reza.ristek@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '085678901235',
            ],
            
            // PSDM
            [
                'name' => 'Fitri Rahmawati',
                'email' => 'fitri.psdm@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '086789012345',
            ],
            [
                'name' => 'Dimas Prakoso',
                'email' => 'dimas.psdm@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '086789012346',
            ],
            
            // Kominfo
            [
                'name' => 'Indah Permata',
                'email' => 'indah.kominfo@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '087890123456',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.kominfo@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '087890123457',
            ],
            
            // Biztalent
            [
                'name' => 'Maya Anggraini',
                'email' => 'maya.biztalent@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '088901234567',
            ],
            [
                'name' => 'Yoga Aditya',
                'email' => 'yoga.biztalent@himaif.ac.id',
                'password' => Hash::make('pengurus123'),
                'role' => 'pengurus',
                'no_hp' => '088901234568',
            ],
        ];

        foreach ($pengurusUsers as $pengurus) {
            DB::table('users')->insert(array_merge($pengurus, [
                'foto' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
