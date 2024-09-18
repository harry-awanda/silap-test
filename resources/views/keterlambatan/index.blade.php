@extends('layouts.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="col-md-3">
        <label for="classroom_id" class="form-label">Filter by Kelas</label>
        <!-- Dropdown filter untuk memilih kelas -->
        <select id="classroom-filter" class="form-select select2" data-allow-clear="true" onchange="filterByClassroom()">
          <option value=""> --- Semua Kelas --- </option>
          @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}">{{ $classroom->nama_kelas }}</option>
          @endforeach
        </select>
      </div>
      <div>
        @if(Auth::user()->role === 'guru_piket')
          <a href="{{ route('keterlambatan.create') }}" class="btn btn-primary">Tambah Keterlambatan</a>
        @endif
      </div>

    </div>
    <div class="card-body">
      @if($keterlambatan->isNotEmpty())
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Siswa</th>
              <th>Tanggal Keterlambatan</th>
              <th>Waktu Keterlambatan</th>
              @if(Auth::user()->role === 'guru_piket')
                <th>Aksi</th> <!-- Kolom Aksi hanya muncul jika role adalah guru_piket -->
              @endif
            </tr>
          </thead>
          <tbody id="keterlambatan-body">
            @foreach($keterlambatan as $item)
            <tr data-classroom="{{ $item->classroom_id }}">
              <td>{{ $loop->index+1 }}</td>
              <td>{{ $item->siswa->nama_lengkap }}</td>
              <td>{{ Carbon\Carbon::parse($item->tanggal_keterlambatan)->format('d-m-Y') }}</td>
              <td>{{ Carbon\Carbon::parse($item->waktu_keterlambatan)->format('H:i') }}</td>
              @if(Auth::user()->role === 'guru_piket')
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('keterlambatan.edit', $item->id) }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('keterlambatan.destroy', $item->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                        <i class="bx bx-trash me-1"></i> Delete
                      </button>
                    </form>
                  </div>
                </div>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <p>Belum ada data keterlambatan.</p>
      @endif
    </div>
  </div>
</div>
@endsection

@push ('scripts')
  <script>
    let table = new DataTable('.datatable');

    function filterByClassroom() {
      const classroomId = document.getElementById('classroom-filter').value;
      const rows = document.querySelectorAll('#keterlambatan-body tr');

      rows.forEach(row => {
        if (classroomId === "" || row.getAttribute('data-classroom') === classroomId) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
  </script>
@endpush
