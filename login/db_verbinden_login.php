<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 23.04.2017
 * Time: 16:27
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
