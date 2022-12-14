<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Need two helper files:
  require_once ('function.php');
  require_once ('dbconnect.php');
    
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check the login:
  list ($check, $data) = check_login_admin($dbc, $_REQUEST['username'], $_REQUEST['password']);
  
  if ($check) { // OK!
    
    // Set the session data:
    session_start();
    $_SESSION['id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if($_SESSION['role']=="landlord"){
    // Redirect:
    header("Location: adminT.php");
    }
    else{
      header("Location: adminR.php");
    }

      
  } else { // Unsuccessful!

    // Assign $data to $errors for login_page.inc.php:
        echo '<script>

        alert("Wrong Username or Password");
      
      </script>'; 
  
  }
    
  mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.


?>

<html>
  <head>
    <meta http-equiv="refresh" content="0; url='login.php" />
    <title>Redirecting...</title>
  </head>
  <body>
    <p><a href="localhost/eTrack/admin/login.php"></a>.</p>
  </body>
</html>