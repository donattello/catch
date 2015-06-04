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

<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/mystyles.css" rel="stylesheet" media="screen">

<section class="container">
    <div class="row">
        
        <div class="logoLogIn col-xs-6 col-xs-offset-3">
            <img src="images/logo.png">
        </div>
        
            
            <!-- register form -->
            <form method="post" action="register.php" name="registerform">

                <!-- the user name input field uses a HTML5 pattern check -->
            <div class="form-group">
                  <div class="formFields col-xs-10 col-xs-offset-1">
                        <input id="login_input_username" class="login_input text-area" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="User Name" required />
                 </div><!--end of sign in form-->
            </div><!--end of form-group sing in form-->

                <!-- the email input field uses a HTML5 email type check -->
            <div class="form-group">
                <div class="formFields col-xs-10 col-xs-offset-1">
                    <input id="login_input_email" class="login_input text-area" type="email" name="user_email" placeholder="User Email" required />
                </div><!--end of sign in form-->
            </div><!--end of form-group sign in form-->

            <div class="form-group">
                  <div class="formFields col-xs-10 col-xs-offset-1">
                    <input id="login_input_password_new" class="login_input text-area" type="password" name="user_password_new" pattern=".{6,}" placeholder="Password" required autocomplete="off" />
                </div><!--end of sign in form-->
            </div><!--end of form-group sign in form-->

                
            <div class="form-group">
                  <div class="formFields col-xs-10 col-xs-offset-1">
                    <input id="login_input_password_repeat" class="login_input text-area" type="password" name="user_password_repeat" pattern=".{6,}" placeholder="Retype Password" required autocomplete="off" />
                </div><!--end of sign in form-->
            </div><!--end of form-group sign in form-->
            
             <div class="form-group">
                <div class="formFields col-xs-10 col-xs-offset-1">    
                    <button type="submit" class="btn btn-block" name="register">Register</button>
                </div>
            </div>

            </form>
        
                
            <div class="link col-xs-6 col-xs-offset-4">
                <a href="login_user.php">Back to Login Page</a>
            </div>
        
    </div><!--end of form row-->
</section><!--end of form container-->



