<?php include ("views/_templates/header.php"); ?>

 <form action="processing/add-event.php" method="post">
                    <select name="event-type">
                        <option value="0">Category</option>
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
                
                    <select name="day">
                        <option value="0">Day</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    </select>
                    
                    <input type="date" name="date">
                    
                    <input type="time" name="usr_time">
                   
                    <input type="text" name="place">
                   
                    <select name="people">
                        <option value="0">How many people</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>  
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                    </select>
                    <input type="submit" name="add-event" value="Add Event">
                </form>

<?php include ("views/_templates/footer.php"); ?>