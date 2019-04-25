<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 23.04.2017
 * Time: 19:28
 */

session_start();
if (empty($_SESSION['id']) AND empty($_SESSION['email']) OR $_SESSION['logged_in'] == false)
{
    header("location: index.php");
}

require_once "db_verbinden.php";
require_once "htmlHelfer.php";
htmlanfang("Transaktion bearbeiten");
include "navigation.php";

echo "<h1>Transaktion bearbeiten</h1>";

// Die aktuelle URL der Seite ermitteln
$host = htmlspecialchars($_SERVER['HTTP_HOST']);
$uri = rtrim(dirname(htmlspecialchars($_SERVER['PHP_SELF'])));
$extra = 'transaktionen_anzeigen.php';

// Definiton des Zahlungsarten-Arrays
$werteradiobutton = array("Einzahlung", "Auszahlung");
// Definition des Arrays mit dem Default Wert 0. In der Verarbeitung muss später verhindert werden, dass eine 0 geschrieben wird
$kategorien = array("..." => "0");
try
{
    // ich bereite das Statement vor.
    if ($stmt = $mysqli->prepare('SELECT haushaltsdaten2.kategorie.id, haushaltsdaten2.kategorie.name 
                                        FROM haushaltsdaten2.kategorie'))
    {
        // Ausführen
        $stmt->execute();
        // Ich binde das Ergebnis an Variablen, dass ich das Array später befüllen kann
        $stmt->bind_result($id,$kategorien_name);
        // Befüllen des Arrays: Solange ein Record mit der Funktion fetch() gefunden wird, ist die Bedingung true,
        // wenn kein datensatz mehr vorhanden ist, wird abgebrochen
        while ($stmt->fetch())
        {
            $kategorien[$kategorien_name] = $id;
        }
    }
    else
    {
        echo "Der Kategorienselect hat leider nicht geklappt";
    }
}
catch (Exception $e)
{
    $fehler = $e->getMessage();
    echo "Fehlermeldung: " . $fehler;
}

if (!isset($_POST["update"]))
{

    if (!isset($_GET['id']) OR !is_numeric($_GET['id']))
    {
         header("Location: http://$host$uri/$extra");
    }
    $id = $_GET['id'];
    $sql = 'SELECT  haushaltsdaten2.transaktion.id, haushaltsdaten2.transaktion.zahlungsart,
             haushaltsdaten2.transaktion.datum, haushaltsdaten2.transaktion.kategorie,
            haushaltsdaten2.transaktion.betrag
            FROM haushaltsdaten2.transaktion
            WHERE haushaltsdaten2.transaktion.id = ?';
    if ($stmt = $mysqli->prepare($sql))
    {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($id, $zahlungsart, $datum, $kategorie, $betrag);
        $stmt->fetch();
        $stmt->close();
        $mysqli->close();
        $zahlungsart = htmlspecialchars($zahlungsart);
        $datum = htmlspecialchars($datum);
        $id = (int)$id;
        formausgeben($zahlungsart, $datum, $kategorie, $betrag, "", $id);
    }
}
else
{
    formverarbeiten();
}

function formausgeben($zahlungsart, $date, $kategorie, $betrag, $fehler, $id)
{
    htmlanfang("Bearbeiten eines neuen Datensatzes");
    // Ich hole mir die Navigation mit rein:
    include "navigation.php";
    // Ich brauche das Kategorien Array in der Funktion
    global $kategorien;
    if (!empty($fehler)) {
        // Die Fehler werden übernommen und angezeigt, damit man weiß was ausgefüllt wird
        echo "<p class='fehler'>$fehler</p>";
    }

    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="zahlungsart">Ein / Auszahlung*</label>
        <input type="radio" name="zahlungsart" value="Einzahlung" <?php
        if ($zahlungsart == "Einzahlung")
        {echo "checked";}?>> Einzahlung
        <input type="radio" name="zahlungsart" value="Auszahlung" <?php
        if ($zahlungsart == "Auszahlung")
        {echo "checked";}?>> Auszahlung <br>
        <label for="date">Datum*</label>
        <input type="date" name="date" id="datepicker" class="datepicker" value="<?php echo htmlspecialchars($date); ?>">
        <label for="kategorie">Kategorie*</label>
        <select name="kategorie">
            <?php
            foreach ($kategorien as $option => $value) {
                // Wenn der gewählte Kategoriewert gleich dem übergebenen Parameter $kategorie entspricht,
                // dann wähle selected
                if ($value == $kategorie) {
                    $selected = "selected=''";
                } // Wenn keine Übereinstimmung übernehme ich nichts
                else {
                    $selected = "";
                }
                echo "<option value='$value' $selected>$option</option>";
            }
            ?>
        </select>
        <label for="betrag">Betrag in Euro*</label>
        <input type="number" step="0.01" name="betrag" min="0" id="betrag" value="<?php echo htmlspecialchars($betrag); ?>">
        <br><br>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" name="update" value="Update">
    </form>

    <?php
    htmlende();
}

function formverarbeiten()
{
    include "datumcheck.php";
    // Ich hole mir den Kategorien-Array, den brauche ich für eine Prüfung
    global $kategorien;
    global $werteradiobutton;

    // Setzen der eingegeben Formulardaten

    if (isset($_POST["zahlungsart"]) && in_array($_POST["zahlungsart"], $werteradiobutton))
    {
        $zahlungsart = ($_POST["zahlungsart"]);
    }
    else
    {
        echo "Meine Zahlungsart wurde nicht gesetzt<br>\n";
        $zahlungsart = "";
    }

    if (isset($_POST["date"]) )//&& check_date_format($_POST["date"], "Ymd", "-")
    {
        $date = ($_POST["date"]);
    }
    else
    {
        $date = "";
    }
    echo "Der Wert der kategorie lautet: " . $_POST["kategorie"] . "<br>\n";
    if ($_POST["kategorie"]>0)
    {
        $kategorie = $_POST["kategorie"];
    }
    else
    {
        $kategorie = "";
    }

    // Setzen des Betrags
    if (isset($_POST["betrag"]))
    {
        $betrag = $_POST["betrag"];
    }
    else
    {
        $betrag = "";
    }

    // Validieren der eingegeben Formulardaten

    $fehler = "";

    // Ist eine Auszahlung angegeben?
    if (empty($zahlungsart))
    {
        $fehler .= "Bitte angeben, ob sie eine Einzahlung oder Auszahlung beschreiben wollen <br>\n";
    }

    // Ist das Datum noch leer?
    if (empty($date))
    {
        $fehler .= "Bitte wählen Sie ein Datum. <br>\n";
    }

    /* Ist das Datum nicht größer als das heutige? check_date_time gibt Rückgabe true wenn Datum korrekt,
     deswegen muss ein Ausrufezeichen vor die Funktion*/
    elseif (!check_date_time($date,"Ymd", "-"))
    {
        $fehler .= "Bitte geben Sie ein korrektes Datum ein.<br>\n";
    }

    // Ist die angegebene Kategorie ( Der Wert) im Kategorien-Array?
    if(empty($kategorie) OR $kategorie == 0 OR !in_array($kategorie, $kategorien))
    {
        $fehler .= "Bitte wählen Sie eine Kategorie aus. <br>\n";
    }

    // Ist das Pflichtfeld Betrag ausgefüllt?
    if (empty($betrag))
    {
        $fehler .= "Bitte geben Sie den Betrag an. <br>\n";
    }

    /*Ich schaue mit strlen nach, ob in dieser Variablen etwas drinne steht. Wenn
    diese länger als null ist, ist ein Fehler aufgetreten und rufen das
    Formular erneut auf mit den bisherigen richtig validierten Variablen*/
    if (strlen($fehler) > 0)
    {
        // Aufruf der erneuten Formularausgabe
        formausgeben($zahlungsart, $date, $kategorie, $betrag, $fehler, $_POST['id']);
    }
    else
    {
        // Ich muss meine Arrays globalisieren, damit ich in der Funktion darauf zugreifen kann
        global $mysqli;
        global $host;
        global $uri;
        global $extra;
        // header("Location: http://$host$uri/$extra");
        /*// Daten werden noch ausgegeben, die eingegeben wurden
        $array = explode("-", $date);
        $jahr = $array[0];
        $monat = $array[1];
        $tag = $array[2];
        echo "Vielen Dank für Ihre Eingaben!<br>\n
                      Ihre Eingaben lauten:<br>\n
                      $zahlungsart über $betrag Euro am $tag.$monat.$jahr für $kategorie ausgegeben";*/
        try
        {
            /*Für das Update benötigt man die id, die haben wir jedoch eigentlich nicht mehr, da nach dem Formular die $_GET['id']
            weg ist.
            Lösung: Wir brauchen ein verstecktes Feld die uns die id mitnimmt
            Das obige Feld ist dann vom Typ "hidden"*/
            $id = $_POST['id'];
            echo $id;
            $sql = 'UPDATE haushaltsdaten2.transaktion SET haushaltsdaten2.transaktion.zahlungsart = ?, 
                                                          haushaltsdaten2.transaktion.datum = ?,  
                                                          haushaltsdaten2.transaktion.kategorie = ?, 
                                                          haushaltsdaten2.transaktion.betrag = ?
                                                       WHERE 
                                                        haushaltsdaten2.transaktion.id = ?';
            if ($stmt = $mysqli->prepare($sql))
            {
                $stmt->bind_param('ssiii', $zahlungsart, $date, $kategorie, $betrag, $id);
                $stmt->execute();
                $stmt->close();
                $mysqli->close();
                // Umleitung an Anzeige
                header("Location: http://$host$uri/$extra");
            }
            else
            {
                echo "<p class='fehler'>Ihr Insert konnte nicht durchgeführt werden</p>";
                formausgeben($zahlungsart, $date, $kategorie, $betrag, $fehler, $_POST['id']);
            }
        }
            // Falls der try Block kracht:
        catch(Exception $e)
        {
            // Fehlermeldung wird beladen
            $fehler = $e->getMessage();
        }

        // Falls es einen Fehler gibt:
        if (!empty($fehler))
        {
            formausgeben($zahlungsart, $date, $kategorie, $betrag, $fehler, $_POST['id']);
        }
    }
}
