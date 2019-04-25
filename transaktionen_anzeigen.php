<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 23.04.2017
 * Time: 19:27
 */
session_start();
if (empty($_SESSION['id']) OR empty($_SESSION['email']) OR $_SESSION['logged_in'] == false)
{
    header("location: index.php");
}
include "htmlHelfer.php";
htmlanfang("Transaktion anzeigen");
include "navigation.php";
require_once "db_verbinden.php";
echo "<h1 style='padding-bottom: 20px; padding-top: 20px'>Transaktionsübersicht</h1>";


    if ($stmt = $mysqli->prepare('SELECT  haushaltsdaten2.transaktion.id, haushaltsdaten2.transaktion.zahlungsart, 
                                          DATE_FORMAT(haushaltsdaten2.transaktion.datum, "%d.%m.%Y"), haushaltsdaten2.kategorie.name, 
                                          haushaltsdaten2.transaktion.betrag
                                  FROM haushaltsdaten2.transaktion, haushaltsdaten2.kategorie
                                  WHERE haushaltsdaten2.transaktion.kategorie = haushaltsdaten2.kategorie.id
                                  AND haushaltsdaten2.transaktion.datum BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL 1 month) AND CURRENT_DATE()
                                  AND haushaltsdaten2.transaktion.user = ?
                                  ORDER BY haushaltsdaten2.transaktion.datum'))
    {
        $userid = $_SESSION['id'];
        $stmt->bind_param('i', $userid);
        // Ausführen des Prepared Statements
        $stmt->execute();
        // Ich binde das Ergebnis an die Parameter, sodass ich später darauf zugreifen kann:
        $stmt->bind_result($id, $zahlungsart, $datum, $kategorie, $betrag);
        // Ich rufe store_result aus, um die Anzahl der Datensätze zu ermitteln (mit num_rows)
        $stmt->store_result();
        // Gibt es aktuell Datensätze, die man ausgeben kann?
        if ($stmt->num_rows() > 0)
        {?>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Zahlungsart</th>
                        <th>Datum</th>
                        <th>Kategorie</th>
                        <th>Betrag</th>
                        <th>Bearbeiten</th>
                        <th>Löschen</th>
                    </tr>
                    <?php
                    while ($stmt->fetch())
                    {
                        $zahlungsart = htmlspecialchars($zahlungsart);
                        $datum = htmlspecialchars($datum);
                        $kategorie = htmlspecialchars($kategorie);
                        $betrag = htmlspecialchars($betrag);
                        $id = htmlspecialchars($id);
                        ?>
                        <tr>
                            <td><?php echo $zahlungsart; ?></td>
                            <td><?php echo $datum; ?></td>
                            <td><?php echo $kategorie; ?></td>
                            <td><?php echo $betrag; ?></td>
                            <td><a href="transaktionen_bearbeiten.php?id=<?php echo $id; ?>">bearbeiten</a></td>
                            <td><a href="transaktion_loeschen.php?id=<?php echo $id; ?>"
                                   onclick="return confirm('Wirklich Löschen?')" style="color: red">löschen</a></td>
                        </tr>
                        <?php
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
            <?php
        }
    }?>

    <br>
   <div class="container">
    <p><a href="neue_transaktion.php"><button type="button" class="btn-lg btn-primary btn-block" style="padding-bottom:10px;">Neue Transaktion anlegen</button></a></p>
       </div>
    <br>
    <?php

    $mysqli->close();

    htmlende();