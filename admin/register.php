<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin Register</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body style="background-image: url('css/img/registerbg.jpg'); background-attachment: fixed; background-size: cover;">
        <div class="register-container">
            <h1>Register Now!</h1>
            <form action="function.php" method="POST">
                <div style="float:left;">
                <p>Username</p>
                <input type="text" name="username" placeholder="Enter Username" maxlength="10" required>
                </div>
                <div style="float:right;">
                <p>No. of Room</p>
                <input type="text" name="no_of_room" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Enter Number of Room" maxlength="2" required>
                </div>
                <div style="float:left;">
                <p>Password</p>
                <input type="password" name="password" placeholder="Enter Password" maxlength="10" required>
                </div>
                <div style="float:right;">
                <p>Phone No.</p>
                <input type="text" id="phone_no" name="phone_no" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Enter Phone Number" maxlength="10" required>
                </div>
                <div style="float:left;">
                <p>Landlord:</p>
                <input type="checkbox" id="landlord" name="landlord" value="landlord">
                </div>
                <input type="submit" name="register" value="Register">
                <a href="login.php">Already Have an Account?</a>
            </form>
        </div>
</body>
</html>