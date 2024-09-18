<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('orang_tua', function (Blueprint $table) {
      $table->id();
      $table->string('nama_ayah', 50)->nullable();
      $table->string('nama_ibu', 50)->nullable();
      $table->string('nama_wali_murid', 50)->nullable();
      $table->string('alamat_orangtua', 50)->nullable();
      $table->string('kontak_ayah', 50)->nullable();
      $table->string('kontak_ibu', 50)->nullable();
      $table->string('kontak_wali', 50)->nullable();
      $table->string('alamat_wali', 50)->nullable();
      $table->timestamps();
    });
  }
  
  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('orang_tua');
  }
};
