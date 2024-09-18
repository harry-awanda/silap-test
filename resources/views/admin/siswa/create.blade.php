@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Silap / Data Siswa / </span> Tambah Data
  </h4>

  <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8 mx-auto">
                @csrf
                <!-- 1. Data Siswa -->
                <h5 class="mb-4">1. Data Siswa</h5>
                <div class="row g-3">
                  <!-- a. kolom input NIS -->
                  <div class="col-md-6">
                    <label class="form-label" for="nis">NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="8867" required />
                  </div>
                  <!-- b. kolom input Nama Siswa -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required />
                  </div>
                  <!-- c. kolom input Tempat Lahir -->
                  <div class="col-md-6">
                    <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control"/>
                  </div>
                  <!-- d. kolom input Tanggal Lahir Lahir -->
                  <div class="col-md-6">
                    <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control"/>
                  </div>
                  <!-- e. kolom input Tanggal Jenis Kelamin -->
                  <div class="col-md-6">
                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" data-allow-clear="true">
                      <option value="" selected disabled>Select</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                  <!-- f. kolom input Agama -->
                  <div class="col-md-6">
                    <label class="form-label" for="jenis_kelamin">Agama</label>
                    <select name="agama" class="form-select" data-allow-clear="true">
                      <option value="" disabled>Select</option>
                      <option value="Islam">Islam</option>
                      <option value="Buddha">Buddha</option>
                      <option value="Hindu">Hindu</option>
                      <option value="Kristen Katolik">Kristen Katolik</option>
                      <option value="Kristen Protestan">Kristen Protestan</option>
                    </select>
                  </div>
                  <!-- g. kolom input Kontak -->
                  <div class="col-md-6">
                    <label class="form-label" for="alt-num">Nomor Telepon / Whatsapp</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak" class="form-control" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- h. kolom input foto -->
                  <div class="col-md-6">
                    <label class="form-label" for="photo">Photo</label>
                    <input type="file" name="photo" class="form-control">
                  </div>
                  <!-- i. kolom input jurusan -->
                  <div class="col-md-6">
                    <label class="form-label" for="jurusan_id">Jurusan</label>
                    <select name="jurusan_id" class="form-select" data-allow-clear="true" required >
                      <option value="" disabled>Select</option>
                      @foreach($jurusan as $data)
                      <option value="{{ $data->id }}">{{ $data->nama_jurusan }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!-- j. kolom input kelas -->
                  <div class="col-md-6">
                    <label class="form-label" for="classroom_id">Kelas</label>
                    <select name="classroom_id" class="form-select" data-allow-clear="true">
                      <option value="" disabled>Select</option>
                      @foreach($classroom as $data)
                      <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                      @endforeach
                    </select>
                  </div>                                
                  <!-- k. kolom input alamat -->
                  <div class="col-12">
                    <label class="form-label" for="address">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" ></textarea>
                  </div>
                </div>
                <hr> 
                <!-- 2. Data Orang Tua -->
                <h5 class="mb-4">2. Data Orang Tua</h5>
                <div class="row g-3">
                  <!-- 2.a. kolom input nama ayah -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_ayah">Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control" />
                  </div>
                  <!-- 2.b. kolom input nama ibu -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_ayah">Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control" />
                  </div>
                  <!-- 2.c. kolom input kontak ayah -->
                  <div class="col-md-6">
                    <label class="form-label" for="kontak_ayah">Nomor Telepon / Whatsapp Ayah</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak_ayah" class="form-control" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- 2.d. kolom input kontak ibu -->
                  <div class="col-md-6">
                    <label class="form-label" for="kontak_ibu">Nomor Telepon / Whatsapp Ibu</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak_ibu" class="form-control" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- 2.e. kolom input alamat orang tua -->
                  <div class="col-12">
                    <label class="form-label" for="alamat_orangtua">Alamat Orang Tua</label>
                    <textarea name="alamat_orangtua" class="form-control" rows="2" ></textarea>
                  </div>
                  <!-- 2.f. kolom input nama wali -->
                  <div class="col-md-6">
                    <label class="form-label" for="nama_wali_murid">Nama Wali Murid</label>
                    <input type="text" name="nama_wali_murid" class="form-control"/>
                  </div>
                  <!-- 2.g. kolom input kontak wali -->
                  <div class="col-md-6">
                    <label class="form-label" for="kontak_wali">Nomor Telepon / Whatsapp Wali</label>
                    <div class="input-group">
                      <span class="input-group-text">+62</span>
                      <input type="text" name="kontak_wali" class="form-control" placeholder="812 3456 7890" />
                    </div>
                  </div>
                  <!-- 2.h. kolom input alamat wali -->
                  <div class="col-12">
                    <label class="form-label" for="alamat_wali">Alamat Wali Murid</label>
                    <textarea name="alamat_wali" class="form-control" rows="2" ></textarea>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>
@endsection