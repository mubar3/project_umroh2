
<script>
    $(function () {
    //   $("#tabel1").DataTable({
    //     "responsive": true, "lengthChange": false, "autoWidth": false,
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#tabel1").DataTable({
            "responsive": true,
            "lengthChange": false,
            // "responsive": true,
            // "scrollX": true,
            "autoWidth": false,
            "ajax": {
                "url": "{{ env('APP_URL').'/ajax_get_jamaah' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "id_anggota" },
                { "data": "nama" },
                { "data": "tanggal_mendaftar" },
                { "data": "jenis_kelamin" },
                {
                    "data": null, // Kolom gabungan
                    "render": function(data, type, row) {
                        return row.tempat_lahir + ', ' + row.tanggal_lahir; // Menggabungkan tempat dan tanggal lahir
                    }
                },
                { "data": "nomor" },
                { "data": "jenis_akun" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-danger btn-hapus" data-id="' + row.id_anggota + '">' +
                                '<i class="fas fa-trash"></i> Hapus</button>';
                    }
                }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

    });
  </script>

  <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-hapus">Batal</button>
                    <button type="button" class="btn btn-danger" id="btn-confirm-hapus">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalsuksesHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">Data Berhasil dihapus</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-berhasilhapus">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalgagalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">Data Gagal dihapus</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-gagalhapus">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variabel untuk menyimpan ID yang akan dihapus
        let idToDelete;

        // Event listener untuk tombol hapus
        $('#tabel1').on('click', '.btn-hapus', function() {
            idToDelete = $(this).data('id'); // Mendapatkan ID dari atribut data-id
            // console.log(idToDelete)
            $('#modalHapus').modal('show'); // Menampilkan modal
        });

        // Event listener untuk tombol konfirmasi hapus di modal
        $('#btn-confirm-hapus').on('click', function() {
            // Kirim permintaan AJAX untuk menghapus data
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_hapus_jamaah' }}/" + idToDelete, // Ganti dengan URL endpoint hapus
                type: 'get', // Atau 'POST' sesuai kebutuhan
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    // console.log(response)
                    // Tangani respons berhasil (misal: reload tabel)
                    $('#tabel1').DataTable().ajax.reload(); // Reload DataTable setelah menghapus
                    // alert('Data berhasil dihapus');
                    $('#modalsuksesHapus').modal('show');
                },
                error: function(xhr) {
                    // Tangani error
                    $('#modalgagalHapus').modal('show');
                    // alert('Terjadi kesalahan saat menghapus data: ' + xhr.responseText);
                }
            });

            // Menutup modal setelah menghapus
            $('#modalHapus').modal('hide');
        });

        $('#btn-cancel-hapus').on('click', function() {
            $('#modalHapus').modal('hide'); // Menutup modal secara manual
        });
        $('#btn-cancel-berhasilhapus').on('click', function() {
            $('#modalsuksesHapus').modal('hide'); // Menutup modal secara manual
        });$('#btn-cancel-gagalhapus').on('click', function() {
            $('#modalgagalHapus').modal('hide'); // Menutup modal secara manual
        });

    </script>

