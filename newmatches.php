<?php include "views/_templates/header.php"; ?>

<?php
	$allUsers = UserQuery::create()
		->limit(100)
		->orderByUserId('desc')
		->find();
?>

    
<?php foreach($allUsers as $user) { ?>

	<div class="event-box">
		<img src="images/<?= $user->getUserName(); ?>.jpg">
		<h3><a href="profile.php?id=<?= $user->getUserId() ?>"><?= $user->getUserName(); ?></a></h3>
        <div class="clearfix"></div>
	</div>

<?php } ?>


<?php include ("views/_templates/footer.php"); ?>


