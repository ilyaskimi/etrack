<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Need two helper files:
  require_once ('../admin/function.php');
  require_once ('../admin/dbconnect.php');
    
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check the login:
  list ($check, $data) = check_login_resident($dbc, $_REQUEST['email'], $_REQUEST['password']);
  
  if ($check) { // OK!
    
    // Set the session data:
    session_start();
    $_SESSION['id'] = $data['id'];
    $_SESSION['email'] = $data['email'];

    // Redirect:
    header("Location: residentR.php");


      
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
    <p><a href="localhost/eTrack/resident/login.php"></a>.</p>
  </body>
</html>