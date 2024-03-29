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
        <title>Add House Unit</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
            $role=$_SESSION["role"];     
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
                <li class="sidebar-list-item" ><a href="adminT.php">
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
          <p class="font-weight-bold">DISPLAY HOUSE UNIT</p>
        </div>
        <div class="charts-card" style="overflow-x:auto;">

<h4>Registered House Unit</h4>

<table class="w3-table w3-striped w3-border">

        <tr>  
          <th>House ID</th>  
          <th>Serial Number</th>  
          <th>Address</th>  
          <th>Number of Room</th>  
</tr>

<?php
$q2 = "SELECT house_summary.id, house_summary.admin_id, serial_number, address, house_summary.no_room FROM house_summary 
WHERE house_summary.admin_id='".$adminid."' ORDER BY house_summary.id ASC";
$q2_run = mysqli_query($dbc, $q2);

if(mysqli_num_rows($q2_run)>0){
foreach($q2_run as $row){

?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['serial_number']; ?></td>
    <td><?= $row['address']; ?></td>
    <td><?= $row['no_room']; ?></td>
    
</tr>
<?php


}
}

else{
?>
<tr>
<td colspan="8">No Record Found</td>
</tr>
<?php
}
?>

</table>
<br>
<table class="w3-table">
<div class="row">
    <form action="function.php" method="POST">
                    <div class="col-md-4 mb-3">
                        <label for="">Serial Number</label>
                        <input type="text" name="serial_number" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Address</label>
                        <input type="text" name="address" maxlength="70" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Number of Room</label>
                        <input type="text" name="room_no" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="1" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                    <button type="submit" name="addHouse" value="<?= $row['admin_id'];?>" class="btn btn-success">ADD ANOTHER HOUSE UNIT</button>
                    </div>
    </form>
</div>
</table>

</div>
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