<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model {
	// use HasFactory;
	protected $fillable = ['nama_kelas','wali_kelas_id','tingkat'];
	
	public function guru() {
		return $this->belongsTo(Guru::class, 'wali_kelas_id');
	}
	public function siswa() {
		return $this->hasMany(Siswa::class, 'classroom_id');
	}
}