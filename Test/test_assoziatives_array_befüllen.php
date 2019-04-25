<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 23.04.2017
 * Time: 22:19
 */

$kategorien = array("0" => "...");
echo "<prev>";
print_r($kategorien);
echo "</prev>";
$kategorien["1"] = "Lebensmittel";
$kategorien["2"] = "Hobbies";
$kategorien["3"] = "Kleidung";

echo "<prev>";
print_r($kategorien);
echo "</prev>";