<!-- google charts statistic graph -->
<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawStatisticChart);

    function drawStatisticChart() {
        // Create the data table.
        var data = google.visualization.arrayToDataTable(<?php print_r(json_encode($mainStatGraphData)); ?>);

        // Set chart options
        var options = {
            colors: ['#48c774', '#FF6347'],
            legend: { position: 'bottom', textStyle: {bold: true}},
            fontSize: 16,
            width: 700,
            height: 600,
            series: {
                0: {targetAxisIndex: 0},
            },
            titleTextStyle : {fontSize: 24, bold: true },
            vAxes: {
                // Adds titles to each axis.
                0: {title: 'Total'},
            }
        };

        // Instantiate and draw our chart, passing in some options.
        var columnChart = new google.visualization.ColumnChart(document.getElementById('former_fixtures_chart'));
        columnChart.draw(data, options);
    }
</script>