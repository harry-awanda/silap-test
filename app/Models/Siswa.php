<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model {
  // use HasFactory;
  protected $table = 'siswa';
  protected $fillable = ['orang_tua_id','jurusan_id','classroom_id','nis','nama_lengkap','jenis_kelamin','tempat_lahir','tanggal_lahir','agama','alamat','kontak','photo'];

	public static function boot() {
		parent::boot();
		static::deleting(function ($siswa) {
			// Hapus data orang tua
			$siswa->orang_tua()->delete();
			// Hapus data keterlambatan
			$siswa->keterlambatan()->delete();
			// Hapus data pelanggaran siswa
			$siswa->pelanggaranSiswa()->each(function($pelanggaran) {
				$pelanggaran->dataPelanggaran()->detach(); // Hapus pivot table
				$pelanggaran->delete(); // Hapus pelanggaran siswa
			});
			// Hapus data absensi
			$siswa->attendances()->delete();
		});
	}
  public function orang_tua() {
		return $this->belongsTo(OrangTua::class);
	}
  
  public function classroom() {
		return $this->belongsTo(Classroom::class, 'classroom_id');
	
  }
  public function jurusan() {
		return $this->belongsTo(Jurusan::class);
	}
	// Tambahkan relasi attendances di sini
  public function attendances() {
    return $this->hasMany(Attendance::class, 'siswa_id');
  }
	// Relasi ke keterlambatan
	public function keterlambatan() {
		return $this->hasMany(Keterlambatan::class, 'siswa_id');
	}
	// Relasi ke pelanggaran siswa
	public function pelanggaranSiswa() {
		return $this->hasMany(PelanggaranSiswa::class, 'siswa_id');
	}
}