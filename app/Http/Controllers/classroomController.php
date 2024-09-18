<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Guru;

class classroomController extends Controller {
  public function index() {
    $title = 'Data Kelas';
    $classrooms = Classroom::with('guru')->withCount('siswa')->get();
    $guru = Guru::all();
    return view('admin.kelas.index', compact('classrooms','title','guru'));
  }

  public function store(Request $request) {
    $request->validate([
      'nama_kelas' => 'required',
      'tingkat' => 'required',
      'wali_kelas_id' => 'nullable|exists:guru,id',
    ]);
    if ( Classroom::create($request->all())) {
      return redirect()->route('classrooms.index')->with('success', 'Berhasil menyimpan data!');
    } else {
      return redirect()->route('classrooms.index')->with('error', 'Gagal menyimpan data.');
    }
  }

  public function update(Request $request, Classroom $classroom) {
    if (!$classroom) {
      return redirect()->route('classrooms.index')->with('error', 'Data tidak ditemukan.');
    }
    $request->validate([
      "nama_kelas" => 'required',
      'tingkat' => 'required',
      'wali_kelas_id' => 'nullable|exists:guru,id',
    ]);
    if ($classroom->update($request->all())) {
      return redirect()->route('classrooms.index')->with('success', 'Berhasil memperbarui data!');
    } else {
      return redirect()->route('classrooms.index')->with('error', 'Gagal memperbarui data.');
    }
  }

  public function destroy(Classroom $classroom) {
    if (!$classroom) {
      return redirect()->route('classrooms.index')->with('error', 'Data tidak ditemukan.');
    }

    if ($classroom->delete()) {
      return redirect()->route('classrooms.index')->with('success', 'Berhasil menghapus data!');
    } else {
      return redirect()->route('classrooms.index')->with('error', 'Gagal menghapus data.');
    }
  }
}