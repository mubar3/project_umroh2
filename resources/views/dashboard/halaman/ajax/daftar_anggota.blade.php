
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
                // { "data": "foto" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<img width="60" src="'+row.foto+'">';
                    }
                },
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
                { "data": "email" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <a href="{{ url('/data_anggota') }}/${row.id_anggota}" target="_blank" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <button type="button" class="btn btn-primary btn-edit" data-id='${row.id_anggota}'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-hapus" data-id="${row.id_anggota}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

    });

    function onChangeSelect(url, id, name,selected) {
        // send ajax request to get the cities of the selected province and append to the select tag
        $.ajax({
            url: url,
            type: 'GET',
            data: {
            id: id
            },
            success: function (data) {
            $('#' + name).empty();
            $('#' + name).append('<option>==Pilih Salah Satu==</option>');
            $.each(data, function (key, value) {
                if(key == selected){
                    $('#' + name).append('<option value="' + key + '" selected>' + value + '</option>');
                }else{
                    $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                }
            });
            }
        });
    }

    $(function () {
        $('#provinsi').on('change', function () {
            onChangeSelect('{{ env('APP_URL').'/cities' }}', $(this).val(), 'kota');
        });
        $('#kota').on('change', function () {
            onChangeSelect('{{ env('APP_URL').'/districts' }}', $(this).val(), 'kecamatan');
        })
        $('#kecamatan').on('change', function () {
            onChangeSelect('{{ env('APP_URL').'/villages' }}', $(this).val(), 'desa');
        })
    });


    $(document).on('click', '.btn-edit', function() {

        // Kirim permintaan AJAX
        $.ajax({
            url: "{{ env('APP_URL').'/ajax_data_jamaah' }}/"+$(this).data('id'),
            type: 'get', // Atau 'POST' sesuai kebutuhan
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    // Tampilkan data di modal atau elemen lainnya untuk diedit
                    // console.log(response.data);
                    // Contoh menampilkan data di form modal
                    $('#jenis_akun').val(response.data.jenis_akun);
                    $('#anggota').val(response.data.id_anggota);
                    $('#nama').val(response.data.nama);
                    $('#tanggal_mendaftar').val(response.data.tanggal_mendaftar);
                    $('#jenis_kelamin').val(response.data.jenis_kelamin);
                    $('#provinsi').val(response.data.provinsi);
                    onChangeSelect('{{ env('APP_URL').'/cities' }}', $('#provinsi').val(), 'kota',response.data.kota);
                    onChangeSelect('{{ env('APP_URL').'/districts' }}', response.data.kota, 'kecamatan',response.data.kecamatan);
                    onChangeSelect('{{ env('APP_URL').'/villages' }}', response.data.kecamatan, 'desa',response.data.desa);
                    $('#alamat').val(response.data.alamat);
                    $('#tempat_lahir').val(response.data.tempat_lahir);
                    $('#tanggal_lahir').val(response.data.tanggal_lahir);
                    $('#nomor').val(response.data.nomor);
                    $('#paket').val(response.data.paket);
                    $('#bank').val(response.data.bank);
                    $('#nama_rekening').val(response.data.nama_rekening);
                    $('#nomor_rekening').val(response.data.nomor_rekening);

                    if(response.data.jenis_akun == 'jamaah'){
                        $("#data-koordinator").show();
                        $("#data-paket").show();
                        $("#data-bank").hide();
                    }else{
                        $("#data-bank").show();
                        $("#data-paket").hide();
                        $("#data-koordinator").hide();
                    }


                    $('#editModal').modal('show');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat mengambil data.'+xhr.responseText);
            }
        });

        // Tampilkan modal
        $('#modalEdit').modal('show');
    });



  </script>

  <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Data Anggota</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">

                    <form id="formEdit" method="POST" enctype="multipart/form-data">
                    {{-- <form action="{{ url('/edit_jamaah') }}" method="post" enctype="multipart/form-data"> --}}
                            <input type="hidden" id="anggota" name="id_anggota">
                            <input type="hidden" id="jenis_akun" name="jenis_akun">
                            {{-- <input id="id_anggota" type="text" class="form-control" name="id_anggota"> --}}
                        {{-- <div class="col-md-6"> --}}
                            {{-- @csrf --}}
                            <div class="form-group" id="data-koordinator">
                                <label>Koordinator  <span class="right badge badge-secondary">Diisi ketika ganti koordinator</span></label>
                                <select name="koordinator" class="form-control select-koordinator" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal mendaftar  <span class="right badge badge-success">wajib</span></label>
                                <input name="tanggal" id='tanggal_mendaftar' type="date" class="form-control" placeholder="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label>Nama  <span class="right badge badge-success">wajib</span></label>
                                <input name="nama" type="text" class="form-control" id="nama" placeholder="nama" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis kelamin  <span class="right badge badge-success">wajib</span></label>
                                <select name="kelamin" id="jenis_kelamin" class="form-control" style="width: 100%;" required>
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
                                    <option>==Pilih Salah Satu==</option>
                                    @foreach ($provinces as $item)
                                        <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" for="kota">
                                <label>Kabupaten / Kota  <span class="right badge badge-success">wajib</span></label>
                                <select class="form-control" name="kota" id="kota" required>
                                    <option>==Pilih Salah Satu==</option>
                                </select>
                            </div>
                            <div class="form-group" for="kecamatan">
                                <label>Kecamatan  <span class="right badge badge-success">wajib</span></label>
                                <select class="form-control" name="kecamatan" id="kecamatan" required>
                                    <option>==Pilih Salah Satu==</option>
                                </select>
                            </div>
                            <div class="form-group" for="desa">
                                <label>Desa  <span class="right badge badge-success">wajib</span></label>
                                <select class="form-control" name="desa" id="desa" required>
                                    <option>==Pilih Salah Satu==</option>
                                </select>
                            </div>

                            <div class="form-group" >
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat">
                                </textarea>
                            </div>
                        {{-- </div>
                        <div class="col-md-6"> --}}
                            <div class="form-group">
                                <label>Tempat lahir  <span class="right badge badge-success">wajib</span></label>
                                <input name="tempat_lahir" id='tempat_lahir' type="text" class="form-control" placeholder="tempat lahir" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal lahir  <span class="right badge badge-success">wajib</span></label>
                                <input name="tanggal_lahir" id="tanggal_lahir" type="date" class="form-control" placeholder="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label>Nomor Whatsapp / Nomor telfon  <span class="right badge badge-success">wajib</span></label>
                                <input name="nomor" id="nomor" type="number" class="form-control" placeholder="nomor" required>
                            </div>
                            <div class="form-group" id="data-paket">
                                <label>Paket  <span class="right badge badge-success">wajib</span></label>
                                <select name="paket" id="paket" class="form-control select2" style="width: 100%;" required>
                                    <option value="" disable selected>Daftar paket</option>
                                    @foreach ($paket as $daftar)
                                        <option value="{{ $daftar->id_paket }}">{{ $daftar->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="data-bank">
                                <div class="form-group">
                                    <label>Bank  <span class="right badge badge-success">wajib</span></label>
                                    <select class="form-control" id="bank" name="bank"required>
                                        <option value="" disable selected>==Pilih Salah Satu==</option>
                                        @foreach ($bank as $data_bank)
                                            <option value="{{ $data_bank->id}}"> {{ $data_bank->nama_bank }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Rekening atas nama  <span class="right badge badge-success">wajib</span></label>
                                    <input name="nama_rekening" id="nama_rekening" type="text" class="form-control" placeholder="nama rekening" required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor rekening  <span class="right badge badge-success">wajib</span></label>
                                    <input name="nomor_rekening" id="nomor_rekening" type="number" class="form-control" placeholder="nomor rekening" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>PasFoto <span class="right badge badge-secondary">Diisi ketika ganti foto</span></label>
                                <div class="custom-file">
                                    <input name="foto" type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Foto KTP <span class="right badge badge-secondary">Diisi ketika ganti foto ktp</span></label>
                                <div class="custom-file">
                                    <input name="ktp" type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>



                        {{-- </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modaledit-close">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEdit">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#modaledit-close').on('click', function() {
            $('#modalEdit').modal('hide'); // Menutup modal secara manual
        });

        $('#saveEdit').click(function() {
            // Submit data form dengan AJAX
            // var formData = $('#formEdit').serialize();
            var formData = new FormData($('#formEdit')[0]);

            $.ajax({
                url: "{{ env('APP_URL').'/ajax_update_anggota' }}", // Sesuaikan dengan URL update di server
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                },
                data: formData,
                contentType: false,  // Memberitahu jQuery untuk tidak mengatur contentType
                processData: false,  // Memberitahu jQuery untuk tidak memproses data
                success: function(response) {
                    // console.log(response)
                    // Tutup modal dan beri notifikasi
                    $('#modalEdit').modal('hide');
                    // alert('Data berhasil diupdate');
                    // Refresh tabel jika perlu
                    $('#tabel1').DataTable().ajax.reload();
                    $('#modalsuksesEdit').modal('show');
                    // alert(response.message);
                },
                error: function(xhr, status, error) {

                    $('#errorMessage').text(JSON.parse(xhr.responseText).message);
                    $('#modalgagalEdit').modal('show');
                    // console.log(xhr)
                    // alert('Terjadi kesalahan: ' + xhr.responseText);
                }
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

    <div class="modal fade" id="modalsuksesEdit" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">Data Berhasil diedit</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-berhasiledit">Tutup</button>
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

    <div class="modal fade" id="modalgagalEdit" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">Data Gagal Diupdate</h5>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p> <!-- Tempat untuk menampilkan pesan error -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-gagaledit">Tutup</button>
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
        });
        $('#btn-cancel-berhasiledit').on('click', function() {
            $('#modalsuksesEdit').modal('hide'); // Menutup modal secara manual
        });
        $('#btn-cancel-gagalhapus').on('click', function() {
            $('#modalgagalHapus').modal('hide'); // Menutup modal secara manual
        });
        $('#btn-cancel-gagaledit').on('click', function() {
            $('#modalgagalEdit').modal('hide'); // Menutup modal secara manual
        });

        $(document).ready(function() {

        // Inisialisasi Select2 di dalam modal saat modal ditampilkan
        // $('#modalEdit').on('shown.bs.modal', function () {
                // Hancurkan instance Select2 jika sudah ada
                // if ($('.select-koordinator').hasClass('select2-hidden-accessible')) {
                //     $('.select-koordinator').select2('destroy');
                // }

                // Inisialisasi Select2 dengan AJAX
                $('.select-koordinator').select2({
                    dropdownParent: $('#modalEdit'), // Pastikan dropdown muncul di atas modal
                    width: '100%',
                    placeholder: 'Cari koordinator...',
                    ajax: {
                        url: '{{ env('APP_URL').'/ajax_get_koordinator' }}', // Sesuaikan URL dengan route server Anda
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term // Mengirimkan teks pencarian ke server
                            };
                        },
                        processResults: function(data) {
                            // Sesuaikan format data sesuai dengan respons server
                            return {
                                results: data.items // Pastikan server mengembalikan array data dalam `data.items`
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2 // Panjang minimal input untuk trigger pencarian
                });
            });
        // });


    </script>

