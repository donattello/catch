<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<div>
	Hey, <?= $user->getUserName(); ?>. You are logged in.
</div>

<div>
Your Events
</div>
<?php foreach($user->getEvents() as $event) { ?>
	<div>
		<h3><?= $event->getSport()->getSport(); ?></h3>
		<p>On: <?= $event->getEventDate('d-m-y H:i'); ?></p>
	</div>
<?php } ?>

All Events
<?php
	$events = EventQuery::create()
		->limit(100)
		->orderByEventDate('desc')
		->find();
?>

<?php foreach($events as $event) { ?>
	<div>
		<h3><a href="event.php?id=<?= $event->getId(); ?>"><?= $event->getSport()->getSport(); ?></a></h3>
		<p>On: <?= $event->getEventDate('d-m-y H:i'); ?></p>
	</div>
<?php } ?>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout">Logout</a>

    <!--footer-->
   <?php // include ("_templates/footer.php"); ?>