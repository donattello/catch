<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CATCH</title>
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/mystyles.css" rel="stylesheet" media="screen">
</head>
 
<body id="menu" class="home">
    <!-- home -->
    <?php include "views/_templates/header.php"; ?>
    
   <section class="container-fluid" id="menu2">
       <div class="row menu">
           
           <a href="viewProfile.php">
               <section class="menuItem" id="viewProfile">
                   <h3>View Profile</h3>
                   <div class="line">
                    </div><!--line-->
                </section> <!--viewProfile-->
            </a>
            
           <a href="editProfile.php">
            <section class="menuItem" id="editProfile">
                <h3>Edit Profile</h3>
                <div class="line">
                </div><!--line-->
            </section><!--line-->
            </a>
            
           <a href="appSettings.php">
            <section class="menuItem" id="appSettings">
                <h3>App Settings</h3>
                <div class="line">
                </div><!--line-->
            </section><!--appSettings-->
            </a>
           
        </div><!--row-->
               
            <button type="button" id="signOutBtn">Sign Out</button>
    </section>
    
</body>
</html>