
<?php $user = UserQuery::create()->findPK($_SESSION["user_id"]); ?>

<div>
	Hey, <?= $user->getUserName(); ?>. You are logged in.
</div>

<section class="container-fluid" id="home">
    <div class="row homecontainer">
        
        <div class="containerHome col-xs-11">
            <a href="newMatches.php">
                <div class="homeButton button1 col-xs-6">
                    <div id="colourHomeButton">
                        <img src="images/tick.png" width="40px" height="40px" class="image">
                        <!--<div class="position">-->
                        <div id="newMatches">
                        <h3>NEW</h3>
                        <h3>MATCHES</h3>
                        </div>
                    </div>
                    <!--</div>-->
                </div>
            </a>
            
            <a href="planner.php">
                <div class="planner button1 col-xs-6">
                    <div id="colourPlanner">
                        <img src="images/calendar.png" width="40px" height="40px" class="image">
                        <div class="position">
                        <h3>PLANNER</h3>
                        </div>
                    </div>
                </div>
            </a>
            
            <a href="friends.php">
                <div class="friends button1 col-xs-6">
                    <div id="colourFriends">
                        <img src="images/smile.png" width="40px" height="40px" class="image">
                        <div class="position">
                        <h3>FRIENDS</h3>
                        </div>
                    </div>
                </div>
            </a>

            <a href="chat.php">
                <div class="chat button1 col-xs-6">
                    <div id="colourChat">
                        <img src="images/chat.png" width="40px" height="40px" class="image">
                        <div class="position">
                        <h3>CHAT</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        
    </div>

</section>
