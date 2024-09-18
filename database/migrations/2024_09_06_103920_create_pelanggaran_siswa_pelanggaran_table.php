<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('pelanggaran_siswa_pelanggaran', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pelanggaran_siswa_id')->constrained('pelanggaran_siswa')->onDelete('cascade');
    $table->foreignId('jenis_pelanggaran_id')->constrained('data_pelanggaran')->onDelete('cascade');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('pelanggaran_siswa_pelanggaran');
  }
};
