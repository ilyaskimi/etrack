<?php

include("dbconnect.php");

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $serial_number = $_POST['serial_number'];
    $address = $_POST['address'];
    $phone_no = $_POST['phone_no'];
    $no_of_room = $_POST['no_of_room'];
    $role = $_POST['landlord'];

    $q0 = "SELECT username FROM admin WHERE username='$username'";		
    $r0 = mysqli_query ($dbc, $q0); // Run the query.
    if(mysqli_num_rows($r0)==1){
  
            // Public message:
            echo "<script>alert('Email already TAKEN, try another Email'); window.location.href= 'register.php';</script>";
    }
     else{ 
    $q1 = "INSERT INTO admin (username, password, phone_no, role) 
    VALUES ('$username', '$password', '$phone_no', '$role')";   
    $r1 = mysqli_query ($dbc, $q1) OR die(mysqli_error($dbc)); // Run the query.
    
 if ($r1){

 // If it ran OK.
	$q2 = "SELECT id FROM admin WHERE username='$username' AND password='$password'";		
	$r2 = mysqli_query ($dbc, $q2); // Run the query.

    while ($row = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        
        $adminid = $row['id'];
      
    }

    $q3 = "INSERT INTO house_summary (serial_number,admin_id,address, no_room) 
    VALUES ('$serial_number','$adminid','$address', '$no_of_room')";   
    $r3 = mysqli_query ($dbc, $q3) OR die(mysqli_error($dbc)); // Run the query.

    $q5 = "SELECT id FROM house_summary WHERE admin_id='$adminid'";   
    $r5 = mysqli_query ($dbc, $q5) OR die(mysqli_error($dbc)); // Run the query.
    while ($row = mysqli_fetch_array($r5, MYSQLI_ASSOC)) {
        
      $houseid = $row['id'];
    
  }
    
  $i = 1;

  while($i <=$no_of_room){

    $q4 = "INSERT INTO room_summary (house_id, room_no) 
    VALUES ('$houseid', '$i')";   
    $r4 = mysqli_query ($dbc, $q4) OR die(mysqli_error($dbc)); // Run the query.

    $i++;
  }

      // Print a message:

    // index.php
    echo "<script>alert('Register Successfully'); window.location.href= 'adminT.php';</script>";


    } else { // If it did not run OK.
  
      // Public message:
      echo '<script>

      alert("Error. Please Try Again");
    
    </script>'; 
  
    header("Location: register.php");
    exit();
        
    } // End of if ($r) IF.

        mysqli_close($dbc); // Close the database connection.
    

    exit();
    }
  }
 
 //This is checking LOGIN for ADMIN
 function check_login_admin($dbc, $username = '', $houseid = '', $password = '') {



		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT house_summary.admin_id, username, role, house_summary.id FROM admin 
          INNER JOIN house_summary ON admin.id=house_summary.admin_id
          WHERE username='$username' AND password='$password' AND house_summary.id='$houseid'";		
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

 //This is checking LOGIN for RESIDENT 
 function check_login_resident($dbc, $username = '', $password = '') {



  // Retrieve the user_id and first_name for that email/password combination:
  $q = "SELECT id, username FROM resident WHERE username='$username' AND password='$password'";		
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

//Register Resident
if (isset($_POST['registerResident'])) {

  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $room_no = $_POST['room_no'];
  $phone_no = $_POST['phone_no'];
  $house_id = $_POST['house_id'];

  //Email Checking
  $q0 = "SELECT email FROM resident WHERE email='$email'";		
  $r0 = mysqli_query ($dbc, $q0); // Run the query.
  if(mysqli_num_rows($r0)==1){

            // Public message:
            echo "<script>alert('Email already TAKEN, try another Email'); window.location.href= '../resident/register.php';</script>";

  } else {
    // House ID Checking
    $q4 = "SELECT house_summary.id FROM house_summary WHERE house_summary.id='$house_id'";		
    $r4 = mysqli_query ($dbc, $q4); // Run the query.
    if(mysqli_num_rows($r4)==1){
  
    //Room No. Checking
    $q5 = "SELECT * FROM room_summary WHERE room_summary.house_id='$house_id' AND room_summary.room_no='$room_no'";		
    $r5 = mysqli_query ($dbc, $q5); // Run the query.
    if(mysqli_num_rows($r5)==1){

      $q3 = "SELECT * FROM resident WHERE room_no='$room_no' AND house_id='$house_id'";		
      $r3 = mysqli_query ($dbc, $q3); // Run the query.

      if(mysqli_num_rows($r3)>0){
                    // Public message:
                    echo "<script>alert('Room Number already TAKEN, try different Room Number'); window.location.href= '../resident/register.php';</script>";
      }
      else{

        $q1 = "INSERT INTO resident (email, username, password, room_no, phone_no, house_id) 
        VALUES ('$email','$username', '$password', '$room_no', '$phone_no', '$house_id')";   
        $r1 = mysqli_query ($dbc, $q1) OR die(mysqli_error($dbc)); // Run the query.
        
      if ($r1){ 
      
          // Print a message:
      
        // index.php
        echo "<script>alert('Register Successfully'); window.location.href= '../resident/residentR.php';</script>";
      
      
        } else { // If it did not run OK.
      
          // Public message:
          echo '<script>
      
          alert("Error. Please Try Again");
        
        </script>'; 
      
        header("Location: ../resident/register.php");
        exit();
            
        } // End of if ($r) IF.
      
            mysqli_close($dbc); // Close the database connection.
        
      
        exit();

      }

    }
    else{
                    // Public message:
                    echo "<script>alert('Room Number does NOT EXIST, try different Room Number'); window.location.href= '../resident/register.php';</script>";
    }
  }
    else{
                    // Public message:
              echo "<script>alert('House ID does NOT EXIST, try different House ID'); window.location.href= '../resident/register.php';</script>";
    }
  }
}
    
//Edit and Update Resident's Account
if (isset($_POST['update'])) {

  $residentid = $_POST['id'];
  $username = $_POST['username'];
  $room_no = $_POST['room_no'];
  $phone_no = $_POST['phone_no'];

  $q1="UPDATE resident SET username='$username', room_no='$room_no', phone_no='$phone_no' WHERE id='$residentid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Updated Successfully'); window.location.href= 'manageT.php';</script>";
  }

}

//Delete Resident
if (isset($_POST['delete'])) {
  
  $residentid = $_POST['delete'];

  $q1 = "DELETE FROM resident WHERE id='$residentid'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>alert('Deleted Successfully'); window.location.href= 'manageT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'manageT.php';</script>";
    }

}

//Add New House Account
if (isset($_POST['addHouse'])) {

  $adminid = $_POST['addHouse'];
  $serial_number = $_POST['serial_number'];
  $address = $_POST['address'];
  $room_no = $_POST['room_no'];

  $q1="INSERT INTO house_summary (serial_number, admin_id, address, no_room) 
      VALUES ('$serial_number', '$adminid', ' $address', '$room_no')";
  $r1=mysqli_query($dbc,$q1);

  if($r1){

    $q5 = "SELECT id FROM house_summary WHERE admin_id='$adminid' AND serial_number='$serial_number'";   
    $r5 = mysqli_query ($dbc, $q5) OR die(mysqli_error($dbc)); // Run the query.
    while ($row = mysqli_fetch_array($r5, MYSQLI_ASSOC)) {
        
      $houseid = $row['id'];
    
  }

    $i = 1;

    while($i <=$room_no){
  
      $q2 = "INSERT INTO room_summary (house_id, room_no) 
      VALUES ('$houseid', '$i')";   
      $r2 = mysqli_query ($dbc, $q2) OR die(mysqli_error($dbc)); // Run the query.
  
      $i++;
    }

        // index.php
        echo "<script>alert('House Registered Successfully'); window.location.href= 'addT.php';</script>";
  }
  else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'addT.php';</script>";
    }

}

//Update House Limit Usage AdminR
if (isset($_POST['addLimitHR'])) {

  $houseid = $_POST['addLimitHR'];
  $house_limit = $_POST['house_limit'];

  $q1="UPDATE house_summary SET limit_house='$house_limit' WHERE id='$houseid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Limit Set Successfully'); window.location.href= 'dataR.php';</script>";
  }

}

//Update House Limit Usage AdminT
if (isset($_POST['addLimitHT'])) {

  $houseid = $_POST['addLimitHT'];
  $house_limit = $_POST['house_limit'];

  $q1="UPDATE house_summary SET limit_house='$house_limit' WHERE id='$houseid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Limit Set Successfully'); window.location.href= 'dataT.php';</script>";
  }

}

//Delete House Limit Usage AdminR
if (isset($_POST['deleteLimitHR'])) {
  
  $houseid = $_POST['deleteLimitHR'];
  $house_limit ="0";

  $q1="UPDATE house_summary SET limit_house='$house_limit' WHERE id='$houseid'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>alert('Deleted Successfully'); window.location.href= 'dataR.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'dataR.php';</script>";
    }

}

//Delete House Limit Usage AdminT
if (isset($_POST['deleteLimitHT'])) {
  
  $houseid = $_POST['deleteLimitHT'];
  $house_limit ="0";

  $q1="UPDATE house_summary SET limit_house='$house_limit' WHERE id='$houseid'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>alert('Deleted Successfully'); window.location.href= 'dataT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'dataT.php';</script>";
    }

}

//Room Switch
if (isset($_POST['status'])) {
  
  $residentid = $_POST['id'];
  $room_status = $_POST['status'];

  $q1="UPDATE resident SET room_status='$room_status' WHERE id='$residentid'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'manageT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'manageT.php';</script>";
    }

}

?>