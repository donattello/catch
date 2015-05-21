<?php
session_start();
$autoloader = require '../vendor/autoload.php';
$autoloader->add('../generated-classes/', '');
require_once ('../generated-conf/config.php');

$submitted = $_POST["create-profile"];

if(!empty($submitted)){
    
    $user_id = $_POST["user_ID"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $eventType = $_POST["event-type"];
    $userBio = $_POST["user_bio"];
}

?>