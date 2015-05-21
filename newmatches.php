<?php include "views/_templates/header.php"; ?>

<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>
    
<?php foreach($user->getUsers() as $users) { ?>
	<div>
		<h3><?= $users->getUserName(); ?></h3>
		<p> <?= $users->getUserAge(); ?></p>
        <p><?= $users->getUserGender(); ?></p>
        <p><?= $users->getBio(); ?></p>

	</div>
<?php } ?>


<?php
	$users = UserQuery::create()
		->limit(100)
		->orderByUserId('desc')
		->find();
?>



<?php include ("views/_templates/footer.php"); ?>