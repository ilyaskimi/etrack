<?php

// $dbname = 'etrack_database';
// $dbuser = 'root';  
// $dbpass = ''; 
// $dbhost = 'localhost'; 

// $connect = @mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

// if(!$connect){
// 	echo "Error: " . mysqli_connect_error();
// 	exit();
// }

// echo "Connection Success!<br><br>";

// $total_usage = $_GET["total_usage"];
// $current_usage = $_GET["current_usage"]; 


// $query = "INSERT INTO temp_usage (total_usage, current_usage) VALUES ('$total_usage', '$current_usage')";
// $result = mysqli_query($connect,$query);

// echo "Insertion Success!<br>";

include("dbconnect.php");
if (isset($_GET["checkSerial"]))
{
    $serial_number = $_GET["checkSerial"];

    $check = "SELECT * FROM temp_usage WHERE serial_number='$serial_number'";
    $runQ = mysqli_query($dbc,$check);

    if (mysqli_num_rows($runQ)==0){
        $insertQ = "INSERT INTO temp_usage (serial_number) VALUES ('$serial_number')";
        $runInsertQ = mysqli_query($dbc,$insertQ);
        
        
        if($runInsertQ){
            
            echo json_encode("true");
            
        }else{

            echo json_encode("false");

        }
    }else{
        while ($row=mysqli_fetch_assoc($runQ)){
            if($row["ready"]=="not ready"){
                    echo json_encode("false");
            }
            else{
                    echo json_encode("true");
            }
        }
    }
}
if (isset($_POST["cData"])){
    $serial_number = $_POST["cData"];
    $total_usage = $_POST["total_usage"];
    $current_usage = $_POST["current_usage"]; 

    //$insertQ = "INSERT INTO temp_usage (total_usage, current_usage) VALUES ('$total_usage', '$current_usage') WHERE serial_number='$serial_number'";
    $insertQ = "UPDATE temp_usage SET total_usage= '$total_usage', current_usage = '$current_usage' WHERE serial_number='$serial_number'";

    $runQu=mysqli_query($dbc,$insertQ); 
    
if($runQu){
   echo json_encode("true");

}else{
   echo json_encode("false");
    }
}

?>
