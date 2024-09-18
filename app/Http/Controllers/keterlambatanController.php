<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keterlambatan;
use App\Models\Siswa;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;

class keterlambatanController extends Controller {
  public function index() {
    $title = 'Keterlambatan';
    $user = Auth::user();
    // Mengambil semua data kelas untuk dropdown filter
    $classrooms = Classroom::all();
    // Jika role adalah guru_bk, hanya dapat melihat data keterlambatan tanpa aksi CRUD
    if ($user->role === 'guru_bk') {
      $keterlambatan = Keterlambatan::with('siswa', 'classroom')->get();
      return view('keterlambatan.index', compact('keterlambatan', 'classrooms', 'title'));
    }
    // Jika role adalah guru_piket, bisa mengakses semua fungsi keterlambatan (CRUD)
    if ($user->role === 'guru_piket') {
      $keterlambatan = Keterlambatan::with('siswa', 'classroom')->get();
      return view('keterlambatan.index', compact('keterlambatan', 'classrooms', 'title'));
    }
    // Jika role tidak valid atau akses ditolak
    return redirect()->route('home')->with('error', 'Akses ditolak.');
  }

  public function create() {
    $title = 'Tambah Keterlambatan';
    $classrooms = Classroom::all();
    $siswa = Siswa::all();
    // Hanya guru_piket yang bisa menambah data
    if (Auth::user()->role === 'guru_piket') {
      return view('keterlambatan.create', compact('siswa', 'classrooms', 'title'));
    }
    return redirect()->route('keterlambatan.index')->with('error', 'Anda tidak memiliki izin untuk menambah data.');
  }
  public function store(Request $request) {
    if (Auth::user()->role === 'guru_piket') {
      $request->validate([
        'siswa_id' => 'required|exists:siswa,id',
        'classroom_id' => 'required|exists:classrooms,id',
        'tanggal_keterlambatan' => 'required|date',
        'waktu_keterlambatan' => 'required|date_format:H:i',
      ]);
      Keterlambatan::create($request->all());
      return redirect()->route('keterlambatan.index')->with('success', 'Keterlambatan berhasil ditambahkan.');
    }
    return redirect()->route('keterlambatan.index')->with('error', 'Anda tidak memiliki izin untuk menambah data.');
  }
  
  public function edit(Keterlambatan $keterlambatan) {
    $title = 'Edit Keterlambatan Siswa';
    $classrooms = Classroom::all();
    $siswa = Siswa::all();
    // Hanya guru_piket yang bisa mengedit data
    if (Auth::user()->role === 'guru_piket') {
      return view('keterlambatan.edit', compact('keterlambatan', 'classrooms', 'siswa', 'title'));
    }
    return redirect()->route('keterlambatan.index')->with('error', 'Anda tidak memiliki izin untuk mengedit data.');
  }
  
  public function update(Request $request, Keterlambatan $keterlambatan) {
    if (Auth::user()->role === 'guru_piket') {
      $request->validate([
        'siswa_id' => 'required|exists:siswa,id',
        'classroom_id' => 'required|exists:classrooms,id',
        'tanggal_keterlambatan' => 'required|date',
        'waktu_keterlambatan' => 'required|date_format:H:i',
      ]);
      $keterlambatan->update($request->all());
      return redirect()->route('keterlambatan.index')->with('success', 'Data keterlambatan berhasil diperbarui.');
    }
    return redirect()->route('keterlambatan.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui data.');
  }

  public function destroy(Keterlambatan $keterlambatan) {
    if (Auth::user()->role === 'guru_piket') {
      $keterlambatan->delete();
      return redirect()->route('keterlambatan.index')->with('success', 'Keterlambatan berhasil dihapus.');
    }
    return redirect()->route('keterlambatan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus data.');
  }
  
  public function searchSiswa(Request $request) {
    if ($request->ajax()) {
      $search = $request->input('query');
      $classroom_id = $request->input('classroom_id');
      // Cari siswa berdasarkan kelas dan nama
      $siswa = Siswa::where('classroom_id', $classroom_id)
      ->where('nama_lengkap', 'LIKE', "%{$search}%")
      ->get(['id', 'nama_lengkap']);
      
      return response()->json($siswa);
    }
    return response()->json(['error' => 'Invalid request'], 400);
  }

}