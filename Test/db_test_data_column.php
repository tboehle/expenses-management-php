<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 08.05.2017
 * Time: 15:31
 */

$firstDate = "2016-09-14";
$secondDate = "2017-05-08";


$mysqli = new mysqli("localhost", "root", "", "haushaltsdaten");
if ($mysqli->connect_error)
{
    echo "Fehler beim Verbindungsaufbau: " . mysqli_connect_error();
    exit();
}
if (!$mysqli->set_charset("utf8"))
{
    echo "Fehler beim Laden von UTF-8" . $mysqli->error();
}

$query = "SELECT kategorie.name AS Kategorie, sum(transaktion.betrag) AS Auszahlung
          FROM transaktion, kategorie
          WHERE transaktion.kategorie= kategorie.id
          AND kategorie.eingang=0
          AND datum BETWEEN ? AND ?
          GROUP BY kategorie.name";

echo $query . "<br>\n";

if ($stmt = $mysqli->prepare($query))
{
    $stmt->bind_param('ss', $firstDate, $secondDate);
    echo $query;
    $stmt->execute();

    $stmt->bind_result($kategorie, $auszahlung);

    $column_chart_data = array();

    while($zeile = $stmt->fetch())
    {
        $column_chart_data[] = array($kategorie, (int) $auszahlung);
    }

    print json_encode($column_chart_data);
    $column_chart_data = json_encode($column_chart_data);

    $stmt->close();
    $mysqli->close();
}

// Query ausführen
/*$qresult = $mysqli->query($query);

$kategorien_summen = array();

while ()
{
    $kategorien_summen [] = $zeile;
}
$qresult->close();



foreach ($kategorien_summen as $result)
{

}*/


