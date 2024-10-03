@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Siswa Binaan / {{ $siswa->nama_lengkap }}</span> / Detail
  </h4>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <!-- 1. Data Siswa -->
              <h5 class="mb-4">1. Data Siswa</h5>
              <div class="row g-3">
                <!-- a. NIS -->
                <div class="col-md-6">
                  <label class="form-label" for="nis">NIS</label>
                  <p>{{ $siswa->nis }}</p>
                </div>
                <!-- b. Nama Lengkap -->
                <div class="col-md-6">
                  <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                  <p>{{ $siswa->nama_lengkap }}</p>
                </div>
                <!-- c. Tempat Lahir -->
                <div class="col-md-6">
                  <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                  <p>{{ $siswa->tempat_lahir }}</p>
                </div>
                <!-- d. Tanggal Lahir -->
                <div class="col-md-6">
                  <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                  <p>{{ $siswa->tanggal_lahir }}</p>
                </div>
                <!-- e. Jenis Kelamin -->
                <div class="col-md-6">
                  <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                  <p>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <!-- f. Agama -->
                <div class="col-md-6">
                  <label class="form-label" for="agama">Agama</label>
                  <p>{{ $siswa->agama }}</p>
                </div>
                <!-- g. Nomor Telepon -->
                <div class="col-md-6">
                  <label class="form-label" for="kontak">Nomor Telepon / Whatsapp</label>
                  <p>+62 {{ $siswa->kontak }}</p>
                </div>
                <!-- h. Foto -->
                <div class="col-md-6">
                  <label class="form-label" for="photo">Foto</label>
                  @if($siswa->photo)
                    <img src="{{ asset('storage/' . $siswa->photo) }}" alt="Foto Siswa" class="img-thumbnail" width="150px">
                  @else
                    <p>Foto tidak tersedia</p>
                  @endif
                </div>
                <!-- i. Jurusan -->
                <div class="col-md-6">
                  <label class="form-label" for="jurusan">Jurusan</label>
                  <p>{{ $siswa->jurusan ? $siswa->jurusan->nama_jurusan : '-' }}</p>
                </div>
                <!-- j. Kelas -->
                <div class="col-md-6">
                  <label class="form-label" for="classroom">Kelas</label>
                  <p>{{ $siswa->classroom ? $siswa->classroom->nama_kelas : '-' }}</p>
                </div>
                <!-- k. Alamat -->
                <div class="col-12">
                  <label class="form-label" for="alamat">Alamat</label>
                  <p>{{ $siswa->alamat }}</p>
                </div>
              </div>
              <hr>
              <!-- 2. Data Orang Tua -->
              <h5 class="mb-4">2. Data Orang Tua</h5>
              <div class="row g-3">
                <!-- a. Nama Ayah -->
                <div class="col-md-6">
                  <label class="form-label" for="nama_ayah">Nama Ayah</label>
                  <p>{{ $siswa->orang_tua ? $siswa->orang_tua->nama_ayah : '-' }}</p>
                </div>
                <!-- b. Nama Ibu -->
                <div class="col-md-6">
                  <label class="form-label" for="nama_ibu">Nama Ibu</label>
                  <p>{{ $siswa->orang_tua ? $siswa->orang_tua->nama_ibu : '-' }}</p>
                </div>
                <!-- c. Kontak Ayah -->
                <div class="col-md-6">
                  <label class="form-label" for="kontak_ayah">Nomor Telepon / Whatsapp Ayah</label>
                  <p>+62 {{ $siswa->orang_tua ? $siswa->orang_tua->kontak_ayah : '-' }}</p>
                </div>
                <!-- d. Kontak Ibu -->
                <div class="col-md-6">
                  <label class="form-label" for="kontak_ibu">Nomor Telepon / Whatsapp Ibu</label>
                  <p>+62 {{ $siswa->orang_tua ? $siswa->orang_tua->kontak_ibu : '-' }}</p>
                </div>
                <!-- e. Alamat Orang Tua -->
                <div class="col-12">
                  <label class="form-label" for="alamat_orangtua">Alamat Orang Tua</label>
                  <p>{{ $siswa->orang_tua ? $siswa->orang_tua->alamat_orangtua : '-' }}</p>
                </div>
                <!-- f. Nama Wali -->
                <div class="col-md-6">
                  <label class="form-label" for="nama_wali_murid">Nama Wali Murid</label>
                  <p>{{ $siswa->orang_tua ? $siswa->orang_tua->nama_wali_murid : '-' }}</p>
                </div>
                <!-- g. Kontak Wali -->
                <div class="col-md-6">
                  <label class="form-label" for="kontak_wali">Nomor Telepon / Whatsapp Wali</label>
                  <p>+62 {{ $siswa->orang_tua ? $siswa->orang_tua->kontak_wali : '-' }}</p>
                </div>
                <!-- h. Alamat Wali -->
                <div class="col-12">
                  <label class="form-label" for="alamat_wali">Alamat Wali Murid</label>
                  <p>{{ $siswa->orang_tua ? $siswa->orang_tua->alamat_wali : '-' }}</p>
                </div>
              </div>
              <a href="{{ route('kelas-binaan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
