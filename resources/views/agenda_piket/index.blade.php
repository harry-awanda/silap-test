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
      <a href="{{ route('agenda_piket.create') }}" class="btn btn-primary">Tambah Agenda Piket</a>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Kejadian Normal</th>
              <th>Kejadian Masalah</th>
              <th>Solusi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($agendaPikets as $agendaPiket)
            <tr>
              <td>{{ $agendaPiket->tanggal }}</td>
              <td>{{ $agendaPiket->kejadian_normal }}</td>
              <td>{{ $agendaPiket->kejadian_masalah }}</td>
              <td>{{ $agendaPiket->solusi }}</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('agenda_piket.export', $agendaPiket->id) }}">
                      <i class="bx bx-file me-1"></i> Export PDF
                    </a>
                    <a class="dropdown-item" href="{{ route('agenda_piket.edit', $agendaPiket->id) }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('agenda_piket.destroy', $agendaPiket->id) }}" method="POST" style="display:inline;">
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
  </div>
</div>
@endsection
@push ('scripts')
  <script>
    let table = new DataTable('.datatable');
  </script>
@endpush
