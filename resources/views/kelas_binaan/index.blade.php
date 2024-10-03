@extends('layouts.app')
@section('content')
@include('layouts.toasts')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Silap / {{ $title }} / </span> {{ $nama_kelas }}

  </h4>
  @if(!empty($message))
    <div class="alert alert-warning">{{ $message }}</div>
  @else
    <div class="card">
      <form action="{{ route('kelas-binaan.updateKelas') }}" method="POST">
        @csrf
        <div class="card-header d-flex justify-content-between align-items-center">
          <!-- Dropdown Pilih Kelas Baru -->
          <div class="input-group">
            <div class="col-md-3">
              <select name="new_classroom_id" class="form-select select2">
                <option value="" disabled selected>Pilih kelas baru</option>
                @foreach ($classroom as $data)
                  <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                @endforeach
              </select>
            </div>

            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importModal">
                  <i class="bx bx-upload me-1"></i> Import Data 
                </button>
              </li>
              <li>
                <button type="submit" class="dropdown-item">
                  <i class="bx bx-transfer me-1"></i> Pindah Kelas
                </button>
              </li>
              <li>
                <button type="submit" class="dropdown-item text-danger"
                formaction="{{ route('kelas-binaan.massDelete') }}" 
                onclick="return confirm('Apakah Anda yakin ingin menghapus siswa yang dipilih?')">
                  <i class="bx bx-trash me-1"></i> Hapus Siswa
                </button>
              </li>
            </ul>
          </div>
        </div>

        <!-- Tabel Data Siswa -->
        <div class="card-body">
          <div class="table-responsive text-nowrap table-hover">
            <table class="table datatable">
              <thead>
                <tr>
                  <th class="text-center"><input type="checkbox" id="check-all"></th>
                  <th class="text-center">#</th>
                  <th>Nama Siswa</th>
                  <th>NIS</th>
                  <th>L / P</th>
                  <th>Pilihan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($siswa as $data)
                  <tr>
                    <td class="text-center" width="40px">
                      <input type="checkbox" name="siswa_ids[]" value="{{ $data->id }}" class="siswa-checkbox">
                    </td>
                    <td class="text-center" width="50px">{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_lengkap }}</td>
                    <td>{{ $data->nis }}</td>
                    <td>{{ $data->jenis_kelamin }}</td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('kelas-binaan.show', $data->id) }}">
                            <i class="bx bx-file me-1"></i> Detail
                          </a>
                          <a class="dropdown-item" href="{{ route('kelas-binaan.edit', $data->id) }}">
                            <i class="bx bx-edit-alt me-1"></i> Edit
                          </a>
                          <form action="{{ route('kelas-binaan.destroy', $data->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
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
      </form>
    </div>
  @endif
</div>
<!-- / Content -->
<!-- Modal to add new record -->
<div class="modal modal-top fade" id="importModal" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalTitle">Import Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3 col-md-12">
            <label class="form-label" for="template">Template Import Siswa</label>
            <div class="input-group">
              <input type="text" class="form-control" value="{{ $siswaImport->file_name ?? 'No file uploaded' }}" readonly>
              @if($fileUrl)
              <a href="{{ $fileUrl }}" class="btn btn-outline-primary" type="button" id="button-addon2">Download</a>
              @else
              <button class="btn btn-outline-secondary" type="button" disabled>No file</button>
              @endif
            </div>
          </div>
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
@endsection

@push('scripts')
  <script>
    let table = new DataTable('.datatable');
    
    // Handle check all functionality
    document.getElementById('check-all').addEventListener('change', function() {
      document.querySelectorAll('.siswa-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
      });
    });
  </script>
@endpush
