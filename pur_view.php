<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
?>

 
 <?
 $invoice=$_GET[id];
      $sql="Select tbl_order.id,dtDate,name,donumber,tbl_order.qty,tbl_order.remarks,sp,truckno,tbl_order.status as sta,deliveryfair,locost from tbl_order 
                 join tbl_company on tbl_order.company=tbl_company.id 
                 where donumber=$_REQUEST[id]";
      
      $users_sql = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users_sql);
      
      $order_id=$row_sql_adj[id];
      $order_dt=$row_sql_adj[dtDate];
      $order_order=$row_sql_adj[donumber];
      $order_company=$row_sql_adj[name];
      $order_remarks=$row_sql_adj[remarks];
      $order_truck=$row_sql_adj[truckno];  
      $order_sp=$row_sql_adj[sp];
      $order_status=$row_sql_adj[sta];       
      $order_qty=$row_sql_adj[qty];
      $order_dfcost=$row_sql_adj[deliveryfair];
      $order_locost=$row_sql_adj[locost];
    

 ?> 
 
  <table width="960px" bgcolor="#FFFFFA" align="center" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr><td colspan="6" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
   
  <tr>
   <td colspan="6" height="60px" align="center">
       <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>"  border="0">
       <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
             
   
  </td>
   </tr>
 </table> 
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="2">Purchase Report</td></tr> 
 <tr><td width="10%"><b>Ref. NO :</b></td> <td><b><?=$order_order;?></b></td></tr>
 <tr><td width="10%">Date:</td> <td><?=$order_dt;?></td></tr>
 <tr><td width="10%">Company:</td> <td><?=$order_company;?></td></tr>  
 <?php if($order_qty>0){?>    
    <tr><td width="10%">Order Qty:</td> <td><?=$order_qty;?></td></tr>
 <?}?>
 <tr><td width="10%">Remarks:</td> <td><?=$order_truck;?>;<?=$order_remarks;?></td></tr>
 <tr><td colspan="2" height="10px">&nbsp;</td></tr>
</table>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trsubhead"><td colspan="7">Item Details</td></tr> 
 <tr align="center">    
       <td>Category</td>
       <td>Item Name</td>
       <td>Qty</td>
       <td>Bundle</td>
       <td>Rate</td> 
       <td>Value</td>   
 </tr>     
    <?
      $user_query="select tbl_receive.id,tbl_product_category.name as cat_name,tbl_product.name as p_name,qty,bundle,rate,dfcost,locost
				  from tbl_receive 
                  join tbl_product on tbl_receive.product=tbl_product.id
                  join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                  where donumber=$order_order order by tbl_receive.id desc";
      $users = mysql_query($user_query);
	  $total = mysql_num_rows($users);     
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $bal=$value[qty]*$value[rate];
       ?>
       <tr align="center">
          <td><?=$value[cat_name];?></td>
          <td><?=$value[p_name];?></td>
          <td><?=$value[qty];?></td>
          <td><?=$value[bundle];?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($bal,2);?></td>      
       </tr>
       <?
       
       $totalqty=$totalqty+$value[qty];
       
       $totaldf=$totaldf+($value[qty]*$value[dfcost]);
       $totallo=$totallo+($value[qty]*$value[locost]);
       
       $totalbundle=$totalbundle+$value[bundle];
       $totalamount=$totalamount+$bal;
       }
       echo"<tr align='right'><td colspan='2'>Total Amount:</td><td colspan='1' align='center'>".number_format($totalqty,2)."</td><td colspan='1' align='center'>".$totalbundle."</td>";
       echo"<td colspan='1' align='right'>".number_format($totalamount/$totalqty,2)."</td><td colspan='1' align='right'>".number_format($totalamount,2)."</td></tr>"; 
       echo "<tr align='right'><td colspan='5'>Delivery Fair:</td><td align='right'>".number_format($totaldf,2)."</td></tr>";
       echo "<tr align='right'><td colspan='5'>Unload & Others Cost:</td><td align='right'>".number_format($totallo,2)."</td></tr>";
       
       $sql_pad="select sum(adjamount) as amount from tbl_receive where donumber='$order_order'";
       $users_pad = mysql_query($sql_pad);
       $row_pad= mysql_fetch_assoc($users_pad);
       $pur_adj=$row_pad[amount]; 
       if($pur_adj<>0)
       {
        echo "<tr align='right'><td colspan='5'>Adjustment :</td><td align='right'>".number_format($pur_adj,2)."</td></tr>";
       }
       else
       {
        $pur_adj=0;
       }
       
       echo "<tr align='right' id='trhead'><td colspan='5'>Total Cost</td><td align='right'><b>=".number_format($totalamount+$totaldf+$totallo=$pur_adj,2)."</b></td></tr>";
      }
    ?>  
  </tr>
 </table>
    
<?php
 include "footer.php";
?>
