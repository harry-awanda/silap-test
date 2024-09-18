@extends('layouts.app')
@section('content')
@include('layouts.toasts')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Silap /</span> Data Kelas
  </h4>
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="ms-auto">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"> Import Data </button>
          <a href="{{ route('siswa.create') }}" class="btn btn-primary"> Tambah Data </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table yajra-datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <th>Nama Jurusan</th>
              <th>Nama Kelas</th>
              <th>L/P</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
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
      <div class="modal-body">
        <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
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

@endsection
@push ('scripts')
<script type="text/javascript">
  $(function () {
    let table = $('.yajra-datatable').DataTable({
      processing: false,
      serverSide: true,
      ajax: "{{ route('siswa.index') }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'nis', name: 'nis'},
        {data: 'nama_lengkap', name: 'nama_lengkap'},
        {data: 'jurusan', name: 'jurusan'},
        {data: 'classroom', name: 'classroom'},
        {data: 'jenis_kelamin', name: 'jenis_kelamin'},
        {data: 'pilihan', name: 'pilihan', orderable: false, searchable: false},
      ]
    });
  });
</script>
@endpush