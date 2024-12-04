
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

<script>
    $(document).ready(function() {
        $('#daftar_barang').select2({
            placeholder: "Pilih data",
            ajax: {
                url: '{{ env('APP_URL').'/ajax_get_barang' }}', // Ganti dengan URL endpoint Anda
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                // type: 'GET',
                dataType: 'json',
                delay: 250, // Penundaan sebelum request
                data: function(params) {
                    return {
                        q: params.term // Mengirimkan teks pencarian ke controller
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });


        $('#barang_keluar').on('submit', function(e) {
            e.preventDefault();

            // Ambil nilai tanpa karakter selain angka
            let banyak = $('#banyak').val();
            let daftar_barang = $('#daftar_barang').val();
            let ket = $('#ket').val();
            if (banyak === ''|| banyak < 1) {
                // alert('Angka kosong');
                $('#rfidErrorModalLabel').text('Gagal');
                $('#rfidErrorMessage').text('Jumlah kosong');
                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                return;
            }

            if(daftar_barang === ''){
                $('#rfidErrorModalLabel').text('Gagal');
                $('#rfidErrorMessage').text('barang kosong');
                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                return;
            }

            // Kirim data jumlah dan RFID melalui AJAX
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_barang_keluar' }}", // Ganti dengan URL tujuan
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                data: { banyak: banyak, barang: daftar_barang, ket:ket },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                    $('#banyak').val('');
                    $('#daftar_barang').val(null).trigger('change');;
                    $('#ket').val('');
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
                "url": "{{ env('APP_URL').'/ajax_get_barang_keluar' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "nama" },
                { "data": "banyak" },
                { "data": "stok" },
                { "data": "ket" },
                // { "data": "input_time" },
                {
                    "data": "input_time",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            return moment(data).format("DD-MM-YYYY HH:mm:ss"); // Format tanggal untuk ditampilkan
                        }
                        return moment(data).format("YYYY-MM-DD HH:mm:ss"); // Format tanggal untuk sorting
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-danger btn-hapus" data-id="' + row.id + '">' +
                                '<i class="fas fa-trash"></i> Hapus</button>';
                    }
                }
            ],
            "order": [[4, "desc"]],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

    });


    $('#btn-cancel-hapus').on('click', function() {
        $('#modalHapus').modal('hide'); // Menutup modal secara manual
    });

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
            url: "{{ env('APP_URL').'/ajax_hapus_barang_keluar' }}/" + idToDelete, // Ganti dengan URL endpoint hapus
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
