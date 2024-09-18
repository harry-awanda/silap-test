<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranSiswa extends Model {
  // use HasFactory;
  protected $table = 'pelanggaran_siswa';
  protected $fillable = ['siswa_id', 'tanggal_pelanggaran', 'keterangan'];

  public function siswa() {
    return $this->belongsTo(Siswa::class);
  }

  public function dataPelanggaran() {
    return $this->belongsToMany(DataPelanggaran::class, 'pelanggaran_siswa_pelanggaran', 'pelanggaran_siswa_id', 'jenis_pelanggaran_id');
  }
}