<?php require_once 'classes/Login.php'; ?>   
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
       
            <!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
            <a href="login_user.php?logout" id="signOutBtn">Sign Out</a>         
       
<!--            <button type="button" id="signOutBtn">Sign Out</button>-->
    </section>
    
    
<?php include ("views/_templates/footer.php"); ?>