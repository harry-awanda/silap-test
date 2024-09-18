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
          <option value="all">--- Semua Kelas ---</option>
          @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}">{{ $classroom->nama_kelas }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <a href="{{ route('attendance.create') }}" class="btn btn-primary">Tambah Kehadiran</a>
      </div>
    </div>
    <div class="card-body">
      @if($attendances->isNotEmpty())
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Status Kehadiran</th>
              <th>Pilihan</th>
            </tr>
          </thead>
          <tbody id="attendance-body">
          @foreach($attendances as $attendance)
            <tr data-classroom="{{ $attendance->siswa->classroom_id }}">
              <td>{{ $loop->index+1 }}</td>
              <td>{{ $attendance->siswa->nama_lengkap }}</td>
              <td>{{ $attendance->siswa->classroom->nama_kelas }}</td>
              <td>{{ ucfirst($attendance->status) }}</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('attendance.edit', $attendance->id) }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
      @else
      <p>Belum ada data kehadiran.</p>
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
      const rows = document.querySelectorAll('#attendance-body tr');

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