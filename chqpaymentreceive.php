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
  
  $con="where (tbl_dir_receive.date between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[customer]!='')
   {
   $con=$con." and tbl_dir_receive.customerid=$_POST[customer]";
   }
  
  if ($_POST[company]!='')
   {
   $con=$con." and tbl_customer.com_id='$_POST[company]'";
   } 
   
  if ($_POST[status]!='')
   {
   $con=$con." and tbl_dir_receive.cstatus='$_POST[status]'";
   }
 
   if ($_POST[sp]!='')
   {
   $con=$con." and tbl_customer.sp='$_POST[sp]'";
   }
    
    
   $user_query="select tbl_dir_receive.id,tbl_dir_receive.mrno, tbl_dir_receive.invoice,tbl_dir_receive.date,tbl_dir_receive.hcash,
                   tbl_dir_receive.cash,tbl_dir_receive.chequeno,tbl_dir_receive.bank,tbl_dir_receive.amount,
                   tbl_dir_receive.cstatus,tbl_dir_receive.cheqdate,tbl_dir_receive.remarks,tbl_bank_name.bankname as bname,
                   tbl_customer.name as customer
                   from tbl_dir_receive
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id
                   left join tbl_bank_name on depositebank=tbl_bank_name.accountcode
                   $con                 
                   order by tbl_dir_receive.date desc";


 }
else
 {
    $user_query="select tbl_dir_receive.id,tbl_dir_receive.mrno, tbl_dir_receive.invoice,tbl_dir_receive.date,tbl_dir_receive.bank,
                   tbl_dir_receive.cash,tbl_dir_receive.chequeno,tbl_dir_receive.bank,tbl_dir_receive.amount,tbl_dir_receive.hcash,
                   tbl_dir_receive.cstatus,tbl_dir_receive.cheqdate,tbl_dir_receive.remarks,tbl_bank_name.bankname as bname,
                   tbl_customer.name as customer
                   from tbl_dir_receive
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id
                   left join tbl_bank_name on depositebank=tbl_bank_name.accountcode
                   order by tbl_dir_receive.date desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="6" align="center"  id="trsubhead"><b>Cheque Recive Details Report</b></td></tr>
 <tr>
   <td>From Date: <input type="Text" id="demo11" maxlength="10" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="10" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>COMPANY:   
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
   
   <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,mobile,type  FROM tbl_customer  where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">
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
         <td>AREA:
         

          <?
           $query_sql = "SELECT id as sp,shortname  FROM tbl_sp  order by shortname asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">      
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['sp'];?>" <?php if($_POST["sp"]==$row_sql['sp']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>    
       </td>   
       <!--
       <td> Status
           <select name="status" style="width:80px"> 
             <option value=""></option>
             <option value="N" <?if($_POST[status]=='N') echo "Selected"; ?>>At Bank</option>
             <option value="C" <?if($_POST[status]=='C') echo "Selected"; ?>>Clear</option>
             <option value="B" <?if($_POST[status]=='B') echo "Selected"; ?>>Bounce</option>
          </select>
       </td>
      --> 
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="11">Payment Recive Details Report</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <td>Customer</td>
       <td>MR NO</td>
       <td>Deposite Bank</td>
       <td>Remarks</td>
       <td>Cash</td>
       <td>Bank</td>
       <td>Cheque</td>
       <td>cheqdate</td> 
       <td>Amount</td>
       <td>Clear Amount</td>
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
          <td><?=$value[bname];?></td>
          <td align="right"><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[hcash],2);?></td>
          <td align="right"><?=$value[bank];?></td>
          <?php
            if($value[amount]<>0)
            {
          ?>
          <td align="right"><?=$value[chequeno];?></td>
          <td><?=$value[cheqdate];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>
          <?
           }
           else
           {
            echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
           }
          ?>
          <td align="right"><?=number_format($value[hcash]+$value[cash],2);?></td>
       </tr>
       <?
       $hcashamount=$hcashamount+$value[hcash];
       $cashamount=$cashamount+$value[cash];
       
       $chequeamount=$chequeamount+$value[amount];
       $discountamount=$discountamount+$value[discount];
       }
      }
    ?>  
 <tr id="trsubhead"><td colspan="4">Total:</td>
     <td colspan="2" align="right"><?=number_format($hcashamount,2);?></td>
     <td colspan="4" align="right"><?=number_format($chequeamount,2);?></td>
     <td colspan="1" align="right"><?=number_format($hcashamount+$cashamount,2);?></td>
 </tr>

 <tr id="trhead"><td colspan="7">At Hand Amount:</td>
     <td colspan="4" align="right"><?=number_format($chequeamount-$cashamount,2);?></b></td>
 </tr>

 </table>


<?php
 include "footer.php";
?>
