<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Siswa;

class attendanceController extends Controller {

  public function index(Request $request) {
    $title = 'Kehadiran';
    // Mengambil semua data kelas untuk dropdown filter
    $classrooms = Classroom::all();
    // Mendapatkan data kehadiran hanya untuk hari ini
    $today = now()->toDateString();
    $attendances = Attendance::with('siswa', 'siswa.classroom')
    ->whereDate('created_at', $today) // Filter data kehadiran untuk hari ini
    ->get();
    // Return view dengan data yang sesuai
    return view('attendance.index', compact('attendances', 'classrooms', 'title'));
  }

  public function create(Request $request) {
    $title = 'Kehadiran';
    $classrooms = Classroom::all();
    return view('attendance.create', compact('classrooms','title'));
  }

  public function store(Request $request) {
    // Validasi input
    $request->validate([
      'classroom_id' => 'required|exists:classrooms,id',
      'attendance' => 'required|array',
      'attendance.*.siswa_id' => 'required|exists:siswa,id',
      'attendance.*.status' => 'in:sakit,izin,alpa'
    ]);

    try {
      // Loop melalui setiap attendance data untuk disimpan
      foreach ($request->attendance as $attendanceData) {
        // Pastikan hanya menyimpan data jika ada status yang dipilih
        if (!empty($attendanceData['status'])) {
          Attendance::create([
            'siswa_id' => $attendanceData['siswa_id'],
            'classroom_id' => $request->classroom_id,
            'status' => $attendanceData['status'],
            'date' => now(),
          ]);
        }
      }
      // Redirect atau response setelah berhasil menyimpan
      return redirect()->route('attendance.index')->with('success', 'Attendance data has been saved successfully.');

    } catch (\Exception $e) {
      // Redirect atau response jika terjadi kegagalan menyimpan data
      return redirect()->route('attendance.create')
      ->with('error', 'Failed to save attendance data. Please try again.');
    }
  }

  public function edit(Attendance $attendance) {
    $title = 'Edit Data Kehadiran';
    $classrooms = Classroom::all();
    $students = Siswa::where('classroom_id', $attendance->classroom_id)->get();

    // Ambil semua record absensi untuk siswa di kelas tersebut pada tanggal yang sama
    $attendances = Attendance::where('classroom_id', $attendance->classroom_id)
    ->whereDate('date', $attendance->date)->get()->keyBy('siswa_id');
    
    return view('attendance.edit', compact('attendance','attendances','classrooms','students','title'));
  }
  
  public function update(Request $request, Attendance $attendance) {
    // Validasi input
    $request->validate([
      'attendance' => 'required|array',
      'attendance.*.siswa_id' => 'required|exists:siswa,id',
      'attendance.*.status' => 'in:sakit,izin,alpa',
    ]);
    
    try {
      // Loop melalui setiap attendance data untuk diperbarui
      foreach ($request->attendance as $siswa_id => $attendanceData) {
        if (isset($attendanceData['status'])) {  // Cek apakah status ada
          Attendance::updateOrCreate(
            [
              'siswa_id' => $siswa_id,
              'classroom_id' => $attendance->classroom_id,
              'date' => $attendance->date,
            ],
            [
              'status' => $attendanceData['status'],
            ]
          );
        }
      }
      // Redirect atau response setelah berhasil memperbarui
      return redirect()->route('attendance.index')->with('success', 'Attendance data has been updated successfully.');

    } catch (\Exception $e) {
      // Redirect atau response jika terjadi kegagalan memperbarui data
      return redirect()->route('attendance.edit', $attendance->id)
      ->with('error', 'Failed to update attendance data. Please try again.');
    }
  }

  public function destroy(Attendance $attendance) {
    $attendance->delete();
    return redirect()->route('attendance.index')->with('success', 'Data kehadiran berhasil dihapus.');
  }

  public function getStudents($classroomId) {
    $siswa = Siswa::where('classroom_id', $classroomId)->get();
    return view('attendance.partial.data-siswa', compact('siswa'))->render();
  }
}