<script>

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
        $('.select-koordinator').select2({
            placeholder: 'Cari koordinator...',
            ajax: {
                url: '{{ env('APP_URL').'/ajax_get_koordinator' }}', // Sesuaikan URL sesuai route Anda
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                dataType: 'json',
                delay: 250,
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
        $('.select-leader').select2({
            placeholder: 'Cari leader...',
            ajax: {
                url: '{{ env('APP_URL').'/ajax_get_leader' }}', // Sesuaikan URL sesuai route Anda
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                dataType: 'json',
                delay: 250,
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
    })

    function onChangeSelect(url, id, name) {
        // send ajax request to get the cities of the selected province and append to the select tag
        $.ajax({
            url: url,
            type: 'GET',
            data: {
            id: id
            },
            success: function (data) {
            $('#' + name).empty();
            $('#' + name).append('<option value="" disable selected >==Pilih Salah Satu==</option>');
            $.each(data, function (key, value) {
                $('#' + name).append('<option value="' + key + '">' + value + '</option>');
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
        $('#provinsi2').on('change', function () {
            onChangeSelect('{{ env('APP_URL').'/cities' }}', $(this).val(), 'kota2');
        });
        $('#kota2').on('change', function () {
            onChangeSelect('{{ env('APP_URL').'/districts' }}', $(this).val(), 'kecamatan2');
        })
        $('#kecamatan2').on('change', function () {
            onChangeSelect('{{ env('APP_URL').'/villages' }}', $(this).val(), 'desa2');
        })
    });

    // Mendapatkan elemen input tanggal
    if (document.getElementById('tanggal_hari_ini')) {
        document.getElementById('tanggal_hari_ini').value = new Date().toISOString().split('T')[0];
    }
    if (document.getElementById('tanggal_hari_ini2')) {
        document.getElementById('tanggal_hari_ini2').value = new Date().toISOString().split('T')[0];
    }

</script>
