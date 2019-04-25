<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 04.05.2017
 * Time: 12:32
 */

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

// Query liefert genau ein Wert, nämlich die Summe der Auszahlungen
$query = "SELECT sum(betrag) as Auszahlungen from transaktion WHERE zahlungsart='Auszahlung'";

// Query ausführen
$qresult = $mysqli->query($query);

$auszahlungen = array();

while ($zeile = $qresult->fetch_assoc())
{
    $auszahlungen [] = $zeile;
}
$qresult->close();

$query = "SELECT sum(betrag) as Einzahlungen from transaktion WHERE zahlungsart='Einzahlung'";

// Query ausführen
$qresult = $mysqli->query($query);

$einzahlungen = array();

while ($zeile = $qresult->fetch_assoc())
{
    $einzahlungen [] = $zeile;
}
$qresult->close();

/*print_r($einzahlungen);
echo "<br><br>";
print_r($auszahlungen);
echo "<br><br>";*/

$pie_chart_data = array();
foreach ($auszahlungen as $result)
{
    $pie_chart_data[] = array('Auszahlungen', (int) $result['Auszahlungen']);
}
foreach ($einzahlungen as $result)
{
    $pie_chart_data[] = array('Einzahlungen', (int) $result['Einzahlungen']);
}

//print json_encode($pie_chart_data);

$pie_chart_data = json_encode($pie_chart_data);
$mysqli->close();