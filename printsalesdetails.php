<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 $con1=$_SESSION[con];
?>


<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr><td colspan="1" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">&nbsp; &nbsp;Print</a></td></tr>
 
 <tr>
   <td colspan="1" height="60px" align="center">
      <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" height="40px"  border="0"> &nbsp;
       <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
             
   
    </td>
 </tr>
</table>
 
 <!-- Receive Details -->

 <?php
      $user_query=$_SESSION[sqlsalesdetails];
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
  <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trhead">
           <td colspan="10">Sales Goods Details.</td>
     </tr> 
     <tr id="trsubhead">    
           <td>Invoice</td>
           <td>Date</td>
           <td>Customer</td>
           <td>Product</td>
           <td>DO</td>
           <td>Qty</td>
           <td>Rate/Unit</td>
           <td>Others/Unit</td>
           <td>Truck No</td>
           <td>Total Taka</td>
     </tr>     
     <?php
     while($value=mysql_fetch_array($users))
       {
         if($inid==$value[invoice])
         {
       ?>  
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
       <?  
         }
        else
         { 
       ?>
       <tr>
          <td align="center">
           <a href="invoice.php?id=<?=$value[invoice];?>" target="_blank" title="View Details">
             <?=$value[invoice];?>
           </a>
          </td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y'); 
           ?></td>
          <td>
             <?=$value[customer];?>
             <?
              if($value[customerid]==1)
               {
                echo "$value[customername]";
               }
             ?> 
          </td>
         <?
          }
         ?>  
          <td> <?=$value[catname];?> <?=$value[product];?></td>
          <td align="center"><a href="pur_view.php?id=<?=$value[donumber]?>" target="_blank"><?=$value[donumber];?></a></td>
          <td align="right"><?=number_format($value[qty],2);?><!-- &nbsp;<?=$value[unit];?> --></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[df]+$value[loadcost],2);?></td>        
          <td align="right"><?=$value[truckno];?></td>
          <td align="right"><?=number_format(($value[qty]*$value[rate])+($value[qty]*($value[df]+$value[loadcost])),2);?></td>         
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $amount=$value[qty]*$value[rate]+($value[qty]*($value[df]+$value[loadcost]));
       $totalamount=$totalamount+$amount;
       $unit=$value[unit];
       $inid=$value[invoice];
       }
       ?>
       <tr id="trsubhead"><td colspan="3"> Total Amount</td>
       <td colspan="2" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
       <td colspan="2" align="right"><?=number_format($totalamount/$totalqty,2);?></td>
       <td colspan="3" align="right"><?=number_format($totalamount,2);?></td></tr>     
    </table>
 
 
 <?php
     }
 ?>
  
<?php
 include "footer.php";
?>
