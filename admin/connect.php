<?php

include("dbconnect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

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
            $total=round(($totalhouse_usage1+$totalhouse_usage2+$totalhouse_usage3+$totalhouse_usage4+$totalhouse_usage5),2);

        $q4 = "UPDATE house_summary SET total_rm = '$total' WHERE serial_number='$serial_number'";
        $r4=mysqli_query($dbc,$q4); 

        //HOUSE Limit Notify
        $q5="SELECT username, house_summary.total_rm, house_summary.limit_house, relay.last_updated FROM admin
        INNER JOIN house_summary ON house_summary.admin_id=admin.id
        INNER JOIN relay ON house_summary.serial_number=relay.serial_number
        WHERE relay.serial_number='$serial_number'";
        $r5=mysqli_query($dbc,$q5);
      
        if(mysqli_num_rows($r5)>0){
            foreach($r5 as $row){
          
          $limit_house = $row['limit_house'];
          $last_updated = $row['last_updated'];
          $email = $row['username'];
          $total_rm = $row['total_rm'];
        
          $currentDate = date('Y-m-d',  strtotime('now'));

          if($currentDate=!$last_updated){
            if($limit_house<=$total_rm && $limit_house>0){
            $mail=new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='kimi.ilyas@gmail.com';
            $mail->Password='zogtqvvldjlnwqdn';
            $mail->SMTPSecure='ssl';
            $mail->Port='465';
            $mail->addAddress($email);
            $mail->setFrom('kimi.ilyas@gmail.com');
          
            $mail->isHTML(true);
    
            $message="Your House Usage already exceed your limit warning!";
            $mail->Subject="HOUSE USAGE WARNING!";
            $mail->Body=$message;
    
            $mail->send();
            }
        }

            }
        
      }

      //Resident House/Room Limit
       $q6="SELECT username, house_summary.total_rm, resident.limit_house, resident.limit_room, relay.last_updated FROM resident
       INNER JOIN house_summary ON house_summary.id=resident.house_id
       INNER JOIN relay ON house_summary.serial_number=relay.serial_number
        WHERE relay.serial_number='$serial_number'";
        $r6=mysqli_query($dbc,$q6);
      
        if(mysqli_num_rows($r6)>0){
            foreach($r6 as $row){
          
          $limit_houseR = $row['limit_house'];
          $limit_roomR = $row['limit_room'];
          $last_updatedR = $row['last_updated'];
          $emailR = $row['username'];
          $total_rm = $row['total_rm'];

        if($currentDate=!$last_updated){
            //HOUSE
            if($limit_houseR<=$total_rm && $limit_houseR>0){
            $mail=new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='kimi.ilyas@gmail.com';
            $mail->Password='zogtqvvldjlnwqdn';
            $mail->SMTPSecure='ssl';
            $mail->Port='465';
            $mail->addAddress($emailR);
            $mail->setFrom('kimi.ilyas@gmail.com');
          
            $mail->isHTML(true);
    
            $message="Your House Usage already exceed your limit warning!";
            $mail->Subject="HOUSE USAGE WARNING!";
            $mail->Body=$message;
    
            $mail->send();
            }

            $total_rmR=$total_rm/
            //ROOM
            if($limit_roomR<=$total_rmR && $limit_roomR>0){
                $mail=new PHPMailer(true);
    
                $mail->isSMTP();
                $mail->Host='smtp.gmail.com';
                $mail->SMTPAuth=true;
                $mail->Username='kimi.ilyas@gmail.com';
                $mail->Password='zogtqvvldjlnwqdn';
                $mail->SMTPSecure='ssl';
                $mail->Port='465';
                $mail->addAddress($emailR);
                $mail->setFrom('kimi.ilyas@gmail.com');
              
                $mail->isHTML(true);
        
                $message="Your House Usage already exceed your limit warning!";
                $mail->Subject="HOUSE USAGE WARNING!";
                $mail->Body=$message;
        
                $mail->send();
                }
        }

            }
        
      }
        


    
    }else{
       echo json_encode("false");
        }
    
}




?>
