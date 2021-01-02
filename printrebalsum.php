<?php
ob_start("ob_gzhandler"); 
session_start();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
  
<? 
	include "includes/functions.php";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=customer_balance.xls;");
	header("Content-Type: application/ms-excel");
	header("Pragma: no-cache");
	header("Expires: 0");
?>

  <? 
  $user_query=$_SESSION['print_cb_sql'];
  $users = mysql_query($user_query);
  $total = mysql_num_rows($users);

  
 if ($total>0)
    {
 ?>
 
 <table width="100%" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   
   <tr>
    <td colspan="10" height="60px" align="center">
       <div id="invoice"><b><?=$global['site_name']?></b></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
   </td>
  </table>
  
    
 <table width="100%" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;"> 
   <tr id="trhead"><td colspan="10">Customer Total Balance </td></tr> 
   <tr id="trsubhead">    
       <td>Customer</td>
       <td>Mobile</td> 
       <td>Address</td>
       <td>Sales Value</td>
       <td>Last Sales Date</td>
       <td>Receive Amount</td>
       <td>Last Pay.Rec Date</td>
       <td>Focus On</td>
       <td>At Bank</td> 
       <td>Credit</td>
    </tr> 
  <?  
     $count=0;
     $users = mysql_query($user_query);
     $totalamount=0;
     
     while($value=mysql_fetch_array($users))
     {
     $bal=$value[sales]-($value[cash]+$value[bank]);
     ?>
      <tr>
          <td><?=$value[name];?></td>
          <td><?=$value[mobile];?></td>
          <td><?=$value[address];?></td>
          <td align="right"><?=number_format($value[sales],2);?></td>
          <td><?=$value[saldate];?></td>
          <td align="right"><?=number_format($value[cash]+$value[bank],2);?></td>
          <td><?=$value[paydate];?></td>
       
          
            <?php
              if($value[datedf]>0 and  $bal>0) 
               {
               echo "<td align='center' bgcolor='#FFEB9C'><b>P</b></td>";
                
               }
              else
               {
                echo "<td align='center'>S</td>";
               } 
            ?>
          <td align="right"><?=number_format($value[athand]-$value[bank],2);?></td>
          <td align="right"><b><?=number_format($bal,2);?></b></td>         
       </tr>
       <?
       $totalsales=$totalsales+$value[sales];
       $totalpayment=$totalpayment+$value[cash]+$value[bank];
       $totalucpayment=$totalucpayment+$value[athand]-$value[bank];
       $totalamount=$totalamount+$bal;
       }
       
    ?> 
      <tr id="trsubhead">
                     <td colspan="3"> Total Amount :</td>
                     <td colspan="2" align="right"><?=number_format($totalsales,2);?></td>
                     <td colspan="2" align="right"><?=number_format($totalpayment,2);?></td>
                     <td colspan="1" align="right"><?=number_format($totalucpayment,2);?></td>
                     <td colspan="2" align="right"><?=number_format($totalamount,2);?></td>
      </tr>      
   </table>
   <?
   }
   ?>
