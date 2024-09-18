@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <form method="POST" action="{{ route('profil.update') }}">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-header">
        <!--  -->
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="row g-3">
            <!-- Input untuk memilih kelas -->
              <div class="col-md-6">
                <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                <input type="text" class="form-control" name="nama_sekolah" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" required>
              </div>
              <div class="col-md-6">
                <label for="npsn" class="form-label">NPSN</label>
                <input type="text" class="form-control" name="npsn" value="{{ old('npsn', $profil->npsn) }}" required>
              </div>
              <div class="col-md-6">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" name="nomor_telepon" value="{{ old('nomor_telepon', $profil->nomor_telepon) }}" >
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $profil->email) }}" >
              </div>
              <div class="col-md-12">
                <label class="form-label" for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" >{{ old('alamat', $profil->alamat) }}</textarea>
              </div>
              <div class="col-md-6">
                <label for="kepala_sekolah" class="form-label">Kepala Sekolah</label>
                <select id="kepala_sekolah_id" name="kepala_sekolah_id" class="form-control">
                  <option value="">Pilih Kepala Sekolah</option>
                  @foreach($kepalaSekolahOptions as $id => $nama_lengkap)
                  <option value="{{ $id }}" {{ $profil->kepala_sekolah_id == $id ? 'selected' : '' }}>{{ $nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="kesiswaan" class="form-label">Kesiswaan</label>
                <select id="kesiswaan_id" name="kesiswaan_id" class="form-control">
                  <option value="">Pilih Kesiswaan</option>
                  @foreach($kesiswaanOptions as $id => $nama_lengkap)
                  <option value="{{ $id }}" {{ $profil->kesiswaan_id == $id ? 'selected' : '' }}>{{ $nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </form>
</div>

@endsection