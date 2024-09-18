<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaPiket extends Model {
  // use HasFactory;
  protected $table = 'agenda_piket';
  
  protected $fillable = [
    'tanggal',
    'kejadian_normal',
    'kejadian_masalah',
    'solusi',
    'guru_piket',
    'absensi_per_kelas',
    'absensi_per_tingkat',
    ];

    /**
     * Casts for attributes.
     */
  protected $casts = [
    'guru_piket' => 'array', // Cast JSON field 'guru_piket' as an array
    'absensi_per_tingkat' => 'array', // Cast JSON field as an array
  ];

  public function getGuruPiketNames() {
    return \App\Models\User::whereIn('id', $this->guru_piket)->pluck('name')->toArray();
  }
}