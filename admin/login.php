<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body style="background-image: url('css/img/loginbg.jpg'); background-attachment: fixed; background-size: cover;" >
        <div class="loginbg">
        <div class="login-container">
            <h1>Login Now!</h1>
            <form action="loginfunc.php" method="POST">
                <p>Username</p>
                <input type="text" name="username" placeholder="Enter Username">
                <p>Password</p>
                <input type="password" name="password" placeholder="Enter Password">
                <input type="submit" name="" value="Login">
                <a href="register.php">Don't Have an Account?</a>
            </form>
        </div>
    </div>
    </body>
</html>