<?php include ("views/_templates/header.php"); ?>

<section class="container">
    <div class="row">

         <form action="processing/add-event.php" method="post">
              <div class="form-group addEvent">
                  <div class="description col-xs-12">
                      <label for="category"><h3>Enter category</h3></label>
                  </div>
                  <div class="col-xs-12">
                    <?php include ("views/_templates/get-event-types.php"); ?>
                  </div>  
              </div><!--end of form-group category-->
             
             <div class="form-group">
                <div class="description col-xs-12">
                    <label for="date"><h3>Select date</h3></label>
                </div>
                <div class="col-xs-12">
                    <input type="date" name="date" class="text-area" required>
<!--                    <input type="text" name="date" class="text-area" required>-->
                </div>
             </div><!--end of form-group date-->
             

             <div class="form-group">
                <div class="description col-xs-12">
                    <label for="time"><h3>Select time</h3></label>
                </div>
                <div class="col-xs-12">
                    <input type="time" name="time" class="text-area" required>
<!--                    <input type="text" name="time" class="text-area" required>-->
                </div>
            </div><!--end of form-group time-->
             
             <div class="form-group">
                <div class="description col-xs-12">
                    <label for="where"><h3>Where</h3></label>
                </div>
                <div class="col-xs-12">
                    <input type="text" name="place" placeholder="Where..." class="text-area" required>
                </div>
            </div><!--end of form-group where-->

             <div class="form-group">
                <div class="description col-xs-12">
                    <label for="people"><h3>How many people wanted</h3></label>
                </div>
                <div class="col-xs-12">
                     <select name="people" class="selects">
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
                </div>
            </div><!--end of form-group people-->
            
            <input type="hidden" name="submitted" value="submitted">
            <button type="submit" name="add-event" class="btn btn-primary ADButton">Add Event</button>
            
        </form>
    
    </div>
</section>
<?php include ("views/_templates/footer.php"); ?>