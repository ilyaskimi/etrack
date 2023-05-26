<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Resident Login</title>
        <link rel="stylesheet" type="text/css" href="../admin/css/style.css">
    </head>
    <body style="background-image: url('../admin/css/img/loginbg.jpg'); background-attachment: fixed; background-size: cover; background-position: center;" >
        <div class="loginbg">
        <div class="login-container">
            <img src="../admin/css/img/logo.png" class="avatar">
            <h1>Login Now!</h1>
            <form action="loginfunc.php" method="POST">
                <p>Email</p>
                <input type="text" name="email" placeholder="Enter Email">
                <p>Password</p>
                <input type="password" name="password" placeholder="Enter Password">
                <input type="submit" name="" value="Login">
                <a href="register.php">Don't Have an Account?</a>
            </form>
        </div>
    </div>
    </body>
</html>