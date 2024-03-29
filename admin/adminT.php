<?php
session_start();
if(empty($_SESSION['username'])){
    header("Location:login.php");
}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,inital-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <title><?php echo $_SESSION['username']?> Dashboard </title>
        <!--Sarabun Font-->
        <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!--Material Icon-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

        <!--CUSTOM CSS-->
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="grid-container">

            <!--HEADER-->
            <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
</div>
            <div class="header-left">
                <span class="material-icons-outlined">search</span>
            </div>
            <div class="header-right">
                <span class="material-icons-outlined">notifications</span>
                <span class="material-icons-outlined">email</span>
                <span class="material-icons-outlined">account_circle</span>
            </div>
            </header>
            <!--END HEADER-->

            <!--SIDEBAR-->
            <aside id="sidebar" action="function.php" method="post">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                <span class="material-icons-outlined">inventory</span><a>House ID = </a> <?php 
                // HOUSE ID CALLOUT
                require('dbconnect.php');
                $houseid=$_SESSION["houseid"];
                $role=$_SESSION["role"];   
                echo $houseid;
            // require('dbconnect.php');
            // $username=$_SESSION["username"];   
            // $adminid=$_SESSION["id"];   
            // // Define the query:
            // $q = "SELECT house_summary.id FROM house_summary WHERE admin_id='".$adminid."'";   
            // $r = mysqli_query ($dbc, $q);
            // $num = mysqli_num_rows($r);
            // if ($num > 0) { // If it ran OK, display the records.
            
            // // Fetch and print all the records:
            // if ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            //     echo  $row['id'] ;
            // }
            // mysqli_free_result ($r);  
            // }
            ?>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item" ><a >
                <span class="material-icons-outlined">dashboard</span>Dashboard
                </a></li> 
                <li class="sidebar-list-item"><a href="manageT.php">
                <span class="material-icons-outlined">dashboard</span>Resident's Account
                </a></li>     
                <li class="sidebar-list-item" ><a href="dataT.php">
                <span class="material-icons-outlined">dashboard</span>Data Usage
                </a></li>   
                <li class="sidebar-list-item"><a href="addT.php">
                <span class="material-icons-outlined">dashboard</span>View House Unit
                </a></li>    
                <li class="sidebar-list-item"><a href="viewProfile.php">
                <span class="material-icons-outlined" >dashboard</span>View Profile
                </a></li>    
                <li class="sidebar-list-item"><a href="logout.php">
                <span class="material-icons-outlined" name="logout" >dashboard</span>Logout
                </a></li>     
            </ul>

            </aside>
            <!--END SIDEBAR-->

            <!--MAIN-->
            <main class="main-container">
            <div class="main-title">
          <p class="font-weight-bold">E-TRACK DASHBOARD</p>
        </div>

        <div class="main-cards">

          <div class="card">
            <div class="card-inner">
              <p class="text-primary font-weight-bold">USAGE BY ROOM</p>
              <span class="material-icons-outlined text-blue">inventory_2</span>
            </div>
            <span class="text-primary"><?php
            //ROOM NUMBER USAGE

            require_once('dbconnect.php');
            $adminid=$_SESSION["id"];
            $houseid=$_SESSION["houseid"];
           // Define the query:
           $q = "SELECT room_summary.room_no,room_summary.total_electric_usage FROM room_summary 
                INNER JOIN house_summary ON room_summary.house_id=house_summary.id 
                WHERE house_summary.admin_id='".$adminid."' AND house_summary.id='".$houseid."'";
           $r = mysqli_query ($dbc, $q);
           
           // Count the number of returned rows:
           $num = mysqli_num_rows($r);
           
           if ($num > 0) { // If it ran OK, display the records.
           
             // Print how many users there are:
           
           $total_electric_usage = array();
           
             // Fetch and print all the records:
             while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $total_electric_usage[]=$row["total_electric_usage"];
               echo '<tr>Room
               <td align="left">' . $row['room_no'] . '</td>=
               <td align="left">' . $row['total_electric_usage'] . '</td> kWh<br>
               </tr>
               ';
           
           }
           
             echo '</table>';
             mysqli_free_result ($r);
             $totalroom_usage = array_sum($total_electric_usage);
           }else{
            echo "No recorded data yet";
           }

            ?></span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary font-weight-bold">TOTAL ELECTRICITY USAGE</p>
              <span class="material-icons-outlined text-green">shopping_cart</span>
            </div>
            <span class="text-primary"><?php

            //ROOM NUMBER USAGE

            require_once('dbconnect.php');
            $adminid=$_SESSION["id"];
            $houseid=$_SESSION["houseid"];
           // Define the query:
           $q = "SELECT house_summary.total_electric_usage_house, house_summary.total_rm FROM house_summary WHERE house_summary.admin_id='".$adminid."' AND house_summary.id='".$houseid."'";
           $r = mysqli_query ($dbc, $q);
           
           // Count the number of returned rows:
           $num = mysqli_num_rows($r);
           
           if ($num > 0) { // If it ran OK, display the records.
           
             // Print how many users there are:
           
           
           
             // Fetch and print all the records:
             while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $totalhouse_usage =  $row['total_electric_usage_house'];
                $totalRM =  $row['total_rm'];
                if($totalhouse_usage==""){
                    $totalhouse_usage=0;
                }
               echo '<tr>
               <td align="left">'  .$totalhouse_usage. '</td> kWh<br>
               </tr>
               ';
           
           }
           
             echo '</table>';
             mysqli_free_result ($r);
           }
            ?></span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary font-weight-bold">TOTAL HOUSE BILL</p>
              <span class="material-icons-outlined text-red">notification_important</span>
            </div>
            <span class="text-primary">RM<?php
            echo '<tr>
            <td align="left">'  .$totalRM. '</td><br>
            </tr>
            ';
            ?> *wihtout any tax.</span>
          </div>

        </div>

            <!--CHARTS-->

<div class="charts">


<div class="charts-card" >
  <div class="charts-card" >
            <p class="chart-title">ELECTRICITY USAGE</p>
            <canvas id="myChart" ></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <?php
        $date = date('Y-m-d');
        ?>


            
            <!--QUERY CALLOUT LINE/BAR CHART-->
            <?php
            $date = date('Y-m-d');
            //BAR
            $sql3="SELECT room_summary.room_no,room_summary.total_electric_usage,house_summary.total_electric_usage_house, relay.last_updated 
            FROM room_summary
            INNER JOIN house_summary ON room_summary.house_id=house_summary.id
            INNER JOIN relay ON house_summary.serial_number=relay.serial_number
            WHERE house_summary.admin_id='".$adminid."' AND house_summary.id='".$houseid."'";

            $result3=mysqli_query($dbc,$sql3);
            if(mysqli_num_rows($result3)>0){
            $room_no = array();
            $total_electric_usage = array();
            $total_electric_usage_house = array();
                                
            while($row = mysqli_fetch_array($result3)){
            $room_no[]=$row["room_no"];
            $dateToday=$row["last_updated"];
            $total_electric_usage[]=$row["total_electric_usage"];
            $total_electric_usage_house[]=$row["total_electric_usage_house"];

            }                        
            // unset($result3);
            }

            //LINE
            if(isset($_POST['date'])){
                $dateN = $_POST['date'];

                try {
                    $sql1 = "SELECT 00hrs,01hrs,02hrs,03hrs,04hrs,05hrs,
                    06hrs,07hrs,08hrs,09hrs,10hrs,11hrs,
                    12hrs,13hrs,14hrs,15hrs,16hrs,17hrs,
                    18hrs,19hrs,20hrs,21hrs,22hrs,23hrs
                    FROM house_details
                    WHERE house_id='".$houseid."' AND date='".$dateN."'";
                    $result1 = $dbc->query($sql1);
                    if(mysqli_num_rows($result1)>0){

                        $data1=mysqli_num_rows($result1);
                        
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
                            $Hhours=array($hrs00,$hrs01,$hrs02,$hrs03,
                                        $hrs04,$hrs05,$hrs06,$hrs07,
                                        $hrs08,$hrs09,$hrs10,$hrs11,
                                        $hrs12,$hrs13,$hrs14,$hrs15,
                                        $hrs16,$hrs17,$hrs18,$hrs19,
                                        $hrs20,$hrs21,$hrs22,$hrs23,);
    
    
                        }                        

                    }
                } catch (PDOExecption $e) {
                    die ("ERROR". $e->getMessage());
                }
            } else {
                try {
                    $sql1 = "SELECT 00hrs,01hrs,02hrs,03hrs,04hrs,05hrs,
                    06hrs,07hrs,08hrs,09hrs,10hrs,11hrs,
                    12hrs,13hrs,14hrs,15hrs,16hrs,17hrs,
                    18hrs,19hrs,20hrs,21hrs,22hrs,23hrs
                    FROM house_details
                    WHERE house_id='$houseid' AND date='$dateToday'";
                    $result1=mysqli_query($dbc,$sql1);
                    if(mysqli_num_rows($result1)>0){
                        
                        $data1=mysqli_num_rows($result1);
                        
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
                            $Hhours=array($hrs00,$hrs01,$hrs02,$hrs03,
                                        $hrs04,$hrs05,$hrs06,$hrs07,
                                        $hrs08,$hrs09,$hrs10,$hrs11,
                                        $hrs12,$hrs13,$hrs14,$hrs15,
                                        $hrs16,$hrs17,$hrs18,$hrs19,
                                        $hrs20,$hrs21,$hrs22,$hrs23,);

    
    
                        }                        

                    }
                } catch (PDOExecption $e) {
                    die ("ERROR". $e->getMessage());
                }
            }

            $data1=mysqli_num_rows($result1);
              
            

            unset($dbc);
            ?>

            <!--QUERY CALLOUT BAR CHART-->
            <?php

            ?>
            <script>

            //SETUP BLOCK
            const room_no = <?php echo  json_encode($room_no); ?>;
            room_no.push("Others");
            const total_electric_usage = <?php echo  json_encode($total_electric_usage); ?>;
            const othersE = <?php echo $totalhouse_usage-$totalroom_usage; ?>;
            total_electric_usage.push(othersE);

            const data = {
            labels: room_no,
                    datasets: [{
                        label: 'USAGE BY ROOM NUMBER',
                        data: total_electric_usage,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                };        //CONFIG BLOCK
            const config ={
            type: 'bar',
                data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            //RENDER BLOCK
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
            
              
            </script>


            <div id="bar-chart"></div>
          </div>
  <div id="bar-chart"></div>
</div>
            
<div class="charts-card">
  <div class="charts-card">
            <p class="chart-title">USAGE LINE CHART</p>
            <form id="myForm" action="adminT.php" method="POST">
            <input type="date" value="<?php $date ?>" id="date" name="date">
            <button class="w3-button w3-blue w3-round-large w3-padding-small" name="submit" type="submit">Check Date</button>
        </form>
        <?php

        if($data1==0){
            echo "No recorded data";
        }

        ?>
            <canvas id="myChart2"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            var ctx = document.getElementById('myChart2').getContext('2d');
            const Hhours = <?php echo  json_encode($Hhours); ?>;
            var myChart2 = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["00hrs","01hrs","02hrs","03hrs"
                            ,"04hrs","05hrs","06hrs","07hrs"
                            ,"08hrs","09hrs","10hrs","11hrs"
                            ,"12hrs","13hrs","14hrs","15hrs"
                            ,"16hrs","17hrs","18hrs","19hrs"
                            ,"20hrs","21hrs","22hrs","23hrs"],
                    datasets: [{
                        label: 'TOTAL USAGE IN THE HOUSE',
                        data: Hhours,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            </script>
            <div id="area-chart"></div>
          </div>
  <div id="area-chart"></div>
</div>
<footer  style="text-align: right;">
@Copyright UniKL MIIT 2022- All Right Reserved. 
</footer>

            </main>
            
            <!--END MAIN-->
        </div>
        <!--SCRIPTS-->
        <!--APEXCHART-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.3/apexcharts.min.js"></script>
       
        <!--CUSTOM JS-->
        <script src="js/scripts.js"></script>    

        <script>

         .getElementById('date').addEventListener('change', function() {
  document.getElementById('myForm').submit();
});
            var sidebarOpen = false;
        var sidebar = document.getElementById("sidebar");

        function openSidebar() {
        if(!sidebarOpen) {
            sidebar.classList.add("sidebar-responsive");
            sidebarOpen = true;
        }
        }
        function closeSidebar(){
            if(sidebarOpen){
                sidebar.classList.remove("sidebar-responsive");
                sidebarOpen = false;
            }
        }


        </script>

    </body>
</html>