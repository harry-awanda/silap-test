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
          data-bs-target="#createUploadModal"> Upload </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Nama File</th>
              <th>Keterangan</th>
              <th>Tipe File</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($uploads as $upload)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
              <td>{{ $upload->file_name }}</td>
              <td>{{ $upload->description }}</td>
              <td>{{ strtoupper($upload->file_type) }}</td>
              <td class="text-center" width="200px">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('uploads.download', $upload->id) }}">
                      <i class="bx bx-download me-1"></i> Download
                    </a>
                    <form action="{{ route('uploads.destroy', $upload->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')">
                        <i class="bx bx-trash me-1"></i> Delete
                      </button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal to add new record -->
  <div class="modal modal-top fade" id="createUploadModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Unggah Berkas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group">
                <label for="file">File</label>
                <input type="file" class="form-control" id="file" name="file" required>
              </div>
              <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea class="form-control" id="description" name="description"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Upload</button>
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