@extends('layouts.app')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Rekap Bulanan /</span> Kelas {{ $classroom->nama_kelas }}
  </h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <form method="GET" action="{{ route('kelas-binaan.monthlyRecap') }}" class="w-100">
        <div class="row align-items-end">
          <div class="col-md-3">
            <label for="month" class="form-label">Bulan</label>
            <select id="month" name="month" class="form-select">
              @foreach($bulanIndonesia as $key => $bulan)
              <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
              {{ $bulan }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="year" class="form-label">Tahun</label>
            <select id="year" name="year" class="form-select">
              @foreach(range(date('Y') - 1, date('Y')) as $y)
              <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
          </div>
          <div class="col-md-3">
            <a href="{{ route('rekap-bulanan.export', ['month' => $month, 'year' => $year]) }}" 
            class="btn btn-success" >
            Export Rekap
            </a>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body">
      <table class="table table-responsive table-hover datatable">
        <thead>
          <tr>
            <th>Nama Siswa</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Alpa</th>
          </tr>
        </thead>
        <tbody>
          @foreach($siswa as $data)
          <tr>
            <td>{{ $data->nama_lengkap }}</td>
            <td>{{ $rekapAbsensi[$data->id]['sakit'] ?? 0 }}</td>
            <td>{{ $rekapAbsensi[$data->id]['izin'] ?? 0 }}</td>
            <td>{{ $rekapAbsensi[$data->id]['alpa'] ?? 0 }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
@push ('scripts')
  <script>
    let table = new DataTable('.datatable');
  </script>
@endpush