<?php
session_start();
$autoloader = require '../vendor/autoload.php';
$autoloader->add('../generated-classes/', '');
require_once ('../generated-conf/config.php');

$submitted = $_POST["create-profile"];

if(!empty($submitted)){
    
    //$user_id = $_POST["name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    //$eventType = $_POST["event-type"];
    $userBio = $_POST["user_bio"];
    
    if(empty($age) || empty($gender) || empty($userBio)) {
		$_SESSION["message"] = "Please fill in all fields";
	    header("Location: ../editProfile.php");
		exit;
        
        //|| empty($eventType)
    }
    
    $newUser = new User();
        $newUser->setUserName($_SESSION["user_id"]);
        //$newUser->setUserName($user_id);
        $newUser->setUserAge($age);
        $newUser->setUserGender($gender);
        //$newUser->setUserEventType($eventType);
        $newUser->setBio($userBio);
    
     //var_dump($newUser->toArray());
    $newUser->save();
    
    $_SESSION["message"] = "Your profile has been updated";

    header("Location: ../editProfile.php");
	exit;
} else {
    $_SESSION["message"] = "Please fill in all the fields to update your profile";
    header("Location: ../editProfile.php");
    exit;
}

?>

