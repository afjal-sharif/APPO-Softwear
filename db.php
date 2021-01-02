<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm(" Warning !!!!  Are You Sure Empty Database ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 



<?
$flag=false;
if(isset($_POST["submit"]))
 {
   $sql="delete from tbl_advance"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'> <b> Success !! Advance Data Delete Successfully.</b><br>";
  
   $sql="delete from tbl_assets_liab"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Assets & Liabilities Data Delete Successfully.</b><br>";
  
  
   $sql="delete from tbl_bank"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Bank Data Data Delete Successfully.</b><br>";
  
  if($_POST[bank]!==on) 
   {
   $sql="delete from tbl_bank_name"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Bank Name Data Delete Successfully.</b><br>";
   }
   else
   {
   $msgnot=" <b>Bank</b> Name. ";
   }
  
   $sql="delete from tbl_cash"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Cash Data Delete Successfully.</b><br>";
   
  if($_POST[company]!==on) 
   {
   $sql="delete from tbl_company"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Company Data Delete Successfully.</b><br>";
   }
   else
   {
   $msgnot=$msgnot." <b>Company</b> Name. ";
   }

   $sql="delete from tbl_com_payment"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Payment Data Delete Successfully.</b><br>";

  if($_POST[customer]!==on) 
   {
   $sql="delete from tbl_customer"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Customer Data Delete Successfully.</b><br>";
   }
   else
   {
   $msgnot=$msgnot." <b>Customer</b> Name. ";
   }
   


   $sql="delete from tbl_dir_receive"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Receive Payment Data Delete Successfully.</b><br>";

   $sql="delete from tbl_docost"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! DO Cost Data Delete Successfully.</b><br>";

   if($_POST[expense]!==on) 
   {
   $sql="delete from tbl_expense_cat"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Delete Expense Category Data Delete Successfully.</b><br>";
   }
   else
   {
    $msgnot=$msgnot." <b>Expense Category</b> Name. ";
   }
 
   $sql="delete from tbl_incentive"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Incentive Data Delete Successfully.</b><br>";
   
   $sql="delete from tbl_order"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Sales Order Data Delete Successfully.</b><br>";

   if($_POST[product]!==on) 
   { 
   $sql="delete from tbl_product"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Product Information Data Delete Successfully.</b><br>";
   }
   else
   {
    $msgnot=$msgnot." <b>Product</b> Name. ";
   }

   $sql="delete from tbl_receive"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Goods Receive Data Delete Successfully.</b><br>";
  
   $sql="delete from tbl_sales"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Sales Data Delete Successfully.</b><br>";
  
   $sql="delete from tbl_open_bal"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Opeinign Balance Data Delete Successfully.</b><br>";

   $sql="delete from tbl_profit"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Profit Balance Data Delete Successfully.</b><br>";
 
   $sql="update tbl_bank_name set openingbal=0"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Bank Opening Balnace Delete Successfully.</b><br>";

   

   if($_POST[project]!==on) 
   { 
   $sql="delete from tbl_project"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Project Name Delete Successfully.</b><br>";
   }
   else
   {
   $msgnot=$msgnot." <b>Project</b> Name. ";
   }

   if($_POST[truck]!==on) 
   { 
   $sql="delete from truck_main"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Truck Income Delete Successfully.</b><br>";
   }
   else
   {
   $msgnot=$msgnot." <b>Truck</b> Name. ";
   }
   
   if($_POST[truckexpense]!==on) 
   { 
   $sql="delete from `truck-expense_cat`"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Truck Expense Delete Successfully.</b><br>";
   }
   else
   {
   $msgnot=$msgnot." <b>Truck Expense </b> Category. ";
   }
 
   
   $sql="delete from tbl_truck"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Truck Name Delete Successfully.</b><br>";

 
 


   $sql="delete from tbl_incentive_rate"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Incentive Rate Delete Successfully.</b><br>";

   $sql="delete from tbl_incentive_pay"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Incentive Payments Delete Successfully.</b><br>";
   
   
   $sql="delete from tbl_sp"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! SP Name Delete Successfully.</b><br>";
 
   $sql="delete from truck_name"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Truck Name Delete Successfully.</b><br>";
  
   $sql="delete from tbl_target"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Target Data Delete Successfully.</b><br>";

   $sql="delete from `today_tmp`"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Today Temp Data Delete Successfully.</b><br>";

   $sql="delete from `tbl_bs`"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Old Balance Sheet Data Delete.</b><br>";

   $sql="delete from `tbl_discussion`"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Ols Discussion Delete.</b><br>";

 
   echo "<br><br>Data Remain :". $msgnot;
   
   
   // Cash Customer.   
   $sql="INSERT INTO `tbl_customer` (`id`, `name`, `address`, `area`, `type`, `mobile`, `tnt`, `email`, `dateandtime`, `user`, `status`, `climit`, `cdays`, `remarks`, `customerbangla`) VALUES
         (1, 'Cash Customer', 'Unknown', 'Dhaka', 'Direct', '-', '', NULL, '2011-05-29 23:46:39', 'admin', 0, 0, 30, '', '&#2453;&#2494;&#2486; &#2453;&#2494;&#2488;&#2463;&#2507;&#2478;&#2494;&#2480;');";
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Cash Customer Create Successfully.</b><br>";

   
   // Insert Cash Discount Category.  
   $sql="INSERT INTO `tbl_expense_cat` (`id`, `type`, `details`, `dateandtime`, `user`, `expensetype`) VALUES
                (100, 'Sales Discount', 'Adjust Sales Discount Amount', '2011-05-30 00:27:18', 'javed', 0),
                (101, 'Purcahse Discount', 'Adjust Purchase Discount Amount', '2011-05-30 00:30:48', 'javed', 0);";
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Openning Expense Category Successfully.</b><br>";

 

  $flag=true;
 }
 if($flag==false)
 {
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <!--
      <tr align="left"><td colspan="7"><b>Remain Following Data(Checkmark if keep data)</b> </td></tr>
      <tr>
        <td><input type="checkbox" name="company" />Company Name</td>
        <td><input type="checkbox" name="product" />Product Name</td>
        <td><input type="checkbox" name="customer" />Customer Name</td>
        <td><input type="checkbox" name="project" />Project Name</td>
        <td><input type="checkbox" name="bank" />Bank Name</td>
        <td><input type="checkbox" name="truck" />Truck Name</td>
        <td><input type="checkbox" name="truckexpense" />Truck Expense Category</td>
     </tr>
 -->    
     <tr id="trsubhead"><td colspan="7" align="center"><b>Warning :: If you click below button all data will remove from database.</b> </td></tr>
     <tr id="trsubhead"><td colspan="7" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="Click Here To Delete All Data From Database." /> </td> </tr>
</table>
</form>
<?php
 }
 include "footer.php";
?>
