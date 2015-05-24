<?php // include ("views/_templates/header.php"); ?>
<?php
$autoloader = require 'vendor/autoload.php';
$autoloader->add('generated-classes/', '');
require_once ('generated-conf/config.php');
?>

<section class="container">
    <div class="row">
        
        <section class="feed col-xs-12">
            <div class="feedAvatar col-xs-3">
                <img src="icons/AvatarTest.png" height="80px" width="80px">
            </div><!--end of feedAvatar-->
            
            <div class="feedDescription col-xs-9">
                <?php include "processing/add-event.php"; ?>
                <?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>
                <?php //foreach($user->getEvents() as $event) { ?>
                    <div>
                        <p><?= $user->getSport()->getSport() . "On:" . $user->getEventDate('d-m-y H:i') . $user->getEventPlace() . $user->getEventNumberPeople(); ?></p>
                    </div>
                <?php //} ?>
            </div><!--end of feedDescription-->
            
        </section><!--end of feed>

    </div><!--end of row-->
</section><!--end of container-->






<?php // include ("views/_templates/footer.php"); ?>