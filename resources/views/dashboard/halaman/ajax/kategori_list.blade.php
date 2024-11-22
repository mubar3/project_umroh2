
  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHapusLabel"></h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body" id="modalHapusIsi">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-cancel-hapus">Batal</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-action">Ya</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#jumlah_uang').on('input', function() {
            let angka = $(this).val().replace(/[^,\d]/g, ""); // Hanya angka
            let rupiah = formatRupiah(angka);
            $(this).val(rupiah);
        });



        $('#kategori_uang_masuk').on('submit', function(e) {
            e.preventDefault();

            let nama = $('#nama_masuk').val();
            let ket = $('#ket_masuk').val();

            $.ajax({
                url: "{{ env('APP_URL').'/ajax_list_uang_masuk' }}", // Ganti dengan URL tujuan
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                data: { nama: nama, ket:ket },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                    $('#nama_masuk').val('');
                    $('#ket_masuk').val('');
                },
                error: function(xhr, status, error) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
        });


        $('#kategori_uang_keluar').on('submit', function(e) {
            e.preventDefault();

            let nama = $('#nama_keluar').val();
            let ket = $('#ket_keluar').val();

            $.ajax({
                url: "{{ env('APP_URL').'/ajax_list_uang_keluar' }}", // Ganti dengan URL tujuan
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                data: { nama: nama, ket:ket },
                success: function(response) {
                    $('#tabel2').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                    $('#nama_keluar').val('');
                    $('#ket_keluar').val('');
                },
                error: function(xhr, status, error) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
        });

    });


    $(function () {

        $("#tabel1").DataTable({
            "responsive": true,
            "lengthChange": false,
            // "responsive": true,
            // "scrollX": true,
            "autoWidth": false,
            "ajax": {
                "url": "{{ env('APP_URL').'/ajax_get_list_uang_masuk' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "nama" },
                { "data": "ket" },
                { "data": "status" },
                { "data": "input_time" },
                {
                    "data": null,
                    "render": function(data, type, row) {

                        if(row.status == 'y'){
                            aktif=`<button class="btn btn-danger btn-nonaktif" data-id="${row.id_list}">
                                    <i class="fas fa-times-circle"></i> Nonaktifkan
                            </button>`;
                        }else{
                            aktif=`<button class="btn btn-info btn-aktifkan" data-id="${row.id_list}">
                                    <i class="fas fa-check-circle"></i> Aktifkan
                            </button>`;
                        }

                        return '<button class="btn btn-danger btn-hapus" data-id="' + row.id_list + '">' +
                                '<i class="fas fa-trash"></i> Hapus</button>'+aktif;
                    }
                }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

        $("#tabel2").DataTable({
            "responsive": true,
            "lengthChange": false,
            // "responsive": true,
            // "scrollX": true,
            "autoWidth": false,
            "ajax": {
                "url": "{{ env('APP_URL').'/ajax_get_list_uang_keluar' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "nama" },
                { "data": "ket" },
                { "data": "status" },
                { "data": "input_time" },
                {
                    "data": null,
                    "render": function(data, type, row) {

                        if(row.status == 'y'){
                            aktif=`<button class="btn btn-danger btn-nonaktif" data-id="${row.id_list}">
                                    <i class="fas fa-times-circle"></i> Nonaktifkan
                            </button>`;
                        }else{
                            aktif=`<button class="btn btn-info btn-aktifkan" data-id="${row.id_list}">
                                    <i class="fas fa-check-circle"></i> Aktifkan
                            </button>`;
                        }

                        return '<button class="btn btn-danger btn-hapus" data-id="' + row.id_list + '">' +
                                '<i class="fas fa-trash"></i> Hapus</button>'+aktif;
                    }
                }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

    });


    $('#btn-cancel-hapus').on('click', function() {
        $('#modalHapus').modal('hide'); // Menutup modal secara manual
    });

    // Variabel untuk menyimpan ID yang akan dihapus
    let idToDelete_masuk;
    let idToAktifkan_masuk;
    let idToNonaktifkan_masuk;
    let idToDelete_keluar;
    let idToAktifkan_keluar;
    let idToNonaktifkan_keluar;

    // Event listener untuk tombol hapus
    $('#tabel1').on('click', '.btn-hapus', function() {
        idToDelete_masuk = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi Hapus')
        $('#modalHapusIsi').text('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-nonaktif', function() {
        idToNonaktifkan_masuk = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi')
        $('#modalHapusIsi').text('List kategori ini akan dinonaktifkan dan tidak bisa diakses')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-aktifkan', function() {
        idToAktifkan_masuk = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi')
        $('#modalHapusIsi').text('List kategori ini akan diaktifkan dan bisa diakses')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });


    $('#tabel2').on('click', '.btn-hapus', function() {
        idToDelete_keluar = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi Hapus')
        $('#modalHapusIsi').text('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    $('#tabel2').on('click', '.btn-nonaktif', function() {
        idToNonaktifkan_keluar = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi')
        $('#modalHapusIsi').text('List kategori ini akan dinonaktifkan dan tidak bisa diakses')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    $('#tabel2').on('click', '.btn-aktifkan', function() {
        idToAktifkan_keluar = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi')
        $('#modalHapusIsi').text('List kategori ini akan diaktifkan dan bisa diakses')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    // Event listener untuk tombol konfirmasi hapus di modal
    $('#btn-confirm-action').on('click', function() {
        // Kirim permintaan AJAX untuk menghapus data
        if(idToDelete_masuk != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_list_uang_masuk' }}/hapus/" + idToDelete_masuk, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                },
                error: function(xhr) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
            idToDelete_masuk=null;

        }else if(idToNonaktifkan_masuk != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_list_uang_masuk' }}/nonaktifkan/" + idToNonaktifkan_masuk, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                },
                error: function(xhr) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
            idToNonaktifkan_masuk=null;

        }else if(idToAktifkan_masuk != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_list_uang_masuk' }}/aktifkan/" + idToAktifkan_masuk, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                },
                error: function(xhr) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
            idToNonaktifkan_masuk=null;
        }else if(idToDelete_keluar != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_list_uang_keluar' }}/hapus/" + idToDelete_keluar, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel2').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                },
                error: function(xhr) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
            idToDelete_keluar=null;

        }else if(idToNonaktifkan_keluar != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_list_uang_keluar' }}/nonaktifkan/" + idToNonaktifkan_keluar, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel2').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                },
                error: function(xhr) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
            idToNonaktifkan_keluar=null;

        }else if(idToAktifkan_keluar != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_list_uang_keluar' }}/aktifkan/" + idToAktifkan_keluar, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel2').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                },
                error: function(xhr) {
                    // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModalLabel').text('Gagal');
                    $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                }
            });
            idToNonaktifkan_keluar=null;
        }

        $('#modalHapus').modal('hide');
    });
</script>



<!-- Modal Error -->
<div class="modal fade" id="rfidErrorModal" tabindex="-1" aria-labelledby="rfidErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rfidErrorModalLabel"></h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <p id="rfidErrorMessage"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="tutup_eror_modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>
      $('#tutup_eror_modal').on('click', function() {
          $('#rfidErrorModal').modal('hide'); // Menutup modal secara manual
      });
  </script>
