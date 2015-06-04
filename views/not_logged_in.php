<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>

<section class="container">
    <div class="row">
        
        <div class="logoLogIn col-xs-6 col-xs-offset-3">
            <img src="images/logo.png">
        </div>

        <!-- login form box -->
        <form method="post" action="index.php" name="loginform">

            <div class="form-group">
                <div class="formFields col-xs-10 col-xs-offset-1">
                    <input id="login_input_username" class="login_input text-area" type="text" name="user_name" placeholder="Username" required />
                </div>
            </div>

            <div class="form-group">
                <div class="formFields col-xs-10 col-xs-offset-1">
                    <input id="login_input_password" class="login_input text-area" type="password" name="user_password" placeholder="Password" autocomplete="off" required />
                </div>
            </div>

            <div class="form-group">
                <div class="formFields col-xs-10 col-xs-offset-1">    
                    <button type="submit" class="btn btn-block" name="login">Submit</button>
                </div>
            </div>

        </form>
        
        <div class="link col-xs-6 col-xs-offset-4">
            <a href="register.php">Register new account</a>
        </div>
    
    </div>
</section>
