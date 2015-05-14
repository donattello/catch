
<?php
//PHP 5.3.7 NEEDED
require_once("libraries/password_compatibility_library.php");
require_once("config/db.php");
require_once("classes/Login.php");

$autoloader = require 'vendor/autoload.php';
$autoloader->add('generated-classes/');
require_once ('generated-conf/config.php');

$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    include("views/logged_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    include("views/not_logged_in.php");
}

