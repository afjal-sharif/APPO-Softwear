<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";


 echo "<img src='images/no_access.png'><br>";
 echo "Sorry !!<b>  $_SESSION[screenName] </b>  You Are Not Authorized  To Access This Menu.";


 include "footer.php";
?>
