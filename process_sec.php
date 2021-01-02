<?php
include  "includes/functions.php";
include "session.php"; 
if($_POST[tran_type]==0)
{

if (empty($_POST[demo11]) or empty($_POST[bank]) or empty($_POST[ref_id]) or empty($_POST[amount]) or !is_numeric($_POST[amount])) 
   {
    $msg="<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
       header("location:admin_security.php?message=$msg");
   }
  else
   {
     $type=$_POST[sec_type];
     $cid=$_POST[ref_id];
     $amount=$_POST[amount];
     $bank=$_POST[bank];
     $branch=$_POST[branch];
     
     $sql="insert into tbl_security (date,type,ref_id,sec_type,amount,expdate,bank,branch,user,remarks) 
         value('$_POST[demo11]',$type,$cid,'$_POST[paymethod]',$amount,'$_POST[demo12]','$bank','$branch','$_SESSION[userName]','$_POST[remarks]')";     
       db_query($sql) or die(mysql_error());   
   
    $msg="<img src='images/active.png' height='15px' width='15px'><b>Security Information Insert Successfully.</b>";
    header("location:message.php?message=$msg");
   }
  }

if($_POST[tran_type]==1)
{

if (empty($_POST[demo11]) or empty($_POST[bank]) or empty($_POST[ref_id]) or empty($_POST[accno])) 
   {
    $msg="<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
       header("location:admin_account.php?message=$msg");
   }
  else
   {
     $type=$_POST[sec_type];
     $cid=$_POST[ref_id];
     $account=$_POST[accno];
     $bank=$_POST[bank];
     $branch=$_POST[branch];
     
     $sql="insert into tbl_sc_account (date,type,ref_id,account,bank,branch,user,remarks) 
         value('$_POST[demo11]',$type,$cid,'$account','$bank','$branch','$_SESSION[userName]','$_POST[remarks]')";     
      db_query($sql) or die(mysql_error());   
   
    $msg="<img src='images/active.png' height='15px' width='15px'><b>Account No Information Insert Successfully.</b>";
    header("location:message.php?message=$msg");
   }
  }

// Do Sales...
if($_POST[tran_type]==2)
{
if (empty($_POST[demo11]) or empty($_POST[invoice]) or empty($_POST[customer])) 
   {
       $msg="<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
       header("location:invoiceprint.php?id=dosales");
   }
  else
   {
     $donumber=$_POST[donumber];
     $invoice=$_POST[invoice];
     $cid=$_POST[customer];
     
     $sql_sp="select sp from tbl_customer where id='$cid'";
     $users_sp = mysql_query($sql_sp);
     $row_sp= mysql_fetch_assoc($users_sp);
     $sp=$row_sp[sp];
     
     $dtDate=$_POST[demo11];
     $remarks=$_POST[remarks];
     $stock_sales=$_POST[stock_sales];
     
    if($stock_sales>0)
     {
      $sales_remarks="DO + Stock";
     }
     else
     {
      $sales_remarks="DO Sales";
     }
     
     /*
     $user_query="select * from tbl_receive where donumber='$donumber'";
     $users = mysql_query($user_query);
     $total = mysql_num_rows($users);    
     if($total>0)
         {
            while($value=mysql_fetch_array($users))
            {
              $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
                    soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination) 
                    value('$_POST[demo11]','$donumber','$value[product]', '$invoice',$value[rate],$value[qty],$value[bundle],
                    '$_SESSION[userName]',$cid,1,'$value[unit]',0,'DO Sales',
                     '-','DO Sales','-','$invoice',0,'-','$_POST[demo11]','-','-')"; 
              db_query($sql) or die(mysql_error());
            }  
         }
     */
    $prod=$_POST[product];
    $s_qty=$_POST[qty];
    $s_rate=$_POST[sale_rate];
    
    $totalqty=$_POST[totalqty];
    $df=$_POST[dfcost];
    $lo=$_POST[locost];
    
   
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $product_id= $prod[$id]; 
    $sal_qty=$s_qty[$id];
    $sal_rate=$s_rate[$id];
    
    
    $sql_unit="Select unit  from tbl_product where id='$product_id'";          
    $user_unit = mysql_query($sql_unit);
    $row_unit= mysql_fetch_assoc($user_unit);
    $unit=$row_unit[unit];
    
    
    
    $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
          soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination) 
          value('$_POST[demo11]','$donumber','$product_id', '$invoice',$sal_rate,$sal_qty,0,
               '$_SESSION[userName]',$cid,1,'$unit',$df/$totalqty,'$sales_remarks',
               '-','DS: $remarks','-','$invoice',$lo/$totalqty,'$sp','$_POST[demo11]','-','-')"; 
    db_query($sql) or die(mysql_error());
   //echo "<br>"; 
   }  
   
   // Add stock Item.
   if($stock_sales>0)
   {
     $sqltmp="select * from tbl_sales_temp where user='$_SESSION[userName]'";
     $userstmp = mysql_query($sqltmp);
     while($value=mysql_fetch_array($userstmp))
     { 
      $remarks=$value[remarks].$_POST[remarks]; 
      $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
            soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination) 
            value('$_POST[demo11]','$value[donumber]','$value[product_id]', '$invoice',$value[rate],$value[qty],$value[freeqty],
             '$_SESSION[userName]',$cid,1,'$unit',0,'$sales_remarks',
              '-','DS: $remarks','-',$invoice,0,'-','$_POST[demo11]','-','-')"; 
      db_query($sql) or die(mysql_error());
     }
    }      
    
     $sql_del="delete from tbl_sales_temp where user='$_SESSION[userName]'";
     db_query($sql_del) or die(mysql_error());
    
         
    $_SESSION[invoice]=$invoice;
    $msg="<img src=images/active.png height='15px' width='15px'><b>".$sales_remarks." Sales Successfully. DO Number :". $donumber."</b>";
    header("location:welcome.php?message=".urlencode($msg)."");
   }
  }
    
?>
