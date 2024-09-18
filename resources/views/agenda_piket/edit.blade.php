@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <form action="{{ route('agenda_piket.update', $agendaPiket->id) }}" method="POST">
    @csrf
    @method('PUT')
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
                <select name="guru_piket[]" class="select2 form-select" multiple data-allow-clear="true" required>
                  @foreach($guruPiket as $guru)
                  <option value="{{ $guru->guru->id }}" {{ in_array($guru->guru->id, json_decode($agendaPiket->guru_piket)) ? 'selected' : '' }}>
                    {{ $guru->guru->nama_lengkap }}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $agendaPiket->tanggal }}" required>
              </div>
              <div class="mb-3">
                <label for="kejadian_normal" class="form-label">Kejadian Normal</label>
                <textarea name="kejadian_normal" class="form-control">{{ $agendaPiket->kejadian_normal }}</textarea>
              </div>
              <div class="mb-3">
                <label for="kejadian_masalah" class="form-label">Kejadian Masalah</label>
                <textarea name="kejadian_masalah" class="form-control">{{ $agendaPiket->kejadian_masalah }}</textarea>
              </div>
              <div class="mb-3">
                <label for="solusi" class="form-label">Solusi</label>
                <textarea name="solusi" class="form-control">{{ $agendaPiket->solusi }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
  </form>
</div>
@endsection
