<?php include ("views/_templates/header.php"); ?>
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
                
                    <div>
                        <p>feedDescription feedDescriptionfeed Descriptionfeed Descriptionfeed Descriptionfeed Descriptionfeed Description</p>
                    </div>
               
            </div><!--end of feedDescription-->
            
        </section><!--end of feed-->

    </div><!--end of row-->
</section><!--end of container-->






<?php // include ("views/_templates/footer.php"); ?>