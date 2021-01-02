<?php
 session_start();
 include "includes/functions.php";
 $mnuid="413";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="11">Bank Clear Form</td></tr> 

   <tr bgcolor="#CCAABB" id="trsubhead">    
       <td>MR No</td>
       <td>Receive Date</td>
       <td>Bank Name</td>
       <td>Branch</td>
       <td>Cheque No</td>
       <td>Cheque Date</td> 
       <td>Amount</td>
       <td>Deposite Bank</td>
       <td>Receive By</td>
       <td colspan="2" align="center" bgcolor="#FFCCAA"><b>Status</b></td>
    </tr>     
  
    <?
      $user_query="Select * from tbl_dir_receive    
                   where (cstatus='N' or (bdate<>curdate() and cstatus='B')) and amount>0";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[salevalue]-$value[payment];
       ?>
       <tr>
          <td align="center"><b><a href="mrprint.php?id=<?=$value[mrno];?>" target="_blank" title="View Details"><?=$value[mrno];?></a></b></td>
          <td><?=$value[date];?></td>
          <td><?=$value[bank];?></td>
          <td><?=$value[branch];?></td>
          <td><?=$value[chequeno];?></td>
          <td><?=$value[cheqdate];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>     
          <td align="right"><?=$value[depositebank];?></td>
          <td align="right"><?=$value[user];?></td>
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=1&mode=Bank&cheque=<?=urlencode($value[chequeno])?>&invoice=<?=urlencode($value[customerid])?>&amount=<?=$value[amount]?>&code=<?=urlencode($value[depositebank])?>&mrno=<?=$value[mrno]?>" title="Click here to bank clear">Clear</a></b></td>
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=0&mode=Bank" title="Click here to Bounch this cheque">Bounce</a></b></td>
       </tr>
       <?
       }
      }
    ?>  
  
  
  <tr id="trsubhead"><td colspan="11">&nbsp;</td></tr> 
  <tr id="trhead"><td colspan="11">Today Clear Amount</td></tr> 
  
      <?
      $user_query="Select * from tbl_dir_receive where (cstatus='C' or cstatus='B') and bdate=curdate()";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[salevalue]-$value[payment];
       ?>
       <tr>
          <td align="center"><b><a href="invoice.php?id=<?=$value[invoice];?>" target="_blank" title="View Details"><?=$value[invoice];?></a></b></td>
          <td><?=$value[date];?></td>
          <td><?=$value[bank];?></td>
          <td><?=$value[branch];?></td>
          <td><?=$value[chequeno];?></td>
          <td><?=$value[cheqdate];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>     
          <td align="right"><?=$value[cash];?></td>
          <?
           if ($value[cstatus]=='C')
           {
            echo "<td><b>Clear.</b></td>";
           }
           if ($value[cstatus]=='B')
           {
            echo "<td><b>Bounce.</b></td>";
           }
          ?>
          <td align="center"><b><a href="clearbank.php?id=<?=$value[id];?>&status=1&mode=CBank" title="Click here Delete">X</a></b></td>
          
       </tr>
       <?
        $camount=$camount+$value[amount];
        $cash=$cash+$value[cash];
       }
       echo "<tr><td colspan=6 align='right'> Total :</td><td align='right'>".number_format($camount,2)."</td><td align='right'>".number_format($cash,2)."</td></tr>";
       
      }
    ?>  

  
  
 </table>

<?php
 include "footer.php";
?>
