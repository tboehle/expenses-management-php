<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Neue Transaktion</title>
        <link rel="stylesheet" href="layout.css"
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
                $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
            } );
        </script>
    </head>
    <body class="Transaktionseite">
        <?php
            include "navigation.php";
        ?>
        <h1>Transaktion</h1>
            <p>Hier können Sie eine neue Transaktion einspielen. Füllen Sie dazu folgende Felder aus:</p>
        <?php
        $kategorien = array("...", "Lebensmittel", "Hobbies", "Fahrtkosten", "Büromaterial",
                            "Miete", "Ausgehen", "Kleidung", "Versicherungen", "Geschenke",
                            "Multimedia", "Sonstige");

        //Wir brauchen ein Array für die Radio Buttons
        $werteradiobutton = array("Einzahlung", "Auszahlung");

        // Wurde das Formular abgesendet?
        if (isset($_POST["gesendet"]))
        {
            formverarbeiten();
        }
        else
        {
            formausgeben();
        }
        /*Default muss auf leere Strings gesetzt werden, da beim ersten Aufruf erst ausgefüllt werden muss.
        werden diese Default Werte überschrieben.*/
        // Die ausgewählten Werte werden in die Value Section geschrieben in dem Formular-Input-Tag!
        function formausgeben($zahlungsart = "", $date = "", $kategorie = "", $betrag = "", $fehler = "")
        {
            // Ich brauche das themen Array in der Funktion
            global $kategorien;
            if (!empty($fehler)) {
                // Die Fehler werden übernommen und angezeigt, damit man weiß was ausgefüllt wird
                echo "<p class='fehler'>$fehler</p>";
            }


            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                Ein / Auszahlung* <br>
                <input type="radio" name="zahlungsart" value="Einzahlung" <?php
                                                                            if ($zahlungsart == "Einzahlung")
                                                                            {echo "checked";}?>> Einzahlung
                <input type="radio" name="zahlungsart" value="Auszahlung" <?php
                                                                            if ($zahlungsart == "Auszahlung")
                                                                            {echo "checked";}?>> Auszahlung <br>
                <br>
                Datum* <br>
                <input type="date" name="date" id="datepicker" class="datepicker" value="<?php echo htmlspecialchars($date); ?>">
                <br>
                Kategorie* <br>
                <select name="kategorie">
                    <?php
                    foreach ($kategorien as $option) {
                        // Wenn das gewählte Thema gleich dem im Array ist, dann nehme ich das gesetzte
                        if ($option == $kategorie) {
                            $gew = "selected";
                        } // Wenn keine Übereinstimmung übernehme ich nichts
                        else {
                            $gew = "";
                        }
                        echo "<option value='$option' $gew>$option</option>";
                    }
                    ?>
                </select>
                <br>
                Betrag in * <br>
                <input type="number" step="0.01" name="betrag" min="0" id="betrag" value="<?php echo htmlspecialchars($betrag); ?>">


                <br>
                <input type="submit" name="gesendet" value="Transaktion anlegen">
            </form>

            <?php
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
                echo "Meine Zahlungsart lautet: <br>\n";
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

            if (isset($_POST["kategorie"]) && is_string($_POST["kategorie"]))
            {
                $kategorie = trim($_POST["kategorie"]);
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

            // Ist die angegebene Kategorie im Kategorien-Array?
            if(!in_array($kategorie, $kategorien) OR $kategorie == "...")
            {
                $fehler .= "Bitte wählen Sie eine Kategorie. <br>\n";
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
                formausgeben($zahlungsart, $date, $kategorie, $betrag, $fehler);
            }
            else
            {
                // Daten werden noch ausgegeben, die eingegeben wurden
                $array = explode("-", $date);
                $jahr = $array[0];
                $monat = $array[1];
                $tag = $array[2];
                echo "Vielen Dank für Ihre Eingaben!<br>\n
                      Ihre Eingaben lauten:<br>\n
                      $zahlungsart über $betrag Euro am $tag.$monat.$jahr für $kategorie ausgegeben";

                //mail versenden
                /*$empfaenger = 'boehleth@dhbw-loerrach.de';
                $betreff = 'Test Email';
                $nachricht = 'Hallo, wie gehts dir heute?';
                $header = 'From: webmaster@example.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($empfaenger, $betreff, $nachricht, $header);*/
            }
        }
        ?>
    </body>
</html>