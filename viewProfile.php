<?php session_start();
$autoloader = require '../vendor/autoload.php';
$autoloader->add('../generated-classes/', '');
require_once ('../generated-conf/config.php'); ?>

<?php include "views/_templates/header.php"; ?>
    
<h1>Your profile</h1>

$PrintUserProfile = UserQuery::create()->findPK($_SESSION["user_id"]);

<?php include ("views/_templates/footer.php"); ?>
    