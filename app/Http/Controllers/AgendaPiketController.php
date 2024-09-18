<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AgendaPiket;
use App\Models\JadwalPiket;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Classroom;
use App\Models\Attendance;
use App\Models\Upload;
use App\Models\profilSekolah;


class AgendaPiketController extends Controller {
  public function index() {
    $title = 'Agenda Harian Piket';
    $agendaPikets = AgendaPiket::all();
    return view('agenda_piket.index', compact('agendaPikets','title'));
  }
  
  public function create() {
    $title = 'Agenda Harian Piket';
    // Mendapatkan hari dalam bahasa Inggris
    $hariEn = Carbon::now()->format('l');
    // Mapping dari hari bahasa Inggris ke bahasa Indonesia
    $hariMap = [
      'Monday' => 'Senin',
      'Tuesday' => 'Selasa',
      'Wednesday' => 'Rabu',
      'Thursday' => 'Kamis',
      'Friday' => 'Jumat',
      'Saturday' => 'Sabtu',
      'Sunday' => 'Minggu',
    ];
    // Mengubah hari bahasa Inggris ke bahasa Indonesia
    $hariIni = $hariMap[$hariEn];
    // Mengambil guru piket berdasarkan hari piket
    $guruPiket = JadwalPiket::with('guru')->where('hari_piket', $hariIni)->get();
    // Debugging untuk melihat data yang dikirim
    // dd($guruPiket);
    return view('agenda_piket.create', compact('title','guruPiket'));
  }
  
  public function store(Request $request) {
    // Validasi input
    $request->validate([
      'tanggal' => 'required|date',
      'kejadian_normal' => 'nullable|string',
      'kejadian_masalah' => 'nullable|string',
      'solusi' => 'nullable|string',
      'guru_piket' => 'required|array',
      'guru_piket.*' => 'exists:guru,id', // Validasi setiap ID guru piket
    ]);
    // Membuat agenda piket baru
    $agendaPiket = AgendaPiket::create([
      'tanggal' => $request->tanggal,
      'kejadian_normal' => $request->kejadian_normal,
      'kejadian_masalah' => $request->kejadian_masalah,
      'solusi' => $request->solusi,
      'guru_piket' => json_encode($request->guru_piket), // Simpan guru piket sebagai JSON
    ]);
    // Mengambil semua kelas
    $kelas = Classroom::all();
    // Inisialisasi array absensi per kelas
    $absensiData = [];
    $totalSiswaPerTingkat = ['10' => 0, '11' => 0, '12' => 0];
    $totalAbsensiPerTingkat = ['10' => ['sakit' => 0, 'izin' => 0, 'alpa' => 0],
    '11' => ['sakit' => 0, 'izin' => 0, 'alpa' => 0],
    '12' => ['sakit' => 0, 'izin' => 0, 'alpa' => 0]];
    // Loop untuk setiap kelas
    foreach ($kelas as $kelasItem) {
      $tingkat = $kelasItem->tingkat;
      $absensiData[$kelasItem->id] = [
        'sakit' => Attendance::whereHas('siswa.classroom', function ($query) use ($kelasItem) {
          $query->where('id', $kelasItem->id); // Filter berdasarkan ID kelas
        })->whereDate('date', $request->tanggal)
        ->where('status', 'sakit')->count(),
        
        'izin' => Attendance::whereHas('siswa.classroom', function ($query) use ($kelasItem) {
          $query->where('id', $kelasItem->id); // Filter berdasarkan ID kelas
        })->whereDate('date', $request->tanggal)
        ->where('status', 'izin')->count(),
        'alpa' => Attendance::whereHas('siswa.classroom', function ($query) use ($kelasItem) {
          $query->where('id', $kelasItem->id); // Filter berdasarkan ID kelas
        })->whereDate('date', $request->tanggal)
        ->where('status', 'alpa')->count(),
      ];
      // Update total siswa per tingkat dan absensi per tingkat
      $totalSiswaPerTingkat[$tingkat] += Siswa::where('classroom_id', $kelasItem->id)->count();
      $totalAbsensiPerTingkat[$tingkat]['sakit'] += $absensiData[$kelasItem->id]['sakit'];
      $totalAbsensiPerTingkat[$tingkat]['izin'] += $absensiData[$kelasItem->id]['izin'];
      $totalAbsensiPerTingkat[$tingkat]['alpa'] += $absensiData[$kelasItem->id]['alpa'];
    }
    // Debugging output
    // dd('Absensi Data:', $absensiData, 'Total Absensi Per Tingkat:', $totalAbsensiPerTingkat);
    // Logging output
    // \Log::info('Absensi Data:', ['data' => $absensiData]);
    // \Log::info('Total Absensi Per Tingkat:', ['data' => $totalAbsensiPerTingkat]);
    // Menyimpan data absensi per kelas dan per tingkat ke dalam agenda piket
    $agendaPiket->update([
      'absensi_per_kelas' => json_encode($absensiData),
      'absensi_per_tingkat' => json_encode($totalAbsensiPerTingkat),
    ]);

    return redirect()->route('agenda_piket.index')->with('success', 'Agenda piket berhasil dibuat.');
  }
  
  public function edit($id) {
    $title = 'Edit Agenda Piket';
    $hariEn = Carbon::now()->format('l');
    // Mapping dari hari bahasa Inggris ke bahasa Indonesia
    $hariMap = [
      'Monday' => 'Senin',
      'Tuesday' => 'Selasa',
      'Wednesday' => 'Rabu',
      'Thursday' => 'Kamis',
      'Friday' => 'Jumat',
      'Saturday' => 'Sabtu',
      'Sunday' => 'Minggu',
    ];
    // Mengubah hari bahasa Inggris ke bahasa Indonesia
    $hariIni = $hariMap[$hariEn];
    $agendaPiket = AgendaPiket::findOrFail($id);
    $guruPiket = JadwalPiket::with('guru')->where('hari_piket', $hariIni)->get();
    // $guruPiket = JadwalPiket::with('guru')->get(); // Mengambil semua guru piket untuk dropdown
    return view('agenda_piket.edit', compact('agendaPiket', 'title', 'guruPiket'));
  }
  
  public function update(Request $request, $id) {
    // Validasi input
    $request->validate([
      'tanggal' => 'required|date',
      'kejadian_normal' => 'nullable|string',
      'kejadian_masalah' => 'nullable|string',
      'solusi' => 'nullable|string',
      'guru_piket' => 'required|array',
      'guru_piket.*' => 'exists:guru,id',
    ]);
    // Update agenda piket
    $agendaPiket = AgendaPiket::findOrFail($id);
    $agendaPiket->update([
      'tanggal' => $request->tanggal,
      'kejadian_normal' => $request->kejadian_normal,
      'kejadian_masalah' => $request->kejadian_masalah,
      'solusi' => $request->solusi,
      'guru_piket' => json_encode($request->guru_piket),
    ]);
    return redirect()->route('agenda_piket.index')->with('success', 'Agenda piket berhasil diperbarui.');
  }
  
  public function destroy($id) {
    $agendaPiket = AgendaPiket::findOrFail($id);
    $agendaPiket->delete();
    return redirect()->route('agenda_piket.index')->with('success', 'Agenda piket berhasil dihapus.');
  }

  public function exportPdf($id) {
    $agendaPiket = AgendaPiket::findOrFail($id);
    $guruPiketIds = json_decode($agendaPiket->guru_piket);
    $guruPiket = Guru::whereIn('id', $guruPiketIds)->pluck('nama_lengkap');
    $absensiPerKelas = json_decode($agendaPiket->absensi_per_kelas, true);
    // Retrieve the data from ProfilSekolah
    // Ambil data profil_sekolah dengan relasi
    $profilSekolah = ProfilSekolah::with(['kepalaSekolah', 'kesiswaan'])->first(); // Asumsikan hanya ada satu record
    // Ambil data profil_sekolah dengan relasi
    // Dump data profil_sekolah untuk melihat isinya
    // dd($profilSekolah->kepalaSekolah, $profilSekolah->kesiswaan);
    // Fetch all relevant classrooms and sort by 'nama_kelas'
    $kelas = Classroom::whereIn('id', array_keys($absensiPerKelas))
    ->orderBy('nama_kelas')
    ->get();
    // Initialize arrays for calculating attendance by grade
    $totalSiswaPerTingkat = ['10' => 0, '11' => 0, '12' => 0];
    $totalAbsensiPerTingkat = ['10' => ['sakit' => 0, 'izin' => 0, 'alpa' => 0],
    '11' => ['sakit' => 0, 'izin' => 0, 'alpa' => 0],
    '12' => ['sakit' => 0, 'izin' => 0, 'alpa' => 0]];
    foreach ($kelas as $kelasItem) {
      $kelasId = $kelasItem->id;
      $tingkat = $kelasItem->tingkat;
      // Update total students per grade
      $totalSiswaPerTingkat[$tingkat] += Siswa::where('classroom_id', $kelasId)->count();
      // Update total absences per grade
      if (isset($absensiPerKelas[$kelasId])) {
        $data = $absensiPerKelas[$kelasId];
        $totalAbsensiPerTingkat[$tingkat]['sakit'] += $data['sakit'];
        $totalAbsensiPerTingkat[$tingkat]['izin'] += $data['izin'];
        $totalAbsensiPerTingkat[$tingkat]['alpa'] += $data['alpa'];
      }
    }
    // Calculate absence percentages per grade
    $persentase = [];
    foreach (['10', '11', '12'] as $tingkat) {
      $totalSiswa = $totalSiswaPerTingkat[$tingkat] > 0 ? $totalSiswaPerTingkat[$tingkat] : 1;
      $totalAbsensi = $totalAbsensiPerTingkat[$tingkat]['sakit'] +
      $totalAbsensiPerTingkat[$tingkat]['izin'] +
      $totalAbsensiPerTingkat[$tingkat]['alpa'];
      $persentase[$tingkat] = [
        'sakit' => ($totalAbsensiPerTingkat[$tingkat]['sakit'] / $totalSiswa) * 100,
        'izin' => ($totalAbsensiPerTingkat[$tingkat]['izin'] / $totalSiswa) * 100,
        'alpa' => ($totalAbsensiPerTingkat[$tingkat]['alpa'] / $totalSiswa) * 100,
      ];
    }
    // Calculate total absences and percentages
    $totalSiswa = array_sum($totalSiswaPerTingkat);
    $totalAbsensi = array_sum(array_column($totalAbsensiPerTingkat, 'sakit')) +
    array_sum(array_column($totalAbsensiPerTingkat, 'izin')) +
    array_sum(array_column($totalAbsensiPerTingkat, 'alpa'));
    $persentaseTotalAbsen = $totalSiswa > 0 ? ($totalAbsensi / $totalSiswa) * 100 : 0;
    
    // Ambil kop surat dari tabel uploads
    $kopSurat = Upload::where('description', 'like', '%Kop Surat%')->first();
    $imagePath = $kopSurat ? $kopSurat->file_path : null;
    // Encode image to Base64
    $imageSrc = null;
    if ($imagePath) {
      $path = storage_path('app/public/' . $imagePath);
      if (file_exists($path)) {
        $imageData = base64_encode(file_get_contents($path));
        $imageType = mime_content_type($path);
        $imageSrc = "data:{$imageType};base64,{$imageData}";
      }
    }
    // Generate PDF with image
    $pdf = Pdf::loadView('agenda_piket.pdf', compact(
      'agendaPiket',
      'guruPiket',
      'kelas',
      'absensiPerKelas',
      'totalAbsensiPerTingkat',
      'totalSiswaPerTingkat',
      'persentase',
      'persentaseTotalAbsen', 
      'imageSrc', // Pass Base64 image to view
      'profilSekolah',
    ));
    return $pdf->download('agenda_piket_' . $agendaPiket->tanggal . '.pdf');
  }
}