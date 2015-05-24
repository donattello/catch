 <?php include "views/_templates/header.php"; ?>

<section class="container">
    <div class="row">
        
        <section class="testAvatar col-xs-4">
            <img src="icons/AvatarTest.png" height="100px" width="100px">
        </section>

        <div class="name col-xs-8">
            <h1><?= $_SESSION["user_name"] ?></h1>
        </div>



        <form action="processing/add-profile.php" method="post" enctype="multipart/form-data">

        <!--
            <div class="form-group">
                <input type="file" name="avatar" id="avatar" />
            </div>
        -->

            <div class="form-group">
                <div class="description col-xs-12">
                    <label for="inputAge"><h3>Enter your age</h3></label>
                </div>
                <div class="col-xs-12">
                    <input type="text" name="age" class="text-area" required>
                </div>
            </div><!--form-group Age-->

            <div class="form-group">
                <div class="description col-xs-12">
                    <label for="selectGender"><h3>Gender</h3></label>
                </div>
                <div class="col-xs-12">
                    <select name="gender" class="selects">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div><!--form-group Gender-->

            <div class="form-group">
                <div class="description col-xs-12">
                    <label for="selectActivity"><h3>Select Category</h3></label>
                </div>
                <div class="col-xs-12">
                    <?php include ("views/_templates/get-event-types.php"); ?>
                </div>
            </div><!--form-group Activity-->

            <div class="form-group">
                <div class="description col-xs-12">
                    <label for="about"><h3>About <?= $_SESSION["user_name"] ?></h3></label>
                </div>
                <div class="text col-xs-12">
                    <textarea rows="8" cols="40" name="user_bio" class="text-area" required></textarea>
                </div>
            </div><!--form-group About-->

            <button type="submit" name="create-profile" class="btn btn-primary">Create Profile</button>
        </form>
    
    </div><!--end of row-->
    
</section><!--end of container-->









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