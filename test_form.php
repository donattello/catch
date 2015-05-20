 <?php include "views/_templates/header.php"; ?>
<!-- login form box -->

        <form method="post" action="index.php" name="loginform">

            <div class="form-group">
                <label for="login_input_username">Username</label>
                <div class="formFields col-xs-10">
                    <input id="login_input_username" class="login_input" type="text" name="user_name" required />
                </div>
            </div>
            <div class="form-group">
                <label for="login_input_password">Password</label>
                <div class="formFields col-xs-10">
                    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required />
                </div>
            </div>
            <div class="form-group">
                <div class="formFields col-xs-10">    
                    <input type="submit"  name="login" value="Log in" />
                </div>
            </div>

        </form>
    

<a href="register.php">Register new account</a>



<!-- register form -->
<form method="post" action="register.php" name="registerform">

    <div class="form-group">
        <!-- the user name input field uses a HTML5 pattern check -->
        <label for="login_input_username">Username</label>
        <div class="formFields col-xs-10">
            <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
        </div>
    </div>
    
    <div class="form-group">
        <!-- the email input field uses a HTML5 email type check -->
        <label for="login_input_email">User's email</label>
        <div class="formFields col-xs-10">
            <input id="login_input_email" class="login_input" type="email" name="user_email" required />
        </div>
    </div>
    
    <div class="form-group">
        <label for="login_input_password_new">Password (min. 6 characters)</label>
        <div class="formFields col-xs-10">
            <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
        </div>
    </div>
    
    <div class="form-group">
        <label for="login_input_password_repeat">Repeat password</label>
        <div class="formFields col-xs-10">
            <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
        </div>
    </div>
    
    <div class="form-group">
        <div class="formFields col-xs-10">
            <input type="submit"  name="register" value="Register" />
        </div>
    </div>
</form>

<!-- backlink -->
<a href="index.php">Back to Login Page</a>



<section class="container">
    <div class="row">
        
    </div>
</section>

<?php include ("views/_templates/footer.php"); ?>


