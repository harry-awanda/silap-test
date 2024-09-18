<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\User;

class guruController extends Controller {
  public function index() {
    $title = 'Data Guru';
    $guru = Guru::all();
    return view('admin.guru.index', compact('guru','title'));
  }

  public function store(Request $request) {
    // Validasi data input
    $request->validate([
      'nip' => 'required|string',
      'nama_lengkap' => 'required|string|max:255',
      'username' => 'required|string|unique:users,username',
      'tempat_lahir' => 'nullable|string',
      'tanggal_lahir' => 'nullable',
      'jenis_kelamin' => 'nullable|string',
      'alamat' => 'nullable|string',
      'kontak' => 'nullable|string',
      'photo' => 'nullable|image|max:2048',
    ]);
    try {
      // Jika ada file foto, simpan dan masukkan ke dalam array data
      $data = $request->all();
      
      if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('photos', 'public');
      }
      // Buat akun login untuk guru
      $user = User::create([
        'name' => $data['nama_lengkap'],
        'username' => strtolower(str_replace(' ', '', $data['username'])), // Gunakan username dari input
        'role' => 'guru',
        'password' => bcrypt('smkn4321'), // Ganti dengan password yang aman
      ]);
      // Tambahkan user_id ke data yang akan disimpan ke tabel teachers
      $data['user_id'] = $user->id;
      // Buat teacher dengan data yang sudah lengkap
      $guru = Guru::create($data);

      return redirect()->route('guru.index')->with('success', 'Data Guru berhasil ditambahkan.');
    } catch (\Exception $e) {
      // Tangani error dan kirim notifikasi error
      return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
  }

  public function show(Guru $guru) {
    //
  }

  public function update(Request $request, Guru $guru) {
    // Validasi data input
    $request->validate([
      'nip' => 'required|string',
      'nama_lengkap' => 'required|string|max:255',
      'username' => 'required|string|unique:users,username,' . $guru->user_id, // Mengecualikan username saat validasi
      'tempat_lahir' => 'nullable|string',
      'tanggal_lahir' => 'nullable',
      'jenis_kelamin' => 'nullable|string',
      'alamat' => 'nullable|string',
      'kontak' => 'nullable|string',
      'photo' => 'nullable|image|max:2048',
    ]);
    if ($request->hasFile('photo')) {
			// Hapus foto lama jika ada
			if ($guru->photo) {
				Storage::disk('public')->delete($guru->photo);
			}
			// Simpan foto baru
			$data['photo'] = $request->file('photo')->store('photos', 'public');
    }
    $guru->update([
			'nip' => $request->nip,
			'nama_lengkap' => $request->nama_lengkap,
      'username' => strtolower(str_replace(' ', '', $request->username)), // Update username
			'jenis_kelamin' => $request->jenis_kelamin,
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $request->tanggal_lahir,
			'alamat' => $request->alamat,
			'kontak' => $request->kontak,
			'photo' => $data['photo'] ?? $guru->photo, // Tetap gunakan foto lama jika tidak ada yang baru
		]);

    return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diperbarui');
  }

  public function destroy(Guru $guru) {
    $guru->delete();
    return redirect()->route('guru.index')->with('success', 'Data Guru berhasil dihapus');
  }
}