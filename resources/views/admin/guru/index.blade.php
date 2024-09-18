@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Silap /</span> {{ $title }}
  </h4>
      @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <!-- <h5>Daftar Kelas</h5> -->
      <div class="ms-auto">
        <button class="btn btn-primary" data-bs-toggle="modal"
          data-bs-target="#createGuruModal"> Tambah Data </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>NIP / NRPTK / NRHS</th>
              <th>Nama Guru</th>
              <th>L / P</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($guru as $data)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
              <td>{{ $data->nip }}</td>
              <td>{{ $data->nama_lengkap }}</td>
              <td>{{ $data->jenis_kelamin }}</td>
              <td class="text-center" width="200px">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editGuruModal{{ $data->id }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('guru.destroy', $data->id) }}" method="POST" class="d-inline">
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
            <div class="modal modal-top fade" id="editGuruModal{{ $data->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('guru.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col md-6">
                          <label for="nip" class="form-label">NIP / NRPTK / NRHS</label>
                          <input type="text" class="form-control" name="nip" value="{{ $data->nip }}" required>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="photo">Photo</label>
                          <input type="file" name="photo" class="form-control">
                          @if($data->photo)
                          <small class="text-muted">Current Photo: {{ $data->photo }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col md-6">
                          <label for="username" class="form-label">Username</label>
                          <input type="text" class="form-control" name="username" value="{{ $data->username }}" required>
                        </div>
                        <div class="col md-6">
                          <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                          <input type="text" class="form-control" name="nama_lengkap" value="{{ $data->nama_lengkap }}" required>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col md-6">
                          <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                          <input type="text" class="form-control" name="tempat_lahir" value="{{ $data->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                          <input type="date" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}" class="form-control"/>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col md-6">
                          <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                          <select name="jenis_kelamin" class="form-select" data-allow-clear="true">
                            <option value="" disabled>Pilih Salah Satu</option>
                            <option value="L" {{ $data->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $data->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="tanggal_lahir">Nomor Telepon / Whatsapp</label>
                            <div class="input-group">
                              <span class="input-group-text">+62</span>
                              <input type="text" name="kontak" class="form-control" value="{{ $data->kontak }}" />
                            </div>
                        </div>
                      </div>
                      
                      <div class="col-12">
                        <label class="form-label" for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" >{{ $data->alamat }}</textarea>
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
  <div class="modal modal-top fade" id="createGuruModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah {{ $title }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col md-6">
                <label for="nip" class="form-label">NIP / NRPTK / NRHS</label>
                <input type="text" class="form-control" name="nip" required>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="col md-6">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" required>
              </div>
            </div>
            <div class="row">
              <div class="col md-6">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" required>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control"/>
              </div>
            </div>
            
            <div class="row">
              <div class="col md-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" data-allow-clear="true">
                  <option value="" selected disabled>Pilih Salah Satu</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="kontak">Nomor Telepon / Whatsapp</label>
                  <div class="input-group">
                    <span class="input-group-text">+62</span>
                    <input type="text" name="kontak" class="form-control" placeholder="812 3456 7890" />
                  </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label" for="alamat">Alamat</label>
              <textarea name="alamat" class="form-control" rows="2" ></textarea>
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