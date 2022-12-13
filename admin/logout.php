<?php
session_start();
session_destroy();
echo '<script>

alert("Logout Successfully");

</script>'; 
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="refresh" content="0; url='login.php" />
    <title>Redirecting...</title>
  </head>
  <body>
    <p><a href="localhost/eTrack/admin/login.php"></a>.</p>
  </body>
</html>