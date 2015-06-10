<?php

	//session_start();
	//$autoloader = require 'vendor/autoload.php';
	//$autoloader->add('generated-classes/');
	//require_once ('generated-conf/config.php');
?>

<?php include ("views/_templates/header.php"); ?>

<?php $event = EventQuery::create()->findPK($_GET["id"]); ?>
<section class="container">
    <div class="row">
        <section class="eventBox col-xs-12">
            <div class="avatarEvent col-xs-3 col-xs-offset-4">
                <img src="images/<?= $event->getUser()->getUserName() ?>.jpg">
            </div><!--end of avatarEvent-->
            <div class="eventDiscription col-xs-12">
                <h3><a href="profile.php?id=<?= $event->getUser()->getUserId() ?>"><?= $event->getUser()->getUserName() ?></a>
                wants to play <?php echo $event->getSport()->getSport() . " at " . $event->getEventPlace() . ", " . "on: " . $event->getEventDate('d-m-y H:i') . ", " . $event->getEventNumberPeople() . " more needed."?></h3>  
            </div><!--eventDiscrioption-->
        </section><!--eventBox-->
        
        <section class="commentBoxEvent col-xs-12">
            <div class="comment col-xs-10">
                <input type="text" class="form-control" aria-describedby="basic-addon1" placeholder="write a comment"> 
            </div><!--end of comment-->
            <div class="commentBtn col-xs-2">
                <button type="button" class="btn btn-default sendBtn1">send</button>
            </div>
            <div class="commentText">
            </div><!--end of commentText-->
        </section><!--end of commentBox-->
    </div><!--end of row-->
</section><!--end of container-->

<?php include ("views/_templates/footer.php"); ?>