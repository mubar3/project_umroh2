<script>
    $(function () {

        $("#tabel1").DataTable({
            "responsive": true,
            "lengthChange": false,
            // "responsive": true,
            // "scrollX": true,
            "autoWidth": false,
            "ajax": {
                "url": "{{ env('APP_URL').'/ajax_get_user/'.Auth::user()->id }}", // Ganti dengan URL API Anda
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
                // {
                //     "data": null,
                //     "render": function(data, type, row) {
                //         return '<button class="btn btn-danger btn-hapus" data-id="' + row.id_anggota + '">' +
                //                 '<i class="fas fa-trash"></i> Hapus</button>';
                //     }
                // }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });

    });
  </script>
