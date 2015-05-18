<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<div>
	Hey, <?= $user->getUserName(); ?>. You are logged in.
</div>

<div>
Your Events
</div>
<?php foreach($user->getEvents() as $event) { ?>
	<div>
		<h3><?= $event->getEventType(); ?></h3>
		<p>On: <?= $event->getEventDate('Y-m-d H:i:s'); ?></p>
	</div>
<?php } ?>

Try to close this browser tab and open it again. Still logged in! ;)

    
   



<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout">Logout</a>

    <!--footer-->
   <?php // include ("_templates/footer.php"); ?>