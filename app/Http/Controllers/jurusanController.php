<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class jurusanController extends Controller {
  public function index() {
    $title = 'Data Jurusan';
    $jurusan = Jurusan::all();
    return view('admin.jurusan.index', compact('jurusan','title'));
  }

  public function store(Request $request) {
    $request->validate([
      'nama_jurusan' => 'required',
    ]);
    if ( Jurusan::create($request->all())) {
      return redirect()->route('jurusan.index')->with('success', 'Berhasil menyimpan data!');
    } else {
      return redirect()->route('jurusan.index')->with('error', 'Gagal menyimpan data.');
    }
  }
  
  public function update(Request $request, Jurusan $jurusan) {
    if (!$jurusan) {
      return redirect()->route('jurusan.index')->with('error', 'Data tidak ditemukan.');
    }
    $request->validate([
      "nama_jurusan" => 'required'
    ]);
    if ($jurusan->update($request->all())) {
      return redirect()->route('jurusan.index')->with('success', 'Berhasil memperbarui data!');
    } else {
      return redirect()->route('jurusan.index')->with('error', 'Gagal memperbarui data.');
    }
  }

  public function destroy(Jurusan $jurusan) {
    if (!$jurusan) {
      return redirect()->route('jurusan.index')->with('error', 'Data tidak ditemukan.');
    }

    if ($jurusan->delete()) {
      return redirect()->route('jurusan.index')->with('success', 'Berhasil menghapus data!');
    } else {
      return redirect()->route('jurusan.index')->with('error', 'Gagal menghapus data.');
    }
  }
}