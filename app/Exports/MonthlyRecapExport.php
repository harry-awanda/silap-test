<?php

namespace App\Exports;

// Menggunakan model Siswa dan beberapa interface dari Maatwebsite Excel untuk fitur export
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping; 

// Class untuk mengekspor rekap bulanan absensi ke Excel
class MonthlyRecapExport implements FromCollection, WithHeadings, WithMapping {

  // Variabel untuk menyimpan data rekap absensi dan daftar siswa
  protected $rekapAbsensi;
  protected $siswa;

  // Konstruktor untuk menginisialisasi variabel dengan data yang diterima dari controller
  public function __construct($rekapAbsensi, $siswa) {
    $this->rekapAbsensi = $rekapAbsensi; // Data rekap absensi yang sudah diproses sebelumnya
    $this->siswa = $siswa; // Daftar siswa yang ada di kelas binaan guru
  }

  // Fungsi untuk mengembalikan koleksi data siswa yang akan diekspor
  public function collection() {
    return $this->siswa; // Mengembalikan koleksi siswa yang akan diekspor
  }
  // Fungsi untuk mengatur judul kolom pada file Excel
  public function headings(): array {
    return [
      'Nama Lengkap', // Kolom untuk nama lengkap siswa
      'Sakit',        // Kolom untuk jumlah hari sakit
      'Izin',         // Kolom untuk jumlah hari izin
      'Alpa',         // Kolom untuk jumlah hari alpa
    ];
  }

  // Fungsi untuk memetakan data siswa dengan rekap absensi masing-masing
  public function map($siswa): array {
    return [
      $siswa->nama_lengkap, // Mengambil nama lengkap siswa
      // Mengambil jumlah hari sakit, izin, dan alpa, jika tidak ada data, default 0
      $this->rekapAbsensi[$siswa->id]['sakit'] ?? 0,
      $this->rekapAbsensi[$siswa->id]['izin'] ?? 0,
      $this->rekapAbsensi[$siswa->id]['alpa'] ?? 0,
    ];
  }
}