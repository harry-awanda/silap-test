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
      <!-- Filter Kelas untuk guru_bk -->
      @if(auth()->user()->role == 'guru_bk')
        <div class="col-md-3">
          <label for="filter-kelas" class="form-label">Filter Kelas</label>
          <select id="filter-kelas" class="form-select select2" data-allow-clear="true">
            <option value="all">Semua Kelas</option>
            @foreach($classrooms as $classroom)
              <option value="{{ $classroom->id }}">{{ $classroom->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
      @endif

      <div class="ms-auto">
        <a href="{{ route('pelanggaranSiswa.create') }}" class="btn btn-primary">Tambah Pelanggaran</a>
      </div>
    </div>
    
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Tanggal</th>
              <th>Nama Siswa</th>
              <th>Jenis Pelanggaran</th>
              <th>Pilihan</th>
            </tr>
          </thead>
          <tbody id="pelanggaran-tbody">
            @foreach($pelanggaranSiswa as $pelanggaran)
              <!-- Kondisi untuk guru_bk (semua kelas) -->
              @if(auth()->user()->role == 'guru_bk')
              <tr class="pelanggaran-row" data-classroom-id="{{ $pelanggaran->siswa->classroom_id }}">
                <td class="text-center" width="50px">{{ $loop->index+1 }}</td>
                <td width="100px">{{ $pelanggaran->tanggal_pelanggaran }}</td>
                <td width="175px">{{ $pelanggaran->siswa->nama_lengkap }}</td>
                <td>{{ $pelanggaran->dataPelanggaran->pluck('jenis_pelanggaran')->implode(', ') }}</td>
                <td class="text-center" width="150px">
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('pelanggaranSiswa.edit', $pelanggaran->id) }}">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                      </a>
                      <form action="{{ route('pelanggaranSiswa.destroy', $pelanggaran->id) }}" method="POST" style="display:inline;">
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
              @elseif(auth()->user()->role == 'guru')
                @if($pelanggaran->siswa->classroom_id)
                <tr>
                  <td class="text-center" width="50px">{{ $loop->index+1 }}</td>
                  <td width="100px">{{ $pelanggaran->tanggal_pelanggaran }}</td>
                  <td width="175px">{{ $pelanggaran->siswa->nama_lengkap }}</td>
                  <td>{{ $pelanggaran->dataPelanggaran->pluck('jenis_pelanggaran')->implode(', ') }}</td>
                  <td class="text-center" width="150px">
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('pelanggaranSiswa.edit', $pelanggaran->id) }}">
                          <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                        <form action="{{ route('pelanggaranSiswa.destroy', $pelanggaran->id) }}" method="POST" style="display:inline;">
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
                @endif
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push ('scripts')
<script>
  $(document).ready(function() {
    // DataTable initialization
    let table = new DataTable('.datatable');

    // Filter kelas untuk guru_bk
    $('#filter-kelas').on('change', function() {
      var selectedClass = $(this).val();
      $('#pelanggaran-tbody tr').each(function() {
        var rowClass = $(this).data('classroom-id');
        if (selectedClass == 'all' || rowClass == selectedClass) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  });
</script>
@endpush