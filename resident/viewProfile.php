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
        <title>User Profile</title>
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
          <p class="font-weight-bold">VIEW PROFILE</p>
        </div>

        <?php
        
            
            $q1="SELECT * FROM resident WHERE id='$residentid'";
            $r1=mysqli_query($dbc,$q1);

            if(mysqli_num_rows($r1)) {
                foreach ($r1 as $q1) {

                ?>
                
        <!-- Edit Form -->
        <div class="charts-card">
            <form action="../admin/function.php" method="POST">
            <input type="hidden" name="id" value="<?= $q1['id']; ?>" class="form-control">
            <input type="hidden" name="house_id" value="<?= $q1['house_id']; ?>" class="form-control">
            <input type="hidden" name="room_no" value="<?= $q1['room_no']; ?>" class="form-control">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" value="<?= $q1['email']; ?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Name</label>
                        <input type="text" name="username" value="<?= $q1['username']; ?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone_no" value="<?= $q1['phone_no']; ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" value="<?= $q1['password']; ?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                    <td><a href="editProfile.php?id=<?= $q1['id'];?>" class="btn btn-success">Edit</a></td>
                    </div>

                    <div class="col-md-6 mb-3">
                    <td><button type="submit" name="pdfResident" value="<?= $q1['id'];?>" class="btn btn-primary">Generate Report</button></td>
                    </div>

        </div>
            </form>

            <?php
                }
            } else {
                ?>
                <p>No Record Found</p>
                <?php
            }
            ?>

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