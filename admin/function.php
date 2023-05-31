<?php

include("dbconnect.php");
require('../fpdf/fpdf.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $serial_number = $_POST['serial_number'];
    $address = $_POST['address'];
    $phone_no = $_POST['phone_no'];
    $no_of_room = $_POST['no_of_room'];
    $role = $_POST['landlord'];

  //Send Email for House ID
try {
  $mail=new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host='smtp.gmail.com';
  $mail->SMTPAuth=true;
  $mail->Username='kimi.ilyas@gmail.com';
  $mail->Password='zogtqvvldjlnwqdn';
  $mail->SMTPSecure='ssl';
  $mail->Port='465';
  $mail->addAddress($username);
  $mail->setFrom('kimi.ilyas@gmail.com');

  $mail->isHTML(true);

    


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

    $q6 = "INSERT INTO relay (serial_number) VALUES ('$serial_number')";
    $r6 = mysqli_query ($dbc, $q6); // Run the query.
    switch ($no_of_room) {
      case "1":
        $room1 = "UPDATE relay set room_no1='ON' WHERE serial_number='$serial_number'";
        $run_room1 = mysqli_query ($dbc, $room1); // Run the query.
        break;
      case "2":
        $room1 = "UPDATE relay set room_no1='ON' WHERE serial_number='$serial_number'";
        $run_room1 = mysqli_query ($dbc, $room1); // Run the query.
        $room2 = "UPDATE relay set room_no1='ON', room_no2='ON' WHERE serial_number='$serial_number'";
        $run_room2 = mysqli_query ($dbc, $room2); // Run the query.
        break;
      case "3":
        $room1 = "UPDATE relay set room_no1='ON' WHERE serial_number='$serial_number'";
        $run_room1 = mysqli_query ($dbc, $room1); // Run the query.
        $room2 = "UPDATE relay set room_no1='ON', room_no2='ON' WHERE serial_number='$serial_number'";
        $run_room2 = mysqli_query ($dbc, $room2); // Run the query.
        $room3 = "UPDATE relay set room_no1='ON', room_no2='ON', room_no3='ON' WHERE serial_number='$serial_number'";
        $run_room3 = mysqli_query ($dbc, $room3); // Run the query.
        break;
      case "4":
        $room1 = "UPDATE relay set room_no1='ON' WHERE serial_number='$serial_number'";
        $run_room1 = mysqli_query ($dbc, $room1); // Run the query.
        $room2 = "UPDATE relay set room_no1='ON', room_no2='ON' WHERE serial_number='$serial_number'";
        $run_room2 = mysqli_query ($dbc, $room2); // Run the query.
        $room3 = "UPDATE relay set room_no1='ON', room_no2='ON', room_no3='ON' WHERE serial_number='$serial_number'";
        $run_room3 = mysqli_query ($dbc, $room3); // Run the query.
        $room4 = "UPDATE relay set room_no1='ON', room_no2='ON', room_no3='ON', room_no4='ON' WHERE serial_number='$serial_number'";
        $run_room4 = mysqli_query ($dbc, $room4); // Run the query.
        break;
    }
    

    $q5 = "SELECT id FROM house_summary WHERE admin_id='$adminid'";   
    $r5 = mysqli_query ($dbc, $q5) OR die(mysqli_error($dbc)); // Run the query.
    while ($row = mysqli_fetch_array($r5, MYSQLI_ASSOC)) {
        
      $houseid = $row['id'];
    
  }



  $message="Your House ID: $houseid";
  $mail->Subject="E-Track Account Registered!";
  $mail->Body=$message;

  $mail->send();

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
} catch (\Throwable $th) {
   // Public message:
   echo "<script>alert('Email is not Valid. Please try again.'); window.location.href= 'register.php';</script>";
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
 function check_login_resident($dbc, $email = '', $password = '') {



  // Retrieve the user_id and first_name for that email/password combination:
  $q = "SELECT id, email FROM resident WHERE email='$email' AND password='$password'";		
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

        $q6 = "SELECT * FROM resident WHERE email='$email'";
        $r6 = mysqli_query ($dbc, $q6); // Run the query.
      
        if ($row = mysqli_fetch_array($r6, MYSQLI_ASSOC)) {
          $residentid=$row['id'];
          $houseid=$row['house_id'];
          $room_no=$row['room_no'];
           }



      $q7="UPDATE room_summary SET resident_id='$residentid' WHERE room_no='$room_no' AND house_id='$houseid'";
      $r7 = mysqli_query ($dbc, $q7); // Run the query.
      
      
        // index.php
        echo "<script>alert('Register Successfully'); window.location.href= '../resident/login.php';</script>";
      
      
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
    
//Edit and Update Resident's Account by Admin
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

  $q2 = "UPDATE room_summary SET resident_id=NULL WHERE resident_id='$residentid'";
  $r2 = mysqli_query($dbc, $q2);

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

  $q6 = "INSERT INTO relay (serial_number) VALUES ('$serial_number')";
    $r6 = mysqli_query ($dbc, $q6); // Run the query.
    switch ($no_of_room) {
      case "1":
        $room1 = "UPDATE relay set room_no1='ON' WHERE serial_number='$serial_number'";
        $run_room1 = mysqli_query ($dbc, $room1); // Run the query.
        break;
      case "2":
        $room2 = "UPDATE relay set room_no1='ON', room_no2='ON' WHERE serial_number='$serial_number'";
        $run_room2 = mysqli_query ($dbc, $room2); // Run the query.
        break;
      case "3":
        $room3 = "UPDATE relay set room_no1='ON', room_no2='ON', room_no3='ON' WHERE serial_number='$serial_number'";
        $run_room3 = mysqli_query ($dbc, $room3); // Run the query.
        break;
      case "4":
        $room4 = "UPDATE relay set room_no1='ON', room_no2='ON', room_no3='ON', room_no4='ON' WHERE serial_number='$serial_number'";
        $run_room4 = mysqli_query ($dbc, $room4); // Run the query.
        break;
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

//Room 1 Switch
if (isset($_POST['statusRoom1'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusRoom1'];

  $q1="UPDATE relay SET room_no1='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'manageT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'manageT.php';</script>";
    }

}

//Room 1 Switch
if (isset($_POST['statusRoom2'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusRoom2'];

  $q1="UPDATE relay SET room_no2='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'manageT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'manageT.php';</script>";
    }

}

//Room 1 Switch
if (isset($_POST['statusRoom3'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusRoom3'];

  $q1="UPDATE relay SET room_no3='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'manageT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'manageT.php';</script>";
    }

}

//Room 4 Switch
if (isset($_POST['statusRoom4'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusRoom4'];

  $q1="UPDATE relay SET room_no4='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'manageT.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'manageT.php';</script>";
    }

}

//Room 1 Switch From Profile
if (isset($_POST['statusProfile1'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusProfile1'];

  $q1="UPDATE relay SET room_no1='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'viewProfile.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'viewProfile.php';</script>";
    }

}
//Room 2 Switch From Profile
if (isset($_POST['statusProfile2'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusProfile2'];

  $q1="UPDATE relay SET room_no2='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'viewProfile.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'viewProfile.php';</script>";
    }

}
//Room 3 Switch From Profile
if (isset($_POST['statusProfile3'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusProfile3'];

  $q1="UPDATE relay SET room_no3='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'viewProfile.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'viewProfile.php';</script>";
    }

}
//Room 4 Switch From Profile
if (isset($_POST['statusProfile4'])) {
  
  $serial_number = $_POST['serial_number'];
  $room_status = $_POST['statusProfile4'];

  $q1="UPDATE relay SET room_no4='$room_status' WHERE serial_number='$serial_number'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>window.location.href= 'viewProfile.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= 'viewProfile.php';</script>";
    }

}

//Delete House Limit Usage Resident
if (isset($_POST['deleteLimitR'])) {
  
  $residentid = $_POST['deleteLimitR'];
  $house_limit ="0";
  $room_limit="0";

  $q1="UPDATE resident SET limit_house='$house_limit', limit_room='$room_limit' WHERE id='$residentid'";
  $r1 = mysqli_query($dbc, $q1);

  if($r1){
    // index.php
    echo "<script>alert('Deleted Successfully'); window.location.href= '../resident/dataR.php';</script>";
  } else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= '../resident/dataR.php';</script>";
    }

}

//Update House Limit Usage Resident
if (isset($_POST['addLimitRH'])) {

  $residentid = $_POST['addLimitRH'];
  $house_limit = $_POST['house_limit'];

  $q1="UPDATE resident SET limit_house='$house_limit' WHERE id='$residentid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('House Limit Set Successfully'); window.location.href= '../resident/dataR.php';</script>";
  }else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= '../resident/dataR.php';</script>";
    }

}

//Update Room Limit Usage Resident
if (isset($_POST['addLimitRR'])) {

  $residentid = $_POST['addLimitRR'];
  $room_limit = $_POST['room_limit'];

  $q1="UPDATE resident SET limit_room='$room_limit' WHERE id='$residentid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Room Limit Set Successfully'); window.location.href= '../resident/dataR.php';</script>";
  }else{
    // index.php
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href= '../resident/dataR.php';</script>";
    }

}

//Edit and Update Admin's Account
if (isset($_POST['updateProfile'])) {

  $adminid = $_POST['id'];
  $username = $_POST['username'];
  $phone_no = $_POST['phone_no'];
  $password = $_POST['password'];

  $q1="UPDATE admin SET username='$username', phone_no='$phone_no', password='$password' WHERE id='$adminid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Updated Successfully'); window.location.href= 'viewProfile.php';</script>";
  }

}

//Edit and Update Resident's Account by Resident
if (isset($_POST['updateProfileR'])) {

  $residentid = $_POST['id'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $phone_no = $_POST['phone_no'];

  $q1="UPDATE resident SET username='$username', phone_no='$phone_no', password='$password' WHERE id='$residentid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Updated Successfully'); window.location.href= '../resident/viewProfile.php';</script>";
  }

}

if (isset($_POST['upload'])) {

  $file = rand(1000,100000)."-".$_FILES['file']['name'];
  $file_loc = $_FILES['file']['tmp_name'];
  $file_size = $_FILES['file']['size'];
  $file_type = $_FILES['file']['type'];
  $file_name = $_POST['filename'];
  $residentid = $_POST['id'];
  $folder = "../upload/";

  $new_size = $file_size/1024;

  $new_file_name = strtolower($file);

  $final_file = str_replace(' ','-',$new_file_name);

  if(move_uploaded_file($file_loc,$folder.$final_file)){

  $q1="UPDATE resident SET proof_payment='$file_name', file_location='$final_file', last_updated=NOW() WHERE id='$residentid'";

    mysqli_query($dbc,$q1);

    // index.php
    echo "<script>alert('Uploaded Successfully'); window.location.href= '../resident/proofPay.php';</script>";
  
  } else{
        // index.php
        echo "<script>alert('Something went wrong. Please try again.'); window.location.href= '../resident/proofPay.php';</script>";
  
  }

}

//Clear Proof Payment File
if (isset($_POST['clearFile'])) {

  $residentid = $_POST['id'];
  $file_location = $_POST['file_location'];
  $proof_payment = null;
  $final_file = null;

  unlink("../upload/$file_location");
  $q1="UPDATE resident SET proof_payment='$proof_payment', file_location='$final_file', last_updated=NOW() WHERE id='$residentid'";
  $r1=mysqli_query($dbc,$q1);

  if($r1){
        // index.php
        echo "<script>alert('Cleared Successfully'); window.location.href= '../resident/proofPay.php';</script>";
  }

}

//Generate Resident PDF
if (isset($_POST['pdfResident'])) {

  $residentid=$_POST['pdfResident'];
  $houseid=$_POST['house_id'];
  $room_no=$_POST['room_no'];

  $q1="SELECT resident.id, resident.username, resident.email, resident.phone_no, resident.house_id, resident.room_no, 
      house_summary.address, house_summary.total_electric_usage_house, house_summary.total_rm,
      room_summary.total_electric_usage, room_summary.total_percentage_usage
      FROM resident 
      INNER JOIN house_summary ON resident.house_id=house_summary.id
      INNER JOIN room_summary ON resident.id=room_summary.resident_id
      WHERE resident.id='$residentid'";

  $r1=mysqli_query($dbc,$q1);

while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
        
  $id = $row['id'];
  $name = $row['username'];
  $email = $row['email'];
  $phone_no = $row['phone_no'];
  $house_id = $row['house_id'];
  $room_no = $row['room_no'];
  $address = $row['address'];
  $total_usageH = $row['total_electric_usage_house'];
  $total_usageR = $row['total_electric_usage'];
  $totalRM_house = $row['total_rm'];
  $total_percent = $row['total_percentage_usage'];

}

  $totalRM_room = $totalRM_house/$total_percent;

  $pdf = new FPDF('L', 'mm', "A4");
  $pdf -> AddPage();

  //PDF Ttile
  $pdf -> SetFont('Arial', 'B', 20);

  $pdf -> Cell(71, 10, '',0,0);
  $pdf -> Cell(59, 5, 'E-TRACK REPORT',0,0);
  $pdf -> Cell(59, 10, '',0,1);

  //PDF Heading 1
  $pdf -> SetFont('Arial', 'B', 15);

  $pdf -> Cell(71, 5, "Account's Information",0,0);
  $pdf -> Cell(59, 5, '',0,0);
  $pdf -> Cell(59, 10, 'House Details',0,1);

  //User Information
  $pdf -> SetFont('Arial', '', 10);

  $pdf -> Cell(35, 5, 'User ID:',0,0);
  $pdf -> Cell(95, 5, $id,0,0);

  //House Information
  $pdf -> Cell(25, 5, 'House ID:',0,0);
  $pdf -> Cell(34, 5, $house_id,0,1);

  //User Information
  $pdf -> Cell(35, 5, 'User Email:',0,0);
  $pdf -> Cell(95, 5, $email,0,0);

  //House Information
  $pdf -> Cell(25, 5, 'Address:',0,0);
  $pdf -> MultiCell(35, 5, $address,0,1);

  //PDF Heading 2
  $pdf -> SetFont('Arial', 'B', 15);

  $pdf -> Cell(71, 5, "Resident's Information",0,0);
  $pdf -> Cell(59, 5, '',0,0);
  $pdf -> Cell(59, 10, '',0,1);

  //User Information
  $pdf -> SetFont('Arial', '', 10);
  $pdf -> Cell(55, 5, "Resident's Name:",0,0);
  $pdf -> Cell(90, 5, $name,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  //User Information
  $pdf -> Cell(55, 5, "Resident's Phone No:",0,0);
  $pdf -> Cell(90, 5, $phone_no,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  //User Information
  $pdf -> Cell(55, 5, "Resident's Room No:",0,0);
  $pdf -> Cell(90, 5, $room_no,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  //User Information
  $pdf -> Cell(55, 5, "Resident's House Usage (kWh):",0,0);
  $pdf -> Cell(90, 5, $total_usageH,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);
  //User Information
  $pdf -> Cell(55, 5, "Resident's Room Usage (kWh):",0,0);
  $pdf -> Cell(90, 5, $total_usageR,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);
  //User Information
  $pdf -> Cell(55, 5, 'Payment Amount (RM):',0,0);
  $pdf -> Cell(90, 5, $totalRM_room,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  $pdf -> Cell(50, 10, '',0,1);

  //House Bill
  $pdf -> SetFont('Arial', 'B', 15);
  $pdf -> Cell(130, 5, 'House Bill',0,0);
  $pdf -> Cell(59, 5, '',0,0);

  $pdf -> SetFont('Arial', 'B', 10);
  $pdf -> Cell(189, 10, '',0,1);

  
  $pdf -> SetFont('Arial', 'B', 10);

  //Table Heading
  $pdf -> Cell(265, 6, 'kWh Sort By HOURS',1,1,'C');
  $pdf -> Cell(25, 6, 'Date',1,0,'C');
  $pdf -> Cell(10, 6, '00',1,0,'C');
  $pdf -> Cell(10, 6, '01',1,0,'C');
  $pdf -> Cell(10, 6, '02',1,0,'C');
  $pdf -> Cell(10, 6, '03',1,0,'C');
  $pdf -> Cell(10, 6, '04',1,0,'C');
  $pdf -> Cell(10, 6, '05',1,0,'C');
  $pdf -> Cell(10, 6, '06',1,0,'C');
  $pdf -> Cell(10, 6, '07',1,0,'C');
  $pdf -> Cell(10, 6, '08',1,0,'C');
  $pdf -> Cell(10, 6, '09',1,0,'C');
  $pdf -> Cell(10, 6, '10',1,0,'C');
  $pdf -> Cell(10, 6, '11',1,0,'C');
  $pdf -> Cell(10, 6, '12',1,0,'C');
  $pdf -> Cell(10, 6, '13',1,0,'C');
  $pdf -> Cell(10, 6, '14',1,0,'C');
  $pdf -> Cell(10, 6, '15',1,0,'C');
  $pdf -> Cell(10, 6, '16',1,0,'C');
  $pdf -> Cell(10, 6, '17',1,0,'C');
  $pdf -> Cell(10, 6, '18',1,0,'C');
  $pdf -> Cell(10, 6, '19',1,0,'C');
  $pdf -> Cell(10, 6, '20',1,0,'C');
  $pdf -> Cell(10, 6, '21',1,0,'C');
  $pdf -> Cell(10, 6, '22',1,0,'C');
  $pdf -> Cell(10, 6, '23',1,1,'C');
  //Table Heading END

  $q2="SELECT * FROM house_details WHERE house_id='$houseid'";
  $r2=mysqli_query($dbc,$q2);

  if(mysqli_num_rows($r2)>0){
    foreach($r2 as $row){
  //Table Content
  $pdf -> SetFont('Arial', '', 10);

    $pdf -> Cell(25, 6, $row['date'],1,0,'R');
    $pdf -> Cell(10, 6, $row['00hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['01hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['02hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['03hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['04hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['05hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['06hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['07hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['08hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['09hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['10hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['11hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['12hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['13hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['14hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['15hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['16hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['17hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['18hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['19hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['20hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['21hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['22hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['23hrs'],1,1,'R');

}
  
  }

  $pdf -> SetFont('Arial', 'B', 10);
  $pdf -> Cell(189, 10, '',0,1);

  
  $pdf -> SetFont('Arial', 'B', 10);

  //Room Bill
  $pdf -> SetFont('Arial', 'B', 15);
  $pdf -> Cell(130, 5, 'Room Bill',0,0);
  $pdf -> Cell(59, 5, '',0,0);

  $pdf -> SetFont('Arial', 'B', 10);
  $pdf -> Cell(189, 10, '',0,1);

  
  $pdf -> SetFont('Arial', 'B', 10);

    //Table Heading
  $pdf -> Cell(265, 6, 'kWh Sort By HOURS',1,1,'C');
  $pdf -> Cell(25, 6, 'Date',1,0,'C');
  $pdf -> Cell(10, 6, '00',1,0,'C');
  $pdf -> Cell(10, 6, '01',1,0,'C');
  $pdf -> Cell(10, 6, '02',1,0,'C');
  $pdf -> Cell(10, 6, '03',1,0,'C');
  $pdf -> Cell(10, 6, '04',1,0,'C');
  $pdf -> Cell(10, 6, '05',1,0,'C');
  $pdf -> Cell(10, 6, '06',1,0,'C');
  $pdf -> Cell(10, 6, '07',1,0,'C');
  $pdf -> Cell(10, 6, '08',1,0,'C');
  $pdf -> Cell(10, 6, '09',1,0,'C');
  $pdf -> Cell(10, 6, '10',1,0,'C');
  $pdf -> Cell(10, 6, '11',1,0,'C');
  $pdf -> Cell(10, 6, '12',1,0,'C');
  $pdf -> Cell(10, 6, '13',1,0,'C');
  $pdf -> Cell(10, 6, '14',1,0,'C');
  $pdf -> Cell(10, 6, '15',1,0,'C');
  $pdf -> Cell(10, 6, '16',1,0,'C');
  $pdf -> Cell(10, 6, '17',1,0,'C');
  $pdf -> Cell(10, 6, '18',1,0,'C');
  $pdf -> Cell(10, 6, '19',1,0,'C');
  $pdf -> Cell(10, 6, '20',1,0,'C');
  $pdf -> Cell(10, 6, '21',1,0,'C');
  $pdf -> Cell(10, 6, '22',1,0,'C');
  $pdf -> Cell(10, 6, '23',1,1,'C');
  //Table Heading END

  $q3="SELECT * FROM room_details WHERE house_id='$houseid' AND room_no='$room_no'";
  $r3=mysqli_query($dbc,$q3);

  if(mysqli_num_rows($r3)>0){
    foreach($r3 as $row){
  //Table Content
  $pdf -> SetFont('Arial', '', 10);

    $pdf -> Cell(25, 6, $row['date'],1,0,'R');
    $pdf -> Cell(10, 6, $row['00hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['01hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['02hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['03hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['04hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['05hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['06hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['07hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['08hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['09hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['10hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['11hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['12hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['13hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['14hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['15hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['16hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['17hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['18hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['19hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['20hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['21hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['22hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['23hrs'],1,1,'R');

}
  
  }

  // $pdf -> Cell(118, 6, '',0,0);
  // $pdf -> Cell(25, 6, 'Total',0,0);
  // $pdf -> Cell(45, 6, 'TOTAL kWh',1,1,'R');
  
  $pdf -> Output();
  }

  //Generate Admin PDF
if (isset($_POST['pdfAdmin'])) {

  $adminid=$_POST['pdfAdmin'];
  $houseid=$_POST['house_id'];

  $q1="SELECT admin.id, admin.username, admin.phone_no, admin.role, 
      house_summary.address, house_summary.total_electric_usage_house, house_summary.total_rm
      FROM admin 
      INNER JOIN house_summary ON admin.id=house_summary.admin_id
      WHERE admin.id='$adminid' AND house_summary.id='$houseid'";

  $r1=mysqli_query($dbc,$q1);

while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
        
  $id = $row['id'];
  $name = $row['username'];
  $phone_no = $row['phone_no'];
  $address = $row['address'];
  $total_usageH = $row['total_electric_usage_house'];
  $totalRM = $row['total_rm'];

}

  $pdf = new FPDF('L', 'mm', "A4");
  $pdf -> AddPage();

  //PDF Ttile
  $pdf -> SetFont('Arial', 'B', 20);

  $pdf -> Cell(71, 10, '',0,0);
  $pdf -> Cell(59, 5, 'E-TRACK REPORT',0,0);
  $pdf -> Cell(59, 10, '',0,1);

  //PDF Heading 1
  $pdf -> SetFont('Arial', 'B', 15);

  $pdf -> Cell(71, 5, "Account's Information",0,0);
  $pdf -> Cell(59, 5, '',0,0);
  $pdf -> Cell(59, 10, 'House Details',0,1);

  //User Information
  $pdf -> SetFont('Arial', '', 10);

  $pdf -> Cell(35, 5, 'User ID:',0,0);
  $pdf -> Cell(95, 5, $id,0,0);

  //House Information
  $pdf -> Cell(25, 5, 'House ID:',0,0);
  $pdf -> Cell(34, 5, $houseid,0,1);

  //User Information
  $pdf -> Cell(35, 5, 'User Email:',0,0);
  $pdf -> Cell(95, 5, $name,0,0);

  //House Information
  $pdf -> Cell(25, 5, 'Address:',0,0);
  $pdf -> MultiCell(35, 5, $address,0,1);

  //PDF Heading 2
  $pdf -> SetFont('Arial', 'B', 15);

  $pdf -> Cell(71, 5, "Resident's Information",0,0);
  $pdf -> Cell(59, 5, '',0,0);
  $pdf -> Cell(59, 10, '',0,1);

  //User Information
  $pdf -> SetFont('Arial', '', 10);

  //User Information
  $pdf -> Cell(55, 5, "Phone No:",0,0);
  $pdf -> Cell(90, 5, $phone_no,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  //User Information
  $pdf -> Cell(55, 5, "House Usage (kWh):",0,0);
  $pdf -> Cell(90, 5, $total_usageH,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  //User Information
  $pdf -> Cell(55, 5, 'Payment Amount (RM):',0,0);
  $pdf -> Cell(90, 5, $totalRM,0,0);

  //House Information
  $pdf -> Cell(25, 5, '',0,0);
  $pdf -> Cell(35, 5, '',0,1);

  $pdf -> Cell(50, 10, '',0,1);

  //House Bill
  $pdf -> SetFont('Arial', 'B', 15);
  $pdf -> Cell(130, 5, 'House Bill',0,0);
  $pdf -> Cell(59, 5, '',0,0);

  $pdf -> SetFont('Arial', 'B', 10);
  $pdf -> Cell(189, 10, '',0,1);

  
  $pdf -> SetFont('Arial', 'B', 10);

  //Table Heading
  $pdf -> Cell(265, 6, 'kWh Sort By HOURS',1,1,'C');
  $pdf -> Cell(25, 6, 'Date',1,0,'C');
  $pdf -> Cell(10, 6, '00',1,0,'C');
  $pdf -> Cell(10, 6, '01',1,0,'C');
  $pdf -> Cell(10, 6, '02',1,0,'C');
  $pdf -> Cell(10, 6, '03',1,0,'C');
  $pdf -> Cell(10, 6, '04',1,0,'C');
  $pdf -> Cell(10, 6, '05',1,0,'C');
  $pdf -> Cell(10, 6, '06',1,0,'C');
  $pdf -> Cell(10, 6, '07',1,0,'C');
  $pdf -> Cell(10, 6, '08',1,0,'C');
  $pdf -> Cell(10, 6, '09',1,0,'C');
  $pdf -> Cell(10, 6, '10',1,0,'C');
  $pdf -> Cell(10, 6, '11',1,0,'C');
  $pdf -> Cell(10, 6, '12',1,0,'C');
  $pdf -> Cell(10, 6, '13',1,0,'C');
  $pdf -> Cell(10, 6, '14',1,0,'C');
  $pdf -> Cell(10, 6, '15',1,0,'C');
  $pdf -> Cell(10, 6, '16',1,0,'C');
  $pdf -> Cell(10, 6, '17',1,0,'C');
  $pdf -> Cell(10, 6, '18',1,0,'C');
  $pdf -> Cell(10, 6, '19',1,0,'C');
  $pdf -> Cell(10, 6, '20',1,0,'C');
  $pdf -> Cell(10, 6, '21',1,0,'C');
  $pdf -> Cell(10, 6, '22',1,0,'C');
  $pdf -> Cell(10, 6, '23',1,1,'C');
  //Table Heading END

  $q2="SELECT * FROM house_details WHERE house_id='$houseid'";
  $r2=mysqli_query($dbc,$q2);

  if(mysqli_num_rows($r2)>0){
    foreach($r2 as $row){
  //Table Content
  $pdf -> SetFont('Arial', '', 10);

    $pdf -> Cell(25, 6, $row['date'],1,0,'R');
    $pdf -> Cell(10, 6, $row['00hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['01hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['02hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['03hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['04hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['05hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['06hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['07hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['08hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['09hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['10hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['11hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['12hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['13hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['14hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['15hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['16hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['17hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['18hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['19hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['20hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['21hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['22hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['23hrs'],1,1,'R');

}
  
  }

  $pdf -> SetFont('Arial', 'B', 10);
  $pdf -> Cell(189, 10, '',0,1);

  
  $pdf -> SetFont('Arial', 'B', 10);

  //Room Bill
  $pdf -> SetFont('Arial', 'B', 15);
  $pdf -> Cell(130, 5, 'Room Bill',0,0);
  $pdf -> Cell(59, 5, '',0,0);

  $pdf -> SetFont('Arial', 'B', 10);
  $pdf -> Cell(189, 10, '',0,1);

  
  $pdf -> SetFont('Arial', 'B', 10);

    //Table Heading
  $pdf -> Cell(283, 6, 'kWh Sort By HOURS',1,1,'C');
  $pdf -> Cell(25, 6, 'Date',1,0,'C');
  $pdf -> Cell(18, 6, 'Room No.',1,0,'C');
  $pdf -> Cell(10, 6, '00',1,0,'C');
  $pdf -> Cell(10, 6, '01',1,0,'C');
  $pdf -> Cell(10, 6, '02',1,0,'C');
  $pdf -> Cell(10, 6, '03',1,0,'C');
  $pdf -> Cell(10, 6, '04',1,0,'C');
  $pdf -> Cell(10, 6, '05',1,0,'C');
  $pdf -> Cell(10, 6, '06',1,0,'C');
  $pdf -> Cell(10, 6, '07',1,0,'C');
  $pdf -> Cell(10, 6, '08',1,0,'C');
  $pdf -> Cell(10, 6, '09',1,0,'C');
  $pdf -> Cell(10, 6, '10',1,0,'C');
  $pdf -> Cell(10, 6, '11',1,0,'C');
  $pdf -> Cell(10, 6, '12',1,0,'C');
  $pdf -> Cell(10, 6, '13',1,0,'C');
  $pdf -> Cell(10, 6, '14',1,0,'C');
  $pdf -> Cell(10, 6, '15',1,0,'C');
  $pdf -> Cell(10, 6, '16',1,0,'C');
  $pdf -> Cell(10, 6, '17',1,0,'C');
  $pdf -> Cell(10, 6, '18',1,0,'C');
  $pdf -> Cell(10, 6, '19',1,0,'C');
  $pdf -> Cell(10, 6, '20',1,0,'C');
  $pdf -> Cell(10, 6, '21',1,0,'C');
  $pdf -> Cell(10, 6, '22',1,0,'C');
  $pdf -> Cell(10, 6, '23',1,1,'C');
  //Table Heading END

  $q3="SELECT * FROM room_details WHERE house_id='$houseid' ORDER BY room_no ASC";
  $r3=mysqli_query($dbc,$q3);

  if(mysqli_num_rows($r3)>0){
    foreach($r3 as $row){
  //Table Content
  $pdf -> SetFont('Arial', '', 10);

    $pdf -> Cell(25, 6, $row['date'],1,0,'R');
    $pdf -> Cell(18, 6, $row['room_no'],1,0,'C');
    $pdf -> Cell(10, 6, $row['00hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['01hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['02hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['03hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['04hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['05hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['06hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['07hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['08hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['09hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['10hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['11hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['12hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['13hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['14hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['15hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['16hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['17hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['18hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['19hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['20hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['21hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['22hrs'],1,0,'R');
    $pdf -> Cell(10, 6, $row['23hrs'],1,1,'R');

}
  
  }

  // $pdf -> Cell(118, 6, '',0,0);
  // $pdf -> Cell(25, 6, 'Total',0,0);
  // $pdf -> Cell(45, 6, 'TOTAL kWh',1,1,'R');
  
  $pdf -> Output();
  }

?>