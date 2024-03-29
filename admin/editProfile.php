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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Edit User Profile</title>
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
<?php
if($role=="landlord"){
    ?>
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
<?php

}
else{
    ?>
    <ul class="sidebar-list">
                    <li class="sidebar-list-item" ><a href="adminT.php">
                    <span class="material-icons-outlined">dashboard</span>Dashboard
                    </a></li>
                    <li class="sidebar-list-item" ><a href="dataT.php">
                    <span class="material-icons-outlined">dashboard</span>Data Usage
                    </a></li>     
                    <li class="sidebar-list-item"><a href="viewProfile.php">
                    <span class="material-icons-outlined" >dashboard</span>View Profile
                    </a></li>    
                    <li class="sidebar-list-item"><a href="logout.php">
                    <span class="material-icons-outlined" name="logout" >dashboard</span>Logout
                    </a></li>     
                </ul>
    
                </aside>
    <?php
}
?>
            
            <!--END SIDEBAR-->

            <!--MAIN-->
            <main class="main-container">
            <div class="main-title">
          <p class="font-weight-bold">USER PROFILE</p>
        </div>

        <?php
        
            
            $q1="SELECT * FROM admin WHERE admin.id='$adminid'";
            $r1=mysqli_query($dbc,$q1);

            if(mysqli_num_rows($r1)) {
                foreach ($r1 as $q1) {

                ?>
                
                

        <!-- Edit Form -->
        <div class="charts-card">
            <form action="function.php" method="POST">
            <input type="hidden" name="id" value="<?= $q1['id']; ?>" class="form-control">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="">Email</label>
                        <input type="text" name="username" value="<?= $q1['username']; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone_no" value="<?= $q1['phone_no']; ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" value="<?= $q1['password']; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <button type="submit"  name="updateProfile" class="btn btn-success">Update User</button>
                    <td><a href="viewProfile.php" onclick="return confirm('Are you sure to leave this page? Progress would not be saved. ')" class="btn btn-danger">Cancel</a></td>
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