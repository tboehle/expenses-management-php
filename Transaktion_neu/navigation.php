<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 20.04.2017
 * Time: 11:11
 */

$navigation = array("Home" => "index.php",
                    "Transaktion" => "transaktion.php",
                    "Periodenauswertung" => "periodenauswertung.php",
                    "Kategorienauswertung" => "kategorienauswertung.php",
                    "Test_Transaktion" => "transaktion_test.php");

echo "<ul>\n";

foreach ($navigation as $seitenname => $seitenlink)
  {
    echo "<li><a href='$seitenlink' class='$seitenname'>$seitenname</a></li>";
  }
echo "</ul>\n";