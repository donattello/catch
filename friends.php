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
        
		<img src="images/<?= $friend->getUserName(); ?>.jpg">
        <h3><a href="profile.php?id=<?= $friend->getUserId() ?>"><?= $friend->getUserName() . " " . $friend->getUserAge() . " " . $friend->getUserGender(); ?></a></h3>
        <div class="clearfix"></div>
	</div>
     <?php } ?>
            </section>
   
    
<?php include ("views/_templates/footer.php"); ?>