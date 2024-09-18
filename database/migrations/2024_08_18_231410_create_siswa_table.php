<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('siswa', function (Blueprint $table) {
      $table->id();
      $table->foreignId('orang_tua_id')->nullable()->constrained('orang_tua')->onDelete('cascade');
      $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
      $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
      $table->string('nis', 5);
      $table->string('nama_lengkap', 50);
      $table->string('jenis_kelamin')->nullable();
      $table->string('tempat_lahir')->nullable();
      $table->date('tanggal_lahir')->nullable();
      $table->string('agama')->nullable();
      $table->text('alamat')->nullable();
      $table->string('kontak')->nullable();
      $table->string('photo')->nullable();
      $table->timestamps();
    });
  }
  
  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('siswa');
  }
};