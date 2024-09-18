@extends('layouts.app')
@section('content')

@include('layouts.toasts')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
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
    <form method="POST" action="{{ route('attendance.store') }}">
      @csrf
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="mb-3">
            <label for="classroom_id" class="form-label">Pilih Kelas</label>
            <select id="classroom_id" name="classroom_id" class="form-select">
              <option value="">-- Pilih Kelas --</option>
              @foreach($classrooms as $classroom)
              <option value="{{ $classroom->id }}">{{ $classroom->nama_kelas }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="card-body">
          <div id="students-container"></div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  
  document.getElementById('classroom_id').addEventListener('change', function() {
    let classroomId = this.value;
    
    if(classroomId) {
      axios.get(`/attendance/get-students/${classroomId}`)
      .then(function(response) {
        document.getElementById('students-container').innerHTML = response.data;
        let table = new DataTable('.datatable');
      })
      
      .catch(function(error) {
        console.error('Error:', error);
      });
    } else {
      document.getElementById('students-container').innerHTML = '';
    }
  });
</script>
@endpush