@extends('layouts.app')
@section('content')
@include('layouts.toasts')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">SILAP /</span> {{ $title }}
  </h4>
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <!-- <h5>Daftar Kelas</h5> -->
      <div class="ms-auto">
        <button class="btn btn-primary" data-bs-toggle="modal"
          data-bs-target="#createUserModal"> Tambah Data </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap table-hover">
        <table class="table datatable">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Role</th>
              <th class="text-center">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->username }}</td>
              <td>{{ ucfirst($user->role) }}</td>
              <td class="text-center" width="200px">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="bx bx-trash me-1"></i> Hapus
                      </button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            <div class="modal modal-top fade" id="editUserModal{{ $user->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                      <div>
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                      </div>
                      <div>
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                      </div>
            
                      <div>
                        <label class="form-label" for="role">Role</label>
                        <select name="role" class="form-select">
                          <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                          <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                          <option value="guru_piket" {{ $user->role == 'guru_piket' ? 'selected' : '' }}>Guru Piket</option>
                          <option value="guru_bk" {{ $user->role == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            
            
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal to add new record -->
  <div class="modal modal-top fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
          <div class="modal-body">
            @csrf
            <div>
              <label for="name" class="form-label">Nama</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div>
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" required>
            </div>

            <div class="form-password-toggle">
              <label class="form-label" for="Password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" name="password" required />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="form-password-toggle">
              <label class="form-label" for="password_confirmation">Confirm Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" name="password_confirmation" required />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              <small id="passwordHelp" class="form-text text-danger" style="display:none;">Password tidak cocok!</small>
            </div>

            <div>
              <label class="form-label" for="role">Role</label>
              <select name="role" class="form-select" data-allow-clear="true">
                <option value="" selected disabled>-- Pilih Salah Satu --</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
                <option value="guru_piket">Guru Piket</option>
                <option value="guru_bk">Guru BK</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->

@endsection
@push ('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let table = new DataTable('.datatable');
      
      const password = document.getElementById('password');
      const passwordConfirmation = document.getElementById('password_confirmation');
      const passwordHelp = document.getElementById('passwordHelp');
      
      passwordConfirmation.addEventListener('input', function() {
        if (password.value !== passwordConfirmation.value) {
          passwordHelp.style.display = 'block';
        } else {
          passwordHelp.style.display = 'none';
        }
      });
    });
  </script>
@endpush