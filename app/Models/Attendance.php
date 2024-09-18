<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
	use HasFactory;
	protected $fillable = ['siswa_id', 'classroom_id', 'date', 'status',];
	
	public function siswa() {
		return $this->belongsTo(Siswa::class, 'siswa_id');
	}
	public function classroom() {
		return $this->belongsTo(Classroom::class, 'classroom_id');
	}
}