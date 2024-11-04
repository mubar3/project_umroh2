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
            $('#' + name).append('<option>==Pilih Salah Satu==</option>');
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
    });
</script>
