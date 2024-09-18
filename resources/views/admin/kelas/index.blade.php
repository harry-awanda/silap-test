@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> Data Kelas
  </h4>
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <!-- <h5>Daftar Kelas</h5> -->
      <div class="ms-auto">
        <button class="btn btn-primary" data-bs-toggle="modal"
          data-bs-target="#createClassroomModal"> Tambah Data </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Nama Kelas</th>
              <th>Nama Wali Kelas</th>
              <th>Total Siswa</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($classrooms as $data)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
              <td>{{ $data->nama_kelas }}</td>
              <td>{{ $data->guru->nama_lengkap ?? 'Belum ada wali kelas' }}</td>
              <td>{{ $data->siswa_count }}</td>
              <td class="text-center" width="200px">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editClassroomModal{{ $data->id }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('classrooms.destroy', $data->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="bx bx-trash me-1"></i> Hapus
                      </button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            <div class="modal modal-top fade" id="editClassroomModal{{ $data->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createClassroomModalTitle">Edit Data Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('classrooms.update', $data->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col-md-12">
                          <label for="nama_kelas" class="form-label">Nama Kelas</label>
                          <input type="text" class="form-control" name="nama_kelas" value="{{ $data->nama_kelas }}" required>
                        </div>
                        <div class="col-md-12">
                          <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
                          <select class="form-select" name="wali_kelas_id" id="wali_kelas_id">
                              <option value="">Pilih Wali Kelas</option>
                              @foreach($guru as $g)
                              <option value="{{ $g->id }}" {{ $data->wali_kelas_id == $g->id ? 'selected' : '' }}>
                              {{ $g->nama_lengkap }}
                              </option>
                              @endforeach
                          </select>
                        </div>
                        <div class="col-md-12">
                          <label for="tingkat" class="form-label">Tingkat</label>
                          <select class="form-select" name="tingkat" required>
                            <option value="" selected disabled>-- Tingkat --</option>
                            <option value="10" {{ $data->tingkat == '10' ? 'selected' : '' }} >Kelas 10</option>
                            <option value="11" {{ $data->tingkat == '11' ? 'selected' : '' }} >Kelas 11</option>
                            <option value="12" {{ $data->tingkat == '12' ? 'selected' : '' }} >Kelas 12</option>
                          </select>
                        </div>
                      </div>
                      <hr>
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
  <!-- Modal to add new record -->
<div class="modal modal-top fade" id="createClassroomModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createClassroomModalTitle">Tambah Data Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('classrooms.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <label for="nama_kelas" class="form-label">Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" required>
            </div>
            <div class="col-md-12">
              <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
              <select class="form-select" name="wali_kelas_id" id="wali_kelas_id">
                <option value="">Pilih Wali Kelas</option>
                @foreach($guru as $g)
                <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <label for="tingkat" class="form-label">Tingkat</label>
              <select class="form-select" name="tingkat" required>
                <option value="" selected disabled>-- Tingkat --</option>
                <option value="10">Kelas 10</option>
                <option value="11">Kelas 11</option>
                <option value="12">Kelas 12</option>
              </select>
            </div>
          </div>
          <hr>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
<!-- / Content -->

@endsection
@push ('scripts')
  <script>
    let table = new DataTable('.datatable');
  </script>
@endpush