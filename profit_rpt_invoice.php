<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
?>

 
 <?
 $invoice=$_GET[id];
 $user_query="Select date as dt,cname,address,mobile,catname,pname,unit,sum(qty) as qty,sum(qty*sal_rate) as sal_value,sum(qty*rate) as pur_value
                   from view_invoice_profit
                   where invoice='$invoice'
                   group by invoice,product
                   ";
 $users = mysql_query($user_query);
 $total = mysql_num_rows($users);   
  
 if ($total>0)
    {
 ?>
   <table width="675px" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr><td colspan="6" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
   <tr>
   <td colspan="6" height="60px" align="center">
      <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" height="40px"  border="0"> &nbsp;
       <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
             
   
  </td>
   </tr>
   
   <tr>
      <td colspan="6" align="left" style="font-size:12px">Invoice No :<?echo $invoice;?> </td>
   
   </tr>
   <tr id="trhead"><td colspan="6" style="font-size:13px">Customer Information</td></tr> 
    <? 
       while($value=mysql_fetch_array($users))
       {
       if($custid!==$value[cname])
       {
    ?>
    <tr>    
       <td colspan="6" align="left" style="font-size:12px">Date: <?=$value[dt];?>   
   </tr>
    
    <tr>    
       <td colspan="6" align="left" style="font-size:12px"><?=$value[cname];?>
        <br><br>Address: <?=$value[address];?>, &nbsp; Mobile :<?=$value[mobile];?></td>   
   </tr>
   <tr bgcolor="#FFCC09"><td id="trsubhead" colspan="6"><b>Sales Details.</b></td></tr>
   <?
    } 
    $custid=$value[cname];
    }
     echo "<tr id='trsubhead'><td colspan='2'>Product</td><td>Qty</td><td>Sales Value</td><td>Purchase Value</td><td>Profit Amount</td></tr>";
     $users = mysql_query($user_query);
     $totalsal=0;
     while($value=mysql_fetch_array($users))
     {
     ?>
    <tr align="center">    
       <td align="center" colspan='2'><?=$value[catname];?> : <?=$value[pname];?></td>
       
       <td align="right" style="font-size:13px"><?=$value[qty];?> &nbsp; <?=$value[unit];?></td>
       <td align="center" style="font-size:13px"><?=number_format($value[sal_value],2);?></td>
       <td align="right" style="font-size:13px"><?=number_format($value[pur_value],2);?></td>
       <td align="right" style="font-size:13px"><?=number_format($value[sal_value]-$value[pur_value],2);?></td>
    </tr> 

     <?    
     }
   ?>
    
    <?
     $user_query="Select * from tbl_dir_receive where invoice='$invoice'";
     $users = mysql_query($user_query);
     $total = mysql_num_rows($users);
     $payment=0;    
     if ($total>0)
      {
     ?>
       <tr bgcolor="#FFCC09"><td id="trsubhead" colspan="6"><b>Payment Details.</b></td></tr>
       <?
      while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
        <!--<td><?=$value[date];?></td>-->
        <td style="font-size:14px">MR No :<?=$value[mrno];?></td>
        
        <td colspan="2" align="center">Cash:  <?=number_format($value[hcash],2);?></td>
        <td colspan="1" align="center">Discount :<?=$value[discount];?></td>
         <td colspan="2" align="right"><?=number_format($value[hcash]+$value[discount],2);?></td>
       </tr>
      <?
      if ($value[amount]>0)
       {
       ?>
       <tr>
        <td><b>Cheque Payment:</b></td>
        <td><?=$value[bank];?></td>
        <td><?=$value[branch];?></td>
        <td colspan="1">Cheque Date :<?=$value[cheqdate];?></td>
        <td align="right" colspan="2"><?=number_format($value[amount],2);?></td>
       </tr>
      <?
      }
      }
      }
      ?>       
   </table>
   <?
   }
   ?>
    
<?php
 // include "footer.php";
?>
