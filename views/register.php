<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<section class="container">
    <div class="row">
        
        <img src="../icons/logo.png">
            <!-- register form -->
            <form method="post" action="register.php" name="registerform">

                <!-- the user name input field uses a HTML5 pattern check -->
            <div class="form-group col-xs-12">
                  <div class="singInForm col-xs-10">
                        <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="User Name" required />
                 </div><!--end of sign in form-->
            </div><!--end of form-group sing in form-->

                <!-- the email input field uses a HTML5 email type check -->
            <div class="form-group col-xs-12">
                <div class="singInForm col-xs-10">
                    <input id="login_input_email" class="login_input" type="email" name="user_email" placeholder="User Email" required />
                </div><!--end of sign in form-->
            </div><!--end of form-group sign in form-->

            <div class="form-group col-xs-12">
                  <div class="singInForm col-xs-10">
                    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" placeholder="Password" required autocomplete="off" />
                </div><!--end of sign in form-->
            </div><!--end of form-group sign in form-->

                
            <div class="form-group col-xs-12">
                  <div class="singInForm col-xs-10">
                    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" placeholder="Retype Password" required autocomplete="off" />
                </div><!--end of sign in form-->
            </div><!--end of form-group sign in form-->
                
            <button type="submit" name="register" class="btn btn-primary ADButton">Register</button>
                      

            </form>
    </div><!--end of form row-->
</section><!--end of form container-->

<!-- backlink -->
<a href="login_user.php">Back to Login Page</a>
