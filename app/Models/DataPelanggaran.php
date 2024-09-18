<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelanggaran extends Model {
  // use HasFactory;
  protected $table = 'data_pelanggaran';
  protected $fillable = [
    'jenis_pelanggaran',
  ];

  public function pelanggaranSiswa() {
    return $this->belongsToMany(PelanggaranSiswa::class, 'pelanggaran_siswa_pelanggaran', 'jenis_pelanggaran_id', 'pelanggaran_siswa_id');
  }
}
