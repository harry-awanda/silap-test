<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Jurusan;
use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation {

  public function model(array $row) {
    // Check if student already exists
    $existingStudent = Siswa::where('nama_lengkap', $row['nama_lengkap'])
      ->where('kontak', $row['kontak'])->first();

    if ($existingStudent) {
      // Optionally log or handle the existing student
      return null;
    }

    // Inisialisasi variabel $orangtua sebagai null
    $orangtua = null;
    // Jika terdapat data orang tua (nama ayah/ibu atau alamat orang tua), buat atau temukan data orang tua
    if ($row['nama_ayah'] || $row['nama_ibu'] || $row['alamat_orangtua']) {
      $orangtua = OrangTua::firstOrCreate([
        'nama_ayah' => $row['nama_ayah'],
        'nama_ibu' => $row['nama_ibu'],
        'alamat_orangtua' => $row['alamat_orangtua'],
        'kontak_ayah' => $row['kontak_ayah'],
        'kontak_ibu' => $row['kontak_ibu'],
      ]);
    }

    // Cari jurusan berdasarkan nama_jurusan, jika tidak ada, buat data baru
    $jurusan = Jurusan::firstOrCreate(['nama_jurusan' => $row['jurusan']]);

    // Cari classroom berdasarkan nama_kelas, jika tidak ada, buat data baru
    $classroom = Classroom::firstOrCreate(['nama_kelas' => $row['classroom']]);

    return new Siswa([
      'orang_tua_id' => $orangtua ? $orangtua->id : null, // Set orang_tua_id jika data orang tua ada
      'jurusan_id' => $jurusan->id, // ID dari jurusan yang sudah ditemukan/dibuat
      'classroom_id' => $classroom->id, // ID dari kelas yang sudah ditemukan/dibuat
      'nis' => $row['nis'],
      'nama_lengkap' => $row['nama_lengkap'],
      'jenis_kelamin' => $row['jenis_kelamin'],
      'tempat_lahir' => $row['tempat_lahir'],
      'tanggal_lahir' => is_numeric($row['tanggal_lahir']) 
      ? Carbon::instance(Date::excelToDateTimeObject($row['tanggal_lahir']))->format('Y-m-d') 
      : Carbon::createFromFormat('d/m/Y', $row['tanggal_lahir'])->format('Y-m-d'),
      'agama' => $row['agama'],
      'alamat' => $row['alamat'],
      'kontak' => $row['kontak'],
    ]);
  }

  public function rules(): array {
    return [
      '*.nis' => ['required'],
      '*.nama_lengkap' => ['required', 'string'],
      '*.kontak' => ['required'],
      '*.nama_ayah' => ['nullable', 'string'],
      '*.nama_ibu' => ['nullable', 'string'],
      '*.jurusan' => ['required', 'exists:jurusan,nama_jurusan'],
      '*.classroom' => ['required', 'exists:classrooms,nama_kelas'],
      '*.jenis_kelamin' => ['nullable', 'string'],
      '*.tempat_lahir' => ['nullable', 'string'],
      '*.tanggal_lahir' => ['nullable'],
      '*.agama' => ['nullable', 'string'],
      '*.alamat' => ['nullable', 'string'],
      '*.kontak_ayah' => ['nullable'],
      '*.kontak_ibu' => ['nullable'],
      '*.alamat_orangtua' => ['nullable'],
    ];
  }  
}