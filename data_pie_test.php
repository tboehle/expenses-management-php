<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 04.05.2017
 * Time: 12:32
 */

$mysqli = new mysqli("localhost", "root", "", "data");
if ($mysqli->connect_error)
{
    echo "Fehler beim Verbindungsaufbau: " . mysqli_connect_error();
    exit();
}
if (!$mysqli->set_charset("utf8"))
{
    echo "Fehler beim Laden von UTF-8" . $mysqli->error();
}

// Query um an die daten zu kommen
$query = "SELECT playerid, score FROM data.players";

// Query ausführen
$qresult = $mysqli->query($query);

$results = array();

while ($res = $qresult->fetch_assoc())
{
    $results [] = $res;
}

// print_r($results);

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