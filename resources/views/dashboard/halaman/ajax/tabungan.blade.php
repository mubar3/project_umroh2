<script>
    $(document).ready(function() {
        $('#rupiah_masuk').on('input', function() {
            let angka = $(this).val().replace(/[^,\d]/g, ""); // Hanya angka
            let rupiah = formatRupiah(angka);
            $(this).val(rupiah);
        });

        $('#uang_masuk').on('submit', function(e) {
            e.preventDefault();

            // Ambil nilai tanpa karakter selain angka
            let angkaBersih = $('#rupiah_masuk').val().replace(/[^,\d]/g, "");
            if (angkaBersih === '' || angkaBersih < 1) {
                // alert('Angka kosong');
                $('#rfidErrorModalLabel').text('Gagal');
                $('#rfidErrorMessage').text('Jumlah uang kosong');
                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                return;
            }

            let jumlah = angkaBersih;
            $('#rfidModal').modal('show');

            // Set fokus pada input RFID setelah modal benar-benar ditampilkan
            $('#rfidModal').on('shown.bs.modal', function () {
                    $('#rfidInput').focus();
            });

            // Tangkap input RFID hanya sekali saat modal pertama kali dibuka
            $('#rfidModal').one('shown.bs.modal', function () {
                $('#rfidInput').val(''); // Kosongkan input setiap kali modal ditampilkan

                // Tangkap input teks dari RFID secara dinamis
                $('#rfidInput').on('input', function() {
                    let rfid = $(this).val();

                    // Periksa jika panjang teks RFID sesuai, misalnya 4 karakter atau lebih
                    if (rfid.length >= 2) {
                        $('#rfidInput').val('');
                        $('#rfidModal').modal('hide'); // Tutup modal setelah input diterima

                        // alert(`RFID: ${rfid}`);

                        // Kirim data jumlah dan RFID melalui AJAX
                        $.ajax({
                            url: "{{ env('APP_URL').'/ajax_tambah_tabungan' }}", // Ganti dengan URL tujuan
                            type: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                            },
                            data: { jumlah: jumlah, rfid: rfid },
                            success: function(response) {
                                $('#uang_masuk')[0].reset();
                                $('#rfidErrorModalLabel').text('Berhasil');
                                $('#rfidErrorMessage').text(response.message);
                                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                            },
                            error: function(xhr, status, error) {
                                // $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                                $('#rfidErrorModalLabel').text('Gagal');
                                $('#rfidErrorMessage').text(JSON.parse(xhr.responseText).message);
                                $('#rfidErrorModal').modal('show');  // Tampilkan modal error
                            }
                        });

                        // Kosongkan input RFID setelah mengirim data untuk mencegah duplikasi
                        $(this).val('');
                    }
                });
            });

            // Kosongkan nilai input RFID ketika modal ditutup agar tidak terjadi duplikasi input
            $('#rfidModal').on('hidden.bs.modal', function () {
                $('#rfidInput').val('');
                $('#rfidInput').off('input'); // Lepaskan event handler untuk menghindari duplikasi
            });
        });

    });
</script>


<!-- Modal untuk tap RFID -->
<div class="modal fade" id="rfidModal" tabindex="-1" aria-labelledby="rfidModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rfidModalLabel">Tap RFID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silakan tap RFID USB Anda...
                <input type="text" id="rfidInput" class="form-control mt-3" placeholder="Scan RFID" autofocus>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


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

