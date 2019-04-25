
<?php
session_start();
if (empty($_SESSION['id']) AND empty($_SESSION['email']) OR $_SESSION['logged_in'] == false)
{
    header("location: index.php");
}
else
{
    $userid = $_SESSION['id'];
}

include "htmlHelfer.php";
htmlanfang("Kategorienauswertung");
include "navigation.php";
echo "<h1>Kategorienauswertung</h1>";

if (isset($_POST['auswerten']) AND $_POST['auswerten'] == "Auswerten")
{
    formverarbeiten();
}
else
{
    global $column_chart_data;
    formausgeben();
}

function formausgeben($firstDate = "", $secondDate = "", $fehler = "")
{
    if (empty($fehler))
    {
        echo "<p>Bitte wählen Sie das Datum aus</p>";
    }
    else
    {
        echo "<p>Bitte Ihre Eingaben prüfen: <br>\n</p>";
    }
    ?>
    <div class="form-group">
    <form class = form-horizontal method="post" action='<?php $_SERVER['PHP_SELF']; ?>'>
        <label for="firstDate">Zeitraum von:</label>
        <input type="date" name="firstDate" id="firstDate" value="<?php echo $firstDate; ?>">
        <label for="secondDate">Zeitraum bis:</label>
        <input type="date" name="secondDate" id="secondDate" value="<?php echo $secondDate; ?>">
        <label for="auswerten">
        <input type="submit" name="auswerten" id="auswerten" value="Auswerten">
    </form>
    </div>
    <?php
}

function formverarbeiten()
{
    global $column_chart_data;
    include "datumcheck.php";
    $fehler = "";

    if (!empty($_POST['firstDate']))
    {
        $firstDate = htmlspecialchars($_POST['firstDate']);
    }
    else
    {
        $firstDate = "";
    }
    if (!empty($_POST['firstDate']))
    {
        $secondDate = htmlspecialchars($_POST['secondDate']);
    }
    else
    {
        $secondDate = "";
    }

    if (empty($firstDate))
    {
        $fehler .= "Bitte wählen Sie das erste Datum aus<br>\n";
    }
    elseif (!check_date_time($firstDate,"Ymd", "-"))
    {
        $fehler .= "Bitte wählen Sie das erste Datum im Format Ymd aus<br>\n";
    }
    if (empty($secondDate))
    {
        $fehler .= "Bitte wählen Sie das zweite Datum aus<br>\n";
    }
    elseif (!check_date_time($secondDate,"Ymd", "-"))
    {
        $fehler .= "Bitte wählen Sie das zweite Datum im Format Ymd aus und höchstens den heutigen Tag<br>\n";
    }
    if (!check_dates_difference($firstDate, $secondDate, "Ymd", "-"))
    {
        $fehler .= "Das zweite Datum muss größer als das erste Datum sein<br>\n";
    }

    if (strlen($fehler) > 0)
    {
        formausgeben($firstDate, $secondDate, $fehler);
    }
    else
    {
        formausgeben($firstDate, $secondDate);
        // include "data_column_kategorienauswertung.php";
        // include "db_verbinden.php";
        $mysqli = new mysqli("localhost", "root", "", "haushaltsdaten2");
        if ($mysqli->connect_error)
        {
            echo "Fehler beim Verbindungsaufbau: " . mysqli_connect_error();
            exit();
        }
        if (!$mysqli->set_charset("utf8"))
        {
            echo "Fehler beim Laden von UTF-8" . $mysqli->error;
        }

        $query = 'SELECT kategorie.name AS Kategorie, sum(transaktion.betrag) AS Auszahlung
                  FROM transaktion, kategorie
                  WHERE transaktion.kategorie= kategorie.id
                  AND kategorie.eingang=0
                  AND datum BETWEEN ? AND ?
                  AND transaktion.user = ?
                  GROUP BY kategorie.name';

      if ($stmt = $mysqli->prepare($query))
      {
          global $userid;
          $stmt->bind_param('ssi', $firstDate, $secondDate, $userid);
          $stmt->execute();

          $stmt->bind_result($kategorie, $auszahlung);

          $column_chart_data = array();

          while($zeile = $stmt->fetch())
          {
              $column_chart_data[] = array($kategorie, (int) $auszahlung);
          }

          // print json_encode($column_chart_data);
          $column_chart_data = json_encode($column_chart_data);

          $stmt->close();
          $mysqli->close();


          $HTML = <<<XYZ
            <script type="text/javascript">
                           google.charts.load('current', {packages: ['corechart', 'bar']});
                           google.charts.setOnLoadCallback(drawBasic);
                    
                           function drawBasic() 
                           {
                               // Ich hole mir die Daten per eingebundenen Jason Format
                               var data = new google.visualization.DataTable();
                               data.addColumn('string', 'Kategorie');
                               data.addColumn('number', 'Ausgaben in Euro');
                   
                               data.addRows($column_chart_data);
                   
                               var options = {
                                   title: 'Ihre Ausgaben pro Kategorie in Euro',
                                   hAxis: {
                                   title: 'Kategorien'
                                         },
                                   vAxis: {
                                   title: 'Ausgaben in Euro'
                                   },
                                   
                                   legend: 'none',
                                   'colors':['#FA5858','#BCF5A9'],
                                   'backgroundColor':'#F2F2F2',
                                   'height': '450',
                               };
                   
                               var chart = new google.visualization.ColumnChart(
                                   document.getElementById('column_div'));
                   
                               chart.draw(data, options);
                           }
                          
                          // for responsive design
                          $(window).resize(function(){
                            drawBasic();
                            });
                        </script>      
XYZ;
          echo $HTML;
          echo "<div class='chart' id='column_div'></div>";
      }


    }
}

htmlende();