<script>


    $('.select-top_leader').select2({
            placeholder: 'Cari top_leader...',
            ajax: {
                url: '{{ env('APP_URL').'/ajax_get_top_leader' }}', // Sesuaikan URL sesuai route Anda
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
</script>
