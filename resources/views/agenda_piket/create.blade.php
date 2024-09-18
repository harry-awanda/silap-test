@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <form action="{{ route('agenda_piket.store') }}" method="POST">
    @csrf
    <div class="card">
      <div class="card-header">
        <!-- <h5>Tambah Data Keterlambatan</h5> -->
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="row g-3">
              <div>
                <label for="guru_piket" class="form-label">Guru Piket</label>
                <select name="guru_piket[]" class="select2 form-select" multiple="multiple" data-allow-clear="true" required>
                  @foreach($guruPiket as $piket)
                  <option value="{{ $piket->guru->id }}">{{ $piket->guru->nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
              </div>
              <div>
                <label for="kejadian_normal">Kejadian Normal</label>
                <textarea name="kejadian_normal" class="form-control"></textarea>
              </div>
              <div>
                <label for="kejadian_masalah">Kejadian Masalah</label>
                <textarea name="kejadian_masalah" class="form-control"></textarea>
              </div>
              <div>
                <label for="solusi">Solusi</label>
                <textarea name="solusi" class="form-control"></textarea>
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
