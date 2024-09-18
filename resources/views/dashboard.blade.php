@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> Dashboard
  </h4>
  <!-- Card Border Shadow -->
  <div class="row">
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-primary h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-git-repo-forked"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $jumlahJurusan }}</h4>
          </div>
          <p class="mb-1">Jumlah Kompetensi Keahlian</p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-warning h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-home-alt"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $jumlahKelas }}</h4>
          </div>
          <p class="mb-1">Jumlah Kelas</p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-success h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-success"><i
                  class="bx bx-group bx-sm"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $jumlahSiswa }}</h4>
          </div>
          <p class="mb-1">Jumlah Siswa</p>

        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-info h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user-voice bx-sm"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ $jumlahGuru }}</h4>
          </div>
          <p class="mb-1">Jumlah Guru</p>
        </div>
      </div>
    </div>

<!-- Persentase Absensi -->
  <!-- single card  -->
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Absensi siswa pada <span class="text-primary">{{ $formattedDate }}</span></h5>
      </div>
      <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
          <div class="row gy-4 gy-sm-1">
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                <div>
                  <h3 class="mb-1">{{ number_format($persentaseAbsenKelasX, 2) }}%</h3>
                  <p class="mb-0">Kelas X</p>
                </div>
                <span class="badge bg-label-danger rounded p-2 me-sm-4">
                  <i class="bx bx-group bx-sm"></i>
                </span>
              </div>
              <hr class="d-none d-sm-block d-lg-none me-4">
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                <div>
                  <h3 class="mb-1">{{ number_format($persentaseAbsenKelasXI, 2) }}%</h3>
                  <p class="mb-0">Kelas XI</p>
                </div>
                <span class="badge bg-label-danger rounded p-2 me-lg-4">
                  <i class="bx bx-group bx-sm"></i>
                </span>
              </div>
              <hr class="d-none d-sm-block d-lg-none">
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                <div>
                  <h3 class="mb-1">{{ number_format($persentaseAbsenKelasXII, 2) }}%</h3>
                  <p class="mb-0">Kelas XII</p>
                </div>
                <span class="badge bg-label-danger rounded p-2 me-sm-4">
                  <i class="bx bx-group bx-sm"></i>
                </span>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <h3 class="mb-1">{{ number_format($persentaseTotalAbsen, 2) }}%</h3>
                  <p class="mb-0">Total</p>
                </div>
                <span class="badge bg-label-danger rounded p-2">
                  <i class="bx bx-group bx-sm"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!--/ Cards with few info -->

  </div>
</div>
<!-- / Content -->

@endsection