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
        Schema::create('tb_acara', function (Blueprint $table) {
            $table->id('id_acara');
            $table->string('nama_acara');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('tempat', 200);
            $table->text('qr_code')->nullable()->comment('QR Code string untuk scan');
            $table->string('qr_token', 100)->unique()->comment('Token unik untuk validasi');
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->enum('jenis_acara', ['Rapat', 'Pelatihan', 'Seminar', 'Kegiatan', 'Lainnya'])->default('Kegiatan');
            $table->integer('target_peserta')->default(0);
            $table->unsignedBigInteger('dibuat_oleh')->comment('Admin yang membuat');
            $table->unsignedBigInteger('diubah_oleh')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dibuat_oleh')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
                
            $table->foreign('diubah_oleh')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
                
            $table->index(['tanggal', 'status']);
            $table->index('qr_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_acara');
    }
};
