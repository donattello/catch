 <?php include "views/_templates/header.php"; ?>
    
    <div id="editProfile1">
        <h1>Members Area</h1>
        <p><b>User Info</b></p>
        
        <table>
            <tr>
                <td>Username:</td>
                <td><?php echo $results['user_login'];?></td>
            </tr>
        </table>
        
        <p>This is the members only area. Only logged in users can view this page. Please <a href="login.php?action=logout">click here to logout</a> </p>
    </div>
    
<?php include ("views/_templates/footer.php"); ?>