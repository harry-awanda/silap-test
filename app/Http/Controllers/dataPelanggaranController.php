<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPelanggaran;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataPelanggaranImport;

class dataPelanggaranController extends Controller {

  public function index() {
    $title = 'Data Pelanggaran';
    $data_pelanggaran = DataPelanggaran::all();
    return view('admin.data_pelanggaran.index', compact('title','data_pelanggaran'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'jenis_pelanggaran' => 'required|string|max:255',
    ]);
    DataPelanggaran::create($request->all());

    return redirect()->route('data_pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
  }

  public function update(Request $request, DataPelanggaran $data_pelanggaran) {
    $request->validate([
      'jenis_pelanggaran' => 'required|string|max:255',
    ]);
    $data_pelanggaran->update($request->all());

    return redirect()->route('data_pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil diupdate.');
  }

  public function destroy(DataPelanggaran $data_pelanggaran) {
    $data_pelanggaran->delete();
    return redirect()->route('data_pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil dihapus.');
  }

  public function importExcel(Request $request) {
    $request->validate([
      'file' => 'required|mimes:xlsx',
    ]);
    Excel::import(new DataPelanggaranImport, $request->file('file'));
    return redirect()->route('data_pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil diimport.');
  }
}