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
        Schema::create('tb_pengurus', function (Blueprint $table) {
            $table->id('id_pengurus');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('nim', 20)->unique()->comment('Nomor Induk Mahasiswa');
            $table->enum('divisi', [
                'BPH',
                'Sekretaris', 
                'Bendahara',
                'Riset Teknologi',
                'PSDM',
                'Kominfo',
                'Biztalent'
            ]);
            $table->string('jabatan', 100)->nullable()->comment('Ketua, Wakil Ketua, Anggota, Koordinator, dll');
            $table->string('periode', 20)->comment('2024/2025, 2025/2026');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('angkatan', 4); // 2021, 2022, dst
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['Aktif', 'Non-Aktif', 'Alumni'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
            $table->index('nim');
            $table->index('user_id');
            $table->index(['divisi', 'status']);
            $table->index('periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pengurus');
    }
};
