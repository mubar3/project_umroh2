<script>
    $(function () {

        $("#tabel1").DataTable({
            "responsive": true,
            "lengthChange": false,
            // "responsive": true,
            // "scrollX": true,
            "autoWidth": false,
            "ajax": {
                "url": "{{ env('APP_URL').'/ajax_get_user' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "name" },
                { "data": "email" },
                { "data": "role" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        if(row.status == 'y'){
                            return 'Aktif';
                        }else{
                            return 'Nonaktif';
                        }
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        button_awal=`<div class="btn-group">`;
                        hapus=`
                            <button class="btn btn-secondary btn-edit" data-id="${row.id}" data-nama="${row.name}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-hapus" data-id="${row.id}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        `;
                        if(row.status == 'y'){
                            aktif=`<button class="btn btn-danger btn-nonaktif" data-id="${row.id}">
                                    <i class="fas fa-times-circle"></i> Nonaktifkan
                            </button>`;
                        }else{
                            aktif=`<button class="btn btn-info btn-aktifkan" data-id="${row.id}">
                                    <i class="fas fa-check-circle"></i> Aktifkan
                            </button>`;
                        }
                        reset_pass=`<button class="btn btn-primary btn-reset" data-id="${row.id}">
                                    <i class="fas fa-key"></i> Reset Password
                            </button>`;
                        button_akhir=`</div>`


                        return button_awal+hapus+reset_pass+aktif+button_akhir;
                    }
                }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

    });
  </script>

  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKonfirmasiLabel"></h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body" id="modalKonfirmasiIsi">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalKonfirmasiCancel">Batal</button>
                <button type="button" class="btn btn-danger" id="btn-Konfirmasi">Ya</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalsukses" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalsuksesLabel"></h5>
            </div>
            <div class="modal-body" id="modalsuksesIsi">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-cancel-sukses">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Edit</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body" id="modalKonfirmasiIsi">
                <div class="form-group">
                    <label>Nama :</label>
                    <input class="form-control" type="text" id="nama_edit">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalKonfirmasiCancel_edit">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-Konfirmasi_edit">Ya</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variabel untuk menyimpan ID yang akan dihapus
    let idToDelete;
    let idAktivasi;
    let idNonaktif;
    let idReset;
    let idEdit;
    let namaEdit;

    function reset_params(){
        idToDelete=null;
        idAktivasi=null;
        idNonaktif=null;
        idReset=null;
        idEdit=null;
        namaEdit=null;
        $('#nama_edit').val(null);
    }

    $('#tabel1').on('click', '.btn-edit', function() {
        idEdit = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        namaEdit = $(this).data('nama'); // Mendapatkan ID dari atribut data-id
        $('#nama_edit').val(namaEdit);
        $('#modalEdit').modal('show'); // Menampilkan modal
    });

    // Event listener untuk tombol hapus
    $('#tabel1').on('click', '.btn-hapus', function() {
        idToDelete = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalKonfirmasiLabel').text('Konfirmasi Hapus'); // Menampilkan modal
        $('#modalKonfirmasiIsi').text('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.'); // Menampilkan modal
        $('#modalKonfirmasi').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-reset', function() {
        idReset = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalKonfirmasiLabel').text('Konfirmasi Reset Password'); // Menampilkan modal
        $('#modalKonfirmasiIsi').text('Password akan tereset menjadi : asd'); // Menampilkan modal
        $('#modalKonfirmasi').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-aktifkan', function() {
        idAktivasi = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalKonfirmasiLabel').text('Konfirmasi Aktifkan User'); // Menampilkan modal
        $('#modalKonfirmasiIsi').text('User akan diaktifkan dan bisa login untuk mengakses aplikasi'); // Menampilkan modal
        $('#modalKonfirmasi').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-nonaktif', function() {
        idNonaktif = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalKonfirmasiLabel').text('Konfirmasi Nonaktif User'); // Menampilkan modal
        $('#modalKonfirmasiIsi').text('User akan dinonaktifkan dan tidak bisa login untuk mengakses aplikasi'); // Menampilkan modal
        $('#modalKonfirmasi').modal('show'); // Menampilkan modal
    });

    // Event listener untuk tombol konfirmasi hapus di modal
    $('#btn-Konfirmasi').on('click', function() {
        $('#modalKonfirmasi').modal('hide');
        if(idToDelete != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_user' }}/hapus/" + idToDelete, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload(); // Reload DataTable setelah menghapus
                    $('#modalsuksesLabel').text('Berhasil');
                    $('#modalsuksesIsi').text(response.message);
                    $('#modalsukses').modal('show');
                },
                error: function(xhr) {
                    $('#modalsuksesLabel').text('Gagal');
                    $('#modalsuksesIsi').text(JSON.parse(xhr.responseText).message);
                    $('#modalsukses').modal('show');
                }
            });
        }else if(idReset != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_user' }}/reset_pass/" + idReset, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload(); // Reload DataTable setelah menghapus
                    $('#modalsuksesLabel').text('Berhasil');
                    $('#modalsuksesIsi').text(response.message);
                    $('#modalsukses').modal('show');
                },
                error: function(xhr) {
                    $('#modalsuksesLabel').text('Gagal');
                    $('#modalsuksesIsi').text(JSON.parse(xhr.responseText).message);
                    $('#modalsukses').modal('show');
                }
            });
        }else if(idAktivasi != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_user' }}/aktifkan/" + idAktivasi, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload(); // Reload DataTable setelah menghapus
                    $('#modalsuksesLabel').text('Berhasil');
                    $('#modalsuksesIsi').text(response.message);
                    $('#modalsukses').modal('show');
                },
                error: function(xhr) {
                    $('#modalsuksesLabel').text('Gagal');
                    $('#modalsuksesIsi').text(JSON.parse(xhr.responseText).message);
                    $('#modalsukses').modal('show');
                }
            });
        }else if(idNonaktif != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_user' }}/nonaktifkan/" + idNonaktif, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload(); // Reload DataTable setelah menghapus
                    $('#modalsuksesLabel').text('Berhasil');
                    $('#modalsuksesIsi').text(response.message);
                    $('#modalsukses').modal('show');
                },
                error: function(xhr) {
                    $('#modalsuksesLabel').text('Gagal');
                    $('#modalsuksesIsi').text(JSON.parse(xhr.responseText).message);
                    $('#modalsukses').modal('show');
                }
            });
        }

        reset_params();

    });

    $('#btn-Konfirmasi_edit').on('click', function() {
        $('#modalEdit').modal('hide');
        $.ajax({
            url: "{{ env('APP_URL').'/ajax_edit_user' }}", // Ganti dengan URL endpoint hapus
            type: 'post', // Atau 'POST' sesuai kebutuhan
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
            },
            data: {
                id: idEdit,
                nama: $('#nama_edit').val(),
            },
            success: function(response) {
                $('#tabel1').DataTable().ajax.reload(); // Reload DataTable setelah menghapus
                $('#modalsuksesLabel').text('Berhasil');
                $('#modalsuksesIsi').text(response.message);
                $('#modalsukses').modal('show');
            },
            error: function(xhr) {
                $('#modalsuksesLabel').text('Gagal');
                $('#modalsuksesIsi').text(JSON.parse(xhr.responseText).message);
                $('#modalsukses').modal('show');
            }
        });

        reset_params();

    });

    $('#modalKonfirmasiCancel').on('click', function() {
        $('#modalKonfirmasi').modal('hide'); // Menutup modal secara manual
        reset_params();
    });
    $('#modalKonfirmasiCancel_edit').on('click', function() {
        $('#modalEdit').modal('hide'); // Menutup modal secara manual
        reset_params();
    });
    $('#btn-cancel-sukses').on('click', function() {
        $('#modalsukses').modal('hide'); // Menutup modal secara manual
        reset_params();
    });

</script>
