<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $msg="";
?>


		  
 <?
  
  $flag=false;
  
 
    if ( !empty($_POST[newPass]))
    {
 
     $userPassword = md5($_POST['newPass']);
     $type=$_POST['type'];
     if($userPassword=='21232f297a57a5a743894a0e4a801fc3')
      {
        if($type==1)
         {
          echo "Please follow serial when enter opening balance.<br>";
          echo "-----------------------------------------------------------------<br><br><br>";
          echo " <b><a href='Openstock.php' target='_blank'>1. Opeining Stock.</a></b><br><br><br>";
          echo " <b><a href='Opencustomer.php' target='_blank'>2. Customer Opening Balance.</a></b><br><br><br>";
          echo " <b><a href='Opencompany.php' target='_blank'>3. Company Opening Balance.</a></b><br><br><br>";
          echo " <b><a href='Openbank.php' target='_blank'>4. &nbsp; Bank & Cash At Hand</a></b>";      
         }
        else
         {
         
         echo "<br><br><br><font size='4' color='red'>Very Risky Operation !! Please ensure backup before empty database.</font><br>";
         echo "<img src='images/danger.png'><br><br>";
         echo "<b><a href='db.php'>Click Here To Go Empty Database Page.</a></b>";  
         
         } 
      }
      else
      {
       echo $msg=" Error !!! You are Not Authorized To Access This Menu. Or Wrong Password";
      } 
    }
    else
     {
      echo $msg=" Error !!! You are Not Authorized To Access This Menu.";
     }      
   
 ?>
 

<?php
 include "footer.php";
?>
