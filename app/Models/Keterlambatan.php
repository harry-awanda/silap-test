<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model {
  // use HasFactory;
  protected $table = 'keterlambatan';
  protected $fillable = [
    'siswa_id',
    'classroom_id',
    'tanggal_keterlambatan',
    'waktu_keterlambatan',
  ];
  public function siswa() {
    return $this->belongsTo(Siswa::class, 'siswa_id');
  }
  public function classroom() {
    return $this->belongsTo(Classroom::class);
  }
}