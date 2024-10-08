<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Imports\SiswaImport;
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
  
  public function show($siswa_id){
    $title = 'Profil Siswa';
    $siswa = Siswa::findOrFail($siswa_id);
    $classrooms = Classroom::all();
    $jurusan = Jurusan::all();
    return view('kelas_binaan.show', compact('title','siswa','jurusan', 'classrooms'));
  }

  public function edit($siswa_id) {
    $title = 'Edit Data Siswa';
    $siswa = Siswa::findOrFail($siswa_id);
    $classrooms = Classroom::all();
    $jurusan = Jurusan::all();
    return view('kelas_binaan.edit', compact('title','siswa','jurusan', 'classrooms'));
  }
  
  public function update(Request $request, $siswa_id) {
    // Validasi data yang diterima dari request
    $data = $request->validate([
      'nis' => 'required|string|max:5',
      'nama_lengkap' => 'required|string|max:255',
      'jurusan_id' => 'required|exists:jurusan,id',
      'classroom_id' => 'required|exists:classrooms,id',
      'jenis_kelamin' => 'nullable|string|in:L,P',
      'tempat_lahir' => 'nullable|string',
      'tanggal_lahir' => 'nullable|date',
      'agama' => 'nullable|string',
      'alamat' => 'nullable|string',
      'kontak' => 'nullable|string',
      'photo' => 'nullable|image',
      'nama_ayah' => 'nullable|string',
      'nama_ibu' => 'nullable|string',
      'kontak_ayah' => 'nullable|string',
      'kontak_ibu' => 'nullable|string',
      'alamat_orangtua' => 'nullable|string',
      'nama_wali_murid' => 'nullable|string',
      'alamat_wali' => 'nullable|string',
      'kontak_wali' => 'nullable|string',
    ]);
    // Cari siswa berdasarkan ID siswa
    $siswa = Siswa::findOrFail($siswa_id);
    // Jika ada upload foto baru, proses penyimpanan file
    if ($request->hasFile('photo')) {
      // Hapus foto lama jika ada
      if ($siswa->photo) {
        Storage::disk('public')->delete($siswa->photo);
      }
      // Simpan foto baru
      $data['photo'] = $request->file('photo')->store('photos', 'public');
    }
    // Perbarui data siswa
    $siswa->update($data);
    // Jika ada data orang tua yang diisi, perbarui atau buat data baru orang tua
    if ($request->filled('nama_ayah') || $request->filled('nama_ibu')) {
      $orangTua = $siswa->orang_tua()->updateOrCreate(
        ['id' => $siswa->orang_tua_id],
        [
          'nama_ayah' => $data['nama_ayah'],
          'nama_ibu' => $data['nama_ibu'],
          'alamat_orangtua' => $data['alamat_orangtua'],
          'kontak_ayah' => $data['kontak_ayah'],
          'kontak_ibu' => $data['kontak_ibu'],
          'nama_wali_murid' => $data['nama_wali_murid'],
          'alamat_wali' => $data['alamat_wali'],
          'kontak_wali' => $data['kontak_wali'],
        ]
      );
      // Hubungkan orang tua dengan siswa
      $siswa->update(['orang_tua_id' => $orangTua->id]);
    }
    // Redirect ke halaman index kelas binaan dengan pesan sukses
    return redirect()->route('kelas-binaan.index')->with('success', 'Data siswa berhasil diperbarui.');
  }

  public function destroy($siswa_id) {
    $siswa = Siswa::findOrFail($siswa_id);
    $siswa->delete();
    return redirect()->route('kelas-binaan.index')->with('success', 'Data siswa berhasil dihapus.');
  }

  public function updateKelas(Request $request) {
    // dd($request->all());
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
			return redirect()->route('kelas-binaan.index')->with('success', 'Data Siswa Berhasil di import.');
			
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