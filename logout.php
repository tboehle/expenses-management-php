<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 12.05.2017
 * Time: 11:04
 */

/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ausgabenverwaltung</title>
    <?php include 'css/css.html'; ?>
</head>

<body>
<div class="form">
    <h1>Bis zum nächsten Mal!</h1>

    <p><?= 'Sie wurden ausgeloggt!'; ?></p>

    <a href="index.php"><button class="button button-block"/>Home</button></a>

</div>
</body>
</html>