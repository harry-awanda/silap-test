<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model {
  // use HasFactory;
  protected $table = 'jadwal_piket';
  // Kolom yang dapat diisi secara massal
  protected $fillable = [
    'guru_id',
    'hari_piket',
  ];

  // Mendefinisikan hubungan dengan model Guru
  public function guru() {
    return $this->belongsTo(Guru::class, 'guru_id');
  }
}