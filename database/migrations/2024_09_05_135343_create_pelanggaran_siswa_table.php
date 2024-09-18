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
    Schema::create('pelanggaran_siswa', function (Blueprint $table) {
      $table->id();
      $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
      $table->date('tanggal_pelanggaran');
      $table->text('keterangan')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pelanggaran_siswa');
  }
};
