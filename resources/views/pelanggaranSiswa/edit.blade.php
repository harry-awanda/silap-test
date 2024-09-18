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

  <form method="POST" action="{{ route('pelanggaranSiswa.update', $pelanggaranSiswa->id) }}">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-header">
        <h5>Edit Data Pelanggaran Siswa</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="row g-3">
              
              <!-- Input untuk memilih kelas (khusus guru_bk) -->
              @if(auth()->user()->role == 'guru_bk')
                <div class="col-md-12">
                  <label for="classroom_id" class="form-label">Pilih Kelas</label>
                  <select id="classroom_id" name="classroom_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classrooms as $classroom)
                      <option value="{{ $classroom->id }}" 
                        @if($classroom->id == $pelanggaranSiswa->siswa->classroom_id) selected @endif>
                        {{ $classroom->nama_kelas }}
                      </option>
                    @endforeach
                  </select>
                </div>
              @endif

              <!-- Input untuk mencari nama siswa -->
              <div class="col-md-12">
                <label for="siswa_nama" class="form-label">Nama Siswa</label>
                <input type="text" id="siswa_nama" name="nama_lengkap" class="form-control" value="{{ $pelanggaranSiswa->siswa->nama_lengkap }}" placeholder="Cari Nama Siswa" data-allow-clear="true" required>
                <div id="autocomplete-suggestions" class="typeahead"></div>
                <input type="hidden" id="siswa_id" name="siswa_id" value="{{ $pelanggaranSiswa->siswa_id }}">
              </div>

              <!-- Input untuk jenis pelanggaran -->
              <div class="col-md-12">
                <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                <div class="select2-primary">
                  <select id="select2Primary" name="jenis_pelanggaran[]" class="select2 form-select" multiple="multiple" data-allow-clear="true" required>
                    @foreach($jenisPelanggaran as $p)
                      <option value="{{ $p->id }}" 
                        @if(in_array($p->id, $pelanggaranSiswa->dataPelanggaran->pluck('id')->toArray())) selected @endif>
                        {{ $p->jenis_pelanggaran }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <!-- Input untuk tanggal pelanggaran -->
              <div class="col-md-12">
                <label for="tanggal_pelanggaran" class="form-label">Tanggal Pelanggaran</label>
                <input type="date" id="tanggal_pelanggaran" name="tanggal_pelanggaran" class="form-control" value="{{ $pelanggaranSiswa->tanggal_pelanggaran }}" required>
              </div>

              <!-- Input untuk keterangan -->
              <div class="col-md-12">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Keterangan..." required>{{ $pelanggaranSiswa->keterangan }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Perbarui</button>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // Pencarian siswa dengan AJAX
    $('#siswa_nama').on('keyup', function() {
      var query = $(this).val();
      var classroom_id = $('#classroom_id').val(); // Untuk guru_bk

      if (query.length > 1) {
        $.ajax({
          url: "{{ route('autocomplete.siswa') }}",
          type: "GET",
          data: {'query': query, 'classroom_id': classroom_id},
          success: function(data) {
            let suggestions = '';
            if (data.length > 0) {
              suggestions = '<ul class="list-group">';
              $.each(data, function(index, siswa) {
                suggestions += '<li class="list-group-item siswa-item" data-id="'+siswa.id+'">'+siswa.value+'</li>';
              });
              suggestions += '</ul>';
            } else {
              suggestions = '<p class="text-danger">Tidak ada siswa di kelas ini.</p>';
            }
            $('#autocomplete-suggestions').html(suggestions);
          },
          error: function(xhr, status, error) {
            console.error("AJAX error:", status, error);
          }
        });
      } else {
        $('#autocomplete-suggestions').empty();
      }
    });

    // Pemilihan siswa dari hasil pencarian
    $(document).on('click', '.siswa-item', function() {
      var siswa_id = $(this).data('id');
      var siswa_nama = $(this).text();

      $('#siswa_id').val(siswa_id);
      $('#siswa_nama').val(siswa_nama);
      $('#autocomplete-suggestions').empty();
    });
  });
</script>
@endpush
