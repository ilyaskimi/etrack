<?php
if (!empty($_POST['name']) && !empty($_POST['apiKey'])){
    
    $name = $_POST['name'];
    $apiKey = $_POST['apiKey'];
    $result = array();

    $conn = mysqli_connect("localhost", "root", "", "etrack_database");

if ($conn){
    
    $sql = "SELECT * FROM resident WHERE name = '".$name."' AND apiKey = '".$apiKey."'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) != 0){
        $row = mysqli_fetch_assoc($res);
        $result = array("status"=>"success", "message"=>"Data Fetched SUCCESS",
                "name"=>$row['name'], "apiKey"=>$row['apiKey']);

        }else {$result = array("status" => "failed", "message" => "Unautherised Access");}

    }else {$result = array("status" => "failed", "message" => "Database Connection Failed");}
}else {$result = array("status" => "failed", "message" => "All Fields are REQUIRED");}   

echo json_encode($result, JSON_PRETTY_PRINT);
