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
    
    $editUser = UserQuery::create()->findPK($_SESSION["user_id"]);
    var_dump($editUser->toArray());
    
    echo "<br>";
    
    $editUser->setUserAge($age);
    $editUser->setUserGender($gender);
    $editUser->setBio($userBio);
    
    $editUser->save();
    
    $_SESSION["message"] = "Your profile has been updated";

    header("Location: ../editProfile.php");
	exit;
} else {
    $_SESSION["message"] = "Please fill in all the fields to update your profile";
    header("Location: ../editProfile.php");
    exit;
}

?>

