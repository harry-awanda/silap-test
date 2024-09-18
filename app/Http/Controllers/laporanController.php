<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class laporanController extends Controller {
  public function rekapBulanan(Request $request) {
    $title = 'Rekap Laporan Bulanan';
    $month = $request->get('month', now()->format('m'));
    $year = $request->get('year', now()->format('Y'));
    
    // Query untuk mengambil data kehadiran bulanan
    $attendance = Attendance::whereYear('date', $year)
    ->whereMonth('date', $month)->with('siswa.classroom')->get();

    return view('laporan.rekap-bulanan', compact('attendance', 'title', 'month', 'year'));
  }
}
