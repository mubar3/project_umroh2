
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>
    <body class='hold-transition login-page'  style="background-image: url('{{ asset('img/background-gelombang.jpg') }}');">
        <div class='login-box'  style="margin-top: 20px;">
            <div class='login-logo'>
              <center><img width="100px" class="img-thumbnail" style="background-color: #026537;" src="{{ asset('img/logo.jpg') }}"></center>
              <a href='login'><b></b></a>
            </div>
            <div class='login-box-body' style="border-top: 8px solid #00a65a;border-bottom: 8px solid #00a65a;border-top-right-radius: 16px;border-top-left-radius: 16px;border-bottom-right-radius: 16px;border-bottom-left-radius: 16px;box-shadow: 0px 3px 6px 0px #222;">
                <center><h4  style="background-color: #00a65a; margin-top: -20px;width: 70%;height: 30px;border-bottom-left-radius: 7px;border-bottom-right-radius: 7px;color: #fff;"><b></b></h4></center>
                <br>
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
                <form method="post" action="{{ url('/login') }}">
                    @csrf
                  <div class='form-group has-feedback'>
                    <input type="email" class="form-control" placeholder="Masukan Username Anda" aria-describedby="basic-addon1" name="email" required autofocus />
                    <span class='glyphicon glyphicon-user form-control-feedback'></span>
                  </div>
                  <br>
                  <div class='form-group has-feedback'>
                    <input type="password" class="form-control" placeholder=" Masukan Password Anda" aria-describedby="basic-addon1" name="password">
                    <span class='glyphicon glyphicon-lock form-control-feedback'></span>
                  </div>
                  <br>
                  <div class='form-group has-feedback'>
                    <select name="role" class="form-control" required>
                      <!-- <option value="">Pilih Level User</option> -->
                      <option value="1">SUPERADMIN</option>
                    </select>
                  </div>
                  <br>
                  <div class='row'>
                    <div class='d-grid gap-2'>
                      <button name="login" type='submit' class='btn bg-orange btn-block'><i class="fa fa-sign-in"></i> MASUK</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
