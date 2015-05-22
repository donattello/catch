 <?php include "views/_templates/header.php"; ?>

<h1><?= $_SESSION["user_name"] ?></h1>
   
<form action="processing/add-profile.php" method="post">
    <input type="text" name="age" placeholder="age" required>
    
    <select name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
    
     <?php include ("views/_templates/get-event-types.php"); ?>
    
    <textarea rows="4" cols="50" name="user_bio" placeholder="write about yourself" required></textarea>
    <input type="submit" name="create-profile" value="Create Profile">
</form>









<!--
    <div id="editProfile1">
        <h1>Members Area</h1>
        <p><b>User Info</b></p>
        
        <table>
            <tr>
                <td>Username:</td>
                <td><?php //echo $results['user_login'];?></td>
            </tr>
        </table>
        
        <p>This is the members only area. Only logged in users can view this page. Please <a href="login.php?action=logout">click here to logout</a> </p>
    </div>
-->
    
<?php include ("views/_templates/footer.php"); ?>