<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('attendances', function (Blueprint $table) {
      $table->id();
      $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
      $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
      $table->enum('status', ['sakit', 'izin', 'alpa'])->nullable(); // Attendance status
      $table->date('date'); // Attendance date
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('attendances');
  }
};