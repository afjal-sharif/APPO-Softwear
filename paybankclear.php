<?php
 session_start();
 include "includes/functions.php";
 $mnuid="403";
 include "session.php";
 @checkmenuaccess($mnuid);  
 include "header.php";
?>

<form name="order" method="post" action="">
   <b>Company:</b> 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company" style="width:200px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
   <input type="submit" name="view" value= "  View  ">
</form>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="11">Payment Cheque Bank Clear</td></tr> 

   <tr bgcolor="#CCAABB" id="trsubhead">    
       <td>Cheque No</td>
       <td>Bank Name</td>
       <td>Acc. Code</td>
       <td>Cheque Date</td>     
       <td>Pay To</td>
       <td>Pay Date</td>
       <td>Amount</td>
       <td colspan="3" align="center" bgcolor="#FFCCAA"><b>Status</b></td>
    </tr>     
  
    <?
      $con='';
      if (isset($_POST["view"]))
       {
          if ($_POST[company]!=='')
            {$con =" and tbl_com_payment.companyid=$_POST[company]";}
          else
            {$con='';}         
       }
       else
       {
       $con='';
       }
      
       $user_query="Select tbl_com_payment.id,tbl_company.name as company,tbl_bank_name.bankname as bname,tbl_com_payment.paydate,tbl_com_payment.bank,tbl_com_payment.chequeno,
                   tbl_com_payment.cheqdate,tbl_com_payment.amount,bal from tbl_com_payment 
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                   join tbl_bank_name on tbl_bank_name.accountcode=tbl_com_payment.bank
                   left join viw_bank_bal on tbl_com_payment.bank=viw_bank_bal.bank 
                   where (tbl_com_payment.status='N' or (tbl_com_payment.bdate<>'$_SESSION[dtcompany]' and tbl_com_payment.status='B')) 
                   and tbl_com_payment.amount>0 and tbl_com_payment.bank<>'Incentive Adjustment' $con  order by tbl_com_payment.chequeno";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       
       $count=$count+1;
       $bal=$value[salevalue]-$value[payment];
       ?>
       
         
         <?
          if($id==$value[chequeno])
           {
         ?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>  
          <td align="right"><?=number_format($value[amount],2);?></td>     
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=1&mode=PayBank" title="Click here to bank clear">Clear</a></b></td>
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=0&mode=PayBank" title="Click here to Bounch this cheque">Bounce</a></b></td>
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=2&mode=PayBank" title="Click here to Bounch this cheque">Withdraw</a></b></td>
       </tr>
 
             
         <? 
            
           }
          else
           {
            
           if($count>1)
           {
          // $count=0;
           echo "<tr align='right'><td colspan='7'><b>".number_format($subtotal,2)."</b></td><td colspan='3'>&nbsp;</td></tr>";
           }
           $subtotal=0;
         ?>
       <tr>
          <td><?=$value[chequeno];?></td>
          <td><b><a href="#" title="Current Bank Balance :<?=number_format($value[bal],0);?>"><?=$value[bname];?></a></b></td>
          <td><a href="#" title="Current Bank Balance :<?=number_format($value[bal],0);?>"><?=$value[bank];?></a></td>
          <td><?=$value[cheqdate];?></td>
          <td align="center"><?=$value[company];?></td>
          <td><?=$value[paydate];?></td>  
          <td align="right"><?=number_format($value[amount],2);?></td>     
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=1&mode=PayBank" title="Click here to bank clear">Clear</a></b></td>
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=0&mode=PayBank" title="Click here to Bounch this cheque">Bounce</a></b></td>
          <td align="right"><b><a href="clearbank.php?id=<?=$value[id];?>&status=2&mode=PayBank" title="Click here to Bounch this cheque">Withdraw</a></b></td>
       </tr>
       <?
         
         }
         $totalamount=$totalamount+$value[amount];
         $subtotal=$subtotal+$value[amount];
         $id=$value[chequeno];
       }
       
       if($count>1)
       {
        echo "<tr align='right'><td colspan='7'><b>".number_format($subtotal,2)."</b></td><td colspan='3'>&nbsp;</td></tr>";
       } 
       
       ?>
        <tr id="trsubhead">
          <td colspan="3" align="right">Grand Total Amount :</td>
          <td colspan="4" align="center"> <? echo number_format($totalamount,2);?></td>
         <td colspan="3">&nbsp;</td>   
       </tr>
       <?
      }
    ?>  
  
  
  <tr id="trsubhead"><td colspan="11">&nbsp;</td></tr> 
  <tr id="trhead"><td colspan="10">Today Clear Amount</td></tr> 
  
      <?
      $user_query="Select tbl_com_payment.id,tbl_company.name as company,tbl_bank_name.bankname as bname,tbl_com_payment.paydate,tbl_com_payment.bank,tbl_com_payment.chequeno,
                   tbl_com_payment.cheqdate,tbl_com_payment.amount,tbl_com_payment.status,tbl_com_payment.bamount from tbl_com_payment 
                   
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                   join tbl_bank_name on tbl_bank_name.accountcode=tbl_com_payment.bank                    
                  where (tbl_com_payment.status='C' or tbl_com_payment.status='B' or tbl_com_payment.status='W'  ) and tbl_com_payment.bdate='$_SESSION[dtcompany]'";
      $users = mysql_query($user_query);
      $totalb = mysql_num_rows($users);    
      if ($totalb>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[salevalue]-$value[payment];
       ?>
       <tr>
          <td align="center"><?=$value[company];?></a></b></td>
          <td><?=$value[paydate];?></td>
          <td><?=$value[bname];?></td>
          <td><?=$value[bank];?></td>
          <td><?=$value[chequeno];?></td>
          <td><?=$value[cheqdate];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>          
          <td align="right"><?=number_format($value[bamount],2);?></td> 
          <?
           if ($value[status]=='C')
           {
            echo "<td bgcolor='#00FF00' colspan='1'><b>Clear.</b></td>";
           }
           if ($value[status]=='B')
           {
            echo "<td bgcolor='#CC0000' colspan='1'><b>Bounce.</b></td>";
           }
           if ($value[status]=='W')
           {
            echo "<td bgcolor='#CC00CC' colspan='1'><b>Withdraw.</b></td>";
           }
          ?>
          <td align="center" id="trsubhead"><b><a href="clearbank.php?id=<?=$value[id];?>&mode=CPayBank" title="Click here Delete"><img src="images/inactive.png" height="15px" width="15px"></a></b></td>
          
       </tr>
       <?
        $camount=$camount+$value[amount];
        $cash=$cash+$value[bamount];
       }
       echo "<tr id='trsubhead'><td colspan=6 align='right'> Total :</td><td align='right'>".number_format($camount,2)."</td><td align='right'>".number_format($cash,2)."</td><td align='right'>".number_format($camount-$cash,2)."</td><td align='right' colspan='1'>&nbsp;</td></tr>";
       
      }
    ?>  
 </table>




<?php
 include "footer.php";
?>
