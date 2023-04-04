<?php
if (!empty($_POST['name']) && !empty($_POST['apiKey'])){
    
    $name = $_POST['name'];
    $apiKey = $_POST['apiKey'];

    $conn = mysqli_connect("localhost", "root", "", "etrack_database");


    if ($conn){
    
        $sql = "SELECT * FROM resident WHERE name = '".$name."' AND apiKey = '".$apiKey."'";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) != 0){
            $row = mysqli_fetch_assoc($res);
            $sqlUpdate = "UPDATE resident SET apiKey = '' WHERE name = '".$name."'";
            if (mysqli_query($conn, $sqlUpdate)){
                echo "Logout SUCCESS";
            } else {echo "Logout FAILED";}
        }else {echo "Unautherised Access";}
    }else {echo "Database Connection Failed";}
}else {echo "All Fields are REQUIRED";}