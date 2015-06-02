<?php include 'views/_templates/header.php'; ?>

<?php
	$userId = $_GET["id"];
	$PrintUserProfile = UserQuery::create()->findPK($userId);
?>

<?php if(!empty($PrintUserProfile)) { ?>

	<section class="container viewProf">
	    <div class="row">
	        <section class="profileImg col-xs-12">
	            <button type="button" class="close glyphicon glyphicon-remove" data-dismiss="modal"></button>
	        </section><!--end of profielImg-->

	        <section class="chatIcon profile col-xs-12">
	            <img src="icons/IconWebChatNew1.png" height="30px" width="30px" class="col-xs-2">
	        </section><!--end of chatIcon-->

	        <section class="profileName profile col-xs-12">
	            <div class="name col-xs-3">
	                <h3>Name:</h3>
	            </div><!--end of name-->
	            <div class="printName col-xs-9">
	                <h3><?= $PrintUserProfile->getUserName(); ?></h3>
	            </div><!--end of printName-->
	        </section><!--end of profileName-->

	        <section class="profileAge profile col-xs-12">
	            <div class="age col-xs-3">
	                <h3>Age:</h3>
	            </div><!--end of Age-->
	            <div class="printAge col-xs-9">
	                <h3><?= $PrintUserProfile->getUserAge(); ?></h3>
	            </div><!--end of printAge-->
	        </section><!--end of profileAge-->

	        <section class="profileGender profile col-xs-12">
	            <div class="gender col-xs-3">
	                <h3>Gender:</h3>
	            </div><!--end of gender-->
	            <div class="printGender col-xs-9">
	                <h3><?= $PrintUserProfile->getUserGender(); ?></h3>
	            </div><!--end of printGender-->
	        </section><!--end of profileGender-->

	        <section class="profileActivity profile col-xs-12">
	            <div class="activity col-xs-3">
	                <h3>Activities:</h3>
	            </div><!--end of activity-->
	            <div class="printActivity col-xs-9">
	            </div><!--end of printActivity-->
	        </section><!--end of profileActivity-->

	        <section class="profileAbout profile col-xs-12">
	            <div class="about col-xs-3">
	                <h3>About:</h3>
	            </div><!--end of about-->
	            <div class="printAbout col-xs-9">
	                <h3><?= $PrintUserProfile->getBio(); ?></h3>
	            </div><!--end of printAbout-->
	        </section><!--end of profileAbout-->

	    </div><!--end of profile row-->
	</section><!--end of profile-->

<?php } else { ?>
	<h1>No User found</h1>
<?php } ?>


<?php include 'views/_templates/footer.php'; ?>