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
        Schema::create('tb_presensi_pengurus', function (Blueprint $table) {
            $table->id('id_presensi');
            $table->unsignedBigInteger('id_pengurus');
            $table->unsignedBigInteger('id_acara');
            $table->date('tanggal');
            $table->time('jam_scan')->comment('Waktu saat scan QR code');
            $table->enum('status_kehadiran', ['Hadir', 'Terlambat', 'Izin', 'Sakit'])->default('Hadir');
            $table->text('keterangan')->nullable();
            
            // QR Code scan information
            $table->string('qr_token_scanned', 100)->comment('Token QR yang di-scan');
            $table->timestamp('qr_scan_time')->comment('Waktu scan QR code dengan timestamp');
            
            // Device & Location tracking
            $table->string('device_info')->nullable()->comment('Browser/Device info');
            $table->string('ip_address', 45)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('foto_bukti')->nullable()->comment('Foto selfie saat absen (optional)');
            
            // Admin tracking
            $table->unsignedBigInteger('dibuat_oleh')->nullable()->comment('Admin yang input manual (jika ada)');
            $table->unsignedBigInteger('diubah_oleh')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pengurus')
                ->references('id_pengurus')
                ->on('tb_pengurus')
                ->onDelete('cascade');
                
            $table->foreign('id_acara')
                ->references('id_acara')
                ->on('tb_acara')
                ->onDelete('cascade');
                
            $table->foreign('dibuat_oleh')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
                
            $table->foreign('diubah_oleh')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
                
            $table->index(['id_acara', 'tanggal']);
            $table->index(['id_pengurus', 'tanggal']);
            $table->index('status_kehadiran');
            $table->unique(['id_pengurus', 'id_acara'], 'unique_pengurus_acara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_presensi_pengurus');
    }
};
