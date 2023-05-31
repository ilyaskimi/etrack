<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Register</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body style="background-image: url('css/img/registerbg.jpg'); background-attachment: fixed; background-size: cover;">
        <div class="register-container">
        <img src="css/img/logo.png" class="avatar">
            <h1>Register Now!</h1>
            <form action="function.php" method="POST">
                <div class="test" style="float:left;">
                <p>Email</p>
                <input type="text" name="username" placeholder="Enter Email" maxlength="50" required>
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
                <div style="float:right;">
                <p>Device Serial Number</p>
                <input type="text" name="serial_number" placeholder="Enter Device Serial Number" maxlength="10" required>
                </div>
                <div style="float:left;">
                <p>Address</p>
                <input type="text" name="address" placeholder="Enter Address" maxlength="70" required>
                </div>

                <div style="float:left;">
                <p style="float:left;">Landlord</p>
                <input type="radio" name="landlord" <?php if (isset($role) && $role=="landlord") echo "checked";?> value="landlord" required>
                </div>
                <div style="float:left;">
                <p style="float:left;">Normal Resident</p>
                <input type="radio" name="landlord" <?php if (isset($role) && $role=="normal resident") echo "checked";?> value="normal resident">
                </div>
                <br><br>
                <input type="submit" name="register" value="Register">
                <a href="login.php">Already Have an Account?</a>
            </form>
            </div>
</body>
</html>