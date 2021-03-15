<!-- google charts statistic graph -->
<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawStatisticChart);

    function drawStatisticChart() {
        // Create the data table.
        var data = google.visualization.arrayToDataTable(<?php print_r(json_encode($mainStatGraphData)); ?>);

        // set chart annotations on the bar (gets the data from the chart data array)
        var dataView = new google.visualization.DataView(data);
        dataView.setColumns([0, 
                        1, { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" }, 
                        2, { calc: "stringify",
                            sourceColumn: 2,
                            type: "string",
                            role: "annotation" } ]);

        // Set chart options
        var options = {
            colors: ['#48c774', '#FF6347'],
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
            fontSize: 16,
            width: 800,
            height: 500,
            chartArea: {left: 75, top:40, 'width': '70%', 'height': '75%'},
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
        columnChart.draw(dataView, options);
    }
</script>