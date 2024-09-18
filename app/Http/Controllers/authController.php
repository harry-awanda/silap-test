<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
  // Method untuk menampilkan form login
  public function showLoginForm() {
    return view('auth.login');
  }

  // Method untuk menangani proses login
  public function postLogin(Request $request) {
    // Validasi input
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    // Ambil data input
    $credentials = [
      'username' => $request->username,
      'password' => $request->password,
    ];

    // Cek kredensial
    if (Auth::attempt($credentials)) {
      // Jika berhasil login, redirect ke dashboard atau halaman yang sesuai
      return redirect()->intended('dashboard')->with('loginSuccess', 'Selamat datang kembali');
    } else {
      // Jika gagal login, redirect kembali ke halaman login dengan pesan error
      return redirect()->back()->with('loginError', 'Username atau password salah.')->withInput();
    }
  }

  // Method untuk logout
  public function logout() {
    Auth::logout();
    return redirect()->route('login')->with('logout', 'Anda telah logout.');
  }
}
