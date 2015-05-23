<?php 
$autoloader = require 'vendor/autoload.php';
$autoloader->add('generated-classes/', '');
require_once ('generated-conf/config.php'); ?>

<?php include "views/_templates/header.php"; ?>

<?php

$userFriends = UserFriendsQuery::create()
            ->filterByUserId($_SESSION["user_id"])
            ->select('friend') //name of the table in the database
            ->find()
        return $userFriends->toArray();

public static function getFriends() {
    $userFriends = UserFriendsQuery::create()
        ->filterByUserId(Session::get('user_id'))
        ->select('friend') //name of the table in the database?
        ->find();
    return $userFriends->toArray();
}

//$userFollows = UserFollowsQuery::create()
//			->filterByUserId($_SESSION["user_id"])
//			->select('friend') //('*follows_user_id* name of table where the ide of friend is saved')
//			->find();
//		return $userFollows->toArray();

//public static function getUserFollowsId() {
//		$userFollows = UserFollowsQuery::create()
//			->filterByUserId(Session::get('user_id'))
//			->select('follows_user_id')
//			->find();
//			var_dump($userFollows->toArray());
//		return $userFollows->toArray();
//	}
?>
    
<h1>Your profile</h1>

<?php $PrintUserProfile = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

	<div>
		<h3><?= $PrintUserProfile->getUserName(); ?></h3>
		<p> <?= $PrintUserProfile->getUserAge(); ?></p>
        <p><?= $PrintUserProfile->getUserGender(); ?></p>
        <p><?= $PrintUserProfile->getBio(); ?></p>
	</div>

    <input type="submit" value="Add Friend" />

    



<?php include ("views/_templates/footer.php"); ?>
    