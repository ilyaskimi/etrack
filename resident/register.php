<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resident Register</title>
        <link rel="stylesheet" type="text/css" href="../admin/css/style.css">
    </head>
    <body style="background-image: url('../admin/css/img/registerbg.jpg'); background-attachment: fixed; background-size: cover;">
        <div class="register-container">
        <img src="../admin/css/img/logo.png" class="avatar">
            <h1>Register Now!</h1>
            <form action="../admin/function.php" method="POST">
                <div class="test" style="float:left;">
                <p>Email</p>
                <input type="email" name="email" placeholder="Enter Email" maxlength="50" required>
                </div>
                <div style="float:right;">
                <p>Name</p>
                <input type="text" name="username" placeholder="Enter your Name" maxlength="10" required>
                </div>
                <div style="float:right;">
                <p>IC Number</p>
                <input type="text" name="ic_no" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Enter IC Number" maxlength="12" required>
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
                <p>House ID</p>
                <input type="text" name="house_id" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Enter House ID" maxlength="2" required>
                </div>
                <div style="float:right;">
                <p>Room Number</p>
                <input type="text" name="room_no" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Enter Room Number" maxlength="2" required>
                </div>
                <input type="submit" name="registerResident" value="Register">
                <a href="login.php">Already Have an Account?</a>
            </form>
        </div>
</body>
</html>