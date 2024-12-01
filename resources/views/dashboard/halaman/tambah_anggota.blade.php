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

        {{-- @if(Auth::user()->role == 1 || Auth::user()->role == 4) --}}
        <div class="card card-default collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Tambah Jamaah</h3>

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
                        <form action="{{ url('/tambah_jamaah') }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label>Tanggal mendaftar  <span class="right badge badge-success">wajib</span></label>
                            <input name="tanggal" id='tanggal_hari_ini' type="date" class="form-control" placeholder="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Nama  <span class="right badge badge-success">wajib</span></label>
                            <input name="nama" type="text" class="form-control" placeholder="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis kelamin  <span class="right badge badge-success">wajib</span></label>
                            <select name="kelamin" id="select_hapus_awal" class="form-control" style="width: 100%;" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                                <option value="pria">pria</option>
                                <option value="wanita">wanita</option>
                            </select>
                        </div>
                        <div class="form-group" for="provinsi">
                            <label>Provinsi  <span class="right badge badge-success">wajib</span></label>
                            @php
                                $provinces = new App\Http\Controllers\Controller;
                                $provinces= $provinces->provinces();
                            @endphp
                            <select class="form-control" name="provinsi" id="provinsi" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                                @foreach ($provinces as $item)
                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" for="kota">
                            <label>Kabupaten / Kota  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="kota" id="kota" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group" for="kecamatan">
                            <label>Kecamatan  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="kecamatan" id="kecamatan" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group" for="desa">
                            <label>Desa  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="desa" id="desa" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                            </select>
                        </div>

                        <div class="form-group" >
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat">
                            </textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tempat lahir  <span class="right badge badge-success">wajib</span></label>
                            <input name="tempat_lahir" type="text" class="form-control" placeholder="tempat lahir" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal lahir  <span class="right badge badge-success">wajib</span></label>
                            <input name="tanggal_lahir" type="date" class="form-control" placeholder="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Whatsapp / Nomor telfon  <span class="right badge badge-success">wajib</span></label>
                            <input name="nomor" type="number" class="form-control" placeholder="nomor" required>
                        </div>
                        <div class="form-group">
                            <label>Koordinator  <span class="right badge badge-success">wajib</span></label>
                            <select name="koordinator" class="form-control select-koordinator" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Paket  <span class="right badge badge-success">wajib</span></label>
                            <select name="paket" id="select_hapus_awal" class="form-control select2" style="width: 100%;" required>
                                <option value="" disable selected>Daftar paket</option>
                                @foreach ($paket as $daftar)
                                    <option value="{{ $daftar->id_paket }}">{{ $daftar->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>PasFoto <span class="right badge badge-success">wajib</span></label>
                            <div class="custom-file">
                                <input name="foto" type="file" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto KTP  <span class="right badge badge-success">wajib</span></label>
                            <div class="custom-file">
                                <input name="ktp" type="file" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nomor RFID  </label>
                            <input name="rfid" type="password" class="form-control" placeholder="RFID">
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
        {{-- @endif --}}
          <!-- /.card -->
          {{-- @if(Auth::user()->role != 4) --}}
          @if(!in_array(Auth::user()->role,[4,8]))
          {{-- <div class="card card-default"> --}}
          <div class="card card-default collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Tambah Koordinator</h3>

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
                        <form action="{{ url('/tambah_koordinator') }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label>Tanggal mendaftar  <span class="right badge badge-success">wajib</span></label>
                            <input name="tanggal" id='tanggal_hari_ini2' type="date" class="form-control" placeholder="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Nama  <span class="right badge badge-success">wajib</span></label>
                            <input name="nama" type="text" class="form-control" placeholder="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis kelamin  <span class="right badge badge-success">wajib</span></label>
                            <select name="kelamin" id="select_hapus_awal" class="form-control" style="width: 100%;" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                                <option value="pria">pria</option>
                                <option value="wanita">wanita</option>
                            </select>
                        </div>
                        <div class="form-group" for="provinsi2">
                            <label>Provinsi  <span class="right badge badge-success">wajib</span></label>
                            @php
                                $provinces = new App\Http\Controllers\Controller;
                                $provinces= $provinces->provinces();
                            @endphp
                            <select class="form-control" name="provinsi" id="provinsi2" required>
                                <option value="" disable selected >==Pilih Salah Satu==</option>
                                @foreach ($provinces as $item)
                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" for="kota2">
                            <label>Kabupaten / Kota  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="kota" id="kota2" required>
                                <option value="" disable selected >==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group" for="kecamatan2">
                            <label>Kecamatan  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="kecamatan" id="kecamatan2" required>
                                <option value="" disable selected >==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group" for="desa2">
                            <label>Desa  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="desa" id="desa2" required>
                                <option value="" disable selected >==Pilih Salah Satu==</option>
                            </select>
                        </div>

                        <div class="form-group" >
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat">
                            </textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tempat lahir  <span class="right badge badge-success">wajib</span></label>
                            <input name="tempat_lahir" type="text" class="form-control" placeholder="tempat lahir" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal lahir  <span class="right badge badge-success">wajib</span></label>
                            <input name="tanggal_lahir" type="date" class="form-control" placeholder="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Whatsapp / Nomor telfon  <span class="right badge badge-success">wajib</span></label>
                            <input name="nomor" type="number" class="form-control" placeholder="nomor" required>
                        </div>
                        <div class="form-group">
                            <label>Leader  <span class="right badge badge-success">wajib</span></label>
                            <select name="leader" class="form-control select-leader" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bank  <span class="right badge badge-success">wajib</span></label>
                            <select class="form-control" name="bank" required>
                                <option value="" disable selected>==Pilih Salah Satu==</option>
                                @foreach ($bank as $data_bank)
                                    <option value="{{ $data_bank->id}}"> {{ $data_bank->nama_bank }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Rekening atas nama  <span class="right badge badge-success">wajib</span></label>
                            <input name="nama_rekening" type="text" class="form-control" placeholder="nama rekening" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor rekening  <span class="right badge badge-success">wajib</span></label>
                            <input name="nomor_rekening" type="number" class="form-control" placeholder="nomor rekening" required>
                        </div>
                        <div class="form-group">
                            <label>PasFoto <span class="right badge badge-success">wajib</span></label>
                            <div class="custom-file">
                                <input name="foto" type="file" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto KTP <span class="right badge badge-success">wajib</span></label>
                            <div class="custom-file">
                                <input name="ktp" type="file" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nomor RFID  </label>
                            <input name="rfid" type="password" class="form-control" placeholder="RFID">
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
        @endif
          <!-- /.card -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
