<?php include "views/_templates/header.php"; ?>

<?php
	$allUsers = UserQuery::create()
		->limit(100)
		->orderByUserId('desc')
		->find();
?>
    
<?php foreach($allUsers as $user) { ?>

	<div class="event-box">
<!--        <img src="images/<? // = $user->getUser()->getUserName(); ?>.jpg">-->
<!--        <h3><a href="profile.php?id=<? // = $user->getUser()->getUserId() ?>"><? // = $user->getUser()->getUserName() ?></a></h3>-->
		<h3><?= $user->getUserName() . " " . $user->getUserAge() . " " . $user->getUserGender() ; ?></h3>
<!--        <p><? // = $user->getBio(); ?></p>-->
        <input type="submit" value="Add Friend" />
        
	</div>

<?php } ?>

<?php include ("views/_templates/footer.php"); ?>


