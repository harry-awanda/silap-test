<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model {
  use HasFactory;
  protected $table = 'orang_tua';
  protected $fillable = ['nama_ayah', 'nama_ibu', 'nama_wali_murid','alamat_orangtua','kontak_ayah','kontak_ibu','kontak_wali','alamat_wali'];

  public function siswa() {
    return $this->hasOne(Siswa::class, 'orang_tua_id');
  }
}
