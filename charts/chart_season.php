<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawSeasonChart);

    function drawSeasonChart() {
        // Create the data table.
        var data = google.visualization.arrayToDataTable(<?php print_r(json_encode($finalSortedGraphArray)); ?>);

        // set chart annotations on the bar (gets the data from the chart data array)
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, 
                        { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" }]);

        // Set chart display options
        var options = {
            colors: ['#FF6347'],
            legend: { position: 'bottom', textStyle: {bold: true}},
            annotations: {
                textStyle: {
                    fontName: 'Arial',
                    fontSize: 16,
                    color: '#ffffff',
                    bold: false,
                    italic: false,
                    auraColor: '#ffffff',
                    opacity: 1
                }
            },
            fontSize: 18,
            width: 800,
            height: 1100,
            chartArea: {left: 250, top:25, 'width': '70%', 'height': '90%'},
            series: {
                0: {targetAxisIndex: 0},
            },
            titleTextStyle : {fontSize: 24, bold: true },
            vAxes: {
                // Add titles to each axis.
                0: {title: 'Club Name'},
            }
        };

        // Instantiate and draw chart
        var seasonChart = new google.visualization.BarChart(document.getElementById('season_analysis_chart'));
        seasonChart.draw(view, options);
    }
</script>