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

<!-- login form box -->
<form method="post" action="index.php" name="loginform">
    <div class="form-group">
        <div class="description col-xs-12">
            <label for="login_input_username">Username</label>
        </div>
        <div class="formFields col-sm-10">
            <input id="login_input_username" class="login_input text-area" type="text" name="user_name" required />
        </div>
    </div>
    <div class="form-group">
        <label for="login_input_password">Password</label>
        <div class="formFields col-sm-10">
            <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required />
        </div>
    </div>
    <div class="form-group">
        <div class="formFields col-sm-10">    
            <input type="submit"  name="login" value="Log in" />
        </div>
    </div>

</form>

<a href="register.php">Register new account</a>
