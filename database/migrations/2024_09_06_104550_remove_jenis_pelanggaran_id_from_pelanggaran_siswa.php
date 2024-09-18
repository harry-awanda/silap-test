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
    Schema::table('pelanggaran_siswa', function (Blueprint $table) {
      // Hapus kolom jenis_pelanggaran_id jika ada
      $table->dropForeign(['jenis_pelanggaran_id']);
      $table->dropColumn('jenis_pelanggaran_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('pelanggaran_siswa', function (Blueprint $table) {
      //
    });
  }
};
