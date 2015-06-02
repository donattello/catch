<?php include ("views/_templates/header.php"); ?>

    <section class="container-fluid" id="planner2">
        <div class="row homecontainer">
            <div class="containerHome col-xs-11">
                <a href="create_event.php">
                    <div class="createEvent button2">
                        <div class="position">
                            <h3>CREATE</h3>
                            <h3>AN EVENT</h3>
                        </div>
                    </div>
                </a><!--link creatEvent-->

            </div><!--containerHome-->

<!--Feed template-->



    </div><!--end of row-->
</section><!--end of container-->


<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<?php foreach($user->getEvents() as $event) { ?>
	<div>
	    <p><?= $event->getSport()->getSport() . "On: " . $event->getEventDate('d-m-y H:i') . $event->getEventPlace() . $event->getEventNumberPeople(); ?></p>
	</div>
<?php } ?>



 <?php
 	$events = EventQuery::create()
        ->limit(100)
        ->orderByEventDate('desc')
        ->find();
?>


All Events

<?php foreach($events as $event) { ?>
	<div class="event-box">
		<img src="images/<?= $event->getUser()->getUserName() ?>.jpg">
		<h3><a href="event.php?id=<?= $event->getId(); ?>"><?= $event->getSport()->getSport(); ?></a></h3>
		<h5>Posted by: <a href="profile.php?id=<?= $event->getUser()->getUserId() ?>"><?= $event->getUser()->getUserName() ?></a></h5>
		<p><?= $event->getEventPlace() ?></p>
		<p><?= $event->getEventNumberPeople() ?></p>
		<p>On: <?= $event->getEventDate('d-m-y H:i'); ?></p>
	</div>
<?php } ?>



<?php include ("views/_templates/footer.php"); ?>
