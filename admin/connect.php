<?php

include("dbconnect.php");

if (isset($_POST["cData"])){

        $serial_number = $_POST["cData"];
        $current_usage = $_POST["current_usage"];
        $date = date('Y-m-d H:i:s'); 

        $check = "SELECT * FROM relay WHERE serial_number='$serial_number'";
        $runQ = mysqli_query($dbc,$check);
    
        if (mysqli_num_rows($runQ)==0){
            $insertQ = "INSERT INTO relay (serial_number) VALUES ('$serial_number')";
            $runInsertQ = mysqli_query($dbc,$insertQ);

        }
    
        $insertQ = "UPDATE relay SET current_usage='$current_usage', last_updated='$date' WHERE serial_number='$serial_number'";
        $runQu=mysqli_query($dbc,$insertQ); 
        
    if($runQu){
       echo json_encode("true");
    
       $q1 = "SELECT total_usage, current_usage FROM relay WHERE serial_number='$serial_number'";
       $r1 = mysqli_query($dbc,$q1);
    
       while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
            
        $current_usage = $row['current_usage'];
        $total_usage1 = $row['total_usage'];
      
    }
       $total_usage2 = ($current_usage/3600)*100 + $total_usage1; //Suppose to be divide by 1000
    
        $q2 = "UPDATE relay SET total_usage = '$total_usage2' WHERE serial_number='$serial_number'";
    
        $r2=mysqli_query($dbc,$q2); 
    
    }else{
       echo json_encode("false");
        }
    
}




?>
