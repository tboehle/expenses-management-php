/**
 * Created by thorb on 04.05.2017.
 */
// Versuch mit Ajax die Daten zu holen und das Pie Chart auszulagern


// Load the Visualization API and the piechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

function drawChart()
{
    var jsonData = $.ajax({
        url: "data_pie_dashboard.php",
        dataType: "json",
        async: false
    }).responseText;

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Instantiate and draw our chart, passing in some options.

    // Set chart options
    var options = {'title':'Test',
        'width':400,
        'height':300
    };
    var chart = new google.visualization.PieChart(document.getElementById('pie_div_ausgelagert'));

    //chart.draw(data, {width: 400, height: 240});
    chart.draw(data, options);

}



