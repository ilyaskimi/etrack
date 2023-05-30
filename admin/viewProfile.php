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
        <title>User Profile</title>
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
                    <li class="sidebar-list-item" ><a href="adminR.php">
                    <span class="material-icons-outlined">dashboard</span>Dashboard
                    </a></li>
                    <li class="sidebar-list-item" ><a href="dataR.php">
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
          <p class="font-weight-bold">VIEW USER PROFILE</p>
        </div>

        <?php
        
            
            $q1="SELECT * FROM admin WHERE admin.id='$adminid'";
            $r1=mysqli_query($dbc,$q1);

            if(mysqli_num_rows($r1)) {
                foreach ($r1 as $q1) {
            
                    $q2="SELECT * FROM house_summary WHERE admin.id='$adminid'";
                    $r2=mysqli_query($dbc,$q2);
                ?>
                
                

        <!-- Edit Form -->
        <div class="charts-card">
            <form action="function.php" method="POST">
            <input type="hidden" name="id" value="<?= $q1['id']; ?>" class="form-control">
            <input type="hidden" name="house_id" value="<?= $houseid ?>" class="form-control">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="">Email</label>
                        <input type="text" name="username" value="<?= $q1['username']; ?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone_no" value="<?= $q1['phone_no']; ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" value="<?= $q1['password']; ?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                    <td><a href="editProfile.php?id=<?= $q1['id'];?>" class="btn btn-success">Edit</a></td>
                    </div>

                    <div class="col-md-6 mb-3">
                    <td><button type="submit" name="pdfAdmin" value="<?= $q1['id'];?>" class="btn btn-primary">Generate Report</button></td>
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
            <!-- POWER SWITCHING -->
            <h4>House Power Status</h4>
            <table class="w3-table w3-striped w3-border">
                    <tr>  
                    <th>Room No.</th>  
                    <th>Power Status</th>  
            </tr>

            <?php
            
            $q3="SELECT relay.serial_number, no_room, room_no1, room_no2, room_no3, room_no4 FROM relay 
            INNER JOIN house_summary ON house_summary.serial_number=relay.serial_number 
            WHERE house_summary.id='$houseid'";
            $r3=mysqli_query($dbc,$q3);
            if(mysqli_num_rows($r3)>0){
                foreach($r3 as $row){
                    $no_room=$row['no_room'];
                }
                
            } else {
                ?>
                <tr>
                    <td colspan="8">No Record Found</td>
                </tr>
            <?php
            }

            switch($no_room){
                case "1":
                    ?>
                    <tr>
                        <td>1</td>
                        <?php
                        if ($row['room_no1']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="OFF" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="ON" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <?php
                    break;

                case "2":
                    ?>
                    <tr>
                        <td>1</td>
                        <?php
                        if ($row['room_no1']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="OFF" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="ON" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                        <td>2</td>
                        <?php
                        if ($row['room_no2']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile2" value="OFF" class="btn btn-primary"><?= $row['room_no2']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile2" value="ON" class="btn btn-primary"><?= $row['room_no2']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <?php
                    break;

                    case "3":
                    ?>
                    <tr>
                        <td>1</td>
                        <?php
                        if ($row['room_no1']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="OFF" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="ON" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                        <td>2</td>
                        <?php
                        if ($row['room_no2']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile2" value="OFF" class="btn btn-primary"><?= $row['room_no2']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile2" value="ON" class="btn btn-primary"><?= $row['room_no2']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                        <td>3</td>
                        <?php
                        if ($row['room_no3']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile3" value="OFF" class="btn btn-primary"><?= $row['room_no3']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile3" value="ON" class="btn btn-primary"><?= $row['room_no3']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <?php
                    break;

                    case "4":
                    ?>
                    <tr>
                        <td>1</td>
                        <?php
                        if ($row['room_no1']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="OFF" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile1" value="ON" class="btn btn-primary"><?= $row['room_no1']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                        <td>2</td>
                        <?php
                        if ($row['room_no2']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile2" value="OFF" class="btn btn-primary"><?= $row['room_no2']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile2" value="ON" class="btn btn-primary"><?= $row['room_no2']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                        <td>3</td>
                        <?php
                        if ($row['room_no3']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile3" value="OFF" class="btn btn-primary"><?= $row['room_no3']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile3" value="ON" class="btn btn-primary"><?= $row['room_no3']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <tr>
                        <td>4</td>
                        <?php
                        if ($row['room_no4']=="ON"){
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile4" value="OFF" class="btn btn-primary"><?= $row['room_no4']; ?></td>
                        </form>
                            <?php
                        } else{
                            ?>
                        <form action="function.php" method="POST">
                        <input type="hidden" name="serial_number" value="<?= $row['serial_number']; ?>" class="form-control">
                        <td><button type="submit" name="statusProfile4" value="ON" class="btn btn-primary"><?= $row['room_no4']; ?></td>
                        </form>
                        <?php
                        }
                        ?>
                        </tr>
                        <?php
                    break;
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