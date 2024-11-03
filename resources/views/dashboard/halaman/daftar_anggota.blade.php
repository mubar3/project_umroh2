<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">DAFTAR ANGGOTA</h1>



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

    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="tabel1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id Anggota</th>
              <th>Nama</th>
              <th>Tanggal Mendaftar</th>
              <th>Jenis Kelamin</th>
              <th>TTL</th>
              <th>Nomor HP</th>
              <th>Jenis Anggota</th>
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


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
