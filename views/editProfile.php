<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CATCH</title>
<link href="../css/bootstrap.css" rel="stylesheet" media="screen">
<link href="../css/mystyles.css" rel="stylesheet" media="screen">
</head>
 
<body id="editProfile" class="home">
    <!-- home -->
    <?php include "header2.php"; ?>
    
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
    
</body>
</html>