<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 05.05.2017
 * Time: 11:14
 */


$mysqli = new mysqli("localhost", "root", "", "haushaltsdaten2");
if ($mysqli->connect_error)
{
    echo "Fehler beim Verbindungsaufbau: " . mysqli_connect_error();
    exit();
}
if (!$mysqli->set_charset("utf8"))
{
    echo "Fehler beim Laden von UTF-8" . $mysqli->error();
}

// Query liefert genau ein Wert, nämlich die Summe der Auszahlungen
$query = "SELECT kategorie.name AS Kategorie, sum(transaktion.betrag) AS Auszahlung
          FROM transaktion, kategorie
          WHERE transaktion.kategorie= kategorie.id
          AND kategorie.eingang=0
          AND transaktion.user = $userid
          AND datum BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL 1 month) AND CURRENT_DATE()
          GROUP BY kategorie.name;";

// Query ausführen
$qresult = $mysqli->query($query);

$kategorien_summen = array();

while ($zeile = $qresult->fetch_assoc())
{
    $kategorien_summen [] = $zeile;
}
$qresult->close();


$column_chart_data = array();
foreach ($kategorien_summen as $result)
{
    $column_chart_data[] = array($result['Kategorie'], (int) $result['Auszahlung']);
}

// print json_encode($column_chart_data);

$column_chart_data = json_encode($column_chart_data);
$mysqli->close();