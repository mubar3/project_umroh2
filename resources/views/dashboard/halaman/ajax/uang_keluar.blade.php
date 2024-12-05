
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
    let filter_start=moment().format('YYYY-MM-DD');
    let filter_end=moment().format('YYYY-MM-DD');
    console.log(filter_end);

    $(document).ready(function() {
        $('input[name="dates"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'  // Format tanggal yang digunakan
            },
            startDate: moment(), // Set tanggal mulai ke hari ini
            endDate: moment()    // Set tanggal akhir ke hari ini
        });

        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            // Ambil nilai start_date dan end_date
            filter_start = picker.startDate.format('YYYY-MM-DD');
            filter_end = picker.endDate.format('YYYY-MM-DD');

            // Reload DataTable dengan parameter baru
            $('#tabel1').DataTable().ajax.reload();
        });

        $('#jumlah_uang').on('input', function() {
            let angka = $(this).val().replace(/[^,\d]/g, ""); // Hanya angka
            let rupiah = formatRupiah(angka);
            $(this).val(rupiah);
        });



        $('#uang_keluar').on('submit', function(e) {
            e.preventDefault();

            // Ambil nilai tanpa karakter selain angka
            let angkaBersih = $('#jumlah_uang').val().replace(/[^,\d]/g, "");
            let kategori = $('#kategori').val();
            let ket = $('#ket').val();
            let bank = $('#bank').val();
            if (angkaBersih === ''|| angkaBersih < 1) {
                // alert('Angka kosong');
                $('#rfidErrorModalLabel').text('Gagal');
                $('#rfidErrorMessage').text('Jumlah uang kosong');
                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                return;
            }

            if(kategori === ''){
                $('#rfidErrorModalLabel').text('Gagal');
                $('#rfidErrorMessage').text('Kategori kosong');
                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                return;
            }

            let jumlah = angkaBersih;

            // Kirim data jumlah dan RFID melalui AJAX
            $.ajax({
                url: "{{ env('APP_URL').'/ajax_uang_keluar' }}", // Ganti dengan URL tujuan
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                data: { jumlah: jumlah, kategori: kategori, ket:ket, bank:bank },
                success: function(response) {
                    $('#tabel1').DataTable().ajax.reload();
                    $('#rfidErrorModalLabel').text('Berhasil');
                    $('#rfidErrorMessage').text(response.message);
                    $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                    $('#kategori').val('');
                    $('#jumlah_uang').val('');
                    $('#ket').val('');
                    $('#bank').val('');
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
                "url": "{{ env('APP_URL').'/ajax_get_uang_keluar' }}", // Ganti dengan URL API Anda
                "type": "GET",
                "data": function(d) {
                    // Tambahkan start_date dan end_date ke parameter AJAX
                    d.start_date = filter_start;
                    d.end_date = filter_end;
                },
                "headers": {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                "dataSrc": "" // Menggunakan data langsung dari respons
            },
            "columns": [
                { "data": "kategori" },
                // { "data": "jumlah" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        // return formatRupiah(row.jumlah);
                        if (type === 'display') {
                            return formatRupiah(row.jumlah); // Memanggil fungsi formatRupiah
                        }
                        return row.jumlah;
                    }
                },
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
                { "data": "nama_bank" },
                {
                    "data": null,
                    "className": "no-export", // Tambahkan kelas ini untuk kolom action
                    "render": function(data, type, row) {
                        return '<button class="btn btn-danger btn-hapus" data-id="' + row.id + '">' +
                                '<i class="fas fa-trash"></i> Hapus</button>';
                    }
                }
            ],
            "order": [[3, "desc"]],
            dom: 'Bfrtip', // Tambahkan dom untuk mengaktifkan tombol
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export ke Excel', // Ubah nama tombol di sini
                    filename: 'Uang_keluar('+filter_start+'_'+filter_end+')',
                    // filename: function() {
                    //     const today = new Date();
                    //     const formattedDate = today.toISOString().slice(0, 10); // Format: YYYY-MM-DD
                    //     return 'Data_Uang_keluar_' + formattedDate; // Tambahkan tanggal ke nama file
                    // },
                    title: 'Data Export',
                    exportOptions: {
                        columns: ':not(.no-export)', // Kecualikan kolom dengan kelas no-export
                        orthogonal: 'export' // Gunakan format "export" untuk gambar
                    }
                }
            ]
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
            url: "{{ env('APP_URL').'/ajax_hapus_uang_keluar' }}/" + idToDelete, // Ganti dengan URL endpoint hapus
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
