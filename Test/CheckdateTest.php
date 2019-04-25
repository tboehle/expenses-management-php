<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 20.04.2017
 * Time: 16:09
 */
include "datumcheck.php";
$dateA = "27.03.1997";
if (check_date_format($dateA, "dmY", "."))
{
    echo "hat geklappt.";
}
else
{
    echo "Fehler";
}
date_default_timezone_set("Europe/Berlin");
$aktuellesJahr = date("Y");
$aktuellerMonat = date("m");
$aktuellerTag = date("d");

echo "$aktuellerTag $aktuellerMonat $aktuellesJahr";