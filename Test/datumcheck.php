<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 20.04.2017
 * Time: 15:51
 */

function check_date_format($date, $format = "dmY", $sep = ".")
{
    // Positionen werden bestimmt in dem das Format druchsucht wird
    $pos1 = strpos($format, 'd');
    $pos2 = strpos($format, 'm');
    $pos3 = strpos($format, 'Y');

    // Anhand der Trennung, wird der Datumsstring in 3 Teile geteilt
    $check = explode($sep, $date);

    // Übergabe im Format: mdY
    return checkdate($check[$pos2], $check[$pos1], $check[$pos3]);
}

// ist das Datum gültig, also höchstens gleich dem heutigen Tag?
function check_date_time($date, $format = "dmY", $sep = ".")
{
    // Positionen werden bestimmt in dem das Format druchsucht wird
    $pos1 = strpos($format, 'd');
    $pos2 = strpos($format, 'm');
    $pos3 = strpos($format, 'Y');

    echo "$pos1 $pos2 $pos3";

    // Anhand der Trennung, wird der Datumsstring in 3 Teile geteilt
    $check = explode($sep, $date);

    echo "<prev>\n";
    print_r($check);
    echo "</prev>\n";

    $year = (int) $check[2];
    $monat = (int) $check[1];
    $tag = (int) $check[0];
    echo "$tag $monat $year<br>";

    // Achtung: europäische Weltzeit
    date_default_timezone_set("Europe/Berlin");
    $aktuellesJahr = date("Y");
    $aktuellerMonat = date("m");
    $aktuellerTag = date("d");

    if ($year > 1900 && year <= $aktuellesJahr)
    {
        if ($monat <= $aktuellerMonat)
        {
            if ($tag <= $aktuellerTag)
            {
                // Falls das Datum valide ist
                return true;
            }
        }
    }
    else
    {
        // Falls das Datum größer ist als das heutige Datum
        return false;
    }
}