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
        
        <div class="resize col-sm-6 col-sm-offset-3 hidden-xs">
            <h1>To access Catch please resize your browser!!! :-)</h1>
        </div>
        
        <div class="logoLogIn col-xs-8 col-xs-offset-2 hidden-sm hidden-md hidden-lg">
            <img src="images/logo.png" class="logo1">
        </div>

        <!-- login form box -->
        <form method="post" action="index.php" name="loginform" class="hidden-sm hidden-md hidden-lg">

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
        
        <div class="link col-xs-6 col-xs-offset-4 hidden-sm hidden-md hidden-lg">
            <a href="register.php">Register new account</a>
        </div>
    
    </div>
</section>
