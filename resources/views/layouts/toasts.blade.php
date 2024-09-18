<!-- Menampilkan toast untuk pesan sukses jika ada sesi 'success' -->
@if(session('success'))
<div id="toastSuccess" class="bs-toast toast fade bg-primary position-absolute m-3 end-0" role="alert" aria-live="assertive" aria-atomic="true">
  <!-- Bagian header dari toast -->
  <div class="toast-header">
    <!-- Ikon notifikasi -->
    <i class="bx bx-bell me-2"></i>
    <!-- Teks judul untuk toast -->
    <div class="me-auto fw-semibold">Berhasil!</div>
    <!-- Tombol tutup untuk menutup toast -->
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <!-- Konten tubuh toast yang menampilkan pesan sukses -->
  <div class="toast-body">{{ session('success') }}</div>
</div>
@endif

<!-- Menampilkan toast untuk pesan kesalahan umum jika ada sesi 'error' -->
@if(session('error'))
<div id="toastError" class="bs-toast toast fade bg-danger position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
  <!-- Bagian header dari toast -->
  <div class="toast-header">
    <!-- Ikon kesalahan -->
    <i class="bx bx-error me-2"></i>
    <!-- Teks judul untuk toast -->
    <div class="me-auto fw-semibold">Error!</div>
    <!-- Tombol tutup untuk menutup toast -->
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <!-- Konten tubuh toast yang menampilkan pesan kesalahan -->
  <div class="toast-body">{{ session('error') }}</div>
</div>
@endif

<!-- Menampilkan toast untuk pesan kesalahan import jika ada sesi 'errorimport' -->
@if(session('errorimport'))
<div id="toastImportError" class="bs-toast toast fade bg-danger position-absolute m-3 end-0" role="alert" aria-live="assertive" aria-atomic="true">
  <!-- Bagian header dari toast -->
  <div class="toast-header">
    <!-- Ikon kesalahan -->
    <i class="bx bx-error me-2"></i>
    <!-- Teks judul untuk toast -->
    <div class="me-auto fw-semibold">Error!</div>
    <!-- Tombol tutup untuk menutup toast -->
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <!-- Konten tubuh toast yang menampilkan pesan kesalahan import -->
  <!-- Menampilkan teks dengan newline yang dikonversi menjadi <br> -->
  <div class="toast-body">{!! nl2br(e(session('errorimport'))) !!}</div>
</div>
@endif

<!-- Menampilkan toast untuk pesan kesalahan umum jika ada sesi 'error' -->
@if(session('loginSuccess'))
<div id="toastLoginSuccess" class="bs-toast toast fade bg-primary position-absolute m-3 end-0" role="alert" aria-live="assertive" aria-atomic="true">
  <!-- Bagian header dari toast -->
  <div class="toast-header">
    <!-- Ikon kesalahan -->
    <i class="bx bx-error me-2"></i>
    <!-- Teks judul untuk toast -->
    <div class="me-auto fw-semibold">Login Berhasil!</div>
    <!-- Tombol tutup untuk menutup toast -->
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <!-- Konten tubuh toast yang menampilkan pesan kesalahan -->
  <div class="toast-body">{{ session('loginSuccess') }}, {{ auth()->user()->name }}!</div>
</div>
@endif

<!-- Menampilkan toast untuk pesan kesalahan umum jika ada sesi 'error' -->
@if(session('loginError'))
<div id="toastLoginError" class="bs-toast toast fade bg-danger position-absolute m-3 end-0" role="alert" aria-live="assertive" aria-atomic="true">
  <!-- Bagian header dari toast -->
  <div class="toast-header">
    <!-- Ikon kesalahan -->
    <!-- <i class="bx bx-x me-2"></i> -->
    <i class="bx bx-error me-2"></i>
    <!-- Teks judul untuk toast -->
    <div class="me-auto fw-semibold">Login Gagal!</div>
    <!-- Tombol tutup untuk menutup toast -->
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <!-- Konten tubuh toast yang menampilkan pesan kesalahan -->
  <div class="toast-body">{{ session('loginError') }}</div>
</div>
@endif

<!-- Menampilkan toast untuk pesan kesalahan umum jika ada sesi 'error' -->
@if(session('logout'))
<div id="toastLogout" class="bs-toast toast fade bg-primary position-absolute m-3 end-0" role="alert" aria-live="assertive" aria-atomic="true">
  <!-- Bagian header dari toast -->
  <div class="toast-header">
    <!-- Ikon kesalahan -->
    <i class="bx bx-bell me-2"></i>
    <!-- Teks judul untuk toast -->
    <div class="me-auto fw-semibold">Berhasil!</div>
    <!-- Tombol tutup untuk menutup toast -->
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <!-- Konten tubuh toast yang menampilkan pesan kesalahan -->
  <div class="toast-body">{{ session('logout') }}</div>
</div>
@endif

<!-- Script untuk menampilkan toast secara otomatis saat halaman dimuat -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Menampilkan toast sukses jika ada
    let successToast = document.getElementById('toastSuccess');
    if (successToast) {
      new bootstrap.Toast(successToast).show();
    }
    // Menampilkan toast kesalahan umum jika ada
    let errorToast = document.getElementById('toastError');
    if (errorToast) {
      new bootstrap.Toast(errorToast).show();
    }
    // Menampilkan toast kesalahan import jika ada
    let errorImportToast = document.getElementById('toastImportError');
    if (errorImportToast) {
      new bootstrap.Toast(errorImportToast).show();
    }
    let successLoginToast = document.getElementById('toastLoginSuccess');
    if (successLoginToast) {
      new bootstrap.Toast(successLoginToast).show();
    }
    let errorLoginToast = document.getElementById('toastLoginError');
    if (errorLoginToast) {
      new bootstrap.Toast(errorLoginToast).show();
    }
    let LogoutToast = document.getElementById('toastLogout');
    if (LogoutToast) {
      new bootstrap.Toast(LogoutToast).show();
    }
  });
</script>
