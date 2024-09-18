<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PelanggaranSiswa;
use App\Models\DataPelanggaran;
use App\Models\Siswa;
use App\Models\Classroom;

class pelanggaranSiswaController extends Controller {
  
  public function index(Request $request) {
    $title = 'Daftar Pelanggaran Siswa';
    $user = Auth::user();
    // Jika role adalah guru
    if ($user->role == 'guru') {
      $guru = $user->guru;
      // Jika guru tidak memiliki kelas binaan
      if (!$guru || !$guru->classroom) {
        return view('pelanggaranSiswa.index', [
          'pelanggaranSiswa' => [],
          'message' => 'Anda tidak memiliki kelas binaan.',
          'title' => $title
        ]);
      }
      // Ambil pelanggaran siswa dari kelas binaan guru
      $pelanggaranSiswa = PelanggaranSiswa::with('siswa.classroom', 'dataPelanggaran')
      ->whereIn('siswa_id', $guru->classroom->siswa->pluck('id'))
      ->get();
      return view('pelanggaranSiswa.index', compact('pelanggaranSiswa', 'title'));
      // Jika role adalah guru_bk
    } elseif ($user->role == 'guru_bk') {
      // Ambil semua pelanggaran siswa dan daftar kelas
      $pelanggaranSiswa = PelanggaranSiswa::with('siswa.classroom', 'dataPelanggaran')->get();
      $classrooms = Classroom::all();
      return view('pelanggaranSiswa.index', compact('pelanggaranSiswa', 'title', 'classrooms'));
    } else {
      // Jika role tidak diizinkan
      return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk melihat pelanggaran siswa.');
    }
  }
  
public function create() {
    $title = 'Tambah Pelanggaran Siswa';
    $user = Auth::user();
    $classrooms = Classroom::all(); // Tetapkan classrooms untuk semua pengguna
    if ($user->role == 'guru') {
      $guru = $user->guru;
      if (!$guru || !$guru->classroom) {
        return redirect()->route('pelanggaranSiswa.index')->with('error', 'Anda tidak memiliki kelas binaan.');
      }
      $siswa = $guru->classroom->siswa; // Hanya siswa dari kelas wali kelas
      
    } elseif ($user->role == 'guru_bk') {
      $siswa = collect(); // Koleksi kosong, nanti diisi setelah kelas dipilih oleh guru_bk
    } else {
      return redirect()->route('pelanggaranSiswa.index')->with('error', 'Anda tidak memiliki akses.');
    }
    
    $jenisPelanggaran = DataPelanggaran::all();
    return view('pelanggaranSiswa.create', compact('siswa', 'jenisPelanggaran', 'title', 'classrooms'));
  }

  public function store(Request $request) {
    $request->validate([
      'siswa_id' => 'required',
      'jenis_pelanggaran' => 'required|array',
      'jenis_pelanggaran.*' => 'exists:data_pelanggaran,id',
      'tanggal_pelanggaran' => 'required|date',
      'keterangan' => 'nullable|string',
    ]);
    $pelanggaranSiswa = PelanggaranSiswa::create([
      'siswa_id' => $request->siswa_id,
      'tanggal_pelanggaran' => $request->tanggal_pelanggaran,
      'keterangan' => $request->keterangan,
    ]);
    // Jika jenis pelanggaran adalah array dan bisa memiliki beberapa jenis, maka gunakan `attach` atau `sync` sesuai kebutuhan
    $pelanggaranSiswa->dataPelanggaran()->attach($request->jenis_pelanggaran);
    return redirect()->route('pelanggaranSiswa.index')->with('success', 'Pelanggaran berhasil ditambahkan');
  }

  public function show(string $id) {
    //
  }
  
  public function edit(PelanggaranSiswa $pelanggaranSiswa) {
    $title = 'Edit Pelanggaran Siswa';
    $user = Auth::user();
    $classrooms = Classroom::all(); // Semua kelas untuk guru_bk
    $jenisPelanggaran = DataPelanggaran::all();
    // Cek role pengguna
    if ($user->role == 'guru') {
      $guru = $user->guru;
      if (!$guru || !$guru->classroom) {
        return redirect()->route('pelanggaranSiswa.index')->with('error', 'Anda tidak memiliki kelas binaan.');
      }
      $siswa = $guru->classroom->siswa; // Hanya siswa dari kelas wali kelas
      
    } elseif ($user->role == 'guru_bk') {
      $siswa = Siswa::all(); // Semua siswa untuk guru_bk
    } else {
      return redirect()->route('pelanggaranSiswa.index')->with('error', 'Anda tidak memiliki akses.');
    }
    
    return view('pelanggaranSiswa.edit', compact('pelanggaranSiswa', 'siswa', 'jenisPelanggaran', 'title', 'classrooms'));
  }

  public function update(Request $request, PelanggaranSiswa $pelanggaranSiswa) {
    $request->validate([
      'siswa_id' => 'required',
      'jenis_pelanggaran' => 'required|array',
      'jenis_pelanggaran.*' => 'exists:data_pelanggaran,id',
      'tanggal_pelanggaran' => 'required|date',
      'keterangan' => 'nullable|string',
    ]);
    $pelanggaranSiswa->update($request->only('siswa_id', 'tanggal_pelanggaran', 'keterangan'));
    // Update jenis pelanggaran yang dipilih
    $pelanggaranSiswa->dataPelanggaran()->sync($request->jenis_pelanggaran);
    return redirect()->route('pelanggaranSiswa.index')->with('success', 'Pelanggaran berhasil diperbarui');
  }
  
  public function destroy(PelanggaranSiswa $pelanggaranSiswa) {
    $pelanggaranSiswa->delete();
    
    return redirect()->route('pelanggaranSiswa.index')->with('success', 'Pelanggaran berhasil dihapus');
  }
  
  public function autocompleteSiswa(Request $request) {
    $search = $request->get('query');
    $classroom_id = $request->get('classroom_id');
    $user = Auth::user();
    
    if ($user->role == 'guru') {
      $guru = $user->guru;
      if (!$guru || !$guru->classroom) {
        return response()->json([]);
      }
      $siswa = $guru->classroom->siswa()
      ->where('nama_lengkap', 'LIKE', '%' . $search . '%')
      ->get();
    } elseif ($user->role == 'guru_bk') {
      // Jika classroom_id tidak ada, kembali kosong
      if (!$classroom_id) {
        return response()->json([]);
      }
      $siswa = Siswa::where('classroom_id', $classroom_id)
      ->where('nama_lengkap', 'LIKE', '%' . $search . '%')
      ->get();
    } else {
      return response()->json([]);
    }
    // Format hasil pencarian untuk dikembalikan sebagai JSON
    $results = $siswa->map(function($s) {
      return ['id' => $s->id, 'value' => $s->nama_lengkap];
    });
    return response()->json($results);
  }
}