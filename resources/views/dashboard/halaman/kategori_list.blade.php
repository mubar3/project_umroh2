<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KATEGORI</h1>



          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
              {{-- <li class="breadcrumb-item active">Dashboard v1</li> --}}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">




            {{-- <div class="card card-default"> --}}
          <div class="card card-default collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Tambah kategori uang masuk</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button> --}}
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                  <div class="col-md-6">
                        <form id="kategori_uang_masuk">
                        <div class="form-group">
                            <label>Nama  <span class="right badge badge-success">wajib</span></label>
                            <input name="nama" type="text" class="form-control" id="nama_masuk" placeholder="Nama" required>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Keterangan </label>
                            <textarea class="form-control" id="ket_masuk"></textarea>
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



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-default collapsed-card">
                <div class="card-header">
                  <h3 class="card-title">Data kategori uang masuk</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button> --}}
                  </div>
                </div>
              <div class="card-body">
                <table id="tabel1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>Nama</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Waktu Input</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  {{-- <tr>
                    <td>Trident</td>
                    <td>Internet
                      Explorer 4.0
                    </td>
                    <td>Win 95+</td>
                    <td> 4</td>
                    <td>X</td>
                  </tr> --}}
                </table>
              </div>
              <!-- /.card-body -->
            </div>


        </div><!-- /.container-fluid -->
      </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">




            {{-- <div class="card card-default"> --}}
          <div class="card card-default collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Tambah kategori uang keluar</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button> --}}
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                  <div class="col-md-6">
                        <form id="kategori_uang_keluar">
                        <div class="form-group">
                            <label>Nama  <span class="right badge badge-success">wajib</span></label>
                            <input name="nama" type="text" class="form-control" id="nama_keluar" placeholder="Nama" required>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Keterangan </label>
                            <textarea class="form-control" id="ket_keluar"></textarea>
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



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-default collapsed-card">
                <div class="card-header">
                  <h3 class="card-title">Data kategori uang keluar</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button> --}}
                  </div>
                </div>
              <div class="card-body">
                <table id="tabel2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>Nama</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Waktu Input</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  {{-- <tr>
                    <td>Trident</td>
                    <td>Internet
                      Explorer 4.0
                    </td>
                    <td>Win 95+</td>
                    <td> 4</td>
                    <td>X</td>
                  </tr> --}}
                </table>
              </div>
              <!-- /.card-body -->
            </div>


        </div><!-- /.container-fluid -->
      </section>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

