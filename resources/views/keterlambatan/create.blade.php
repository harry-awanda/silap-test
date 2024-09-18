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

  <form method="POST" action="{{ route('keterlambatan.store') }}">
    @csrf
    <div class="card">
      <div class="card-header">
        <!-- <h5>Tambah Data Keterlambatan</h5> -->
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="row g-3">
              <!-- Input untuk tanggal keterlambatan -->
              <div class="col-md-6">
                <label for="tanggal_keterlambatan" class="form-label">Tanggal Keterlambatan</label>
                <input type="date" id="tanggal_keterlambatan" name="tanggal_keterlambatan" class="form-control" required>
              </div>
              <!-- Input untuk waktu keterlambatan -->
              <div class="col-md-6">
                <label for="waktu_keterlambatan" class="form-label">Waktu Keterlambatan</label>
                <input type="time" id="waktu_keterlambatan" name="waktu_keterlambatan" class="form-control" required>
              </div>              
              <!-- Input untuk memilih kelas -->
              <div class="col-md-6">
                <label for="classroom_id" class="form-label">Kelas</label>
                <select id="classroom_id" name="classroom_id" class="form-select select2" data-allow-clear="true" required>
                  <option value="">-- Pilih Kelas --</option>
                  @foreach($classrooms as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                  @endforeach
                </select>
              </div>
              <!-- Input untuk mencari nama siswa -->
              <div class="col-md-6">
                <label for="siswa_nama" class="form-label">Nama Siswa</label>
                <input type="text" id="siswa_nama" class="form-control" placeholder="Cari Nama Siswa" required>
                <!-- Tempat menampilkan saran hasil pencarian siswa -->
                <div id="autocomplete-suggestions" class="typeahead" type="text" autocomplete="off"></div>
                <input type="hidden" id="siswa_id" name="siswa_id" value="">
              </div>
            </div>
          </div>
        </div>
      </div>
            
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </form>
</div>

@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // Ketika kelas dipilih
    $('#classroom_id').on('change', function() {
      var classroom_id = $(this).val();
      $('#siswa_nama').data('classroom_id', classroom_id); // Simpan classroom_id di input nama siswa
      $('#siswa_nama').val(''); // Kosongkan nama siswa
      $('#siswa_id').val(''); // Kosongkan id siswa
      $('#autocomplete-suggestions').empty(); // Kosongkan saran
      $('#error-message').hide(); // Sembunyikan pesan error
    });
    // Ketika pengguna mengetik di input nama siswa
    $('#siswa_nama').on('keyup', function() {
      var query = $(this).val(); // Ambil nilai input
      var classroom_id = $(this).data('classroom_id'); // Ambil classroom_id

      if (query.length > 1 && classroom_id) { // Hanya lakukan pencarian jika panjang query lebih dari 1 karakter dan classroom_id ada
        $.ajax({
          url: "{{ route('search.siswa') }}", // URL endpoint pencarian siswa
          type: "GET",
          data: {'query': query, 'classroom_id': classroom_id}, // Kirim query pencarian dan classroom_id
          success: function(data) {
            let suggestions = '';
            if (data.length > 0) {
              suggestions = '<ul class="list-group">';
              $.each(data, function(index, siswa) {
                // Buat daftar saran siswa
                suggestions += '<li class="list-group-item siswa-item" data-id="'+siswa.id+'">'+siswa.nama_lengkap+'</li>';
              });
              suggestions += '</ul>';
              $('#error-message').hide(); // Sembunyikan pesan error jika ada saran
            } else {
              suggestions = '<p class="text-danger">Tidak ada siswa bernama "' + query + '" di kelas ini.</p>';
              $('#error-message').html(suggestions).show(); // Tampilkan pesan error
            }
            $('#autocomplete-suggestions').html(suggestions); // Tampilkan saran di bawah input
          },
          error: function(xhr, status, error) {
            console.error("AJAX error:", status, error); // Tangani error AJAX
          }
        });
      } else {
        $('#autocomplete-suggestions').empty(); // Kosongkan saran jika query kurang dari 2 karakter atau classroom_id tidak ada
        $('#error-message').hide(); // Sembunyikan pesan error
      }
    });
    // Ketika pengguna mengklik item saran siswa
    $(document).on('click', '.siswa-item', function() {
      var siswa_id = $(this).data('id'); // Ambil ID siswa dari data attribute
      var siswa_nama = $(this).text(); // Ambil nama siswa dari teks item

      $('#siswa_id').val(siswa_id); // Set nilai ID siswa di input hidden
      $('#siswa_nama').val(siswa_nama); // Set nilai nama siswa di input
      $('#autocomplete-suggestions').empty(); // Kosongkan saran setelah memilih
      $('#error-message').hide(); // Sembunyikan pesan error
    });
  });
</script>
@endpush
