<?php

if(!empty($_POST['name']) && !empty($_POST['phone_no']) && !empty($_POST['room_no']) && !empty($_POST['house_id']) && !empty($_POST['password'])){
   
    $conn = mysqli_connect("localhost", "root", "", "etrack_database");

    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $room_no = $_POST['room_no'];
    $house_id = $_POST['house_id'];
    $password = $_POST['password'];

    //$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if ($conn){
    $sql = "INSERT INTO resident (name, password, room_no, phone_no, house_id) 
    VALUES ('".$name."', '".$password."', '".$room_no."', '".$phone_no."', '".$house_id."')";
    if(mysqli_query($conn, $sql)){
        echo "success";
    } else {
        echo "Registration Failed";
    }
} else {
    echo "Database Connection Failed";
    }
} else {
    echo "All Field are REQUIRED";
}
?>