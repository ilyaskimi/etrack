<?php

if(!empty($_POST['email']) && !empty($_POST['password'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = array();

    $conn = mysqli_connect("localhost", "root", "", "etrack_database");
    //echo "error1";

if ($conn){

    $sql = "SELECT * FROM admin WHERE email = '".$email."'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) != 0){
        //echo "error2";
        $row = mysqli_fetch_assoc($res);
        if($email == $row['email'] && $password == $row['password']){
            
            try{
                //echo "error3";
                $apiKey = bin2hex(random_bytes(23));
                
            } catch (Exception $e){
                $apiKey = bin2hex(uniqid($email, true));
            }
            $sqlUpdate = "UPDATE admin SET apiKey = '".$apiKey."' WHERE email = '".$email."'";
            if (mysqli_query($conn, $sqlUpdate)){
                $result = array("status"=>"success", "message"=>"Login SUCCESS",
                "email"=>$row['email'], "apiKey"=>$apiKey);
            } else {$result = array("status" => "failed", "message" => "Login Failed TRY AGAIN");}

        }else {
            //echo "error4";
            $result = array("status" => "failed", "message" => "Retry With Correct Name and Password");}
    }else {$result = array("status" => "failed", "message" => "Retry With Correct Name and Password");}

}else {$result = array("status" => "failed", "message" => "Database Connection Failed");}
}else {$result = array("status" => "failed", "message" => "All Fields are REQUIRED");}

echo json_encode($result, JSON_PRETTY_PRINT);