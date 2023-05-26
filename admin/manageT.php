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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Manage Account</title>
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
                $adminid=$_SESSION["id"];   
                echo $houseid;
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
          <p class="font-weight-bold">MANAGE RESIDENT'S ACCOUNT</p>
        </div>
                <!-- <div class="container-fluid px-4">
                    <h1 class="mt-4">Users</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                    <li class="breadcrumb-item">Users</li>
        </ol> -->
        <div class="charts-card" style="overflow-x:auto;">

                    <h4>Registered Tenant</h4>

                    <table class="w3-table w3-striped w3-border">

                            <tr>  
                              <th>Room No.</th>  
                              <th>Email</th>  
                              <th>Name</th>  
                              <th>Phone No.</th>
                              <th>Payment File</th>  
                              <th>Room Status</th>  
                              <th>Edit</th>  
                              <th>Delete</th>  
        </tr>

        <?php
        $q2 = "SELECT resident.id, email, username, resident.room_no, phone_no, proof_payment, room_status FROM resident 
                INNER JOIN house_summary ON house_summary.id = resident.house_id
                WHERE house_summary.admin_id='".$adminid."' ORDER BY room_no ASC";
        $q2_run = mysqli_query($dbc, $q2);
        
        if(mysqli_num_rows($q2_run)>0){
            foreach($q2_run as $row){
                if($row['proof_payment']==""){
                    $proofPay= "No File Uploaded";
                
                ?>
                    <tr>
                        <td><?= $row['room_no']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['phone_no']; ?></td>
                        <td><?= $proofPay; ?></td>
                        <?php
                        if ($row['room_status']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">
                        <td><button type="submit" name="status" value="OFF" class="btn btn-primary"><?= $row['room_status']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">
                            <td><button type="submit" name="status" value="ON" class="btn btn-primary"><?= $row['room_status']; ?></td>
                        </form>
                                <?php
                        }
                        ?>
                        <td><a href="editResident.php?id=<?= $row['id'];?>" class="btn btn-success">Edit</a></td>
                        <form action="function.php" method="POST">
                        <td><button type="submit" name="delete" value="<?= $row['id'];?>" onclick="return confirm('Are you sure to delete this user? Deleted data can not be restored. ')"  class="btn btn-danger">Delete</button></td>
                        </form>
                </tr>
                <?php
                }

                else{
                    ?>
                    <tr>
                        <td><?= $row['room_no']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['phone_no']; ?></td>
                        <td><?= $row['proof_payment']; ?></td>
                        <td><?= $row['room_status']; ?></td>
                        <td><a href="editResident.php?id=<?= $row['id']; ?>" class="btn btn-success">Edit</a></td>
                        <form action="function.php" method="POST">
                        <td><button type="submit" name="delete" value="<?= $row['id'];?>" onclick="return confirm('Are you sure to delete this user? Deleted data can not be restored. ')" class="btn btn-danger">Delete</button></td>
                        </form>
                </tr>
                <?php
                }
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
        </div>
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