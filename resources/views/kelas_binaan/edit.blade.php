@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Siswa Binaan / {{ $siswa->nama_lengkap }}</span> / Edit
  </h4>
  
  <form action="{{ route('kelas-binaan.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8 mx-auto">
                @csrf
                @method('PUT')
                <!-- 1. Data Siswa -->
                <h5 class="mb-4">1. Data Siswa</h5>
                <div class="row g-3">
                  <!-- a. kolom input NIS -->
                  <div class="col-md-6">
                    <label class="form-label" for="nis">NIS</label>
                    <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required />
                  </div>
                  <!-- b. kolom input Nama Siswa -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required />
                  </div>
                  <!-- c. kolom input Tempat Lahir -->
                  <div class="col-md-6">
                    <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"/>
                  </div>
                  <!-- d. kolom input Tanggal Lahir Lahir -->
                  <div class="col-md-6">
                    <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"/>
                  </div>
                  <!-- e. kolom input Tanggal Jenis Kelamin -->
                  <div class="col-md-6">
                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" data-allow-clear="true">
                      <option value="" disabled>Select</option>
                      <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                  </div>
                  <!-- f. kolom input Agama -->
                  <div class="col-md-6">
                    <label class="form-label" for="jenis_kelamin">Agama</label>
                    <select name="agama" class="form-select" data-allow-clear="true">
                      <option value="" disabled>Select</option>
                      <option value="Islam" {{ old('agama', $siswa->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                      <option value="Buddha" {{ old('agama', $siswa->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                      <option value="Hindu" {{ old('agama', $siswa->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                      <option value="Kristen Katolik" {{ old('agama', $siswa->agama) == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                      <option value="Kristen Protestan" {{ old('agama', $siswa->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                    </select>
                  </div>
                  <!-- g. kolom input Kontak -->
                  <div class="col-md-6">
                    <label class="form-label" for="alt-num">Nomor Telepon / Whatsapp</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $siswa->kontak) }}" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- h. kolom input foto -->
                  <div class="col-md-6">
                    <label class="form-label" for="photo">Photo</label>
                    <input type="file" name="photo" class="form-control">
                    @if($siswa->photo)
                      <small class="text-muted">Current Photo: {{ old('photo', $siswa->photo) }}</small>
                    @endif
                  </div>
                  <!-- i. kolom input jurusan -->
                  <div class="col-md-6">
                    <label class="form-label" for="jurusan_id">Jurusan</label>
                    <select name="jurusan_id" class="form-select" data-allow-clear="true" required >
                      <option value="" disabled>Select</option>
                      @foreach($jurusan as $data)
                        <option value="{{ $data->id }}" {{ old('jurusan_id', $siswa->jurusan_id) == $data->id ? 'selected' : '' }}>{{ $data->nama_jurusan }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!-- j. kolom input kelas -->
                  <div class="col-md-6">
                    <label class="form-label" for="classroom_id">Kelas</label>
                    <select name="classroom_id" class="form-select" data-allow-clear="true">
                      <option value="" disabled>Select</option>
                      @foreach($classrooms as $data)
                        <option value="{{ $data->id }}" {{ old('classroom_id', $siswa->classroom_id) == $data->id ? 'selected' : '' }}>{{ $data->nama_kelas }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!-- k. kolom input alamat -->
                  <div class="col-12">
                    <label class="form-label" for="address">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $siswa->alamat) }}</textarea>
                  </div>
                </div>
                <hr> 
                <!-- 2. Data Orang Tua -->
                <h5 class="mb-4">2. Data Orang Tua</h5>
                <div class="row g-3">
                  <!-- 2.a. kolom input nama ayah -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_ayah">Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control" value="{{ $siswa->orang_tua ? $siswa->orang_tua->nama_ayah : '' }}" />
                  </div>
                  <!-- 2.b. kolom input nama ibu -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_ibu">Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control" value="{{ $siswa->orang_tua ? $siswa->orang_tua->nama_ibu : '' }}" />
                  </div>
                  <!-- 2.c. kolom input kontak ayah -->
                  <div class="col-md-6">
                    <label class="form-label" for="kontak_ayah">Nomor Telepon / Whatsapp Ayah</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak_ayah" class="form-control" value="{{ $siswa->orang_tua ? $siswa->orang_tua->kontak_ayah : '' }}" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- 2.d. kolom input kontak ibu -->
                  <div class="col-md-6">
                    <label class="form-label" for="kontak_ibu">Nomor Telepon / Whatsapp Ibu</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak_ibu" class="form-control" value="{{ $siswa->orang_tua ? $siswa->orang_tua->kontak_ibu : '' }}" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- 2.e. kolom input alamat orang tua -->
                  <div class="col-12">
                    <label class="form-label" for="alamat_orangtua">Alamat Orang Tua</label>
                    <textarea name="alamat_orangtua" class="form-control" rows="2">{{ $siswa->orang_tua ? $siswa->orang_tua->alamat_orangtua : '' }}</textarea>
                  </div>
                  <!-- 2.f. kolom input nama wali -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_wali_murid">Nama Wali Murid</label>
                    <input type="text" name="nama_wali_murid" class="form-control" value="{{ $siswa->orang_tua ? $siswa->orang_tua->nama_wali_murid : '' }}"/>
                  </div>
                  <!-- 2.g. kolom input kontak wali -->
                  <div class="col-md-6">
                    <label class="form-label" for="kontak_wali">Nomor Telepon / Whatsapp Wali</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak_wali" class="form-control" value="{{ $siswa->orang_tua ? $siswa->orang_tua->kontak_wali : '' }}" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- 2.h. kolom input alamat wali -->
                  <div class="col-12">
                    <label class="form-label" for="alamat_wali">Alamat Wali Murid</label>
                    <textarea name="alamat_wali" class="form-control" rows="2">{{ $siswa->orang_tua ? $siswa->orang_tua->alamat_wali : '' }}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection