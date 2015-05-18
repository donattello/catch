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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CATCH</title>
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/mystyles.css" rel="stylesheet" media="screen">
    </head>
 
    <body id="appSettings" class="home">
        
        
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="row">
                    <div class="nav-button col-xs-1">
                         <a href="menu.php">
                            <img src="icons/menuButton.png" width="30px" height="21px">
                        </a>
                    </div><!--nav-button-->

                    <a href="index.php">
                      <div class="logo nav-icon col-xs-3">
                          <img src="icons/logo.png" width="70px" height="39px">
                      </div>
                    </a>

                    <div class="icon nav-icon pull-right col-xs-7">
                        <a href="newMatches.php" class="col-xs-3">
                            <img src="icons/tick.png" width="25px" height="25px" class="image-nav">
                        </a>

                        <a href="planner.php" class="col-xs-3">
                            <img src="icons/calendar.png" width="25px" height="25px" class="image-nav">
                        </a>

                        <a href="friends.php" class="col-xs-3">
                            <img src="icons/smile.png" width="25px" height="25px"  class="image-nav">
                        </a>
                        
                        <a href="chat.php" class="col-xs-3">
                            <img src="icons/chat.png" width="25px" height="25px" class="image-nav">
                        </a>
                    </div><!--icon-->

                </div><!--row--> 

            </div><!-- /.container-fluid -->
        </nav>
        
    <?php
        if ($login->isUserLoggedIn() == true) {
        }
    ?>