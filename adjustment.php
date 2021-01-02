<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";

$todo=$_REQUEST["todo"];
switch ($todo)
{
 case "viewin":
 {
  viewin();
  exit;
 }
 case "submitin":
 {
  submitin();
  exit;
 }
 
 case "viewde":
 {
  viewde();
  exit;
 }
 case "submitde":
 {
  submitde();
  exit;
 }
 
 case "viewsup":
 {
  viewsup();
  exit;
 }
 case "submitsup":
 {
  submitsup();
  exit;
 }
 
 case "viewcust":
 {
  viewcust();
  exit;
 }
 case "submitcust":
 {
  submitcust();
  exit;
 }
 
 
}


 function viewin()
 {
  //$mnuid="442";
  @checkmenuaccess($mnuid);
  include "stock_adjust.php";
 }
 
 function viewde()
 {
  //$mnuid="443";
  @checkmenuaccess($mnuid);
  include "adjust_decrease.php";
 }
  
 function viewsup()
 {
  echo "Under Construction";
  include "footer.php";
  //include "stock_adjust.php";
 }


 function viewcust()
 {
  echo "Under Construction";
  include "footer.php";
  //include "stock_adjust.php";
 }
  
 
 
 function submitin()
 {
   $sub_cat = $_POST['sub_cat'];
   $type = $_POST['type'];
   $type=0;
   $qty=$_POST[quantity];
   $rate=0;
   $remarks=$_POST[remarks];
   $sql="insert into tbl_adjustment(date,type,product,qty,rate,user,remarks)value('$_SESSION[dtcompany]','$type','$sub_cat','$qty','$rate','$_SESSION[userName]','$remarks')";
   db_query($sql);
   include "stock_adjust.php";
 }

function submitde()
 {
   
  // $product=substr($pro_value,0,strpos($pro_value,'::'));
   //$pro_value=substr($pro_value,strpos($pro_value,'::')+2);
   //$qty=substr($pro_value,0,strpos($pro_value,'::'));
   //$rate=substr($pro_value,strpos($pro_value,'::')+2);
   
   $product=$_POST[sub_cat];
   $qty=$_POST[quantity];
   $remarks=$_POST[remarks];
   
   $sql="select sum(qty) as qty from view_stock_display where product='$product' ";
   $sql_qty = mysql_query($sql);
   $sql_st_qty= mysql_fetch_assoc($sql_qty);
   $stockqty=$sql_st_qty[qty];
   if($qty>$stockqty)
   {
    $qty=$stockqty;
   }
   
   $rembal=$qty;
         
   if($stockqty>=$qty)
   {
     $user_query="select * from view_stock_sales where product='$product' order by donumber";
     $users = mysql_query($user_query);
     $total = mysql_num_rows($users);
     $flag=true;
     while($value=mysql_fetch_array($users) and ($flag==true))
     {
      if($rembal<=$value[qty])
      {
        $salesqty=$rembal;
        $rembal=0;
        $flag=false;
      }
    else
     {
      $salesqty=$value[qty];
      $rembal=$rembal-$value[qty];
      $flag=true;     
     }  
    
    $sql="insert into tbl_adjustment(date,type,donumber,product,qty,rate,user,remarks,unit) 
              values('$_SESSION[dtcompany]',1,'$value[donumber]','$value[product]','$salesqty','$value[grate]','$_SESSION[userName]','$remarks','$value[unit]')";
    db_query($sql);   
   }// While loop for insert
 } 

  include "adjust_decrease.php"; 
 } 
 
 
 
 
?>
