<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
?>

 
 <?
 $invoice=$_GET[id];
 $user_query="Select date_format(date,'%d-%M-%y') as dt,invoice,sum(tbl_sales.qty) as qty,tbl_sales.unit,sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as rate,
                  avg(tbl_sales.loadcost) as loadcost,avg(tbl_sales.otherscost) as otherscost,tbl_sales.customername,avg(tbl_sales.bundle) as bundle,
                   tbl_sales.truckno,avg(tbl_sales.df) as df,
                   tbl_customer.name as customer,address,mobile,tbl_product.name as product,tbl_sales.customerid as cust,
                   tbl_product_category.name as cat_name
                   from tbl_sales join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   left join tbl_product on tbl_sales.product=tbl_product.id
                   left join tbl_product_category on tbl_product_category.id=tbl_product.category_id
                   where invoice='$invoice'  group by invoice,product";
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
       if($custid!==$value[customer])
       {
    ?>
    <tr>    
       <td colspan="6" align="left" style="font-size:12px">Date: <?=$value[dt];?>   
   </tr>
    
    <tr>    
       <td colspan="6" align="left" style="font-size:12px"><?=$value[customer];?>  <?=$value[customername];?>
        <br><br>Address: <?=$value[address];?>, &nbsp; Mobile :<?=$value[mobile];?></td>   
   </tr>
   <tr bgcolor="#FFCC09"><td id="trsubhead" colspan="6"><b>Sales Details.</b></td></tr>
   <?
    } 
    $custid=$value[customer];
    }
     echo "<tr id='trsubhead'><td colspan='2'>Product</td><td>Qty</td><td>Bundle</td><td>Rate</td><td>Amount</td></tr>";
     $users = mysql_query($user_query);
     $totalsal=0;
     while($value=mysql_fetch_array($users))
     {
     ?>
    <tr align="center">    
       <td align="center" colspan='2'><?=$value[cat_name];?> : <?=$value[product];?></td>
       
       <td align="right" style="font-size:13px"><?=$value[qty];?> &nbsp; <?=$value[unit];?></td>
       <td align="center" style="font-size:13px"><?=number_format($value[bundle],0);?></td>
       <td align="right" style="font-size:13px"><?=number_format($value[rate],2);?></td>
       <td align="right" style="font-size:13px"><?=number_format(($value[qty]*$value[rate]),2);?></td>
    </tr> 

     <?
       $totalsal=$totalsal+($value[qty]*$value[rate]);
       $cust=$value[cust];
       $otherscost=$otherscost+($value[df]+$value[loadcost])*$value[qty];
       
     }
   ?>
    <tr><td colspan="6" align="right" style="font-size:13px">Goods Value   : =<?=number_format($totalsal,2);?></td></tr>
    <tr><td colspan="6" align="right" style="font-size:13px">DF & Load Cost: =<?=number_format($otherscost,2);?></td></tr>
    <tr id="trhead"><td colspan="6" align="right" style="font-size:13px">Total:=&nbsp;<?=number_format($totalsal+$otherscost,2);?></td></tr>
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
        
        <td colspan="2" align="center">Cash :  <?=number_format($value[hcash],2);?></td>
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
      $payment=$payment+($value[hcash]+$value[discount]+$value[amount]);
      }
      }
      $bal=$totalsal+$otherscost-$payment;
      if($bal>0)
      {
      ?>
      <tr><td colspan="6" align="right" style="font-size:12px">Due Amount Tk.:<? echo number_format($bal,2);?>  </td></tr>
      <?
      }
      elseif($bal<0)
       {
       ?>
       <tr><td colspan="6" align="right" style="font-size:12px">Over Paid Amount Tk.:<? echo number_format($bal,2);?></td></tr>
       <?
       }
       else
       {
       ?>
       <tr><td colspan="6" align="right" style="font-size:12px">Due Amount Tk.:<? echo number_format($bal,2);?></td></tr>
       <?
       }
      
      
       $sql="SELECT  sum(salesvalue-cash-bank-(athand-bank)) as balance 
             from view_cust_stat_base   
             where custid =$cust";      
       $sql = mysql_query($sql) or die(mysql_error());
       $row_sql = mysql_fetch_assoc($sql);
       $balance=$row_sql[balance];
       $previousout=$balance-$bal;
       
      ?>
      <tr>
        <td colspan="4" align="center">Previous Oustanding : </td>
        <td colspan="2" align="right">Tk:=&nbsp;<? echo number_format($previousout,2);?></td>
      </tr>
      <tr id="trsubhead">
        <td colspan="4">Total Oustanding : </td>
        <td colspan="2" align="right">Tk:=&nbsp;<? echo number_format($balance,2);?></td>
      </tr>
      
      <tr height="120px" valign="bottom">
         <td colspan="2" align="left" height="90px">Customer Signature</td>
         <td valign="top" align="center" colspan="2">
          <!--
          
          <? if($bal==0)
             {
           ?>   
           <img src="images/paid.png">
            <?
            }
            elseif($bal>0)
            { 
            ?>
            <img src="images/due.png">
            <?
            }
            ?>
            -->
          <br><!--<?echo date("d-M-Y"); ?> -->  
         </td>
         
         <td colspan="2" align="right"><b><? echo $_SESSION[userName];?></b> <br>Signature</td></tr>
      <tr><td colspan="6">Print Date : <? echo date("d-M-Y h:i A");?></td></tr>
   </table>
   <?
   }
   ?>
    
<?php
 // include "footer.php";
?>
