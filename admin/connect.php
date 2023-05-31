<?php

include("dbconnect.php");

if (isset($_POST["cData"])){

        $serial_number = $_POST["cData"];
        $current_usage = $_POST["current_usage"];
        $date = date('Y-m-d H:i:s', strtotime(' + 6 hours')); 

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
    
       $q1 = "SELECT house_details.date, total_usage, current_usage FROM relay 
       INNER JOIN  house_summary ON house_summary.serial_number = relay.serial_number
       INNER JOIN house_details ON house_summary.id = house_details.house_id
       WHERE relay.serial_number='$serial_number'";
       $r1 = mysqli_query($dbc,$q1);
    
       while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
            
        $current_usage = $row['current_usage'];
        $total_usage1 = $row['total_usage'];
      
    }
       $total_usage2 = ($current_usage/3600)*100 + $total_usage1; //Suppose to be divide by 1000
    
        $q2 = "UPDATE relay SET total_usage = '$total_usage2' WHERE serial_number='$serial_number'";
    
        $r2=mysqli_query($dbc,$q2);
        
        $q3 = "UPDATE house_summary SET total_electric_usage_house = '$total_usage2' WHERE serial_number='$serial_number'";
        $r3=mysqli_query($dbc,$q3); 

        $totalhouse_usage1=0;
            $totalhouse_usage2=0;
            $totalhouse_usage3=0;
            $totalhouse_usage4=0;
            $totalhouse_usage5=0;
            if($total_usage2>200){
                $total_usage2-=200;
                $totalhouse_usage1=200*0.218;
                if($total_usage2>100){
                    $total_usage2-=100;
                    $totalhouse_usage2=100*0.334;
                    if($total_usage2>300){
                        $total_usage2-=300;
                        $totalhouse_usage3=300*0.516;
                        if($total_usage2>300){
                            $total_usage2-=300;
                            $totalhouse_usage4=300*0.546;
                            if ($total_usage2>0) {
                                $totalhouse_usage5=$total_usage2*0.571;
                            }
                            else{
                                $totalhouse_usage5=0;
                            }
                        }
                        else {
                            $totalhouse_usage4=$total_usage2*0.546;
                        }
                    }
                    else {
                        $totalhouse_usage3=$total_usage2*0.516;
                    }
                }
                else {
                    $totalhouse_usage2=$total_usage2*0.334;
                }
            }
            else{
                $totalhouse_usage1=$total_usage2*0.218;
            }
            $total=$totalhouse_usage1+$totalhouse_usage2+$totalhouse_usage3+$totalhouse_usage4+$totalhouse_usage5;

        $q4 = "UPDATE house_summary SET total_rm = '$total' WHERE serial_number='$serial_number'";
        $r4=mysqli_query($dbc,$q4); 
    
    }else{
       echo json_encode("false");
        }
    
}




?>
