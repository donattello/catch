<?php include "views/_templates/header.php"; ?>

<?php
	$allUsers = UserQuery::create()
		->limit(100)
		->orderByUserId('desc')
		->find();
?>
    
<?php foreach($allUsers as $user) { ?>
	<div>
		<h3><?= $user->getUserName(); ?></h3>
		<p> <?= $user->getUserAge(); ?></p>
        <p><?= $user->getUserGender(); ?></p>
        <p><?= $user->getBio(); ?></p>

	</div>
<?php } ?>






<?php include ("views/_templates/footer.php"); ?>