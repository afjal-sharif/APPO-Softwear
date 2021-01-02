<?php
  session_start();
  include "includes/functions.php";
 
  $sql="delete from tbl_daily_sales where user='$_SESSION[userName]'";
  db_query($sql);  
  
  $emp_ben=$_POST[cash];
  $emp_rate=$_POST[rate];
  $emp_cost=$_POST[cost];
  $emp_remarks=$_POST[remarks];
  
  $skill_id=$_POST[skill_id];
  
  $product=$_POST[product];
  $stock=$_POST[stock];
  $product_name=$_POST[product_name];
  
  $user=$_SESSION['userName']; 
  
    
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $emp_ben_result= $emp_ben[$id];
    $emp_rate_result=$emp_rate[$id];
    $emp_cost_result=$emp_cost[$id];
    $emp_remarks_result=$emp_remarks[$id];
    
    $skill_id_result=$skill_id[$id];  
    
    
    if(($emp_ben_result<>'') and  ($emp_ben_result<>0)) 
     {
       $sql="insert into tbl_daily_sales(cust_id,product,qty,rate,cost,user,stock,product_name,remarks)
               values('$skill_id_result','$product','$emp_ben_result','$emp_rate_result','$emp_cost_result','$user','$stock','$product_name','$emp_remarks_result')";
       db_query($sql);
     }      
   }   
   header("location: rec_cement_sales.php?id=2");
      
?> 
