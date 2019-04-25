<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 11.05.2017
 * Time: 22:37
 */
$host = $_SERVER['PHP_SELF'];
session_start();

require_once "db_verbinden_login.php";

// Escape all $_POST variables to protect against SQL injections
$vorname = $mysqli->escape_string($_POST['vorname']);
$nachname = $mysqli->escape_string($_POST['nachname']);
$email = $mysqli->escape_string($_POST['email']);
$passwort = $mysqli->escape_string(password_hash($_POST['passwort'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 )
{

    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");

}
else
{
    // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $query = "INSERT INTO users (first_name, last_name, email, password, hash) "
        . "VALUES ('$vorname','$nachname','$email','$passwort', '$hash')";

    // Add user to the database
    if ( $mysqli->query($query) )
    {

        $_SESSION['message'] = "Wir schreiben Ihnen eine Email, wenn ihr Account freigeschaltet wurde";

//            "Confirmation link has been sent to $email, please verify
//                 your account by clicking on the link in the message!";
//
//        // Send registration confirmation link (verify.php)
//        $to      = $email;
//        $subject = 'Account Verification ( clevertechie.com )';
//        $message_body = '
//        Hello '.$first_name.',
//
//        Thank you for signing up!
//
//        Please click this link to activate your account:
//
//        http://localhost/login-system/verify.php?email='.$email.'&hash='.$hash;

        //mail( $to, $subject, $message_body );

        header("location: error.php");

    }

    else
    {
        $_SESSION['message'] = 'Registrierung fehlgeschlagen!';
        header("location: error.php");
    }
}