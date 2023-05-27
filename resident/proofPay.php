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
        <title>Proof Payment</title>
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
            $q = "SELECT id, resident.house_id FROM resident  WHERE resident.id='".$residentid."'";      
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
          <p class="font-weight-bold">UPLOAD PROOF PAYMENT</p>
        </div>
        <?php
        
            
        $q1="SELECT * FROM resident WHERE id='$residentid'";
        $r1=mysqli_query($dbc,$q1);

        if(mysqli_num_rows($r1)) {
            foreach ($r1 as $q1) {

            ?>

        <div class="charts-card">
        <form action="../admin/function.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $q1['id']; ?>" class="form-control">
                        <label for="">File Name</label>
                        <input type="text" name="filename" class="form-control" placeholder="Ex: May/2023" required>
                        <br>       
            <input type="file" name="file">
            <br></br>
            <button type="submit" name="upload" class="btn btn-success">Upload File</button>
        </form>

        <?php
            }
        }
        ?>
<br>
<h4>Latest Upload</h4>
            

            <?php
            
            $q3="SELECT * FROM resident
                WHERE id='$residentid'";
            $r3=mysqli_query($dbc,$q3);
            if(mysqli_num_rows($r3)>0){
                foreach($r3 as $row){
                    if($row['proof_payment']==null){
                        ?>
                    <p>No Record Found</p>
                    <?php
                    } else{

                    
                    ?>
                    <table class="w3-table w3-striped w3-border">
                    <tr>  
                    <th>File Name</th>  
                    <th>Last Updated</th>  
                    <th>Delete</th>  
            </tr>
                    <tr>
                        <form action="../admin/function.php" method="POST">
                        <input type="hidden" name="file_location" value="<?= $row['file_location']; ?>" class="form-control">
                        <td><?= $row['proof_payment']; ?></td>
                        <td><?= $row['last_updated']; ?></td>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">
                        <td><button type="submit"  name="clearFile" class="btn btn-danger">CLEAR</td>
                        </form>
        
                        
                        </tr>
                        <?php
                        }
                }
            }
            else {
                ?>
                <p>No Record Found</p>
                <?php
            }
        
        ?>

            
            
        
        
            </table>
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