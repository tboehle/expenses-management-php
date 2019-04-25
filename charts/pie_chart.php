<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 04.05.2017
 * Time: 11:54
 */

require "db_verbinden.php";

// Query um an die daten zu kommen
$query = "SELECT playerid, score FROM data.players";

// Query ausführen
$qresult = $mysqli->query($query);

$results = array();

while ($res = $qresult->fetch_assoc())
{
    $results [] = $res;
}

print_r($results);

echo "<br><br><br>";

$pie_chart_data = array();
foreach ($results as $result)
{
    $pie_chart_data[] = array($result['playerid'], (int) $result['score']);
}

// print json_encode($pie_chart_data);

$pie_chart_data = json_encode($pie_chart_data);
$qresult->close();
$mysqli->close();

$HTML = <<<XYZ
<!--Load the AJAX API-->
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'playerid');
      data.addColumn('number', 'score');
      data.addRows({$pie_chart_data});

      // Set chart options
      var options = {'title':'How the whole Game-score is divided to the playerid\'s ',
                     'width':600,
                     'height':600};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('pie_div'));
      chart.draw(data, options);
    }
    </script>
    <div id="pie_div">
    
    </div>

XYZ;

echo $HTML;

