<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class uploadController extends Controller {
  public function index() {
    $title = 'Upload Berkas';
    $uploads = Upload::all();
    return view('admin.uploads.index', compact('title','uploads'));
  }

  public function store(Request $request) {
    $request->validate([
      'file' => 'required|mimes:xlsx,jpg,jpeg,png,pdf|max:2048',
      'description' => 'nullable|string|max:255',
    ]);

    $file = $request->file('file');
    $originalName = $file->getClientOriginalName();
    $filePath = $file->storeAs('uploads', $originalName, 'public');
    $fileType = $file->getClientOriginalExtension();

    Upload::create([
      'file_name' => $originalName,
      'file_path' => $filePath,
      'description' => $request->input('description'),
      'file_type' => $fileType,
    ]);

    return redirect()->route('uploads.index')->with('success', 'File uploaded successfully.');
    
  }

  public function download(Upload $upload) {
    return Storage::download('public/' . $upload->file_path);
  }

  public function destroy(Upload $upload) {
    // Hapus file dari storage
    Storage::delete('public/' . $upload->file_path);
    // Hapus record dari database
    $upload->delete();
    return redirect()->route('uploads.index')->with('success', 'File deleted successfully.');
  }
}