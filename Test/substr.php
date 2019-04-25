<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 10.05.2017
 * Time: 22:06
 */

$string = "2017-04-20";
echo "$string<br>\n Nun erfolgt der Subtract:<br>";
$neuerstring = substr($string, 0, 4);
echo "$neuerstring ist nun das Datum.<br>";

$zahleins = substr($string, 0, 4);
$zahlzwei = substr($string, 5, 2);
echo "$zahleins : Zahl 1<br>";
echo "$zahlzwei : Zahl 2<br>";
$zahl = "$zahleins$zahlzwei";
$zahl = (int) $zahl;
echo $zahl . "lautet nun die Zahl";