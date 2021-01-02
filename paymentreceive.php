<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
if(isset($_POST["view"]))
 {
  $con='';
  
  $con="where (tbl_dir_receive.date between '$_POST[demo11]' and '$_POST[demo12]') and hcash>0";
  
   if ($_POST[customer]!='')
   {
   $con=$con." and tbl_dir_receive.customerid=$_POST[customer]";
   }
    
    
     $user_query="select tbl_dir_receive.id,tbl_dir_receive.mrno, tbl_dir_receive.invoice,tbl_dir_receive.date,
                   tbl_dir_receive.hcash,tbl_dir_receive.cash,tbl_dir_receive.chequeno,tbl_dir_receive.bank,tbl_dir_receive.amount,
                   tbl_dir_receive.cstatus,tbl_dir_receive.cheqdate,tbl_dir_receive.remarks,tbl_dir_receive.user,
                   tbl_customer.name as customer
                   from tbl_dir_receive
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id
                                 
                   $con                 
                   order by tbl_dir_receive.id desc";


 }
else
 {
    $user_query="select tbl_dir_receive.id,tbl_dir_receive.mrno, tbl_dir_receive.invoice,tbl_dir_receive.date,
                   tbl_dir_receive.hcash,tbl_dir_receive.discount,
                   tbl_dir_receive.cstatus,tbl_dir_receive.cheqdate,tbl_dir_receive.remarks,tbl_dir_receive.user,
                   tbl_customer.name as customer
                   from tbl_dir_receive
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id   
                   order by tbl_dir_receive.id desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trsubhead"><b>Cash Payment Receive Report</b></td></tr>
 <tr>
   <td>From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,mobile,type  FROM tbl_customer order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  style="width: 200px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['mobile']?> : <?php echo $row_sql['type']?>   </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Cash Payment Receive Details.</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <td>Customer</td>
       <td align="center">MR NO</td>
       <td>Remarks</td>
       <td>Invoice</td>
       <td>Cash</td>
       <td>Discount</td>
    </tr>     
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
      $cashamount=0;
      $chequeamount=0;
      $discountamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[customer];?></td>
          <td align="center"><?=$value[mrno];?></td>
          <td><?=$value[remarks];?>::<?=$value[user];?></td>
          <td><?=$value[invoice];?></td>
          <td align="right"><?=number_format($value[hcash],2);?></td>
          <td align="right"><?=number_format($value[discount],2);?></td>        
       </tr>
       <?
       $cashamount=$cashamount+$value[hcash];
       $chequeamount=$chequeamount+$value[amount];
       $discountamount=$discountamount+$value[discount];
       }
      }
    ?>  
  </tr>
 <tr id="trsubhead"><td colspan="3" align="left">
      Total:</td>
     <td colspan="3" align="right"><?=number_format($cashamount,2);?></td>
    
     <td colspan="1" align="right"><?=number_format($discountamount,2);?></td>
     
 </tr>

 <tr id="trhead"><td colspan="3" align="left">
       <b>Total Receive:</b></td>
     <td colspan="4" align="right"><b><?=number_format($cashamount+$chequeamount-$discountamount,2);?></b></td>
     
     
     
 </tr>
 </table>


<?php
 include "footer.php";
?>
