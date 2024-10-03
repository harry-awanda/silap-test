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

class SiswaImport implements ToModel, WithHeadingRow, WithValidation {
  public function headingRow(): int {
    return 1; // Header dimulai dari baris 1
  }

  public function model(array $row) {
    // Lewati jika field yang diperlukan tidak ada
    if (empty($row['nis']) || empty($row['nama_lengkap']) || empty($row['jurusan']) || empty($row['classroom'])) {
      return null;
    }
    // Cek jika siswa sudah ada
    $existingStudent = Siswa::where('nama_lengkap', $row['nama_lengkap'])
    ->where('nis', $row['nis'])->first();

    if ($existingStudent) {
      return null; // Jika siswa sudah ada, lewati
    }

    // Proses data orang tua
    $orangtua = null;
    if ($row['nama_ayah'] || $row['nama_ibu'] || $row['alamat_orangtua']) {
      $orangtua = OrangTua::firstOrCreate([
        'nama_ayah' => $row['nama_ayah'],
        'nama_ibu' => $row['nama_ibu'],
        'alamat_orangtua' => $row['alamat_orangtua'],
        'kontak_ayah' => $row['kontak_ayah'],
        'kontak_ibu' => $row['kontak_ibu'],
      ]);
    }
    // Proses data jurusan dan kelas
    $jurusan = Jurusan::firstOrCreate(['nama_jurusan' => $row['jurusan']]);
    $classroom = Classroom::firstOrCreate(['nama_kelas' => $row['classroom']]);
    // Kembalikan objek siswa
    return new Siswa([
      'orang_tua_id' => $orangtua ? $orangtua->id : null,
      'jurusan_id' => $jurusan->id,
      'classroom_id' => $classroom->id,
      'nis' => $row['nis'],
      'nama_lengkap' => $row['nama_lengkap'],
      'jenis_kelamin' => $row['jenis_kelamin'],
      'tempat_lahir' => $row['tempat_lahir'],
      'tanggal_lahir' => $this->formatTanggalLahir($row['tanggal_lahir']),
      'agama' => $row['agama'],
      'alamat' => $row['alamat'],
      'kontak' => $row['kontak'],
    ]);
  }

  public function rules(): array {
    return [
      '*.nis' => ['required'], // Pastikan nis unik
      '*.nama_lengkap' => ['required', 'string'],
      '*.kontak' => ['nullable'],
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

  private function formatTanggalLahir($tanggalLahir) {
    return is_numeric($tanggalLahir)
    ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalLahir))->format('Y-m-d')
    : Carbon::createFromFormat('d/m/Y', $tanggalLahir)->format('Y-m-d');
  }
}