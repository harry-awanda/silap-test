<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Keterlambatan;

class AbsensiKeterlambatanController extends Controller {

  public function absensi() {
    $title = 'Rekap Absensi Kelas';
    $guru = Auth::user()->guru;
    
    if (!$guru || !$guru->classroom) {
      return view('kelas_binaan.rekapAbsensi', [
        'dataAbsensi' => [],
        'message' => 'Anda tidak memiliki kelas binaan.',
        'title' => $title
      ]);
    }
    
    $classroomId = $guru->classroom->id;
    $nama_kelas = $guru->classroom->nama_kelas;
    // Ambil semua data absensi untuk kelas ini
    $dataAbsensi = Attendance::where('classroom_id', $classroomId)
      ->with('siswa')
      ->orderBy('date', 'desc') // Mengurutkan berdasarkan tanggal terbaru
      ->get();
    
    return view('kelas_binaan.absensi', compact('dataAbsensi', 'nama_kelas', 'title'));
  }
  
  public function keterlambatan() {
    $title = 'Rekap Keterlambatan Kelas';
    $guru = Auth::user()->guru;
    
    if (!$guru || !$guru->classroom) {
      return view('kelas_binaan.rekapKeterlambatan', [
        'dataKeterlambatan' => [],
        'message' => 'Anda tidak memiliki kelas binaan.',
        'title' => $title
      ]);
    }
    
    $classroomId = $guru->classroom->id;
    $nama_kelas = $guru->classroom->nama_kelas;
    // Ambil semua data keterlambatan untuk kelas ini
    $dataKeterlambatan = Keterlambatan::where('classroom_id', $classroomId)
      ->with('siswa')
      ->orderBy('tanggal_keterlambatan', 'desc') // Mengurutkan berdasarkan tanggal terbaru
      ->get();
    
    return view('kelas_binaan.keterlambatan', compact('dataKeterlambatan', 'nama_kelas', 'title'));
  }
  
  public function filter(Request $request) {
    $guru = Auth::user()->guru;
    $classroomId = $guru->classroom->id;
    
    $filterDateAbsensi = $request->input('filter_date_absensi');
    $filterDateKeterlambatan = $request->input('filter_date_keterlambatan');
    $filterType = $request->input('filter_type');
    
    $dataAbsensi = [];
    $dataKeterlambatan = [];
    
    if ($filterType == 'absensi' && $filterDateAbsensi) {
      $dataAbsensi = Attendance::where('classroom_id', $classroomId)
        ->whereDate('date', Carbon::parse($filterDateAbsensi))
        ->with('siswa')
        ->get();
    }
    
    if ($filterType == 'keterlambatan' && $filterDateKeterlambatan) {
      $dataKeterlambatan = Keterlambatan::where('classroom_id', $classroomId)
        ->whereDate('tanggal_keterlambatan', Carbon::parse($filterDateKeterlambatan))
        ->with('siswa')
        ->get();
    }
    
    return response()->json([
      'dataAbsensi' => $dataAbsensi,
      'dataKeterlambatan' => $dataKeterlambatan
    ]);
  }
}