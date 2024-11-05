<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TAMBAH USER</h1>



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

            {{-- <div class="card card-default"> --}}
          <div class="card card-default collapsed">
            <div class="card-header">
              <h3 class="card-title">Tambah User</h3>

              <div class="card-tools">
                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button> --}}
                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button> --}}
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                  <div class="col-md-6">
                        <form action="{{ url('/tambah_user') }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label>nama  <span class="right badge badge-success">wajib</span></label>
                            <input name="nama" type="text" class="form-control" placeholder="nama" required>
                        </div>
                        @if(Auth::user()->role == 1)
                            <div class="form-group">
                                <label>Top Leader
                                    <span class="right badge badge-secondary">wajib ketika input data leader</span>
                                </label>
                                <select name="top_leader" class="form-control select-top_leader" style="width: 100%;">
                                </select>
                            </div>
                        @endif
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role  <span class="right badge badge-success">wajib</span></label>
                            <select name="role" id="select_hapus_awal" class="form-control" style="width: 100%;" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                                @if(Auth::user()->role == 1)
                                    <option value="1">ADMIN</option>
                                    <option value="2">TOP LEADER</option>
                                @endif
                                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                                    <option value="3">LEADER</option>
                                @endif
                            </select>
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
