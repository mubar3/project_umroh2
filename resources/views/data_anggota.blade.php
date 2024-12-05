<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}">
  <title>Data Anggota</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
</head>
<body>
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('img/logo.jpg') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Detail Profil Anggota</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 col-12 text-center">
                                <div class="profile-picture">
                                    <img src="{{ $anggota->foto }}" class="img-fluid " alt="Foto Anggota">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 text-center">
                                <h4>{{ $anggota->nama }}</h4>
                                @if($anggota->status == 'y')
                                    <span class="right badge badge-success">Aktif</span>
                                @elseif ($anggota->status == 'n')
                                    <span class="right badge badge-danger">Tidak Aktif</span>
                                @endif
                                @if(!empty($anggota->koordinator))
                                    <p class="text-muted">Paket yang diambil : {{ $anggota->paket }}</p>
                                @else
                                    <br>
                                @endif
                                <h5>Foto Identitas</h5>
                                <div class="profile-picture">
                                    <img width="100" src="{{ $anggota->ktp }}" class="img-fluid" alt="Foto Identitas">
                                </div>
                            </div>


                        {{-- <!-- Foto Identitas di bagian bawah -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <h5>Foto Identitas</h5>
                                <div class="profile-picture">
                                    <img src="{{ $anggota->foto }}" class="img-fluid" alt="Foto Identitas">
                                </div>
                            </div>
                        </div> --}}
                        </div>

                        <div class="row">
                            <!-- Kolom untuk tampilan desktop (4 kolom) -->
                            <div class="col-md-3 col-6">
                                <strong>Tanggal Mendaftar:</strong> {{ $anggota->tanggal_mendaftar }}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Jenis Kelamin:</strong> {{ $anggota->jenis_kelamin }}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Alamat:</strong> {{ $anggota->provinsi.', '.$anggota->kota.', '.$anggota->kecamatan.', '.$anggota->desa.', '.$anggota->alamat }}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Tempat Tanggal Lahir:</strong> {{ $anggota->tempat_lahir.', '.$anggota->tanggal_lahir }}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Nomor Telepon:</strong> {{ $anggota->nomor }}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Total Tabungan:</strong> {{ $anggota->saldo }}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Total (Tagihan / Telah disetor):</strong> {{ $anggota->tagihan_paket}} / {{ $anggota->setoran}}
                            </div>
                            <div class="col-md-3 col-6">
                                <strong>Total Hutang:</strong> {{ $anggota->hutang }}
                            </div>

                            @if(!empty($anggota->koordinator))
                                <div class="col-md-3 col-6">
                                    <strong>Koordinator:</strong> {{ $anggota->koordinator }}
                                </div>
                            @endif

                            @if(!empty($anggota->leader))
                                <div class="col-md-3 col-6">
                                    <strong>Leader:</strong> {{ $anggota->leader }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>


  <!-- Content Wrapper. Contains page content -->

  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="https://adminlte.io">PT ASH SHOFWAH GROUP</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> {{ env('VERSION')}}
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('asset/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('asset/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('asset/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('asset/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('asset/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('asset/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('asset/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('asset/dist/js/adminlte.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('asset/dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('asset/dist/js/pages/dashboard.js') }}"></script>
<script>
    const select = document.getElementById('select_hapus_awal');
    if(select){
        // Menghapus opsi pertama ketika dropdown dibuka
        select.addEventListener('focus', function() {
            if (select.options[0].value === "") {
                select.remove(0);
            }
        });
    }

    $(function () {
        bsCustomFileInput.init();
    });
</script>
</body>
</html>
