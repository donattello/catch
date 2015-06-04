<?php
$autoloader = require 'vendor/autoload.php';
$autoloader->add('generated-classes/', '');
require_once ('generated-conf/config.php'); ?>

<?php include "views/_templates/header.php"; ?>

<?php

//$userFriends = UserFriendsQuery::create()
//            ->filterByUserId($_SESSION["user_id"])
//            ->select('friend') //name of the table in the database
//            ->find()
//        return $userFriends->toArray();
//
//public static function getFriends() {
//    $userFriends = UserFriendsQuery::create()
//        ->filterByUserId(Session::get('user_id'))
//        ->select('friend') //name of the table in the database?
//        ->find();
//    return $userFriends->toArray();
//}

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



<!--<input type="submit" value="Add Friend" />-->



<?php $PrintUserProfile = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<section class="container viewProf">
    <div class="row">
        <section class="profileImg col-xs-12">
            <button type="button" class="close glyphicon glyphicon-remove" data-dismiss="modal"></button>
        </section><!--end of profielImg-->

        <div class="buttons profile">
            <section class="chatIcon col-xs-2">
                <img src="images/IconWebChatNew1.png" height="30px" width="30px">
            </section><!--end of chatIcon-->
            <section class="tick col-xs-2 col-xs-offset-6">
                <img src="images/tick1.png" height="30px" width="30px">
            </section>
            <section class="deleteButton col-xs-2">
                <img src="images/delete.png" height="30px" width="30px">
            </section>
        </div>

        <section class="profileName profile col-xs-12">
            <div class="name col-xs-3">
                <h3>Name:</h3>
            </div><!--end of name-->
            <div class="printName col-xs-9">
                <h3><?= $PrintUserProfile->getUserName(); ?></h3>
            </div><!--end of printName-->
        </section><!--end of profileName-->

        <section class="profileAge profile col-xs-12">
            <div class="age col-xs-3">
                <h3>Age:</h3>
            </div><!--end of Age-->
            <div class="printAge col-xs-9">
                <h3><?= $PrintUserProfile->getUserAge(); ?></h3>
            </div><!--end of printAge-->
        </section><!--end of profileAge-->

        <section class="profileGender profile col-xs-12">
            <div class="gender col-xs-3">
                <h3>Gender:</h3>
            </div><!--end of gender-->
            <div class="printGender col-xs-9">
                <h3><?= $PrintUserProfile->getUserGender(); ?></h3>
            </div><!--end of printGender-->
        </section><!--end of profileGender-->

        <section class="profileActivity profile col-xs-12">
            <div class="activity col-xs-3">
                <h3>Activities:</h3>
            </div><!--end of activity-->
            <div class="printActivity col-xs-9">
            </div><!--end of printActivity-->
        </section><!--end of profileActivity-->

        <section class="profileAbout profile col-xs-12">
            <div class="about col-xs-3">
                <h3>About:</h3>
            </div><!--end of about-->
            <div class="printAbout col-xs-9">
                <h3><?= $PrintUserProfile->getBio(); ?></h3>
            </div><!--end of printAbout-->
        </section><!--end of profileAbout-->

    </div><!--end of profile row-->
</section><!--end of profile-->

<?php include ("views/_templates/footer.php"); ?>
