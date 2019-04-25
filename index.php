<?php
session_start();
if (!empty($_SESSION['id']) AND !empty($_SESSION['email']) AND $_SESSION['logged_in'] == true)
{
    $userid = $_SESSION['id'];
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="bootstrap-3.3.7-dist/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="bootstrap-3.3.7-dist/css/style.css" rel="stylesheet">
            <link rel="stylesheet" href="layout.css">

            <title>Dashboard</title>
        </head>

        <body class="Dashboardseite">

        <?php
        include "navigation.php";
        ?>
        <div class="container">

            <h1 style="padding-top: 20px; padding-bottom: 10px">Willkommen in Ihren Finanzen</h1>

            <h2 style="padding-bottom: 20px">Holen Sie sich einen kleinen Überblick</h2>

        </div>
        <?php
        include "data_pie_dashboard.php";
        include "data_column_dashboard.php";
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
                                  function drawChart() 
                                  {
                            
                                      // Create the data table.
                                      var data = new google.visualization.DataTable();
                                      data.addColumn('string', 'Zahlungsart');
                                      data.addColumn('number', 'Betrag');
                                      data.addRows({$pie_chart_data});
                                
                                      // Set chart options
                                      var options = {'title':'Verhältnis von Auszahlung und Einzahlung in Euro',
                                                     is3D: true,
                                                     'colors':['#FA5858','#BCF5A9'],
                                                     'backgroundColor':'#F2F2F2'
                                                     };
                                
                                      // Instantiate and draw our chart, passing in some options.
                                      var chart = new google.visualization.PieChart(document.getElementById('pie_div'));
                                      chart.draw(data, options);
                                  }
                                  
                                   google.charts.load('current', {packages: ['corechart', 'bar']});
                                   google.charts.setOnLoadCallback(drawBasic);
                            
                                   function drawBasic() 
                                   {
                                       // Ich hole mir die Daten per eingebundenen Jason Format
                                       var data = new google.visualization.DataTable();
                                       data.addColumn('string', 'Kategorie');
                                       data.addColumn('number', 'Ausgaben in Euro');
                           
                                       data.addRows(/*[
                                           [ 'Ausgehen' , 20],
                                           [ 'Geschenke' , 30],
                                           [ 'Hobbies', 80],
                                           [ 'Elektronik', 200],
                                           [ 'Kleidung', 75],
                                           [ 'Büromaterial', 6],
                                           [ 'Miete', 100],
                                           [ 'Versicherung', 60],
                                           [ 'Sonstiges', 60],
                                       ]*/
                                       $column_chart_data
                                       );
                           
                                       var options = {
                                           is3D: true,
                                           title: 'Ihre Ausgaben pro Kategorie',
                                           hAxis: {
                                               title: 'Einzelkategorien'
                                                 },
                                           vAxis: {
                                               title: 'Ausgaben in Euro pro Kategorie'
                                           },
                                           legend: 'none',
                                           'colors':['#FA5858','#BCF5A9'],
                                           'backgroundColor':'#F2F2F2'
                                       };
                           
                                       var chart = new google.visualization.ColumnChart(
                                           document.getElementById('column_div'));
                           
                                       chart.draw(data, options);
                                   }
                                  
                                  // for responsive design
                                  $(window).resize(function(){
                                    drawChart();
                                    drawBasic();
                                    });
                                </script>
XYZ;
        echo $HTML;
        ?>

        <div class="container">
            <div id="pie_div" class="chart"></div>
            <div id="column_div" class="chart"></div>
        </div>


        <br>
        <div class="container" style="text-align: center">
            <a href="neue_transaktion.php" class="btn btn-success btn-lg" role="button">Transaktion</a>
            <a href="periodenauswertung.php" class="btn btn-success btn-lg" role="button">Periodenauswertung durchführung</a>
            <a href="kategorienauswertung.php" class="btn btn-success btn-lg" role="button">Kategorienauswertung durchführen</a>
            <br><br>
        </div>

        <script src="jquery/jquery-1.12.4.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <footer class="modal-footer">
            <div class="container">
                <p class="text-muted">&copy; by Team Overkill (auch bekannt als Teaminator)</p>
            </div>
        </footer>
        </body>
        </html>

<?php
}
else
{
    header("Location: loginindex.php");
}

