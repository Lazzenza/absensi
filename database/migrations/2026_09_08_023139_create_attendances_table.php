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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (FK)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Catatan Tanggal Presensi
            $table->date('date');
            
            // Waktu Check-in & Check-out (nullable karena bisa saja belum check-out atau memilih Izin/Sakit)
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            
            // Status Presensi (Hadir, Terlambat, Izin, Sakit)
            $table->enum('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit']);
            
            $table->timestamps();

            // Memastikan 1 user hanya memiliki 1 catatan presensi per hari
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};