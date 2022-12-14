<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin Register</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="login-container">
            <h1>Register Now!</h1>
            <form action="function.php" method="POST">
                <div style="float:left;">
                <p>Username</p>
                <input type="text" name="username" placeholder="Enter Username" maxlength="10" required>
                </div>
                <div style="float:right;">
                <p>No. of Room</p>
                <input type="text" name="no_of_room" placeholder="Enter Number of Room" maxlength="2" required>
                </div>
                <div style="float:left;">
                <p>Password</p>
                <input type="password" name="password" placeholder="Enter Password" maxlength="10" required>
                </div>
                <div style="float:right;">
                <p>Phone No.</p>
                <input type="number" id="phone_no" name="phone_no"placeholder="Enter Phone Number" maxlength="10" required>
                </div>
                <div style="float:left;">
                <p>Confirm Password</p>
                <input type="password" name="password2" placeholder="Enter Password" maxlength="10" required>
                </div>
                <div style="display:inline-block; width:45%;text-align:center;">
                <p>Landlord:</p>
                <input type="checkbox" id="landlord" name="landlord" value="landlord">
                </div>
                <input type="submit" name="register" value="Register">
                <a href="login.php">Already Have an Account?</a>
            </form>
        </div>
</body>
</html>