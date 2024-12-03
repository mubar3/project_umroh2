<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">UANG MASUK</h1>



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
          <div class="card card-default collapsed">
            <div class="card-header">
              <h3 class="card-title">Tambah pemasukan</h3>

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
                        <form id="uang_masuk" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Jumlah  <span class="right badge badge-success">wajib</span></label>
                            <input name="jumlah" id="jumlah_uang" type="text" class="form-control" placeholder="jumlah" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan </label>
                            <textarea name="ket" class="form-control" id="ket"></textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori <span class="right badge badge-success">wajib</span></label>
                            <select name="kategori" id="kategori" class="form-control" style="width: 100%;" required>
                                <option value="">==Pilih Salah Satu==</option>
                                @foreach ($list as $item)
                                    <option value="{{ $item->id_list }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bank</label>
                            <select name="bank" id="bank" class="form-control" style="width: 100%;">
                                <option value="">==Pilih Salah Satu==</option>
                                @foreach ($bank as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_bank }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto </label>
                            <input name="foto" type="file" class="form-control" placeholder="foto">
                        </div>
                        <div class="form-group">
                            <label>Koordinator  </label>
                            <select name="koordinator" class="form-control select-koordinator" style="width: 100%;">
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



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

          <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabel1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>Kategori</th>
                      <th>Jumlah</th>
                      <th>Keterangan</th>
                      <th>Waktu</th>
                      <th>Dari Bank</th>
                      <th>Foto</th>
                      <th>Koordinator</th>
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
