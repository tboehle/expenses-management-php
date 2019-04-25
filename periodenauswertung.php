<?php
session_start();
if (empty($_SESSION['id']) AND empty($_SESSION['email']) OR $_SESSION['logged_in'] == false)
{
    header("location: index.php");
}
include "htmlHelfer.php";

htmlanfang("Periodenauswertungseite");
include "navigation.php";

echo "<h1>Periodenauswertung</h1>";
$intervalle = array(1 => "jährlich",
                    2 => "monatlich",
                    3 => "täglich");

if (isset($_POST['auswerten']) AND $_POST['auswerten'] == "Auswerten")
{
    formverarbeiten();
}
else
{
    formausgeben();
}

function formausgeben($intervall = "monatlich", $firstDate = "", $secondDate = "", $fehler = "")
{
    global $intervalle;
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
            <label for="intervall">Intervall</label>
                <select name="intervall" id="intervall">
                    <?php
                    foreach ($intervalle as $option => $value) {
                        // Wenn der gewählte Kategoriewert gleich dem übergebenen Parameter $kategorie entspricht,
                        // dann wähle selected
                        if ($value == $intervall)
                        {
                            $gew = "selected";
                        } // Wenn keine Übereinstimmung übernehme ich nichts
                        else
                        {
                            $gew = "";
                        }
                        echo "<option value='$value' $gew>$value</option>";
                    }
                    ?>
                </select>
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
    global $line_chart_data;
    global $intervalle;
    include "datumcheck.php";
    $fehler = "";

    // Setzen der Felder
    if (!empty($_POST['intervall']))
    {
        $intervall = htmlspecialchars($_POST['intervall']);
    }
    else
    {
        $intervall = "";
    }
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

    // Validieren der Ergebnisse
    if (empty($intervall))
    {
        $fehler .= "Bitte geben Sie ein Intervall an<br>\n";
    }
    elseif (!in_array($intervall, $intervalle))
    {
        $fehler .= "Bitte geben Sie ein Intervall an, dass valide ist und zur Auswahl steht<br>\n";
    }
    if (empty($firstDate))
    {
        $fehler .= "Bitte wählen Sie das erste Datum aus<br>\n";
    }
    elseif (!check_date_time($firstDate,"Ymd", "-"))
    {
        $fehler .= "Bitte wählen Sie das erste Datum im Format Ymd aus, es darf höchstens heute sein<br>\n";
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
        formausgeben($intervall, $firstDate, $secondDate, $fehler);
    }
    else
    {
        formausgeben($intervall, $firstDate, $secondDate);
        $line_chart_data = array();
        $userid = $_SESSION['id'];
        //$null = "2015";
        // $line_chart_data [] = array((string) $null, 0, 0);
        // include "data_column_kategorienauswertung.php";
        // include "db_verbinden.php";
        $mysqli = new mysqli("localhost", "root", "", "haushaltsdaten2");
        if ($mysqli->connect_error) {
            echo "Fehler beim Verbindungsaufbau: " . mysqli_connect_error();
            exit();
        }
        if (!$mysqli->set_charset("utf8")) {
            echo "Fehler beim Laden von UTF-8" . $mysqli->error;
        }

        if ($intervall == "monatlich")
        {
            $unteresDate = substr($firstDate, 0, 7);
            $oberesDate = substr($secondDate, 0, 7);
            // Ausgaben Query pro Monat
            $query1 = "SELECT month_key, SUM(betrag)FROM period_month_aus_v WHERE month_key BETWEEN ? AND ? AND (user = ? OR user IS NULL) GROUP BY month_key";
            if ($stmt1 = $mysqli->prepare($query1))
            {
                $stmt1->bind_param('ssi', $unteresDate, $oberesDate, $userid);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($month, $ausgabe);
                $kummulierteAusgaben = 0;
                $kummulierteEinnahmen = 0;
                while ($stmt1->fetch())
                {
                    if (is_null($month))
                    {
                        continue;
                    }
                    if (is_null($ausgabe))
                    {
                        $ausgabe = 0;
                    }
                    else
                    {
                        $kummulierteAusgaben += $ausgabe;
                    }
                    // $line_chart_data_aus [] = array("$month", $kummulierteAusgaben);
                    $query2 = "SELECT month_key, SUM(betrag) FROM period_month_ein_v WHERE month_key = ? AND (user = ? OR user IS NULL) GROUP BY month_key";
                    if ($stmt2 = $mysqli->prepare($query2))
                    {
                        $stmt2->bind_param('si', $month, $userid);
                        $stmt2->execute();
                        $stmt2->store_result();
                        $stmt2->bind_result($zeit, $einnahmen);
                        while ($stmt2->fetch())
                        {
                            if (is_null($einnahmen))
                            {
                                $einnahmen = 0;
                            }
                            else
                            {
                                $kummulierteEinnahmen += $einnahmen;
                            }
                            $line_chart_data [] = array($month, $kummulierteAusgaben, $kummulierteEinnahmen);
                        }
                    }
                }
                // print_r(json_encode($line_chart_data));
                echo "<br>";
                $stmt2->close();
                $line_chart_data = json_encode($line_chart_data);
                $stmt1->close();
            }
            $mysqli->close();
        }
        elseif ($intervall == "täglich")
        {
            $unteresDate = $firstDate;
            $oberesDate = $secondDate;
            // Ausgaben Query pro Monat
            $query1 = "SELECT day_key, SUM(betrag) FROM period_day_aus_v WHERE day_key BETWEEN ? AND ? AND (user = ? OR user IS NULL) GROUP BY day_key";
            if ($stmt1 = $mysqli->prepare($query1))
            {
                $stmt1->bind_param('ssi', $unteresDate, $oberesDate, $userid);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($day, $ausgabe);
                $kummulierteAusgaben = 0;
                $kummulierteEinnahmen = 0;
                while ($stmt1->fetch())
                {
                    if (is_null($day))
                    {
                        continue;
                    }
                    if (is_null($ausgabe))
                    {
                        $ausgabe = 0;
                    }
                    else
                    {
                        $kummulierteAusgaben += $ausgabe;
                    }
                    // $line_chart_data_aus [] = array("$month", $kummulierteAusgaben);
                    $query2 = "SELECT day_key, SUM(betrag) FROM period_day_ein_v WHERE day_key = ? AND (user = ? OR user IS NULL) GROUP BY day_key";
                    if ($stmt2 = $mysqli->prepare($query2))
                    {
                        $stmt2->bind_param('si', $day, $userid);
                        $stmt2->execute();
                        $stmt2->store_result();
                        $stmt2->bind_result($zeit, $einnahmen);
                        while ($stmt2->fetch())
                        {
                            if (is_null($einnahmen))
                            {
                                $einnahmen = 0;
                            }
                            else
                            {
                                $kummulierteEinnahmen += $einnahmen;
                            }
                            $line_chart_data [] = array($day, $kummulierteAusgaben, $kummulierteEinnahmen);
                        }
                    }
                }
                // print_r(json_encode($line_chart_data));
                echo "<br>";
                $stmt2->close();
                $line_chart_data = json_encode($line_chart_data);
                $stmt1->close();
            }
            $mysqli->close();
        }
        elseif ($intervall == "jährlich")
        {
            $unteresDate = substr($firstDate, 0, 4);
            $oberesDate = substr($secondDate, 0, 4);
            // Ausgaben Query pro Monat
            $query1 = "SELECT year, SUM(betrag) FROM period_year_aus_v WHERE year BETWEEN ? AND ? AND (user = ? OR user IS NULL) GROUP BY year";
            if ($stmt1 = $mysqli->prepare($query1))
            {
                $stmt1->bind_param('ssi', $unteresDate, $oberesDate, $userid);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($year, $ausgabe);
                $kummulierteAusgaben = 0;
                $kummulierteEinnahmen = 0;
                while ($stmt1->fetch())
                {
                    if (is_null($year))
                    {
                        continue;
                    }
                    if (is_null($ausgabe))
                    {
                        $ausgabe = 0;
                    }
                    else
                    {
                        $kummulierteAusgaben += $ausgabe;
                    }
                    // $line_chart_data_aus [] = array("$month", $kummulierteAusgaben);
                    $query2 = "SELECT year, SUM(betrag) FROM period_year_ein_v WHERE year = ? AND (user = ? OR user IS NULL) GROUP BY year";
                    if ($stmt2 = $mysqli->prepare($query2))
                    {
                        $stmt2->bind_param('si', $year, $userid);
                        $stmt2->execute();
                        $stmt2->store_result();
                        $stmt2->bind_result($zeit, $einnahmen);
                        while ($stmt2->fetch())
                        {
                            if (is_null($einnahmen))
                            {
                                $einnahmen = 0;
                            }
                            else
                            {
                                $kummulierteEinnahmen += $einnahmen;
                            }
                            $line_chart_data [] = array((string) $year, $kummulierteAusgaben, $kummulierteEinnahmen);
                        }
                    }
                }
                // print_r(json_encode($line_chart_data));
                echo "<br>";
                $stmt2->close();
                $line_chart_data = json_encode($line_chart_data);
                $stmt1->close();
            }
            $mysqli->close();
        }
        if ($line_chart_data)
        {
            $HTML = <<<XYZ
            <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'line']});
            google.charts.setOnLoadCallback(drawBasic);

                function drawBasic() 
                {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Datum');
                    data.addColumn('number', 'Kummulierte Ausgaben in Euro');
                    data.addColumn('number', 'Kummulierte Einnahmen in Euro');
        
                    data.addRows
                    (
                        $line_chart_data
                    );
        
                    var options = {
                                    hAxis: {
                                                title: 'Time',
                                                viewWindow: {
                                                                min:0
                                                            }
                                           },
                                    vAxis: {
                                                title: 'Euro',
//                                                viewWindow: {
//                                                                min:0
//                                                            }
//                                                color: 'blue';
                                                    
                                           }
//                                  series: {
//                                                 1: {curveType: 'function'}
//                                           },
//                                   'colors':['#FA5858','#BCF5A9'],
//                                   'backgroundColor':'#F2F2F2'
                                   };
        
                    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        
                    chart.draw(data, options);
                }
                // for responsive design
                              $(window).resize(function()
                              {
                                drawBasic();
                              });
            </script>
XYZ;
            echo "<div id='chart_div' class='chart'></div>";
            echo $HTML;

        }
    }
}



htmlende();