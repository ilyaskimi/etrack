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
        $currentHour=date('H:i:s', strtotime(' + 6 hours'));
        $currentdate = date('Y-m-d', strtotime(' + 6 hours')); 


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
    
       $q1 = "SELECT house_summary.id, house_details.date, total_usage, current_usage FROM relay 
       INNER JOIN  house_summary ON house_summary.serial_number = relay.serial_number
       INNER JOIN house_details ON house_summary.id = house_details.house_id
       WHERE relay.serial_number='$serial_number'";
       $r1 = mysqli_query($dbc,$q1);
    
       while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
            
        $house_id = $row['id'];
        $current_usage = $row['current_usage'];
        $total_usage1 = $row['total_usage'];
      
    }
       $total_usage2 = round(($current_usage/3600)*10 + $total_usage1,2); //Suppose to be divide by 1000
    
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

        //Send out Data by Hour
        $sql1 = "SELECT 00hrs,01hrs,02hrs,03hrs,04hrs,05hrs,
        06hrs,07hrs,08hrs,09hrs,10hrs,11hrs,
        12hrs,13hrs,14hrs,15hrs,16hrs,17hrs,
        18hrs,19hrs,20hrs,21hrs,22hrs,23hrs
        FROM house_details
        WHERE house_id='$house_id' AND date='$currentdate'";
        $result1 = $dbc->query($sql1);
        if(mysqli_num_rows($result1)>0){
            
            while($row = mysqli_fetch_array($result1)){
                $hrs00=$row["00hrs"];
                $hrs01=$row["01hrs"];
                $hrs02=$row["02hrs"];
                $hrs03=$row["03hrs"];
                $hrs04=$row["04hrs"];
                $hrs05=$row["05hrs"];
                $hrs06=$row["06hrs"];
                $hrs07=$row["07hrs"];
                $hrs08=$row["08hrs"];
                $hrs09=$row["09hrs"];
                $hrs10=$row["10hrs"];
                $hrs11=$row["11hrs"];
                $hrs12=$row["12hrs"];
                $hrs13=$row["13hrs"];
                $hrs14=$row["14hrs"];
                $hrs15=$row["15hrs"];
                $hrs16=$row["16hrs"];
                $hrs17=$row["17hrs"];
                $hrs18=$row["18hrs"];
                $hrs19=$row["19hrs"];
                $hrs20=$row["20hrs"];
                $hrs21=$row["21hrs"];
                $hrs22=$row["22hrs"];
                $hrs23=$row["23hrs"];
            }

            //Update by Hours
            if ($currentHour >= '00:00:00' && $currentHour < '01:00:00'){
                $total_usage_hour1=$hrs00;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql00="UPDATE house_details SET 00hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run00=mysqli_query($dbc,$sql00);
            }

            if ($currentHour >= '01:00:00' && $currentHour < '02:00:00'){
                $total_usage_hour1=$hrs01;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql01="UPDATE house_details SET 01hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run01=mysqli_query($dbc,$sql01);
            }

            if ($currentHour >= '02:00:00' && $currentHour < '03:00:00'){
                $total_usage_hour1=$hrs02;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql02="UPDATE house_details SET 02hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run02=mysqli_query($dbc,$sql02);
            }

            if ($currentHour >= '03:00:00' && $currentHour < '04:00:00'){
                $total_usage_hour1=$hrs03;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql03="UPDATE house_details SET 03hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run03=mysqli_query($dbc,$sql03);
            }

            if ($currentHour >= '04:00:00' && $currentHour < '05:00:00'){
                $total_usage_hour1=$hrs04;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql04="UPDATE house_details SET 04hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run04=mysqli_query($dbc,$sql04);
            }

            if ($currentHour >= '05:00:00' && $currentHour < '06:00:00'){
                $total_usage_hour1=$hrs05;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql05="UPDATE house_details SET 05hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run05=mysqli_query($dbc,$sql05);
            }
            
            if ($currentHour >= '06:00:00' && $currentHour < '07:00:00'){
                $total_usage_hour1=$hrs06;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql06="UPDATE house_details SET 06hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run06=mysqli_query($dbc,$sql06);
            }

            if ($currentHour >= '07:00:00' && $currentHour < '08:00:00'){
                $total_usage_hour1=$hrs07;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql07="UPDATE house_details SET 07hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run07=mysqli_query($dbc,$sql07);
            }

            if ($currentHour >= '08:00:00' && $currentHour < '09:00:00'){
                $total_usage_hour1=$hrs08;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql08="UPDATE house_details SET 08hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run08=mysqli_query($dbc,$sql08);
            }

            if ($currentHour >= '09:00:00' && $currentHour < '10:00:00'){
                $total_usage_hour1=$hrs09;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql09="UPDATE house_details SET 09hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run09=mysqli_query($dbc,$sql09);
            }

            if ($currentHour >= '10:00:00' && $currentHour < '11:00:00'){
                $total_usage_hour1=$hrs10;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql10="UPDATE house_details SET 10hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run10=mysqli_query($dbc,$sql10);
            }

            if ($currentHour >= '11:00:00' && $currentHour < '12:00:00'){
                $total_usage_hour1=$hrs11;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql11="UPDATE house_details SET 11hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run11=mysqli_query($dbc,$sql11);
            }

            if ($currentHour >= '12:00:00' && $currentHour < '13:00:00'){
                $total_usage_hour1=$hrs12;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql12="UPDATE house_details SET 12hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run12=mysqli_query($dbc,$sql12);
            }

            if ($currentHour >= '13:00:00' && $currentHour < '14:00:00'){
                $total_usage_hour1=$hrs13;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql13="UPDATE house_details SET 13hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run13=mysqli_query($dbc,$sql13);
            }
            
            if ($currentHour >= '14:00:00' && $currentHour < '15:00:00'){
                $total_usage_hour1=$hrs14;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql14="UPDATE house_details SET 14hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run14=mysqli_query($dbc,$sql14);
            }
            
            if ($currentHour >= '15:00:00' && $currentHour < '16:00:00'){
                $total_usage_hour1=$hrs15;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql15="UPDATE house_details SET 15hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run15=mysqli_query($dbc,$sql15);
            }
            
            if ($currentHour >= '16:00:00' && $currentHour < '17:00:00'){
                $total_usage_hour1=$hrs16;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql16="UPDATE house_details SET 16hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run16=mysqli_query($dbc,$sql16);
            }
            
            if ($currentHour >= '17:00:00' && $currentHour < '18:00:00'){
                $total_usage_hour1=$hrs17;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql17="UPDATE house_details SET 17hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run17=mysqli_query($dbc,$sql17);
            }
            
            if ($currentHour >= '18:00:00' && $currentHour < '19:00:00'){
                $total_usage_hour1=$hrs18;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql18="UPDATE house_details SET 18hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run18=mysqli_query($dbc,$sql18);
            }
            
            if ($currentHour >= '19:00:00' && $currentHour < '20:00:00'){
                $total_usage_hour1=$hrs19;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql19="UPDATE house_details SET 19hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run19=mysqli_query($dbc,$sql19);
            }
            
            if ($currentHour >= '20:00:00' && $currentHour < '21:00:00'){
                $total_usage_hour1=$hrs20;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql20="UPDATE house_details SET 20hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run20=mysqli_query($dbc,$sql20);
            }
                        
            if ($currentHour >= '21:00:00' && $currentHour < '22:00:00'){
                $total_usage_hour1=$hrs21;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql21="UPDATE house_details SET 21hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run21=mysqli_query($dbc,$sql21);
            }
                        
            if ($currentHour >= '22:00:00' && $currentHour < '23:00:00'){
                $total_usage_hour1=$hrs22;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql22="UPDATE house_details SET 22hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run22=mysqli_query($dbc,$sql22);
            }
                        
            if ($currentHour >= '23:00:00' && $currentHour <= '23:59:59'){
                $total_usage_hour1=$hrs23;
                $total_usage_hour = round(($current_usage/3600)*10,2)+$total_usage_hour1; //Suppose to be divide by 1000
                $sql23="UPDATE house_details SET 23hrs='$total_usage_hour' WHERE house_id='$house_id' AND date='$currentdate'";
                $run23=mysqli_query($dbc,$sql23);
            }

    
        } else {
            $sql="INSERT INTO house_details (house_id,date) VALUES ('$house_id','$date') ";
            $run=mysqli_query($dbc,$sql);
        }


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

            // $total_rmR=$total_rm/
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
