<?php

	session_start();
	$autoloader = require 'vendor/autoload.php';
	$autoloader->add('generated-classes/');
	require_once ('generated-conf/config.php');

	$event = EventQuery::create()->findPK($_GET["id"]);

	echo $event->getSport()->getSport();

?>
