<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
?>

 <script src="./js/code_regen.js"></script> 
 
 <?
 $invoice=$_GET[invoice];
 $user_query="Select date,invoice,tbl_sales.qty,tbl_sales.unit,tbl_sales.rate,tbl_sales.freeqty,
                 tbl_sales.customername,tbl_sales.remarks,tbl_sales.bundle,
                  tbl_sales.df,tbl_customer.name as customer,truckno,address,tbl_product_category.name as catname,
                  mobile,tbl_product.name as product,destination,bdestination,customerbangla
                  from tbl_sales join tbl_customer on tbl_sales.customerid=tbl_customer.id
                  join tbl_product on tbl_sales.product=tbl_product.id
                  join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                  where invoice='$invoice' order by destination desc";
 $users = mysql_query($user_query);
 $total = mysql_num_rows($users);   
  
 if ($total>0)
    {
 ?>
   <table width="660px" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;">
   <tr><td colspan="4" height="6px" align="left"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
   <tr>
    <td colspan="4" height="60px" align="center">
       <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" width="65px" height="50px"  border="0">
       <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?>
       T & T : <?=$global['t&t']?>
       Fax : <?=$global['fax']?><br>      
   
    </td>
   </tr>
   
   <tr>
    <td colspan="2" align="left"> <b>  Delivery Challan : <?echo $invoice;?></b> </td>
   <td colspan="2" align="right">Print Date : <?=date('d-M-Y')?></td>
  </tr>

   <tr align="center"><td colspan="4">:: Customer Information ::</td></tr> 
    <? 
       while($value=mysql_fetch_array($users))
       {
       if($custid!==$value[customer])
        {
    ?>
    <tr>    
       <td colspan="4" align="left"><b><?=$value[customer];?> <?=$value[customername];?></b><br>
        <b><?=$value[customerbangla];?></b><br>
        Address: <?=$value[address];?>
        Mobile :<?=$value[mobile];?></td>   
   </tr>
   <tr align="left" height="80px"><td colspan="4" valign="top">:: Destination Address ::
   <!--
   </td></tr> 
   <font size="20px">
   <tr><td align="left" colspan="4">
   -->
   <?=$value[destination];?><br><?=$value[bdestination];?> </td></tr>
   <!--</font>-->
   <tr><td align="left" colspan="4">Truck No: <?=$value[truckno];?> </td></tr>
   
   <tr><td align="center" colspan="4">:: Sales Details ::</td></tr>
   <?
     }
    $custid=$value[customer];
    } 
     echo "<tr align='center'><td>Product</td><td>Qty</td><td colspan='1'>Bundle</td><td colspan='1'>Remarks</td></tr>";
     $users = mysql_query($user_query);
     $totalsal=0;
     while($value=mysql_fetch_array($users))
     {
     ?>
    <tr>          
       <td align="center"><?=$value[catname];?>::<?=$value[product];?></td>
       <td align="right"><?=$value[qty]+$value[freeqty];?>&nbsp;<?=$value[unit];?></td>
       <td align="center"><?=$value[bundle];?></td>
       <td align="center" colspan="2"><?=$value[remarks];?></td>
    </tr> 
     <?
      $totalqty=$totalqty+$value[qty]+$value[freeqty];
      $totalbd=$totalbd+$value[bundle];
      $unit=$value[unit];
      }   
   ?>
    <tr>
      <td align="center">Total :</td>
      <td align="right"><?=number_format($totalqty,0)?> <?=$unit;?> </td>
      <td align="center"><?=$totalbd?> </td>
      <td colspan="1">&nbsp;</td>
    </tr>    

    <tr height="80px" valign="bottom">
      <td colspan="2" align="left" height="80px" valign="bottom">Customer Signature</td>
      <td colspan="2" align="right" height="80px" valign="bottom"><b><? echo $_SESSION[userName];?></b><br>Signature</td></tr>

   
   </table>
   <?
   }
   ?>
    
<?php
 // include "footer.php";
?>
