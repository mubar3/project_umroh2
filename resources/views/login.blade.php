<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}">
  <title>Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img width="100px" class="img-thumbnail" style="background-color: #026537;" src="{{ asset('img/logo.jpg') }}">
  </div>
  <!-- /.login-logo -->
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('img/logo.jpg') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">SIlahkan login ke akun anda</p>


      @if (session()->has('success'))
      <div class="alert alert-success" role="alert">
          {{ session('success') }}
          {{-- PO Berhasil Dikirim --}}
      </div>
      @endif
      @if (session()->has('eror'))
      <div class="alert alert-danger" role="alert">
          {{ session('eror') }}
      </div>
      @endif

      <form action="{{ url('/login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
                <select name="role" id="select_hapus_awal" class="form-control" required>
                    <option value="" disable selected>JENIS AKUN</option>
                    <option value="1">Admin</option>
                    <option value="2">Top leader</option>
                    <option value="3">leader</option>
                    <option value="4">Koordinator</option>
                  </select>
        </div>
        <button type="submit" class="btn-lg btn-primary btn-block">Sign In</button>
      </form>


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('asset/dist/js/adminlte.min.js') }}"></script>

<script>
    const genderSelect = document.getElementById('select_hapus_awal');

    // Menghapus opsi pertama ketika dropdown dibuka
    genderSelect.addEventListener('focus', function() {
        if (genderSelect.options[0].value === "") {
            genderSelect.remove(0);
        }
    });
</script>
</body>
</html>
