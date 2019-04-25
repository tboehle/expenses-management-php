<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 25.04.2017
 * Time: 18:24
 */

require_once "db_verbinden.php";

// Query um an die daten zu kommen
$query = sprintf("SELECT playerid, score FROM data.players ORDER BY playerid");

// Query ausführen
$result = $mysqli->query($query);

// mIt Schleife die Daten in ein Array schreiben:
$data = array();
foreach ($result as $row)
{
    $data [] = $row;
}

$result->close();
$mysqli->close();

// Die Daten ausgeben
print json_encode($data);