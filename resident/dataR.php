<?php
session_start();
if(empty($_SESSION['email'])){
    header("Location:login.php");
}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,inital-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Data Manage</title>
        <!--Sarabun Font-->
        <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!--Material Icon-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

        <!--CUSTOM CSS-->
        <link rel="stylesheet" href="../admin/css/style.css">
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
            <aside id="sidebar" action="../admin/function.php" method="post">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                <span class="material-icons-outlined">inventory</span><a>House ID = </a> <?php 
                // HOUSE ID CALLOUT
            require('../admin/dbconnect.php');
            $email=$_SESSION["email"];   
            $residentid=$_SESSION["id"];   
            // Define the query:
            $q = "SELECT resident.house_id FROM resident  WHERE resident.id='".$residentid."'";      
            $r = mysqli_query ($dbc, $q);
            $num = mysqli_num_rows($r);
            if ($num > 0) { // If it ran OK, display the records.
            
            // Fetch and print all the records:
            if ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo  $row['house_id'] ;
            }
            mysqli_free_result ($r);  
            }
            ?>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item" ><a href="residentR.php">
                <span class="material-icons-outlined">dashboard</span>Dashboard
                </a></li> 
                <li class="sidebar-list-item"><a href="proofPay.php">
                <span class="material-icons-outlined">dashboard</span>Proof of Payment
                </a></li>     
                <li class="sidebar-list-item" ><a href="dataR.php">
                <span class="material-icons-outlined">dashboard</span>Data Usage
                </a></li>   
                <li class="sidebar-list-item"><a href="viewProfile.php">
                <span class="material-icons-outlined">dashboard</span>View Profile
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
          <p class="font-weight-bold">MANAGE YOUR ELECTRICITY USAGE</p>
        </div>
        <div class="charts-card" style="overflow-x:auto;">

<h4>Set Usage Warning</h4>

<table class="w3-table w3-striped w3-border">



<?php

$q2 = "SELECT * FROM resident WHERE id='".$residentid."'";
$q2_run = mysqli_query($dbc, $q2);
if(mysqli_num_rows($q2_run)>0){
foreach($q2_run as $row){

if($row['limit_house']==0 && $row['limit_room']==0){      
?>
<tr>
<td colspan="8">No Record Found</td>
</tr>
<?php
}

else{
?>
<tr>
<tr>  
          <th>House Limit (RM)</th>  
          <th>Room Limit (RM)</th>  
          <th>Delete</th>  
</tr>
    <td><?= $row['limit_house']; ?></td>
    <td><?= $row['limit_room']; ?></td>
    <form action="../admin/function.php" method="POST">
    <td><button type="submit" name="deleteLimitR" value="<?= $row['id'];?>" onclick="return confirm('Are you sure to delete this limit? ')" class="btn btn-danger">Delete</button></td>
    </form>
</tr>
<?php
}
}
}
?>



</table>
<br>
<table class="w3-table">
<div class="row">

<form action="../admin/function.php" method="POST">
<div class="col-md-4 mb-3">
    <label for="">House Limit (RM)</label>
    <input type="text" name="house_limit" maxlength="3" class="form-control">
    <br>
    <button type="submit" name="addLimitRH" value="<?= $row['id'];?>" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="btn btn-primary">SET NEW HOUSE LIMIT</button>
</div>
</form>
<form action="../admin/function.php" method="POST">
<div class="col-md-4 mb-3">
    <label for="">Room Limit (RM)</label>
    <input type="text" name="room_limit" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control">
    <br>
    <button type="submit" name="addLimitRR" value="<?= $row['id'];?>" class="btn btn-primary">SET NEW ROOM LIMIT</button>
</div>
</form>


</div>
</table>
</div>
</div>
</div>
            </main>
            <!--END MAIN-->
        </div>
        <!--SCRIPTS-->
        <!--APEXCHART-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.3/apexcharts.min.js"></script>
       
        <!--CUSTOM JS-->
        <script src="../admin/js/scripts.js"></script>    

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