<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah', 255)->default('Nama Sekolah');
            $table->string('tahun_ajaran', 32)->default('2023/2024');
            $table->string('logo_sekolah', 255)->nullable();
            $table->timestamps();
        });

        // Insert default data
        DB::table('general_settings')->insert([
            'nama_sekolah' => 'HIMAIF - INFORMATIKA UWI',
            'tahun_ajaran' => '2024/2025',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
