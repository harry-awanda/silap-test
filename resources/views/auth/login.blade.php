<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
  data-assets-path="{{asset('assets/')}}" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Login &mdash; SILAP</title>
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico')}}" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />
  <!-- Core CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />
  <!-- Page CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />
  <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
  <script src="{{asset('assets/js/config.js')}}"></script>
</head>
<body>
  @include('layouts.toasts')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center">
              <a href="#" class="app-brand-link gap-2">
                <span class="app-brand-text demo text-uppercase fw-bolder">SILAP</span>
              </a>
            </div>
            <h4 class="mb-2">Sistem Informasi Layanan Akademik dan Pendidikan</h4>
            <form class="mb-3" action="{{ route('postLogin') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label" for="uname">Username</label>
                <input type="text" class="form-control" name="username"
                placeholder="Enter your username" value="{{ old('username') }}" autofocus required />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="passwd">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
  <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <!-- Main JS -->
  <script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>