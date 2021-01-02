<?php
 session_start();
 include "includes/functions.php";
 
  $sql="delete from tbl_cash_temp where user='$_SESSION[userName]'";
  db_query($sql);  
  
  $emp_ben=$_POST[cash];
  $skill_id=$_POST[skill_id];
  
  $user=$_SESSION['userName']; 
  
    
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $emp_ben_result= $emp_ben[$id];
    $skill_id_result=$skill_id[$id];  
    
    
    if(($emp_ben_result<>'') and  ($emp_ben_result<>0)) 
     {
       $sql="insert into tbl_cash_temp(cust_id,cash,user)
               values('$skill_id_result','$emp_ben_result','$user')";
       db_query($sql);
     }
       
   }   
   header("location: rec_cash_bulk.php?id=2");
      
?> 
