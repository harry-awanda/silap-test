<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class userController extends Controller {
  
  public function index() {
    $title = 'User Management';
    $users = User::orderBy('role', 'asc')->get();
    return view('admin.users.index', compact('title','users'));
  }

  public function store(Request $request) {
    $request->validate([
      'name' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'role' => 'required|string',
    ]);

    User::create([
      'name' => $request->name,
      'username' => $request->username,
      'password' => bcrypt($request->password),  // Enkripsi dengan bcrypt
      'role' => $request->role,
    ]);
    return redirect()->route('users.index')->with('success', 'User created successfully.');
  }

  public function update(Request $request, User $user) {
    $request->validate([
      'name' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:users,username,' . $user->id,
      'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
      'role' => 'required|string',
    ]);
    $user->update([
      'name' => $request->name,
      'username' => $request->username,
      'email' => $request->email,
      'role' => $request->role,
    ]);
    
    return redirect()->route('users.index')->with('success', 'User updated successfully.');
  }
  
  public function resetPassword(Request $request, User $user) {
    $request->validate([
      'password' => 'required|string|min:8|confirmed',
    ]);
    $user->update([
      'password' => bcrypt($request->password),  // Enkripsi dengan bcrypt
    ]);
    
    return redirect()->route('users.index')->with('success', 'Password reset successfully.');
  }

  public function destroy(User $user) {
    try {
      // Hapus user dari database
      $user->delete();
      
      return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    } catch (\Exception $e) {
      // Tangani error dan kirim notifikasi error
      return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    }
  }
}