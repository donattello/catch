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
        
        <section class="feed col-xs-12">
            <div class="feedAvatar col-xs-3">
                <img src="icons/AvatarTest.png" height="80px" width="80px">
            </div><!--end of feedAvatar-->
            
            <div class="feedDescription col-xs-9">
                    <p>The event description goes here</p>
            </div><!--end of feedDescription-->
            
        </section><!--end of feed-->

    </div><!--end of row-->
</section><!--end of container-->


<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

                <?php foreach($user->getEvents() as $event) { ?>
                    <div>
                        <p><?= $event->getSport()->getSport() . "On: " . $event->getEventDate('d-m-y H:i') . $event->getEventPlace() . $event->getEventNumberPeople(); ?></p>     
                    <?php } ?>
                    </div>


 <?php
    $events = EventQuery::create()
            ->limit(100)
            ->orderByEventDate('desc')
            ->find();
?>


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


<!--
<div>
	Hey, <?//= $user->getUserName(); ?>. You are logged in.
</div>

<div>
	Bio: <?//= $user->getBio(); ?>
</div>
-->

<!--
<?php // $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<div>
Your Events
</div>
<?php // foreach($user->getEvents() as $event) { ?>
	<div>
		<h3><? // = $event->getSport()->getSport(); ?></h3>
		<p>On: <? // = $event->getEventDate('d-m-y H:i'); ?></p>
        <p><? // = $event->getEventPlace(); ?></p>
        <p><? // = $event->getEventNumberPeople(); ?></p>

	</div>
<?php // } ?>
-->
