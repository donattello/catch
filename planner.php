<?php include ("views/_templates/header.php"); ?>
    
    <section class="container-fluid" id="planner2">
        <div class="row homecontainer">
            <div class="containerHome col-xs-11">
                <a href="views/createEvent.php">
                    <div class="createEvent button2">
                        <div class="position">
                            <h3>CREATE</h3>
                            <h3>AN EVENT</h3>
                        </div>
                    </div>
                </a><!--link creatEvent-->
                
                <form action="processing/add-event.php" method="post">
                    <select name="event-type">
                        <option value="1">Tennis</option>
                        <option value="2">Football</option>
                        <option value="3">Basketball</option>
                        <option value="4">Netball</option>
                        <option value="5">Volleyball</option>
                        <option value="6">Gym</option>
                        <option value="7">Running</option>
                        <option value="8">Cycling</option>
                        <option value="9">Rugby</option>
                        <option value="10">Badminton</option>
                    </select>
                    <input type="submit" name="add-event" value="Add Event">
                </form>
                
                
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
            </div><!--containerHome-->
            
        </div><!--row homecontainer-->
    </section><!--container-->

<?php include ("views/_templates/footer.php"); ?>