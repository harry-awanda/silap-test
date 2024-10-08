<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    DashboardController,
    AuthController,
    JurusanController,
    SiswaController,
    GuruController,
    ClassroomController,
    KelasBinaanController,
    JadwalPiketController,
    AttendanceController,
    UploadController,
    UserController,
    DataPelanggaranController,
    PelanggaranSiswaController,
    AgendaPiketController,
    KeterlambatanController,
    AbsensiKeterlambatanController,
    ProfilSekolahController,
    ProfileController
};
// Public routes
Route::redirect('/', '/auth/login');
Route::controller(AuthController::class)->group(function() {
  Route::get('auth/login', 'showLoginForm')->name('login')->middleware('guest'); // Perbarui URL
  Route::post('auth/login', 'postLogin')->name('postLogin'); // Gunakan route name untuk post login
  Route::post('logout', 'logout')->name('logout');
});

// Route to run storage:link
Route::get('generate-storage-link', function() {
  Artisan::call('storage:link');
  echo 'success';
});

// Routes with common 'auth' middleware
Route::middleware(['auth'])->group(function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')
  ->middleware('checkRole:admin,guru,guru_piket,guru_bk');
  // Route untuk edit profil
  Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  // Route untuk update profil
  Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
  // Route untuk update foto profil
  Route::post('profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
  // Route untuk update password
  Route::put('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
  
    // Admin routes
    Route::middleware('checkRole:admin')->group(function () {
      Route::resources([
        'classrooms' => ClassroomController::class,
        'jurusan' => JurusanController::class,
        'guru' => GuruController::class,
        'siswa' => SiswaController::class,
        'jadwal-piket' => JadwalPiketController::class,
        'uploads' => UploadController::class,
        'users' => UserController::class,
        'data_pelanggaran' => DataPelanggaranController::class,
      ]);
      Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
      Route::post('data_pelanggaran/import', [DataPelanggaranController::class, 'importExcel'])->name('data_pelanggaran.import');
      Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
      Route::controller(ProfilSekolahController::class)->group(function () {
        Route::get('profil', 'edit')->name('profil.edit');
        Route::put('profil', 'update')->name('profil.update');
      });

      Route::get('uploads/download/{upload}', [UploadController::class, 'download'])->name('uploads.download');
    });
    

    // Guru routes
    Route::middleware('checkRole:guru')->group(function () {
      Route::resource('kelas-binaan', KelasBinaanController::class)->parameters(['kelas-binaan' => 'siswa_id']); // Mengubah nama parameter rute default
      Route::post('updateKelas', [KelasBinaanController::class, 'updateKelas'])->name('updateKelas');
      Route::post('massDelete', [KelasBinaanController::class, 'massDelete'])->name('massDelete');
      Route::post('kelas-binaan/import', [KelasBinaanController::class, 'import'])->name('kelas-binaan.import');
      Route::get('rekap-bulanan', [KelasBinaanController::class, 'monthlyRecap'])->name('kelas-binaan.monthlyRecap');
      Route::get('rekap-bulanan/export', [KelasBinaanController::class, 'exportMonthlyRecap'])->name('rekap-bulanan.export');
      Route::get('rekap-absensi', [AbsensiKeterlambatanController::class, 'absensi'])->name('absensi');
      Route::get('rekap-keterlambatan', [AbsensiKeterlambatanController::class, 'keterlambatan'])->name('keterlambatan');
      Route::post('absensi-keterlambatan/filter', [AbsensiKeterlambatanController::class, 'filter'])->name('absensi-keterlambatan.filter');
    });

    // Guru Piket routes
    Route::middleware('checkRole:guru_piket')->group(function () {
      Route::resource('attendance', AttendanceController::class);
      Route::get('attendance/get-students/{classroom_id}', [AttendanceController::class, 'getStudents']);
      Route::resource('agenda_piket', AgendaPiketController::class);
      Route::get('agenda_piket/export/{id}', [AgendaPiketController::class, 'exportPdf'])->name('agenda_piket.export');
    });

    // Shared routes between Guru and Guru BK
    Route::middleware('checkRole:guru,guru_bk')->group(function () {
      Route::resource('pelanggaranSiswa', PelanggaranSiswaController::class);
      Route::get('autocomplete-siswa', [PelanggaranSiswaController::class, 'autocompleteSiswa'])->name('autocomplete.siswa');
    });

    // Shared routes between Guru Piket and Guru BK
    Route::middleware('checkRole:guru_piket,guru_bk')->group(function () {
      Route::resource('keterlambatan', KeterlambatanController::class);
      Route::get('search-siswa', [KeterlambatanController::class, 'searchSiswa'])->name('search.siswa');
    });
});