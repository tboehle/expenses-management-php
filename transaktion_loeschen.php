<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 23.04.2017
 * Time: 19:28
 * Das Löschen erzeugt keine Ausgabe, deswegen brauchen wir kein HTML Gerüst.
 */
session_start();
if (empty($_SESSION['id']) AND empty($_SESSION['email']) OR $_SESSION['logged_in'] == false)
{
    header("location: index.php");
}


// Die aktuelle URL der Seite ermitteln
require_once "db_verbinden.php";
$host = htmlspecialchars($_SERVER['HTTP_HOST']);
$uri = rtrim(dirname(htmlspecialchars($_SERVER['PHP_SELF'])));
$extra = 'transaktionen_anzeigen.php';

// Über die URL bekomme ich die URL mitgeteilt und hole sie mir deswegen mit dem Array $_GET
if (!isset($_GET['id']) OR !is_numeric($_GET['id']))
{
    header("Location: http://$host$uri/$extra");
}
else
{
    // Die id über den GET Array wird lokal gespeichert
    $id = $_GET['id'];
    if ($stmt = $mysqli->prepare('DELETE FROM haushaltsdaten2.transaktion WHERE id = ?'))
    {
        // Ich binde den vorher festgelegten Parameter, sodass die DB welchen Record sie löschen muss
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
        header("Location: http://$host$uri/$extra");
    }
}