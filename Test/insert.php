<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 14.05.2017
 * Time: 17:11
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

$zahlungsart = "Auszahlung";
$date = "2017-05-14";
$kategorie = 5;
$betrag = 60;
$userid = 1;

// INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-20', 5, 4.00, 1);

try
{
    if ($stmt = $mysqli->prepare('INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) 
                                                  VALUES (?, ?, ?, ?, ?)'))
    {
        $stmt->bind_param('ssiii', $zahlungsart, $date, $kategorie, $betrag, $userid);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
        // Umleitung an Anzeige
        // header("Location: http://$host$uri/$extra");
        echo "Ihr Record wurde geschrieben";
    }
    else
    {
        echo "Ihr Insert konnte nicht durchgeführt werden";
    }
}
    // Falls der try Block kracht:
catch(Exception $e)
{
    // Fehlermeldung wird beladen
    $fehler = $e->getMessage();
}