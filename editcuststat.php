<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add New Customer ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[name]) or empty($_POST[address]) or empty($_POST[mobile])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_customer (name,address,mobile,tnt,type,user,climit,cdays,area,remarks) value('$_POST[name]','$_POST[address]','$_POST[mobile]','$_POST[tnt]','$_POST[type]','$_SESSION[userName]',$_POST[limit],$_POST[cdays],'$_POST[area]','$_POST[remarks]')"; 
   db_query($sql) or die(mysql_error());
    echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Customer Name insert successfully</b>";
   } // Error chech If
 }// Submit If
?>

<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Display Existing Customer List</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Name</td>
       <td>ID</td>
       <td>Date</td>
       <td>MR No</td>
       <td>Invoice</td>
       <td>Cash</td>       
      </tr>     
  <tr>
    <?
      $user_query="select * from tbl_dir_receive where customerid=0 order by id";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
      $sql_cust="Select customerid from tbl_sales where invoice='$value[invoice]'";
      $users_cust = mysql_query($sql_cust);
      $row_sql= mysql_fetch_assoc($users_cust);
      $custid=$row_sql[customerid];
      //echo "<br>";
       $sql="update tbl_dir_receive set customerid=$custid where id=$value[id]";
      //echo "<br>";
      db_query($sql);
      
       ?>
       <tr><td colspan="1" id="trsubhead" align="left"><?=$value[name];?></td>
          <td><?=$value[id];?></td>
          <td><?=$value[date];?></td>
          <td><?=$value[mrno];?></td>
          <td><?=$value[invoice];?></td>
          <td><?=number_format($value[hcash],0);?></td>
        </tr>
       <?
       }
      }
    ?>  
  </tr>
 </table>
 
 <?
  $sql="delete from tbl_cash where `deposite`=0 and `withdraw`=0";
  db_query($sql);
  $sql="delete from tbl_dir_receive where `hcash`=0 and cash=0 and amount=0 and discount=0";
  db_query($sql);
  $sql="delete FROM `tbl_com_payment` where `amount`=0 and `bamount`=0";
  db_query($sql);
  
  $sql="DROP VIEW IF EXISTS `viw_com_statement`";
  db_query($sql);
  $sql="CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_com_statement` AS select `tbl_order`.`dateandtime` AS `date`,`tbl_order`.`donumber` AS `dono`, `tbl_order`.`company` AS `com`,`tbl_order`.`product` AS `product`, `tbl_order`.`qty` AS `quantity`,(`tbl_order`.`rate` + `tbl_order`.`deliveryfair`) AS `price`, `tbl_order`.`comission` AS `dis`,0 AS `gp`,0 AS `truck`,0 AS `cheque`, 0 AS `bank`,0 AS `amount`,1 AS `dorder` from `tbl_order` union all select `tbl_receive`.`date` AS `date`,`tbl_receive`.`donumber` AS `dono`, `tbl_order`.`company` AS `com`,`tbl_order`.`product` AS `product`, `tbl_receive`.`qty` AS `quantity`,0 AS `price`,0 AS `dis`, `tbl_receive`.`gpnumber` AS `gp`,`tbl_receive`.`truckno` AS `truck`, 0 AS `cheque`,0 AS `bank`,0 AS `amount`,2 AS `dorder` from (`tbl_receive` join `tbl_order` on((`tbl_order`.`donumber` = `tbl_receive`.`donumber`))) union all select min(`tbl_com_payment`.`paydate`) AS `date`,0 AS `dono`, `tbl_order`.`company` AS `com`,0 AS `product`,0 AS `quantity`, 0 AS `price`,0 AS `dis`,0 AS `gp`,0 AS `truck`, `tbl_com_payment`.`chequeno` AS `cheque`, `tbl_com_payment`.`bank` AS `bank`,sum(`tbl_com_payment`.`amount`) AS `amount`,3 AS `dorder` from (`tbl_com_payment` join `tbl_order` on((`tbl_order`.`donumber` = `tbl_com_payment`.`donumber`))) group by chequeno,bank,company;";
  db_query($sql) or die(mysql_error());
   
  
 ?>



<?php
 include "footer.php";
?>

