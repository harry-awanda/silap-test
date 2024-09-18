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
        <button class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#createJadwalPiketModal"> Tambah Data </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Nama Guru</th>
              <th>Hari</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jadwalPiket as $data)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
              <td>{{ $data->guru->nama_lengkap }}</td>
              <td>{{ $data->hari_piket }}</td>
              <td class="text-center" width="200px">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editJadwalPiketModal{{ $data->id }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('jadwal-piket.destroy', $data->id) }}" method="POST" class="d-inline">
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
            <!-- Modal Edit -->
            <div class="modal modal-top fade" id="editJadwalPiketModal{{ $data->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal Piket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('jadwal-piket.update', $data->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col mb-3">
                          <label for="guru_id">Guru</label>
                          <select name="guru_id" id="guru_id" class="form-control" required>
                            @foreach ($guru as $g)
                            <option value="{{ $g->id }}" {{ $data->guru_id == $g->id ? 'selected' : '' }}>
                              {{ $g->nama_lengkap }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <label for="hari">Hari</label>
                            <select name="hari_piket" class="form-control" required>
                              <option value="Senin" {{ $data->hari_piket == 'Senin' ? 'selected' : '' }}>Senin</option>
                              <option value="Selasa" {{ $data->hari_piket == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                              <option value="Rabu" {{ $data->hari_piket == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                              <option value="Kamis" {{ $data->hari_piket == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                              <option value="Jumat" {{ $data->hari_piket == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            </select>
                          </div>
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
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal to add new record -->
  <div class="modal modal-top fade" id="createJadwalPiketModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah {{ $title }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('jadwal-piket.store') }}" method="POST">
            @csrf
            <div class="row">        
              <div class="col mb-3">
                <label for="guru_id">Guru</label>
                <select name="guru_id" id="guru_id" class="form-control" required>
                  <option value="" selected disabled>Pilih Salah Satu</option>
                  @foreach ($guru as $g)
                  <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="hari">Hari</label>
                  <select name="hari_piket" class="form-control" required>
                    <option value="" selected disabled>Pilih Hari Piket</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                  </select>
                </div>
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
</div>
<!-- / Content -->

@endsection
@push ('scripts')
  <script>
    let table = new DataTable('.datatable');
  </script>
@endpush