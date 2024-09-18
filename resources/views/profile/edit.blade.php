@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="col-lg-8 mx-auto">
          <h5 class="card-header">Photo Profile</h5>
          <!-- Account -->
          @if($user->role === 'guru' || $user->role === 'guru_bk')
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img src="{{ $guru->photo ? asset('storage/' . $guru->photo) : asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block rounded" height="100" width="100" />
              <div class="button-wrapper d-flex flex-column align-items-start gap-3">
                <form action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                  @csrf
                  <label for="upload" class="btn btn-primary mb-2">
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" name="photo" hidden accept="image/png, image/jpeg" />
                  </label>
                  <button type="submit" class="btn btn-primary mb-2">Save Photo</button>
                </form>
                <button type="button" class="btn btn-label-secondary mb-2">
                  <i class="bx bx-reset d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Reset</span>
                </button>
              </div>
            </div>
          </div>
          <hr class="my-0">
          @endif
          <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="username" class="form-label">Username</label>
                  <input class="form-control" type="text" name="username" value="{{ old('username', $guru->username ?? $user->username) }}" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                  <input class="form-control" type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap  ?? $user->name) }}" />
                </div>
                @if($user->role === 'guru' || $user->role === 'guru_bk')
                <div class="mb-3 col-md-6">
                  <label for="nip" class="form-label">NIP / NRPTK / NRHS</label>
                  <input class="form-control" type="text" name="nip" value="{{ old('nip', $guru->nip ?? '') }}" autofocus />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                  <input class="form-control" type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}" />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                  <input class="form-control" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir ?? '') }}" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="kontak" class="form-label">Nomor Telepon / Whatsapp</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">ID (+62)</span>
                    <input class="form-control" type="text" name="kontak" value="{{ old('kontak', $guru->kontak ?? '') }}" />
                  </div>
                </div>
                <div class="mb-3 col-md-12">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea name="alamat" class="form-control" rows="2" >{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                </div>
                @endif
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
          <hr class="my-0">
          <div class="card-body">
            <form action="{{ route('profile.updatePassword') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle">
                  <label class="form-label" for="currentPassword">Password Saat Ini</label>
                  <div class="input-group input-group-merge">
                    <input class="form-control" type="password" name="current_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle">
                  <label class="form-label" for="newPassword">Password Baru</label>
                  <div class="input-group input-group-merge">
                    <input class="form-control" type="password" name="new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

                <div class="mb-3 col-md-6 form-password-toggle">
                  <label class="form-label" for="confirmPassword">Konfirmasi Password Baru</label>
                  <div class="input-group input-group-merge">
                    <input class="form-control" type="password" name="new_password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="col-12 mt-1">
                  <button type="submit" class="btn btn-primary me-2">Save changes</button>
                  <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      
      </div>
    </div>
  </div>
</div>
@endsection