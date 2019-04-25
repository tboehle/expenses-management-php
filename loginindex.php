<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 12.05.2017
 * Time: 08:00
 */

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign-Up/Login Form</title>
    <?php include 'css/css.html'; ?>
</head>

<?php
if ($_SERVER['REQUEST_METHOD']== 'POST')
{
    // Wurde login oder register gedrückt?
    if (isset($_POST['login'])) // dann wird der Benutzer angemeldet
    {
        // Die Handlung übernimmt login.php
        require 'login.php';
    }
    elseif (isset($_POST['registrieren'])) // Der Benutzer wird registriert
    {
        // Die Handlung übernimmt require.php
        require 'registrieren.php';
    }
}

?>
<body>
<div class="form">

    <ul class="tab-group">
        <li class="tab"><a href="#registrieren">Registrieren</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
    </ul>

    <div class="tab-content">

        <div id="login">
            <h1>Willkommen zurück!</h1>

            <form action="loginindex.php" method="post" autocomplete="off">

                <div class="field-wrap">
                    <label>
                        Email Addresse<span class="req">*</span>
                    </label>
                    <input type="email" required autocomplete="off" name="email"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Passwort<span class="req">*</span>
                    </label>
                    <input type="password" required autocomplete="off" name="passwort"/>
                </div>

                <!--                    <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>-->
                <?php
/*                if (!empty($_SESSION['errormessage']))
                {
                    echo "<p class=\"forgot\">" . $_SESSION['errormessage'] . "</p>";
                }
                */?>


                <button class="button button-block" name="login" />Log In</button>

            </form>

        </div>

        <div id="registrieren">
            <h1>Registrierungsantrag</h1>

            <form action="loginindex.php" method="post" autocomplete="off">

                <div class="top-row">
                    <div class="field-wrap">
                        <label>
                            Vorname<span class="req">*</span>
                        </label>
                        <input type="text" required autocomplete="off" name='vorname' />
                    </div>

                    <div class="field-wrap">
                        <label>
                            Nachname<span class="req">*</span>
                        </label>
                        <input type="text"required autocomplete="off" name='nachname' />
                    </div>
                </div>

                <div class="field-wrap">
                    <label>
                        Email Addresse<span class="req">*</span>
                    </label>
                    <input type="email"required autocomplete="off" name='email' />
                </div>

                <div class="field-wrap">
                    <label>
                        Passwort setzen<span class="req">*</span>
                    </label>
                    <input type="password"required autocomplete="off" name='passwort'/>
                </div>

                <button type="submit" class="button button-block" name="registrieren" />Registrieren</button>

            </form>

        </div>

    </div><!-- tab-content -->

</div> <!-- /form -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>
</html>