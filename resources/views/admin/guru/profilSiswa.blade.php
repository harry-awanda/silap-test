@extends('layouts.app')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Rekap Bulanan /</span> 
  </h4>

      <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Home</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Profile</button>
          </li>

        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
              <h5>Data Siswa</h5>
              <div class="row">
                <div class="col-md-6">
                  <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                  <p><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
                  <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
                  <p><strong>Tanggal Lahir:</strong> {{ $siswa->tanggal_lahir }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>Kelas:</strong> {{ optional($siswa->classroom)->nama_kelas ?? 'Tidak ada kelas' }}</p>
                  <p><strong>Jurusan:</strong> {{ optional($siswa->jurusan)->nama_jurusan ?? 'Tidak ada jurusan' }}</p>
                  <p><strong>Alamat:</strong> {{ $siswa->alamat }}</p>
                </div>
              </div>
            <p class="mb-0">
              Tootsie roll fruitcake cookie. Dessert topping pie. Jujubes wafer carrot cake jelly. Bonbon jelly-o
              jelly-o ice
              cream jelly beans candy canes cake bonbon. Cookie jelly beans marshmallow jujubes sweet.
            </p>
          </div>
          <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
            <p>
              Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
              halvah
              tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
            </p>
            <p class="mb-0">
              Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
              liquorice caramels.
            </p>
          </div>

        </div>
      </div>
    </div>
@endsection