@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <!-- <h5>Daftar Kelas</h5> -->
      <div class="ms-auto">
        <div class="btn-group" role="group">
          <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"> Import Data </button>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDataPelanggaranModal"> Tambah Data </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Jenis Pelanggaran</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data_pelanggaran as $data)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
              <td>{{ $data->jenis_pelanggaran }}</td>
              <td class="text-center" width="200px">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editDataPelanggaranModal{{ $data->id }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('data_pelanggaran.destroy', $data->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus data pelanggaran ini?')">
                        <i class="bx bx-trash me-1"></i> Hapus
                      </button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
  
            <div class="modal modal-top fade" id="editDataPelanggaranModal{{ $data->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('data_pelanggaran.update', $data->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col mb-3">
                          <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                          <input type="text" class="form-control" name="jenis_pelanggaran" value="{{ $data->jenis_pelanggaran }}" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal tambah jenis pelanggaran -->
  <div class="modal modal-top fade" id="createDataPelanggaranModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Pelanggaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('data_pelanggaran.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col mb-3">
                <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                <input type="text" class="form-control" name="jenis_pelanggaran" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal import jenis pelanggaran -->
  <div class="modal modal-top fade" id="importModal" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importModalTitle">Import Jenis Pelanggaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('data_pelanggaran.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <label class="form-label" for="file">Pilih Berkas Excel</label>
                <input type="file" name="file" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Import</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@push ('scripts')
  <script>
    let table = new DataTable('.datatable');
  </script>
@endpush