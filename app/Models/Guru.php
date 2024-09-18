<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model {
  // use HasFactory;
  protected $table = 'guru';
  protected $fillable = [
    'user_id', 'nip','nama_lengkap','username','tempat_lahir','tanggal_lahir','jenis_kelamin', 'alamat', 'kontak', 'photo',
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  // Relasi dengan Classroom sebagai wali kelas
  public function classroom() {
    return $this->hasOne(Classroom::class, 'wali_kelas_id');
  }
  
  public function jadwalPiket() {
    return $this->hasOne(JadwalPiket::class, 'guru_id');
  }

  // Cascade delete user ketika teacher dihapus
  protected static function booted() {
    static::deleting(function ($guru) {
      $guru->user()->delete();
    });
  }
}