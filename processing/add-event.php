<?php
session_start();
$autoloader = require '../vendor/autoload.php';
$autoloader->add('../generated-classes/');
require_once ('../generated-conf/config.php');

$submitted = $_POST["add-event"];

if(!empty($submitted)) {
    
    $eventType = $_POST["event-type"];

    $newEvent = new Event();
    $newEvent->setEventUserId($_SESSION["user_id"]);
    $newEvent->setEventType($eventType);
    $newEvent->save();
    
    //redirect

} else {
    //REDIRECT   
}
?>