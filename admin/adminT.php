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
            $username=$_SESSION["username"];   
            $adminid=$_SESSION["id"];   
            // Define the query:
            $q = "SELECT house_summary.id FROM house_summary WHERE admin_id='".$adminid."'";   
            $r = mysqli_query ($dbc, $q);
            $num = mysqli_num_rows($r);
            if ($num > 0) { // If it ran OK, display the records.
            
            // Fetch and print all the records:
            if ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo  $row['id'] ;
            }
            mysqli_free_result ($r);  
            }
            ?>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item" href="adminT.php"><a >
                <span class="material-icons-outlined">dashboard</span>Dashboard
                </a></li> 
                <li class="sidebar-list-item"><a href="manageT.php">
                <span class="material-icons-outlined">dashboard</span>Resident's Account
                </a></li>     
                <li class="sidebar-list-item">
                <span class="material-icons-outlined">dashboard</span>Data Usage
                </li>   
                <li class="sidebar-list-item">
                <span class="material-icons-outlined">dashboard</span>Add House Unit
                </li>   
                <li class="sidebar-list-item"><a href="logout.php">
                <span class="material-icons-outlined" name="logout" >dashboard</span>Logout
                </a></li>     
            </ul>

            </aside>
            <!--END SIDEBAR-->

            <!--MAIN-->
            <main class="main-container">
            <div class="main-title">
          <p class="font-weight-bold">DASHBOARD</p>
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
           // Define the query:
           $q = "SELECT room_summary.room_no,room_summary.total_electric_usage FROM room_summary INNER JOIN house_summary ON room_summary.house_id=house_summary.id WHERE house_summary.admin_id='".$adminid."'";
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
           }
            $totalroom_usage = array_sum($total_electric_usage);
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
           // Define the query:
           $q = "SELECT house_summary.total_electric_usage_house FROM house_summary WHERE house_summary.admin_id='".$adminid."'";
           $r = mysqli_query ($dbc, $q);
           
           // Count the number of returned rows:
           $num = mysqli_num_rows($r);
           
           if ($num > 0) { // If it ran OK, display the records.
           
             // Print how many users there are:
           
           
           
             // Fetch and print all the records:
             while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $totalhouse_usage =  $row['total_electric_usage_house'];
               echo '<tr>
               <td align="left">' . $row['total_electric_usage_house'] . '</td> kWh<br>
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
              <p class="text-primary font-weight-bold">TOTAL BILL</p>
              <span class="material-icons-outlined text-red">notification_important</span>
            </div>
            <span class="text-primary">RM<?php
            $totalhouse_usage1=0;
            $totalhouse_usage2=0;
            $totalhouse_usage3=0;
            $totalhouse_usage4=0;
            $totalhouse_usage5=0;
            if($totalhouse_usage>200){
                $totalhouse_usage-=200;
                $totalhouse_usage1=200*0.218;
                if($totalhouse_usage>100){
                    $totalhouse_usage-=100;
                    $totalhouse_usage2=100*0.334;
                    if($totalhouse_usage>300){
                        $totalhouse_usage-=300;
                        $totalhouse_usage3=300*0.516;
                        if($totalhouse_usage>300){
                            $totalhouse_usage-=300;
                            $totalhouse_usage4=300*0.546;
                            if ($totalhouse_usage>0) {
                                $totalhouse_usage5=$totalhouse_usage*0.571;
                            }
                            else{
                                $totalhouse_usage5=0;
                            }
                        }
                        else {
                            $totalhouse_usage4=$totalhouse_usage*0.546;
                        }
                    }
                    else {
                        $totalhouse_usage3=$totalhouse_usage*0.516;
                    }
                }
                else {
                    $totalhouse_usage2=$totalhouse_usage*0.334;
                }
            }
            else{
                $totalhouse_usage1=$totalhouse_usage*0.218;
            }
            echo $total=$totalhouse_usage1+$totalhouse_usage2+$totalhouse_usage3+$totalhouse_usage4+$totalhouse_usage5;
            ?> *wihtout any tax.</span>
          </div>

        </div>

            <!--CHARTS-->
            <!--QUERY CALLOUT-->
            <?php
            try {
                $sql = "SELECT room_summary.room_no,room_summary.total_electric_usage,house_summary.total_electric_usage_house FROM room_summary INNER JOIN house_summary 
                ON room_summary.house_id=house_summary.id 
                WHERE house_summary.admin_id='".$adminid."'";
                $result = $dbc->query($sql);
                if(mysqli_num_rows($result)>0){
                    $room_no = array();
                    $total_electric_usage = array();
                    $total_electric_usage_house = array();
                    
                    while($row = mysqli_fetch_array($result)){
                        $room_no[]=$row["room_no"];
                        $total_electric_usage[]=$row["total_electric_usage"];
                        $total_electric_usage_house[]=$row["total_electric_usage_house"];


                    }                        
                    unset($result);
                }else{
                    echo "No matching records";
                }
            } catch (PDOExecption $e) {
                die ("ERROR". $e->getMessage());
            }

            unset($dbc);
            ?>

<div class="charts">

<div class="charts-card">
  <div class="charts-card">
            <p class="chart-title">ELECTRICITY USAGE</p>
            <canvas id="myChart"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        label: 'ELECTRICITY USAGE BY ROOM NUMBER',
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
                };

            //CONFIG BLOCK
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
            <p class="chart-title">USAGE PERCENTAGE</p>
            <canvas id="myChart2" width="400" height="200"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart2 = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: room_no,
                    datasets: [{
                        label: 'TOTAL USAGE IN THE HOUSE',
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
            </main>
            <!--END MAIN-->
        </div>
        <!--SCRIPTS-->
        <!--APEXCHART-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.3/apexcharts.min.js"></script>
       
        <!--CUSTOM JS-->
        <script src="js/scripts.js"></script>    

        <script>
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