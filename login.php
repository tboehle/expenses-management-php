<?php
/**
 * Created by IntelliJ IDEA.
 * User: thorb
 * Date: 11.05.2017
 * Time: 22:36
 */
$host = $_SERVER['PHP_SELF'];
session_start();

require "db_verbinden_login.php";

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM haushaltsdaten2.users WHERE email='$email'");

if ( $result->num_rows == 0 )
{
    // User doesn't exist
    $_SESSION['message'] = "Benutzer mit dieser Email existiert nicht!";
    header("location: error.php");
}
else
    {
        // User exists
    $user = $result->fetch_assoc();

    if ( password_verify($_POST['passwort'], $user['password']))
    {
        if ($user['active'] == 0)
        {
            $_SESSION['message'] = "Ihr Account wurde noch nicht freigeschalten";
            header("location: error.php");
        }
        else
        {
            $_SESSION['email'] = $user['email'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['active'] = $user['active'];

            // This is how we'll know the user is logged in
            $_SESSION['logged_in'] = true;

            header("location: index.php");
        }
    }
    else
    {
        $_SESSION['message'] = "Falsches Passwort, bitte erneut versuchen!";
        header("location: error.php");
    }
}