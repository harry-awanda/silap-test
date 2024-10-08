<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('keterlambatan', function (Blueprint $table) {
      $table->id();
      $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
      $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
      $table->date('tanggal_keterlambatan');
      $table->time('waktu_keterlambatan');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('keterlambatan');
  }
};