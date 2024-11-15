<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">HUTANG</h1>



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
                    <h3 class="card-title">Tambah hutang</h3>

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

                        <div class="col-md-12">
                            <form id="uang_masuk">
                                <div class="form-group">
                                    <label>Jumlah  <span class="right badge badge-success">wajib</span></label>
                                    <input name="jumlah" id="rupiah_masuk" type="text" class="form-control" placeholder="Rp." required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                        <!-- /.col -->
                </div>
                    <!-- /.row -->

                {{-- <div class="card-footer">
                </div> --}}
            </div>
                <!-- /.card -->




        {{-- <div class="card card-default"> --}}
            <div class="card card-default collapsed">
                <div class="card-header">
                    <h3 class="card-title">Bayar hutang</h3>

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

                        <div class="col-md-12">
                            <form id="uang_bayar">
                                <div class="form-group">
                                    <label>Jumlah  <span class="right badge badge-success">wajib</span></label>
                                    <input name="jumlah" id="rupiah_bayar" type="text" class="form-control" placeholder="Rp." required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
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
