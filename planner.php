<?php include ("views/_templates/header.php"); ?>

    <section class="container" id="planner2">
        <div class="row homecontainer">
            <div class="containerEvent col-xs-12">
                <a href="create_event.php">
                    <div class="createEvent button2">
                        <div class="position">
                            <h3>CREATE</h3>
                            <h3>AN EVENT</h3>
                        </div>
                    </div>
                </a><!--link creatEvent-->

            </div><!--containerHome-->

   
<div class="allEvents col-xs-12">
    <h3>My Events</h3>
</div>

<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<?php foreach($user->getEvents() as $event) { ?>

<div class="event-box">
		<img src="images/<?= $event->getUser()->getUserName() ?>.jpg">
		<h3><a href="event.php?id=<?= $event->getId(); ?>"><?= $event->getSport()->getSport(); ?></a></h3>
		<h5>Posted by: <a href="profile.php?id=<?= $event->getUser()->getUserId() ?>"><?= $event->getUser()->getUserName() ?></a></h5>
		<p><?= "at " . $event->getEventPlace() . ", " . "on: " . $event->getEventDate('d-m-y H:i') . ", " . $event->getEventNumberPeople() . " more needed"?></p>
	</div>
	
<?php } ?>



 <?php
 	$events = EventQuery::create()
        ->limit(100)
        ->orderByEventDate('desc')
        ->find();
?>

<div class="allEvents col-xs-12">
    <h3>All Events</h3>
</div>

<?php foreach($events as $event) { ?>
	<div class="event-box">
		<img src="images/<?= $event->getUser()->getUserName(); ?>.jpg">
		<h3><a href="event.php?id=<?= $event->getId(); ?>"><?= $event->getSport()->getSport(); ?></a></h3>
		<h5>Posted by: <a href="profile.php?id=<?= $event->getUser()->getUserId() ?>"><?= $event->getUser()->getUserName() ?></a></h5>
		<p><?= "at " . $event->getEventPlace() . ", " . "on: " . $event->getEventDate('d-m-y H:i') . ", " . $event->getEventNumberPeople() . " more needed"?></p>
	</div>
<?php } ?>


             </div><!--end of row-->
</section><!--end of container-->


<?php include ("views/_templates/footer.php"); ?>
