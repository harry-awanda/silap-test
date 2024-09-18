<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Models\Classroom;
use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\OrangTua;
use DataTables;

class siswaController extends Controller { 
	public function index(Request $request) {
		$title = 'Siswa';
    if ($request->ajax()) {
			$data = Siswa::with(['jurusan', 'classroom'])->get();
			return DataTables::of($data)
			->addIndexColumn()
			->addColumn('jurusan', function($row) {
				return $row->jurusan ? $row->jurusan->nama_jurusan : '';
			})
			->addColumn('classroom', function($row) {
				return $row->classroom ? $row->classroom->nama_kelas : '';
			})
			->addColumn('jenis_kelamin', function($row) {
				return $row->jenis_kelamin ? ucfirst($row->jenis_kelamin) : '';
			})
			->addColumn('pilihan', function($row) {
				$editUrl = route('siswa.edit', $row->id);
				$deleteUrl = route('siswa.destroy', $row->id);
				$btn = '<div class="dropdown">';
				$btn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">';
				$btn .= '<i class="bx bx-dots-vertical-rounded"></i>';
				$btn .= '</button>';
				$btn .= '<div class="dropdown-menu">';
				$btn .= '<a class="dropdown-item" href="' . $editUrl . '">';
				$btn .= '<i class="bx bx-edit-alt me-1"></i> Edit';
				$btn .= '</a>';
				$btn .= '<form action="' . $deleteUrl . '" method="POST" class="d-inline">';
				$btn .= csrf_field();
				$btn .= method_field('DELETE');
				$btn .= '<button type="submit" class="dropdown-item" onclick="return confirm(\'Apakah Anda yakin ingin menghapus siswa ini?\')">';
				$btn .= '<i class="bx bx-trash me-1"></i> Delete';
				$btn .= '</button>';
				$btn .= '</form>';
				$btn .= '</div>';
				$btn .= '</div>';
				
				return $btn;
			})
			->rawColumns(['pilihan'])
			->make(true);
    }
    return view('admin.siswa.index', compact('title'));
	}

  public function create() {
    $title = 'Tambah Data Siswa';
    $orangtua = OrangTua::all();
		$jurusan = Jurusan::all();
		$classroom = Classroom::all();
		return view('admin.siswa.create', compact('orangtua', 'jurusan', 'classroom','title'));
  }
  
  public function store(Request $request) {
    $data = $request->validate([
			'nis' => 'required|string',
			'nama_lengkap' => 'required|string',
			'jurusan_id' => 'required|exists:jurusan,id',
			'classroom_id' => 'required|exists:classrooms,id',
			'jenis_kelamin' => 'nullable|string',
			'tempat_lahir' => 'nullable|string',
			'tanggal_lahir' => 'nullable',
			'agama' => 'nullable|string',
			'alamat' => 'nullable|string',
			'kontak' => 'nullable|string',
			'photo' => 'nullable|image',
			// Validasi data orang tua hanya jika disertakan
        'nama_ayah' => 'nullable|string',
        'nama_ibu' => 'nullable|string',
        'kontak_ayah' => 'nullable|string',
        'kontak_ibu' => 'nullable|string',
        'alamat_orangtua' => 'nullable|string',
        'nama_wali_murid' => 'nullable|string',
        'alamat_wali' => 'nullable|string',
        'kontak_wali' => 'nullable|string',
		]);

		if ($request->hasFile('photo')) {
			$data['photo'] = $request->file('photo')->store('photos', 'public');
		}
		
		// Buat data orang tua hanya jika ada input untuk data orang tua
    if ($request->filled('nama_ayah') || $request->filled('nama_ibu')) {
			$orang_tua = OrangTua::create([
				'nama_ayah' => $data['nama_ayah'],
				'nama_ibu' => $data['nama_ibu'],
				'alamat_orangtua' => $data['alamat_orangtua'],
				'kontak_ayah' => $data['kontak_ayah'],
				'kontak_ibu' => $data['kontak_ibu'],
				'nama_wali_murid' => $data['nama_wali_murid'],
				'kontak_wali' => $data['kontak_wali'],
				'alamat_wali' => $data['alamat_wali'],
			]);
			$data['orang_tua_id'] = $orang_tua->id;
    }
			unset( $data['nama_ayah'], $data['nama_ibu'], $data['alamat_orangtua'],
			$data['kontak_ayah'], $data['kontak_ibu'], $data['nama_wali_murid'],
			$data['kontak_wali'], $data['alamat_wali'],
		);

		Siswa::create($data);

		return redirect()->route('siswa.index')->with('success', 'Berhasil menyimpan data.');
  }

  public function show(string $id) {
    //
  }

  public function edit(Siswa $siswa) {
		$title = 'Edit Data Siswa';
		// Load relationships without using find() because $siswa is already an instance
    $siswa->load('orang_tua', 'jurusan', 'classroom');
    $jurusan = Jurusan::all();
    $classroom = Classroom::all();

    return view('admin.siswa.edit', compact('siswa', 'jurusan', 'classroom', 'title'));
  }
	
	public function update(Request $request, Siswa $siswa) {
		// dd($request->all()); // Menampilkan semua input yang diterima
		$data = $request->validate([
			'nis' => 'required|string',
			'nama_lengkap' => 'required|string',
			'jurusan_id' => 'required|exists:jurusan,id',
			'classroom_id' => 'required|exists:classrooms,id',
			'jenis_kelamin' => 'nullable|string',
			'tempat_lahir' => 'nullable|string',
			'tanggal_lahir' => 'nullable',
			'agama' => 'nullable|string',
			'alamat' => 'nullable|string',
			'kontak' => 'nullable|string',
			'photo' => 'nullable|image',
			// Validasi data orang tua hanya jika disertakan
			'nama_ayah' => 'nullable|string',
			'nama_ibu' => 'nullable|string',
			'kontak_ayah' => 'nullable|string',
			'kontak_ibu' => 'nullable|string',
			'alamat_orangtua' => 'nullable|string',
			'nama_wali_murid' => 'nullable|string',
			'alamat_wali' => 'nullable|string',
			'kontak_wali' => 'nullable|string',
    ]);
		
    if ($request->hasFile('photo')) {
			// Hapus foto lama jika ada
			if ($siswa->photo) {
				Storage::disk('public')->delete($siswa->photo);
			}
			// Simpan foto baru
			$data['photo'] = $request->file('photo')->store('photos', 'public');
    }
		// Perbarui data siswa
    $siswa->update($data);
		
    // Update or create data orang tua hanya jika ada input data orang tua
    if ($request->filled('nama_ayah') || $request->filled('nama_ibu')) {
			$orangTua = $siswa->orang_tua()->updateOrCreate(
				['id' => $siswa->orang_tua_id],
				[
					'nama_ayah' => $data['nama_ayah'],
					'nama_ibu' => $data['nama_ibu'],
					'alamat_orangtua' => $data['alamat_orangtua'],
					'kontak_ayah' => $data['kontak_ayah'],
					'kontak_ibu' => $data['kontak_ibu'],
					'nama_wali_murid' => $data['nama_wali_murid'],
					'alamat_wali' => $data['alamat_wali'],
					'kontak_wali' => $data['kontak_wali'],
				]
			);
			// Assign orang_tua_id to siswa
        $siswa->update(['orang_tua_id' => $orangTua->id]);
		}
    return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diperbarui');
	}

  public function destroy(Siswa $siswa) {
    if ( $siswa->delete()) {
      return redirect()->route('siswa.index')->with('success', 'Berhasil menghapus data!');
    } else {
      return redirect()->route('siswa.index')->with('error', 'Gagal menghapus data.');
    }
  }
	
	public function import(Request $request) {
    // Validasi permintaan
    $request->validate([
      'file' => 'required|mimes:xls,xlsx|max:2048' // Opsional: batasi ukuran file
    ]);
		
		try {
      // Coba impor file menggunakan kelas SiswaImport
			Excel::import(new SiswaImport, $request->file('file'));
      // Redirect dengan pesan sukses
			return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil di import.');
			
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      // Tangani pengecualian validasi dari impor Excel
			$failures = $e->failures();
			$messages = [];
			foreach ($failures as $failure) {
				$messages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
			}
      // Catat kesalahan validasi untuk debugging
      \Log::error('Gagal Validasi Impor: ', ['errors' => $messages]);
			// Ganti <br> dengan \n
			$importError = implode("\n", $messages);
      // Redirect kembali dengan pesan kesalahan
			return redirect()->back()->with('errorimport', $importError);
		}
    catch (\Exception $e) {
      // Tangani pengecualian umum (seperti kesalahan membaca atau parsing file)
      \Log::error('Kesalahan Impor: ' . $e->getMessage());
      
      return redirect()->back()->with('errorimport', 'Terjadi kesalahan saat mengimpor file. Pastikan file sesuai dengan format yang benar.');
    }
	}
}