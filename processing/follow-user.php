<?php
session_start();
$autoloader = require '../vendor/autoload.php';
$autoloader->add('../generated-classes/', '');
require_once ('../generated-conf/config.php');

if(!empty($_GET["id"])){
    $newFollow = new Friend();
    $newFollow->setUserId($_SESSION["user_id"]);
    $newFollow->setFriendId($_GET["id"]);
    $newFollow->save(); 
}
?>
