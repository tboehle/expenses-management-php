<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 20.04.2017
 * Time: 15:51
 */


// returns boolean
function check_date_format($date, $format = "dmY", $sep = ".")
{
    // Positionen werden bestimmt in dem das Format druchsucht wird
    $pos1 = strpos($format, 'd');
    $pos2 = strpos($format, 'm');
    $pos3 = strpos($format, 'Y');

    // Anhand der Trennung, wird der Datumsstring in 3 Teile geteilt
    $check = explode($sep, $date);

    // Übergabe im Format: mdY
    if (checkdate($check[$pos2], $check[$pos1], $check[$pos3]))
    {
        return true;
    }
    else
    {
        return false;
    }

}

// returns Boolean
// ist das Datum gültig, also höchstens gleich dem heutigen Tag?
function check_date_time($date, $format = "dmY", $sep = ".")
{
    // Positionen werden bestimmt in dem das Format druchsucht wird
    $pos1 = strpos($format, 'd');
    $pos2 = strpos($format, 'm');
    $pos3 = strpos($format, 'Y');

    // Anhand der Trennung, wird der Datumsstring in 3 Teile geteilt
    $check = explode($sep, $date);

    /*echo "<prev>\n";
    print_r($check);
    echo "</prev>\n";*/

    $jahr = (int) $check[$pos3];
    $monat = (int) $check[$pos2];
    $tag = (int) $check[$pos1];

    /*echo "Die Positionen: $pos1 $pos2 $pos3<br>\n";
    echo "Das Datum lautet: $tag $monat $jahr<br>\n";*/

    // Achtung: europäische Weltzeit
    date_default_timezone_set("Europe/Berlin");
    $aktuellesJahr = (int) date("Y");
    $aktuellerMonat = (int) date("m");
    $aktuellerTag = (int) date("d");

    /*echo "Das Systemdatum: $aktuellerTag $aktuellerMonat $aktuellesJahr<br>\n";
    echo "Das ausgelesene aktuelle Datum: $tag $monat $jahr<br>";*/

    if ($jahr > 1900 && $jahr <= $aktuellesJahr)
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