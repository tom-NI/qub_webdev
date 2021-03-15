<!-- apex charts graph to show the one matches statistics in full -->
<!-- if linking, must include all dependencies in the head -->
<script>
    let matchStatChart = {
        colors: ['#48c774', '#FF6347'],
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            fontSize: '16px',
            fontFamily: 'Helvetica, Arial',
            fontWeight: 500,
            itemMargin: {
                horizontal: 30,
                vertical: 10
            },
            onItemHover: {
                highlightDataSeries: false,
            },
            onItemClick: {
                toggleDataSeries: false,
            },
        },
        series: [{
            name: <?php echo "'{$hometeam}'"; ?>,
            data: <?php print_r(json_encode($htStatsForGraph)); ?>
        }, {
            name: <?php echo "'{$awayteam}'"; ?>,
            data: <?php print_r(json_encode($atStatsForGraph)); ?>
        }],
        chart: {
            animations: {
                enabled: false, 
            }, 
            type: 'bar',
            height: 500,
            stacked: true,
            stackType: '100%',
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 2,
                left: 2,
                blur: 3,
                color: '#999',
                opacity: 0.4
            },
            fontFamily: 'Helvetica, Arial, sans-serif'
        },
        plotOptions: {
            bar: {
                horizontal: true,
            },
        },
        dataLabels: {
            enabled: true,
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: ["Half Time Goals", "Shots", "Shots on Target", "% Shots on Target", "Corners", "Fouls", "Yellow Cards", "Red Cards"],
            style: {
                fontSize: '16px',
            },
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        },
        fill: {
            opacity: 1
        },
    };

    var chart = new ApexCharts(document.querySelector("#match_stat_chart"), matchStatChart);
    chart.render();
</script>