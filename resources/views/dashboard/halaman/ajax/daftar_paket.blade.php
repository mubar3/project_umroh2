
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
                <button type="button" class="btn btn-danger" id="btn-confirm-action">ya</button>
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



        $('#tambah_paket').on('submit', function(e) {
            e.preventDefault();

            // Ambil nilai tanpa karakter selain angka
            let angkaBersih = $('#jumlah_uang').val().replace(/[^,\d]/g, "");
            let judul = $('#judul').val();
            let deskripsi = $('#deskripsi').val();
            if (angkaBersih === ''|| angkaBersih < 1) {
                // alert('Angka kosong');
                $('#rfidErrorModalLabel').text('Gagal');
                $('#rfidErrorMessage').text('Jumlah Harga kosong');
                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                return;
            }

            let jumlah = angkaBersih;

            // Kirim data jumlah dan RFID melalui AJAX
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_tambah_paket' }}", // Ganti dengan URL tujuan
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                data: { harga: jumlah, judul: judul, deskripsi:deskripsi },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                    $('#judul').val('');
                    $('#jumlah_uang').val('');
                    $('#deskripsi').val('');
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
                "url": "{{ env('APP_URL').'/ajax_get_paket' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "judul" },
                // { "data": "harga" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return formatRupiah(row.harga);
                    }
                },
                { "data": "deskripsi" },
                { "data": "input_time" },
                {
                    "data": null,
                    "render": function(data, type, row) {


                        if(row.status == 'y'){
                            aktif=`<button class="btn btn-danger btn-nonaktif" data-id="${row.id_paket}">
                                    <i class="fas fa-times-circle"></i> Nonaktifkan
                            </button>`;
                        }else{
                            aktif=`<button class="btn btn-info btn-aktifkan" data-id="${row.id_paket}">
                                    <i class="fas fa-check-circle"></i> Aktifkan
                            </button>`;
                        }

                        return '<button class="btn btn-danger btn-hapus" data-id="' + row.id_paket + '">' +
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
    let idToDelete;
    let idToNonaktifkan;
    let idToAktifkan;

    // Event listener untuk tombol hapus
    $('#tabel1').on('click', '.btn-hapus', function() {
        idToDelete = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi Hapus')
        $('#modalHapusIsi').text('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-nonaktif', function() {
        idToNonaktifkan = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi')
        $('#modalHapusIsi').text('Paket ini akan dinonaktifkan dan tidak bisa diakses')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    $('#tabel1').on('click', '.btn-aktifkan', function() {
        idToAktifkan = $(this).data('id'); // Mendapatkan ID dari atribut data-id
        // console.log(idToDelete)
        $('#modalHapusLabel').text('Konfirmasi')
        $('#modalHapusIsi').text('Paket ini akan diaktifkan dan bisa diakses')
        $('#modalHapus').modal('show'); // Menampilkan modal
    });

    // Event listener untuk tombol konfirmasi hapus di modal
    $('#btn-confirm-action').on('click', function() {
        // Kirim permintaan AJAX untuk menghapus data
        if(idToDelete != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_paket' }}/hapus/" + idToDelete, // Ganti dengan URL endpoint hapus
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
            idToDelete=null;

        }else if(idToAktifkan != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_paket' }}/aktifkan/" + idToAktifkan, // Ganti dengan URL endpoint hapus
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
            idToAktifkan=null;

        }else if(idToNonaktifkan != null){
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_ubah_paket' }}/nonaktifkan/" + idToNonaktifkan, // Ganti dengan URL endpoint hapus
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
            idToNonaktifkan=null;

        }

        // Menutup modal setelah menghapus
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
