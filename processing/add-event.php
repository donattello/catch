<?php
session_start();
$autoloader = require '../vendor/autoload.php';
$autoloader->add('../generated-classes/', '');
require_once ('../generated-conf/config.php');

$submitted = $_POST["add-event"];

if(!empty($submitted)) {

	$date = $_POST["date"];
	$time = $_POST["time"];
	$eventType = $_POST["event-type"];

	if(empty($date) || empty($time) || empty($eventType)) {
		$_SESSION["message"] = "Please fill in all fields";
	    header("Location: ../create_event.php");
		exit;
	}

    $newEvent = new Event();
    $newEvent->setEventUserId($_SESSION["user_id"]);
    $newEvent->setEventDate($date.$time);
    $newEvent->setEventType($eventType);

    var_dump($newEvent->toArray());
    $newEvent->save();

    $_SESSION["message"] = "Your event has been added";

    header("Location: ../index.php");
	exit;

} else {
	$_SESSION["message"] = "Please submit the form";
    header("Location: ../create_event.php");
    exit;
}
?>