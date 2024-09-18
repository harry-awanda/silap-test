<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::create('classrooms', function (Blueprint $table) {
      $table->id();
      $table->string('nama_kelas');
      $table->tinyInteger('tingkat');
      $table->unsignedBigInteger('wali_kelas_id')->nullable();
      $table->foreign('wali_kelas_id')->references('id')->on('guru')->onDelete('set null');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('classrooms');
  }
};