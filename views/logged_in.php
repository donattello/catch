<!-- if you need user information, just put them into the $_SESSION variable and output them here -->

<?php $user = UsersQuery::create()->findPK($_SESSION["user_id"]); ?>

<div>
	Hey, <?= $user->getUserName(); ?>. You are logged in.
</div>

<div>
Your Events
</div>
<?php foreach($user->getEventss() as $event) { ?>
	<div>
		<h3><?= $event->getEventType(); ?></h3>
		<p>On: <?= $event->getEventDate('Y-m-d H:i:s'); ?></p>
	</div>
<?php } ?>

Try to close this browser tab and open it again. Still logged in! ;)

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout">Logout</a>
