<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Classroom;
use App\Models\Jurusan;
use App\Models\Attendance;

class dashboardController extends Controller {
  public function index (){
    $title = 'Dashboard';
    $jumlahSiswa = Siswa::count();
    $jumlahGuru = Guru::count();
    $jumlahKelas = Classroom::count();
    $jumlahJurusan = Jurusan::count();

    // Dapatkan tanggal hari ini
    $date = Carbon::today();
    // Format tanggal sesuai kebutuhan
    $formattedDate = $date->format('d-m-Y');

    // Total siswa di kelas X
    $totalSiswaKelasX = Siswa::whereHas('classroom', function($query) {
      $query->where('tingkat', 10);
    })->count();

    // Jumlah siswa yang absen di kelas X pada hari tertentu
    $absenKelasX = Attendance::whereHas('siswa.classroom', function($query) {
      $query->where('tingkat', 10);
    })->whereDate('date', $date)->count();

    // Cek jika total siswa di kelas X tidak nol
    if ($totalSiswaKelasX > 0) {
      // Persentase absensi kelas X pada hari tertentu
      $persentaseAbsenKelasX = $absenKelasX / $totalSiswaKelasX * 100;
    } else {
      // Jika tidak ada siswa di kelas X
      $persentaseAbsenKelasX = 0; // atau Anda bisa memberikan pesan atau nilai khusus
    }

    $totalSiswaKelasXI = Siswa::whereHas('classroom', function($query) {
      $query->where('tingkat', 11);
    })->count();

    $absenKelasXI = Attendance::whereHas('siswa.classroom', function($query) {
      $query->where('tingkat', 11);
    })->whereDate('date', $date)->count();

    if ($totalSiswaKelasXI > 0) {
      $persentaseAbsenKelasXI = $absenKelasXI / $totalSiswaKelasXI * 100;
    } else {
      // Jika tidak ada siswa di kelas XI
      $persentaseAbsenKelasXI = 0; // atau Anda bisa memberikan pesan atau nilai khusus
    }

    $totalSiswaKelasXII = Siswa::whereHas('classroom', function($query) {
      $query->where('tingkat', 12);
    })->count();
    $absenKelasXII = Attendance::whereHas('siswa.classroom', function($query) {
      $query->where('tingkat', 12);
    })->whereDate('date', $date)->count();

    if ($totalSiswaKelasXII > 0) {
      $persentaseAbsenKelasXII = $absenKelasXII / $totalSiswaKelasXII * 100;
    } else {
      // Jika tidak ada siswa di kelas XII
      $persentaseAbsenKelasXII = 0; // atau Anda bisa memberikan pesan atau nilai khusus
    }

    // Jumlah siswa yang absen di sekolah pada hari tertentu
    $totalAbsen = Attendance::whereDate('date', $date)->count();

    // Cek jika total siswa di seluruh sekolah tidak nol
    if ($jumlahSiswa > 0) {
      // Persentase absensi di seluruh sekolah pada hari tertentu
      $persentaseTotalAbsen = $totalAbsen / $jumlahSiswa * 100;
    } else {
      // Jika tidak ada siswa di sekolah
      $persentaseTotalAbsen = 0; // atau Anda bisa memberikan pesan atau nilai khusus
    }
    
    return view('dashboard',compact(
      'title',
      'jumlahSiswa',
      'jumlahGuru',
      'jumlahKelas',
      'jumlahJurusan',
      'persentaseAbsenKelasX',
      'formattedDate', 
      'persentaseAbsenKelasXI', 
      'persentaseAbsenKelasXII',
      'persentaseTotalAbsen',
    ));
  }
}