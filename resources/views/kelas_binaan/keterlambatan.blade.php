@extends('layouts.app')
@section('content')
@include('layouts.toasts')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Silap / {{ $title }} /</span> Kelas {{ $nama_kelas }}
  </h4>
  @if(!empty($message))
  <div class="alert alert-warning">{{ $message }}</div>
  @else
  <div class="card">
    <div class="card-header">
      <form id="filterFormKeterlambatan" class="mb-4">
        @csrf
        <input type="hidden" name="filter_type" value="keterlambatan">
        <div class="row g-3 align-items-center">
          <div class="col-md-6">
            <div class="input-group">
              <label class="input-group-text" for="filter_date_keterlambatan">Tanggal Keterlambatan</label>
              <input type="date" class="form-control" id="filter_date_keterlambatan" name="filter_date_keterlambatan">
            </div>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary" onclick="filterData('keterlambatan')">Filter</button>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body">
      <table class="table table-responsive table-hover datatable" id="keterlambatanTable">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Nama Siswa</th>
            <th>Tanggal</th>
            <th>Waktu Keterlambatan</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data akan diisi oleh AJAX -->
          @foreach($dataKeterlambatan as $item)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->siswa->nama_lengkap }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_keterlambatan)->format('d-m-Y') }}</td>
            <td>{{ $item->waktu_keterlambatan }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  function filterData(type) {
    let formId = (type === 'keterlambatan') ? '#filterFormKeterlambatan' : '#filterFormAbsensi';
    let tableId = (type === 'keterlambatan') ? '#keterlambatanTable tbody' : '#absensiTable tbody';
    
    $.ajax({
      url: "{{ route('absensi-keterlambatan.filter') }}",
      method: "POST",
      data: $(formId).serialize(),
      success: function(response) {
        let data = (type === 'keterlambatan') ? response.dataKeterlambatan : response.dataAbsensi;
        let rows = '';
        data.forEach(function(item, index) {
          rows += '<tr>' +
          '<td class="text-center">' + (index + 1) + '</td>' +
          '<td>' + item.siswa.nama_lengkap + '</td>' +
          '<td>' + (new Date(item.tanggal_keterlambatan || item.date)).toLocaleDateString() + '</td>' +
          '<td>' + (item.waktu_keterlambatan || item.status) + '</td>' +
          '</tr>';
        });
        $(tableId).html(rows);
      }
    });
  }
  // Inisialisasi DataTable
  $(document).ready(function() {
    $('.datatable').DataTable();
  });
</script>
@endpush
