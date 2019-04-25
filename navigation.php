<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 20.04.2017
 * Time: 11:11
 */

$navigation = array("Dashboard" => "index.php",
                    "Transaktionen" => "transaktionen_anzeigen.php",
                    "Periodenauswertung" => "periodenauswertung.php",
                    "Kategorienauswertung" => "kategorienauswertung.php",
                    "Logout" => "logout.php",
                    );
//echo "<nav>";
//echo "<ul>\n";

echo '<div class="container">
<nav class="navbar navbar-inverse navbar-fixed-top" style="padding-left: 10%">
            <ul class="nav navbar-nav">';
foreach ($navigation as $seitenname => $seitenlink)
  {
      if ($seitenname == "Logout")
      {
          echo "<li><a href='$seitenlink' id='logout'>$seitenname</a></li>";
      }
      else
      {
          echo "<li><a href='$seitenlink'>$seitenname</a></li>";
      }

  }
  echo ' </ul>
</nav> </div>
</br> </br>';

