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
                
                
<!--
                <a href="_/php/existingEvents.php">
                    <div class="existingEvents col-xs-6">
                        <div id="colourExistingEvents">
                            <div class="position">
                                <h3>EXISTING</h3>
                                <h3>EVENTS</h3>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="_/php/pastEvents.php">
                    <div class="pastEvents col-xs-6">
                       <div id="colourPastEvents">
                            <div class="position">
                                <h3>PAST</h3>
                                <h3>EVENTS</h3>
                            </div>
                       </div>
                    </div>
                </a>
-->
            </div><!--containerHome-->
            
        </div><!--row homecontainer-->
    </section><!--container-->



<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<div>
	Hey, <?= $user->getUserName(); ?>. You are logged in.
</div>

<div>
	Bio: <?= $user->getBio(); ?>
</div>



<div>
Your Events
</div>
<?php foreach($user->getEvents() as $event) { ?>
	<div>
		<h3><?= $event->getSport()->getSport(); ?></h3>
		<p>On: <?= $event->getEventDate('d-m-y H:i'); ?></p>
        <p><?= $event->getEventPlace(); ?></p>
        <p><?= $event->getEventNumberPeople(); ?></p>

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



<?php include ("views/_templates/footer.php"); ?>