<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPiket;
use App\Models\Guru;
use App\Models\User;

class jadwalPiketController extends Controller {
  public function index() {
    $title = 'Jadwal Piket';
    // Ambil semua data guru untuk ditampilkan di view
    $guru = Guru::all();
    $jadwalPiket = JadwalPiket::with('guru')->get();
    return view('admin.jadwal_piket.index', compact('jadwalPiket', 'title', 'guru'));
  }
  
  public function store(Request $request) {
    // Validasi data input
    $request->validate([
      'guru_id' => 'required|exists:guru,id',
      'hari_piket' => 'required',
    ]);
    
    try {
      // Cek jika guru sudah memiliki jadwal piket di hari yang sama
      $existingSchedule = JadwalPiket::where('guru_id', $request->guru_id)
      ->where('hari_piket', $request->hari_piket)
      ->exists();
      
      if ($existingSchedule) {
        return redirect()->back()->with('error', 'Guru sudah memiliki jadwal piket pada hari ini.');
      }

      // Ambil data guru beserta user terkait
      $guru = Guru::findOrFail($request->guru_id);
      $user = $guru->user;
      
      // Pastikan username ada dan tidak null
      $username = 'piket.' . ($user->username ?? strtolower(str_replace(' ', '', $guru->nama_lengkap)));
      
      // Buat akun guru piket dengan role guru_piket
      $userPiket = User::create([
        'username' => $username, // Gunakan username yang sudah ada dengan prefix piket atau default
        'name' => $guru->nama_lengkap,
        'role' => 'guru_piket',
        'password' => bcrypt('smkn4321') // Ganti dengan password yang aman
      ]);
      
      // Simpan jadwal piket
      $jadwalPiket = JadwalPiket::create($request->all());
      
      return redirect()->route('jadwal-piket.index')->with('success', 'Jadwal piket berhasil ditambahkan dan akun guru piket telah dibuat.');
      
    } catch (\Exception $e) {
      // Tangani error dan kirim notifikasi error
      return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
  }
  
  public function update(Request $request, JadwalPiket $jadwalPiket) {
    $request->validate([
      'guru_id' => 'required|exists:guru,id',
      'hari_piket' => 'required',
    ]);
    // Cek jika guru sudah memiliki jadwal piket di hari yang sama dan bukan jadwal yang sedang di-update
    $existingSchedule = JadwalPiket::where('guru_id', $request->guru_id)
    ->where('hari_piket', $request->hari_piket)
    ->where('id', '!=', $jadwalPiket->id)
    ->exists();
    
    if ($existingSchedule) {
      return redirect()->back()->with('error', 'Guru sudah memiliki jadwal piket pada hari ini.');
    }
    $jadwalPiket->update($request->all());
    return redirect()->route('jadwal-piket.index')->with('success', 'Jadwal piket berhasil diupdate.');
  }
  
  public function destroy(JadwalPiket $jadwalPiket) {
    $jadwalPiket->delete();
    return redirect()->route('jadwal-piket.index')->with('success', 'Jadwal piket berhasil dihapus.');
  }
}