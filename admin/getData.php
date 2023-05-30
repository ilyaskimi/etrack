<?php
include("dbconnect.php");

if (!empty($_POST)) {
    // keep track post values
    $serial_number = $_POST['serialNum'];
    $myObj = (object)array();
    
    //........................................ 
    $q3 = 'SELECT room_no1, room_no2, room_no3, room_no4 FROM relay
        WHERE serial_number="' . $serial_number . '"';
    $r3 = mysqli_query($dbc,$q3);
    $i=0;
    foreach ($r3 as $row) {
      $myObj->room_no1 = $row['room_no1'];
      $myObj->room_no2 = $row['room_no2'];
      $myObj->room_no3 = $row['room_no3'];
      $myObj->room_no4 = $row['room_no4'];
      $myJSON = json_encode($myObj);
      echo $myJSON;
    }
  }
?>