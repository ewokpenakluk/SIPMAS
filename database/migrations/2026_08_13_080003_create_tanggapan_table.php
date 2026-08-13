<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggapan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->cascadeOnDelete();
            $table->foreignId('pengguna_id')->constrained('pengguna')->cascadeOnDelete();
            $table->text('pesan');
            $table->string('status_diubah_ke', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggapan');
    }
};
