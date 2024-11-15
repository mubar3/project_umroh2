<script>
    // var areaChartData = {
    //   labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //   datasets: [
    //     {
    //       label               : 'Jamaah total : 1004',
    //       backgroundColor     : 'rgba(60,141,188,0.9)',
    //       borderColor         : 'rgba(60,141,188,0.8)',
    //       pointRadius          : false,
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [28, 48, 40, 19, 86, 27, 90]
    //     },{
    //       label               : 'Koordinator total : 600',
    //       backgroundColor     : 'rgba(210, 214, 222, 1)',
    //       borderColor         : 'rgba(210, 214, 222, 1)',
    //       pointRadius         : false,
    //       pointColor          : 'rgba(210, 214, 222, 1)',
    //       pointStrokeColor    : '#c1c7d1',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(220,220,220,1)',
    //       data                : [28, 48, 40, 19, 86, 27, 1]
    //     },
    //   ]
    // }


    $.ajax({
        url: "{{ env('APP_URL').'/ajax_get_chart' }}",
        type: "GET",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            var areaChartData = response.chart;
            $('#jumlah_jamaah_user').text(response.jamaah_user);
            $('#total_jamaah').text(response.total_jamaah);
            $('#total_pemasukan').text(formatRupiah(response.total_pemasukan));

            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
            }

            new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
            })

            // console.log(areaChartData);
        },
        error: function(error) {
            // console.log('Error:', error);
        }
    });
</script>
