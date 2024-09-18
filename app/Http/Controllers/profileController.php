<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;

class ProfileController extends Controller {
  // Menampilkan form edit profil
  public function edit() {
    $title = 'Informasi Akun';
    $user = Auth::user();
    $guru = $user->guru; // Mengambil data Guru yang berelasi dengan user
    // Cek apakah user memiliki relasi guru (untuk role guru atau guru_bk)
    if ($user->role === 'guru' || $user->role === 'guru_bk') {
      if (!$guru) {
        return redirect()->back()->withErrors('Data guru tidak ditemukan.');
      }
      // Tampilkan halaman profil dengan data guru
      return view('profile.edit', compact('user', 'guru', 'title'));
    }
    // Untuk role admin dan guru_piket, tidak ada data guru
    return view('profile.edit', compact('user', 'title'));
  }
  
  // Update profil (selain photo dan password)
  public function update(Request $request) {
    $user = Auth::user();
    $guru = $user->guru;
    // Validasi data untuk profil
    $request->validate([
      'username' => 'required|string|max:255|unique:users,username,' . $user->id,
      'nama_lengkap' => 'required|string|max:255',
      'nip' => 'nullable|string',
      'tempat_lahir' => 'nullable|string',
      'tanggal_lahir' => 'nullable|date',
      'kontak' => 'nullable|string',
      'alamat' => 'nullable|string',
    ]);
    // Update data User
    $user->update([
      'username' => strtolower(str_replace(' ', '', $request->username)),
    ]);
    // Update data Guru jika ada
    if ($guru) {
      $guru->update([
        'nip' => $request->nip,
        'nama_lengkap' => $request->nama_lengkap,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'kontak' => $request->kontak,
        'alamat' => $request->alamat,
      ]);
    }
    return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
  }

  // Update photo profil
  public function updatePhoto(Request $request) {
    $request->validate([
      'photo' => 'nullable|image|max:2048',
    ]);
    $user = Auth::user();
    $guru = $user->guru;
    if ($request->hasFile('photo')) {
      $photoPath = $request->file('photo')->store('photos', 'public');
      if ($guru) {
        // Update photo di model Guru
        $guru->update(['photo' => $photoPath]);
      }
    }
    return redirect()->route('profile.edit')->with('success', 'Foto profil berhasil diperbarui.');
  }
  // Update password
  public function updatePassword(Request $request) {
    $user = Auth::user();
    $request->validate([
      'current_password' => 'required|string',
      'new_password' => 'required|string|min:8|confirmed',
    ]);
    // Cek kecocokan password saat ini
    if (Hash::check($request->current_password, $user->password)) {
      // Update password baru
      $user->update(['password' => bcrypt($request->new_password)]);
      return redirect()->route('profile.edit')->with('success', 'Password berhasil diperbarui.');
    } else {
      return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
    }
  }
}