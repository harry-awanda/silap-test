<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo ">
    <a href="" class="app-brand-link">
      <span class="app-brand-logo demo"></span>
      <span class="app-brand -text demo menu-text fw-bold ms-2">SILAP</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>
  
  <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item @if (Request::segment(1) == 'dashboard') active @endif">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
      </a>
    </li>
    @if (auth()->user()->role == 'guru_piket' || auth()->user()->role == 'guru_bk')
      <!-- Apps & Pages -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Pages</span>
      </li>
      @if (auth()->user()->role == 'guru_piket')
      <li class="menu-item @if (Request::segment(1) == 'agenda_piket') active open @endif">
        <a href="{{ route('agenda_piket.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-list-check"></i>
          <div class="text-truncate">Agenda Harian</div>
        </a>
      </li>
      <li class="menu-item @if (Request::segment(1) == 'attendance') active open @endif">
        <a href="{{ route('attendance.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-list-check"></i>
          <div class="text-truncate">Absensi Siswa</div>
        </a>
      </li>
      @endif
      <li class="menu-item @if (Request::segment(1) == 'keterlambatan') active open @endif">
        <a href="{{ route('keterlambatan.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-list-check"></i>
          <div class="text-truncate">Keterlambatan Siswa</div>
        </a>
      </li>
    @endif
    
    @if (auth()->user()->role == 'guru' || auth()->user()->role == 'guru_bk')
      @if (auth()->user()->role == 'guru' && auth()->user()->guru && auth()->user()->guru->classroom)
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Pages</span>
      </li>
      <li class="menu-item @if (Request::segment(1) == 'kelas-binaan') active @endif">
        <a href="{{ route('kelas-binaan.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div class="text-truncate">Siswa Binaan</div>
        </a>
      </li>
      @endif
      
      <li class="menu-item @if (Request::segment(1) == 'pelanggaranSiswa') active @endif">
        <a href="{{ route('pelanggaranSiswa.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div class="text-truncate">Pelanggaran Siswa</div>
        </a>
      </li>
      
      @if (auth()->user()->role == 'guru' && auth()->user()->guru->classroom)
      <li class="menu-item @if (Request::segment(1) == 'rekap-absensi' || Request::segment(1) == 'rekap-keterlambatan' || Request::segment(1) == 'rekap-bulanan') active open @endif">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
          <div class="text-truncate">Rekap</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item @if (Request::segment(1) == 'rekap-absensi') active @endif">
            <a href="{{ route('absensi') }}" class="menu-link">
              <div class="text-truncate">Absensi Harian</div>
            </a>
          </li>
          <li class="menu-item @if (Request::segment(1) == 'rekap-keterlambatan') active @endif">
            <a href="{{ route('keterlambatan') }}" class="menu-link">
              <div class="text-truncate">Keterlambatan Harian</div>
            </a>
          </li>
          <li class="menu-item @if (Request::segment(1) == 'rekap-bulanan') active @endif">
            <a href="{{ route('kelas-binaan.monthlyRecap') }}" class="menu-link">
              <div class="text-truncate">Absensi Bulanan</div>
            </a>
          </li>
        </ul>
      </li>
      @endif
    @endif

    @if (auth()->user()->role == 'admin')
    <!-- Admin Menus -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Master Data</span></li>
    <li class="menu-item @if (Request::segment(1) == 'classrooms' || Request::segment(1) == 'jurusan' || Request::segment(1) == 'guru' || Request::segment(1) == 'siswa' || Request::segment(1) == 'data_pelanggaran') active open @endif">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-box"></i>
        <div class="text-truncate">Data</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item @if (Request::segment(1) == 'jurusan') active @endif">
          <a href="{{ route('jurusan.index') }}" class="menu-link">
            <div class="text-truncate">Data Jurusan</div>
          </a>
        </li>
        <li class="menu-item @if (Request::segment(1) == 'classrooms') active @endif">
          <a href="{{ route('classrooms.index') }}" class="menu-link">
            <div class="text-truncate">Data Kelas</div>
          </a>
        </li>
        <li class="menu-item @if (Request::segment(1) == 'siswa') active @endif">
          <a href="{{ route('siswa.index') }}" class="menu-link">
            <div class="text-truncate">Data Siswa</div>
          </a>
        </li>
        <li class="menu-item @if (Request::segment(1) == 'guru') active @endif">
          <a href="{{ route('guru.index') }}" class="menu-link">
            <div class="text-truncate">Data Guru</div>
          </a>
        </li>
        <li class="menu-item @if (Request::segment(1) == 'data_pelanggaran') active @endif">
          <a href="{{ route('data_pelanggaran.index') }}" class="menu-link">
            <div class="text-truncate">Data Pelanggaran</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Menu</span></li>
    <li class="menu-item @if (Request::segment(1) == 'profil') active @endif">
      <a href="{{ route('profil.edit') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-store"></i>
        <div class="text-truncate">Profil Sekolah</div>
      </a>
    </li>
    <li class="menu-item @if (Request::segment(1) == 'jadwal-piket') active @endif">
      <a href="{{ route('jadwal-piket.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div class="text-truncate">Jadwal Piket</div>
      </a>
    </li>
    <li class="menu-item @if (Request::segment(1) == 'uploads') active @endif">
      <a href="{{ route('uploads.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-window-open"></i>
        <div class="text-truncate">Uploads</div>
      </a>
    </li>
    <li class="menu-item @if (Request::segment(1) == 'users') active @endif">
      <a href="{{ route('users.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-check-shield"></i>
        <div class="text-truncate">User Management</div>
      </a>
    </li>
    @endif
  </ul>
</aside>
<!-- / Menu -->
