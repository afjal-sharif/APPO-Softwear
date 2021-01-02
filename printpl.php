<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 
 date_default_timezone_set('Asia/Dacca');
 $totalcedit=0;
 $totaldebit=0;
 $date1=$_SESSION[date1];
 $date2=$_SESSION[date2];
 include "rptheader.php";
?>

<table width="800px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 
 <tr><td colspan="4" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
   <tr>
    <td colspan="4" height="60px" align="center">
       <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" width="65px" height="50px"  border="0"> &nbsp;
       <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
    </td>
   </tr>
 
<tr><td colspan="4" align="left">Print Date & Time: <? echo date("d-M-Y h:i A");?></td></tr>
 <tr id="trhead"><td colspan="4"><?=$global['site_name']?> Income Statement </td></tr> 
 <tr id="trhead"><td colspan="4">Date Between <?=$date1;?> and <?=$date2;?> </td></tr>
   <tr bgcolor="#FFCCAA">    
       <td>Head</td>
       <td>Description</td>
       <td>Tk</td> 
       <td>Tk</td>   
      </tr>     
  
  
  
  <tr>
  
  

<?
            
  
      $user_query="Select ttype,sum(deposite) as balance from tbl_incentive 
                  where type=1 and ttype!='Incentive Adjust'
                  and  tbl_incentive.date between '$_POST[demo11]' and '$_POST[demo12]'
                  group by ttype
                  ";
      $users = mysql_query($user_query);
      //$row_sql= mysql_fetch_assoc($users);
      //$balance=$row_sql[balance];
      //$totalcedit=$totalcedit+$balance;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
?>

    <tr>
      <td>&nbsp;</td>
      <td><?=$value[ttype];?></td>
      <td align="right"><?=number_format($value[balance],2)?></td>
      <td>&nbsp;</td>
    </tr>
<?
  $totalcedit=$totalcedit+$value[balance];
 }
 }
?>



 <?
  $sql="select sum(amount) as amount from tbl_profit where  tbl_profit.date between '$_POST[demo11]' and '$_POST[demo12]'";
  $users = mysql_query($sql);
  $row_sql= mysql_fetch_assoc($users);
  $profit=$row_sql[amount];   
  $totaldebit=$totaldebit+$profit; 
 ?>



    <tr bgcolor="#FFCCEE" align="center" id="trsubhead">
     <td align="left">Profit Withdraw</td>
     <td>&nbsp;</td>
     <td align="right"></td>
     <td align="right"><?=number_format($profit,2);?></td>
   </tr>

  
  
  
   <tr bgcolor="#FFCCEE" align="center" id="trsubhead">
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td align="right"><?=number_format($totalcedit,2);?></td>
     <td align="right"><?=number_format($totaldebit,2);?></td>
   </tr>
  
  <tr bgcolor="#FFCC09" id="trhead">
      <td><b>Net Profit</b></td>
      <td>Net Profit from Total Business</td>
      <!--<td>&nbsp;</td>-->
      <td align="right" colspan="2"><?=number_format($totalcedit-$totaldebit,2)?></td>
  </tr>
  
   
  
    
  
 </table>
 
 <?
 }
 if(($totalcedit-$totaldebit)>0)
  {
  ?>
     <br><div id="profit"><A HREF=javascript:void(0) onclick=window.open('profitwith.php?&amount=<?=($totalcedit-$totaldebit);?>','','width=600,height=400,menubar=no,status=no,location=100,toolbar=no,scrollbars=yes') title="Profit Withdraw">Click Here To Profit Withdraw.</a></div>
  <? 
  }
 
 ?> 


<?php
 include "footer.php";
?>
