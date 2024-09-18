<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Classroom;
use App\Models\Jurusan;
use App\Models\Attendance;
use App\Models\Upload;
use App\Models\Keterlambatan;
use App\Exports\MonthlyRecapExport;
use Maatwebsite\Excel\Facades\Excel;

class kelasBinaanController extends Controller {

  public function index() {
    $title = 'Kelas Binaan';
    $classroom = Classroom::all();
    $guru = Auth::user()->guru;
    // Ambil nama kelas dari kelas yang dibina oleh guru tersebut
    $nama_kelas = $guru->classroom->nama_kelas;
    $siswa = $guru->classroom->siswa; // Ambil siswa dari kelas yang dibina
    // Ambil template import excel data siswa dari tabel uploads
    $siswaImport = Upload::where('description', 'like', '%data siswa%')->first();
    if (!$guru || !$guru->classroom) {
      return view('kelas_binaan.index', ['siswa' => [], 'message' => 'Anda tidak memiliki kelas binaan.', 'title' => $title]);
    }
    // Pastikan file URL bisa diakses
    $fileUrl = $siswaImport ? asset('storage/' . $siswaImport->file_path) : null;
    return view('kelas_binaan.index', compact('siswa','nama_kelas','classroom','siswaImport','fileUrl', 'title'));
  }
  
  public function show(Siswa $siswa) {
    $title = 'Profile Siswa';
    $siswa->load('classroom', 'jurusan', 'orang_tua');
    
    return view('admin.guru.profilSiswa', compact('title', 'siswa'));
  }
  
  public function edit(Siswa $siswa) {
    $title = 'Edit Data Siswa';
    $classrooms = Classroom::all();
    $jurusan = Jurusan::all();
    return view('kelas_binaan.edit', compact('title','siswa','jurusan', 'classrooms'));
  }
  
  public function update(Request $request, Siswa $siswa) {
    // Validasi dan update data siswa sesuai kebutuhan
    $request->validate([
      'nama_lengkap' => 'required|string|max:255',
      'nis' => 'required|string|max:20',
      'jenis_kelamin' => 'required|in:L,P',
      'classroom_id' => 'required|exists:classrooms,id',
    ]);
    $siswa->update([
      'nama_lengkap' => $request->nama_lengkap,
      'nis' => $request->nis,
      'jenis_kelamin' => $request->jenis_kelamin,
      'classroom_id' => $request->classroom_id,
    ]);
    
    return redirect()->route('kelas-binaan.index')->with('success', 'Data siswa berhasil diperbarui.');
  }

  public function destroy(Siswa $siswa) {
    $siswa->delete();
    return redirect()->route('kelas-binaan.index')->with('success', 'Data siswa berhasil dihapus.');
  }

  public function updateKelas(Request $request) {
    // Validasi input
    $request->validate([
      'siswa_ids' => 'required|array',
      'siswa_ids.*' => 'exists:siswa,id',
      'new_classroom_id' => 'required|exists:classrooms,id',
    ]);
    // Lakukan update data classroom_id untuk siswa yang dipilih
    Siswa::whereIn('id', $request->siswa_ids)
    ->update(['classroom_id' => $request->new_classroom_id]);
    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Siswa berhasil dipindahkan ke kelas baru.');
  }

  public function massDelete(Request $request) {
    $request->validate([
      'siswa_ids' => 'required|array',
      'siswa_ids.*' => 'exists:siswa,id',
    ]);
    // Ambil semua siswa yang dipilih
    $siswas = Siswa::whereIn('id', $request->siswa_ids)->get();
    // Hapus setiap siswa, yang akan memicu event deleting
    foreach ($siswas as $siswa) {
      $siswa->delete();
    }
    return redirect()->back()->with('success', 'Siswa terpilih berhasil dihapus.');
  }
  
  public function monthlyRecap(Request $request) {
    $title = 'Rekap Bulanan';
    $guru = Auth::user()->guru;
    // Cek apakah guru memiliki kelas binaan
    if (!$guru || !$guru->classroom) {
      return view('kelas_binaan.rekapBulanan', [
        'siswa' => [],
        'message' => 'Anda tidak memiliki kelas binaan.',
        'title' => $title
      ]);
    }
    $classroom = $guru->classroom;
    $month = $request->input('month', Carbon::now()->month);
    $year = $request->input('year', Carbon::now()->year);
        // Array nama bulan dalam bahasa Indonesia
    $bulanIndonesia = [
        1 => 'Januari', 
        2 => 'Februari', 
        3 => 'Maret', 
        4 => 'April', 
        5 => 'Mei', 
        6 => 'Juni', 
        7 => 'Juli', 
        8 => 'Agustus', 
        9 => 'September', 
        10 => 'Oktober', 
        11 => 'November', 
        12 => 'Desember'
    ];
    // Ambil semua siswa di kelas binaan
    $siswa = $classroom->siswa->sortBy('nama_lengkap');

    // Ambil rekap absensi bulanan
    $rekapAbsensi = Attendance::where('classroom_id', $classroom->id)
    ->whereMonth('date', $month)
    ->whereYear('date', $year)
    ->get()
    ->groupBy('siswa_id')
    ->map(function($attendanceRecords) {
      return [
        'sakit' => $attendanceRecords->where('status', 'sakit')->count(),
        'izin' => $attendanceRecords->where('status', 'izin')->count(),
        'alpa' => $attendanceRecords->where('status', 'alpa')->count(),
      ];
    });

    return view('kelas_binaan.rekapBulanan', compact('siswa', 'classroom', 'rekapAbsensi', 'title', 'month', 'year','bulanIndonesia'));
  }

  public function exportMonthlyRecap(Request $request) {
    $guru = Auth::user()->guru;

    if (!$guru || !$guru->classroom) {
      return redirect()->back()->with('error', 'Anda tidak memiliki kelas binaan.');
    }

    $classroom = $guru->classroom;
    $month = $request->input('month', Carbon::now()->month);
    $year = $request->input('year', Carbon::now()->year);

    $siswa = $classroom->siswa->sortBy('nama_lengkap');
    $rekapAbsensi = Attendance::whereHas('siswa', function($query) use ($classroom) {
      $query->where('classroom_id', $classroom->id);
    })->whereMonth('date', $month)->whereYear('date', $year)
    ->get()->groupBy('siswa_id')->map(function ($items) {
      return [
        'sakit' => $items->where('status', 'sakit')->count(),
        'izin' => $items->where('status', 'izin')->count(),
        'alpa' => $items->where('status', 'alpa')->count(),
      ];
    });

    return Excel::download(new MonthlyRecapExport($rekapAbsensi, $siswa), 'rekap_bulanan.xlsx');
  }

  public function import(Request $request) {
    // Validasi permintaan
    $request->validate([
      'file' => 'required|mimes:xls,xlsx|max:2048' // Opsional: batasi ukuran file
    ]);
		
		try {
      // Coba impor file menggunakan kelas SiswaImport
			Excel::import(new SiswaImport, $request->file('file'));
      // Redirect dengan pesan sukses
			return redirect()->route('kelas_binaan.index')->with('success', 'Data Siswa Berhasil di import.');
			
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      // Tangani pengecualian validasi dari impor Excel
			$failures = $e->failures();
			$messages = [];
			foreach ($failures as $failure) {
				$messages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
			}
      // Catat kesalahan validasi untuk debugging
      \Log::error('Gagal Validasi Impor: ', ['errors' => $messages]);
      $importError = implode("\n", $messages);
      // Redirect kembali dengan pesan kesalahan
			return redirect()->back()->with('errorimport', $importError);
		}
    catch (\Exception $e) {
      // Tangani pengecualian umum (seperti kesalahan membaca atau parsing file)
      \Log::error('Kesalahan Impor: ' . $e->getMessage());
      
      return redirect()->back()->with('errorimport', 'Terjadi kesalahan saat mengimpor file. Pastikan file sesuai dengan format yang benar.');
    }
	}
}