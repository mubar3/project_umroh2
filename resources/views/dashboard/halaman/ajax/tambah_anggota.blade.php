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
</script>
