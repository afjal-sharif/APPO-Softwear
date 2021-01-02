<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Home";
 include "session.php";  
 include "header.php";
 $_SESSION[constatus]='';
 $msg=$_GET[msg];
 echo "<b>".$msg ."</b>";
 ?>
 
 <?php
 include "footer.php";
?> 
 

