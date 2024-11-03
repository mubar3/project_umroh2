<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TAMBAH ANGGOTA</h1>



          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
              {{-- <li class="breadcrumb-item active">Dashboard v1</li> --}}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('eror'))
            <div class="alert alert-danger" role="alert">
                {{ session('eror') }}
            </div>
        @endif
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Tambah Jamaah</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                  <div class="col-md-6">
                        <form action="{{ url('/tambah_jamaah') }}" method="post">
                            @csrf
                        <div class="form-group">
                            <label>Tanggal mendaftar</label>
                            <input name="tanggal" id='tanggal_hari_ini' type="date" class="form-control" placeholder="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="nama" type="text" class="form-control" placeholder="nama" required>
                        </div>
                        <div class="form-group">
                        <label>Jenis kelamin</label>
                        <select name="kelamin" id="select_hapus_awal" class="form-control select2" style="width: 100%;" required>
                            <option value="" disable selected>jenis kelamin</option>
                            <option value="pria">pria</option>
                            <option value="wanita">wanita</option>
                        </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tempat lahir</label>
                            <input name="tempat_lahir" type="text" class="form-control" placeholder="tempat lahir" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal lahir</label>
                            <input name="tanggal_lahir" type="date" class="form-control" placeholder="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Whatsapp / Nomor telfon</label>
                            <input name="nomor" type="text" class="form-control" placeholder="nomor" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                    <!-- /.col -->
            </div>
              <!-- /.row -->

            {{-- <div class="card-footer">
            </div> --}}
        </div>
          <!-- /.card -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
