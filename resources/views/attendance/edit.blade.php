@extends('layouts.app')
@section('content')

@include('layouts.toasts')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> Edit Kehadiran
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

  <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div class="mb-3">
          <label for="classroom_id" class="form-label">Pilih Kelas</label>
          <select id="classroom_id" name="classroom_id" class="form-select" disabled>
            @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}" {{ $classroom->id == $attendance->classroom_id ? 'selected' : '' }}>
              {{ $classroom->nama_kelas }}
            </option>
            @endforeach
          </select>
        </div>
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
            @foreach($students as $s)
            <tr>
              <td>{{ $s->nama_lengkap }}</td>
              <td>
                <input type="radio" name="attendance[{{ $s->id }}][status]" value="sakit"
                {{ isset($attendances[$s->id]) && $attendances[$s->id]->status == 'sakit' ? 'checked' : '' }}>
              </td>
              <td>
                <input type="radio" name="attendance[{{ $s->id }}][status]" value="izin"
                {{ isset($attendances[$s->id]) && $attendances[$s->id]->status == 'izin' ? 'checked' : '' }}>
              </td>
              <td>
                <input type="radio" name="attendance[{{ $s->id }}][status]" value="alpa"
                {{ isset($attendances[$s->id]) && $attendances[$s->id]->status == 'alpa' ? 'checked' : '' }}>
              </td>
              <input type="hidden" name="attendance[{{ $s->id }}][siswa_id]" value="{{ $s->id }}">
            </tr>
            @endforeach
          </tbody>
        </table> 
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push ('scripts')
  <script>
    let table = new DataTable('.datatable');
  </script>
@endpush