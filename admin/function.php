<?php

include("dbconnect.php");

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone_no = $_POST['phone_no'];
    $no_of_room = $_POST['no_of_room'];
    $role = $_POST['landlord'];

    if ($role==""){
        $role="normal resident";
    }
    
    $q = "INSERT INTO admin (username, password, phone_no, no_of_room, role) 
    VALUES ('$username', '$password', '$phone_no', '$no_of_room', '$role')";   
    $r = mysqli_query ($dbc, $q) OR die(mysqli_error($dbc)); // Run the query.
    
 if ($r){

 // If it ran OK.
	$q2 = "SELECT id FROM admin WHERE username='$username' AND password='$password'";		
	$r2 = mysqli_query ($dbc, $q2); // Run the query.

    while ($row = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        
        $adminid = $row['id'];
      
    }

    $q3 = "INSERT INTO house_summary (admin_id) 
    VALUES ('$adminid')";   
    $r3 = mysqli_query ($dbc, $q3) OR die(mysqli_error($dbc)); // Run the query.
      // Print a message:

    // index.php
    header("Location: login.php");


    } else { // If it did not run OK.
  
      // Public message:
      echo '<script>

      alert("Error. Please Try Again");
    
    </script>'; 
  
    header("Location: register.php");
    exit();
        
    } // End of if ($r) IF.

        mysqli_close($dbc); // Close the database connection.
    
        header("Location: login.php");

    exit();
    
  }
 
 //This is checking LOGIN for CUSTOMER
 function check_login_admin($dbc, $username = '', $password = '') {



		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT id, username FROM admin WHERE username='$username' AND password='$password'";		
		$r = mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	
			// Return true and the record:
			return array(true, $row);
			
		}
		
	 // End of empty($errors) IF.

}
    

    


?>