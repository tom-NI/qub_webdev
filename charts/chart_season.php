<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawSeasonChart);

    function drawSeasonChart() {
        // Create the data table.
        var data = google.visualization.arrayToDataTable(<?php print_r(json_encode($finalSortedGraphArray)); ?>);

        // Set chart options
        var options = {
            colors: ['#FF6347'],
            legend: { position: 'bottom', textStyle: {bold: true}},
            fontSize: 18,
            width: 800,
            height: 1100,
            chartArea: {left: 250, top:25, 'width': '70%', 'height': '90%'},
            series: {
                0: {targetAxisIndex: 0},
            },
            titleTextStyle : {fontSize: 24, bold: true },
            vAxes: {
                // Adds titles to each axis.
                0: {title: 'Club Name'},
            }
        };

        // Instantiate and draw our chart, passing in some options.
        var seasonChart = new google.visualization.BarChart(document.getElementById('season_analysis_chart'));
        seasonChart.draw(data, options);
    }
</script>