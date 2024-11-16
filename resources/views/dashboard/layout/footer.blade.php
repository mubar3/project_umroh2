

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
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') . '?v=' . time() }}"></script>
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
<script src="{{ asset('asset/plugins/jqvmap/jquery.vmap.min.js') . '?v=' . time() }}"></script>
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



    function formatRupiah(angka) {
        // Hapus karakter non-angka (termasuk spasi dan simbol)
        let cleaned = angka.toString().replace(/[^0-9]/g, '');

        // Jika angka kosong setelah pembersihan, kembalikan dengan 'Rp0'
        if (cleaned === '') {
            return 'Rp';
        }

         // Konversi menjadi number
        cleaned = Number(cleaned);
        cleaned = cleaned.toString()

        // Ubah angka menjadi string dan balikkan
        let reverse = cleaned.split('').reverse().join('');

        // Pisahkan angka dalam grup ribuan
        let ribuan = reverse.match(/\d{1,3}/g);

        // Gabungkan hasil dengan titik (.) dan balikkan lagi
        let hasil = ribuan.join('.').split('').reverse().join('');

        // Kembalikan hasil dengan awalan 'Rp'
        return 'Rp' + hasil;
    }
</script>



<div class="modal fade" id="edit_pass_modal" tabindex="-1" aria-labelledby="rfidModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >EDIT PASSWORD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" type="password" id="pass_lama" placeholder="Password Lama">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" id="pass_baru" placeholder="Password Baru">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" id="pass_baru2" placeholder="Ulangi Password Baru">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel_edit_pass">Cancel</button>
                <button type="submit" class="btn btn-primary" id="simpan_edit_pass">Simpan</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Error -->
<div class="modal fade" id="modal_eror" tabindex="-2" aria-labelledby="rfidErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_eror_label"></h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <p id="modal_eror_message"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="modal_eror_tutup">Tutup</button>
        </div>
      </div>
    </div>
  </div>

<script>
    $('#edit_pass').on('click', function() {
        $('#edit_pass_modal').modal('show'); // Menutup modal secara manual
    });


    $('#cancel_edit_pass').on('click', function() {
        $('#edit_pass_modal').modal('hide'); // Menutup modal secara manual
    });


    $('#modal_eror_tutup').on('click', function() {
        $('#modal_eror').modal('hide'); // Menutup modal secara manual
    });

    $('#simpan_edit_pass').on('click', function(e) {
        $.ajax({
            url: "{{ env('APP_URL').'/ajax_edit_pass_user' }}", // Ganti dengan URL tujuan
            type: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
            },
            data: {
                    pass_lama: $('#pass_lama').val(),
                    pass_baru: $('#pass_baru').val(),
                    pass_baru2: $('#pass_baru2').val()
                },
            success: function(response) {
                $('#edit_pass_modal').modal('hide'); // Menutup modal secara manual
                $('#pass_lama').val('')
                $('#pass_baru').val('')
                $('#pass_baru2').val('')

                $('#modal_eror_label').text('Berhasil');
                $('#modal_eror_message').text(response.message);
                $('#modal_eror').modal('show');  // Tampilkan modal error
            },
            error: function(xhr, status, error) {
                $('#modal_eror_label').text('Gagal');
                $('#modal_eror_message').text(JSON.parse(xhr.responseText).message);
                $('#modal_eror').modal('show');  // Tampilkan modal error
            }
        });
    });
</script>

</body>
</html>
