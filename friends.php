<?php include "views/_templates/header.php"; ?>

<?php 

        $friendsIds = FriendQuery::create()
            ->filterByUserId($_SESSION["user_id"]) 
            ->select('friend_id')
            ->find();
        $friendsIdsArray = $friendsIds->toArray();
        
        $friends = UserQuery::create()
            ->findPKs($friendsIdsArray);

        
    ?>

<section>

<!--    <h3>Friends</h3>  -->
        <?php foreach($friends as $friend) { ?>
         
    
    <div class="event-box">
        
		<img src="images/<?= $friend->getUserName(); ?>.jpg" height="80px" width="80px">
        <a href="profile.php?id=<?= $friend->getUserId() ?>">
            <h3><?= $friend->getUserName(); ?></h3>
            <h5><?= $friend->getUserAge(); ?></h5>
            <h5><?= $friend->getUserGender(); ?></h5>
        </a>
        <div class="clearfix"></div>
	</div>
     <?php } ?>
    
 </section>
   
    
<?php include ("views/_templates/footer.php"); ?>