<?php include "views/_templates/header.php"; ?>

<?php
	$allUsers = UserQuery::create()
		->limit(100)
		->orderByUserId('desc')
		->find();
?>

    
<?php foreach($allUsers as $user) { ?>

	<div class="event-box">
		<img src="images/<?= $user->getUserName(); ?>.jpg" height="80px" width="80px">
		<a href="profile.php?id=<?= $user->getUserId() ?>">
            <h3><?= $user->getUserName(); ?></h3>
            <h5><?= $user->getUserAge(); ?></h5>
            <h5><?= $user->getUserGender(); ?></h5>
        </a>

        
        <div class="clearfix"></div>
	</div>

<?php } ?>


<?php include ("views/_templates/footer.php"); ?>


