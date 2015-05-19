<?php include ("views/_templates/header.php"); ?>

 <form action="processing/add-event.php" method="post">

    <?php include ("views/_templates/get-event-types.php"); ?>

    <input type="date" name="date">

    <input type="time" name="time">

    <input type="text" name="place" placeholder="Where...">

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