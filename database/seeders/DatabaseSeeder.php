<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan seeder penting karena ada foreign key constraints
        $this->call([
            UserSeeder::class,      // 1. Buat users (admin, pengurus)
            PengurusSeeder::class,  // 2. Buat data pengurus (relasi ke users)
            AcaraSeeder::class,     // 3. Buat data acara (relasi ke users)
        ]);
        
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->newLine();
        $this->command->info('📝 Login credentials:');
        $this->command->info('   Admin: admin@himaif.ac.id / admin123');
        $this->command->info('   Pengurus: budi.bph@himaif.ac.id / pengurus123');
        $this->command->newLine();
        $this->command->info('🎯 Total: 2 Admin + 13 Pengurus (7 Divisi)');
        $this->command->info('📅 Total: 5 Acara (4 aktif, 1 selesai)');
    }
}
