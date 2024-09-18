<?php

namespace App\Imports;

use App\Models\DataPelanggaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class DataPelanggaranImport implements ToModel {

  use Importable;

  public function model(array $row) {
    // Anggap kolom pertama (index 0) adalah data 'jenis_pelanggaran'
    $jenisPelanggaran = $row[0];
    // Cek apakah jenis pelanggaran sudah ada dalam database
    $existing = DataPelanggaran::where('jenis_pelanggaran', $jenisPelanggaran)->first();
    
    if ($existing === null) {
      // Jika belum ada, buat entri baru
      return new DataPelanggaran([
        'jenis_pelanggaran' => $jenisPelanggaran,
      ]);
    }
    // Jika sudah ada, tidak melakukan apa-apa (bisa logika lain jika diperlukan)
    return null;
  }
}