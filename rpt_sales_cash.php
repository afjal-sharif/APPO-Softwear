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
  
    $con="where (tbl_sales.date='$_POST[demo11]' and truckno like 'DCS:$_POST[demo11]%')";        
    $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.truckno,customername,tbl_sales.customerid,
                   tbl_sales.loadcost,tbl_sales.truckno,tbl_product_category.name as catname,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,
                   tbl_customer.name as customer,tbl_product.name as product
                   from tbl_sales
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id       
                   $con                 
                   order by tbl_sales.id desc,invoice";
 }
else
 {
    $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.truckno,customername,tbl_sales.customerid,
                   tbl_sales.loadcost,tbl_sales.truckno,tbl_product_category.name as catname,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,
                   tbl_customer.name as customer,tbl_product.name as product
                   from tbl_sales
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   where tbl_sales.date='$_SESSION[dtcustomer]' and truckno like 'DCS:$_SESSION[dtcustomer]%'
                   order by tbl_sales.id desc limit 0,10";
   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Daily Cash Sales Details</b></td></tr>
 <tr align="center">
   <td>Date: <input type="Text" id="demo11" maxlength="15" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
        <input type="submit" name="view" value= "  View  "> 
      </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Daily Cash Sales Details.</td></tr> 
   <tr id="trsubhead">    
       <td>Invoice</td>
       <td>Date</td>
       <td>Customer</td>
       <td>Product</td>
       <td>Qty</td>
       <td>Rate/Unit</td>
       <td>Total Taka</td>
   </tr>     
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
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
          <td><?=$value[date];?></td>
          <td>
             <?=$value[cname];?>
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
          <td> <?=$value[catname];?> - <?=$value[product];?></td>
          
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[rate]+$value[df]+$value[loadcost],2);?></td>      
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
       <tr id="trsubhead"><td colspan="2"> Total Amount</td>
       <td colspan="2" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
       <td colspan="2" align="right"><?=number_format($totalamount/$totalqty,2);?></td>
       <td colspan="3" align="right"><?=number_format($totalamount,2);?></td></tr>
             
       <?
      }
    ?>  
 </table>

<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
