<?php
//PHP 5.3.7 NEEDED
require_once("libraries/password_compatibility_library.php");
require_once("config/db.php");
require_once("classes/Login.php");

$autoloader = require 'vendor/autoload.php';
$autoloader->add('generated-classes/');
require_once ('generated-conf/config.php');

$login = new Login();
?>

<!doctype html>
<html>
    <head>
        <title>Catch</title>
        <link src="" rel="stylesheet">
    </head>

    <body>
        
    <?php
        if ($login->isUserLoggedIn() == true) {
        }
    ?>