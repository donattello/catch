<?php include ("views/_templates/header.php"); ?>


<section class="container-fluid" id="home">
    <div class="row homecontainer">
        
        <div class="containerHome col-xs-11">
            <a href="newMatches.php">
                <div class="homeButton button1 col-xs-6">
                    <div id="colourHomeButton">
                        <img src="icons/tick.png" width="40px" height="40px" class="image">
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
                        <img src="icons/calendar.png" width="40px" height="40px" class="image">
                        <div class="position">
                        <h3>PLANNER</h3>
                        </div>
                    </div>
                </div>
            </a>
            
            <a href="friends.php">
                <div class="friends button1 col-xs-6">
                    <div id="colourFriends">
                        <img src="icons/smile.png" width="40px" height="40px" class="image">
                        <div class="position">
                        <h3>FRIENDS</h3>
                        </div>
                    </div>
                </div>
            </a>

            <a href="chat.php">
                <div class="chat button1 col-xs-6">
                    <div id="colourChat">
                        <img src="icons/chat.png" width="40px" height="40px" class="image">
                        <div class="position">
                        <h3>CHAT</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        
    </div>

</section>



<?php
    // ... ask if we are logged in here:
    if ($login->isUserLoggedIn() == true) {
        // the user is logged in. you can do whatever you want here.
        // for demonstration purposes, we simply show the "you are logged in" view.
        include("views/logged_in.php");

    } else {
        // the user is not logged in. you can do whatever you want here.
        // for demonstration purposes, we simply show the "you are not logged in" view.
        include("views/not_logged_in.php");
    }
?>


<?php include ("views/_templates/footer.php"); ?>
