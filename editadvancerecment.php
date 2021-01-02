<?php
 session_start();
 include "includes/functions.php";
 include "session.php"; 
 include "header.php";
?>

 
<?
       $user_query="SELECT tbl_advance.id,date_format(tbl_advance.dateandtime,'%d-%M-%y') as dt,name,bankname,chequeno,tbl_advance.adjustamount,
                   amount,chequedate,tbl_advance.user ,tbl_advance.remarks,tbl_advance.bank,bcamount,tbl_advance.status,tbl_advance.type    
                   FROM tbl_advance
                   join tbl_customer on tbl_customer.id=tbl_advance.customer
                   join tbl_bank_name on tbl_advance.bank=tbl_bank_name.accountcode
                   where tbl_advance.type='1' and tbl_advance.bcamount>adjustamount order by tbl_advance.id asc";
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
      ?>
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="12">Advance Receive Adjust</td></tr>
<tr bgcolor="#FFCCAA"><td>Pay Date</td><td>Company</td><td>Deposite Bank</td><td>Account Code</td><td>Cheque No</td>
                     <td>Amount</td><td>Chq.Date</td><td bgcolor="#FFcc00">Adjust Amount</td><td>Balance</td><td>Remarks</td><td>User</td><td>Delete</td>
                     </tr>          
      <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[dt];?></td>
          <td bgcolor="#FFCC09"><?=$value[name];?></td>
          <td><?=$value[bankname];?></td>
          <td><?=$value[bank];?></td>
          <td><?=$value[chequeno];?></td>
          <td align="right"><?=number_format($value[bcamount],2);?></td>
          <td><?=$value[chequedate];?></td>
          <td align="right" bgcolor="#FFcc00"><b><?=number_format($value[adjustamount],2);?></b></td>
          <td align="right" id="trsubhead"><b><?=number_format($value[amount]-$value[adjustamount],2);?></b></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[user];?></td>    
          <td align="center">
             <a href="indelete.php?id=<?=$value[id];?>&mode=advdelete" onClick="return (confirm('Are you sure to delete advance data?')); return false;" title="Delete Data"><img src="images/inactive.png" height="15px" width="15px" alt="Delete"></a>
          </td>     
       </tr>
       <?
       }
      echo "</table>";  
      }
    ?>  
 
 

<?
       $user_query="SELECT tbl_advance.id,date_format(tbl_advance.dateandtime,'%d-%M-%y') as dt,name,bankname,chequeno,tbl_advance.adjustamount,
                   amount,chequedate,tbl_advance.user ,tbl_advance.remarks,tbl_advance.bank,bcamount,tbl_advance.status,tbl_advance.type    
                   FROM tbl_advance
                   join tbl_company on tbl_company.id=tbl_advance.customer
                   join tbl_bank_name on tbl_advance.bank=tbl_bank_name.accountcode
                   where tbl_advance.type='0' and tbl_advance.bcamount>adjustamount order by tbl_advance.id asc";
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
      ?>
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="12">Advance Payment Adjust</td></tr>
<tr bgcolor="#FFCCAA"><td>Pay Date</td><td>Company</td><td>Bank Name</td><td>Account Code</td><td>Cheque No</td>
                     <td>Amount</td><td>Chq.Date</td><td bgcolor="#FFcc00">Adjust Amount</td><td>Balance</td><td>Remarks</td><td>User</td><td>Delete</td>
                     </tr>          
      <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[dt];?></td>
          <td bgcolor="#FFCC09"><?=$value[name];?></td>
          <td><?=$value[bankname];?></td>
          <td><?=$value[bank];?></td>
          <td><?=$value[chequeno];?></td>
          <td align="right"><?=number_format($value[bcamount],2);?></td>
          <td><?=$value[chequedate];?></td>
          <td align="right" bgcolor="#FFcc00"><b><?=number_format($value[adjustamount],2);?></b></td>
          <td align="right" id="trsubhead"><b><?=number_format($value[amount]-$value[adjustamount],2);?></b></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[user];?></td>    
          <td align="center">
             <a href="indelete.php?id=<?=$value[id];?>&mode=advpaydelete" onClick="return (confirm('Are you sure to delete advance data?')); return false;" title="Delete Data"><img src="images/inactive.png" height="15px" width="15px" alt="Delete"></a>
          </td>     
       </tr>
       <?
       }
      echo "</table>"; 
      }
    ?>  


 
 
<?php
 include "footer.php";
?>
