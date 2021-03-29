function drawStatPieChart(winsArray, idOfElementToFill, providedTitle) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {
    var data = google.visualization.arrayToDataTable(winsArray);

    var options = {
        reverseCategories : true,
        colors: ['#FF6347', '#48c774'],
        fontSize: 16,
        width: 260,
        height: 260,
        is3D: true,
        legend: 'none',
        title: providedTitle,
        titleTextStyle: { 
            color: '#000',
            fontName: "Arial",
            fontSize: 20,
            bold: true,
            italic: false
        },
        chartArea: {left: 0, top: 50, 'width': '100%', 'height': '100%'},
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
    };

    var chart = new google.visualization.PieChart(document.getElementById(idOfElementToFill));
    chart.draw(data, options);
    }
}