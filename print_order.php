<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
 $ref_no=$_GET[id];
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
 <tr id="trhead"><td colspan="2">Order Report</td></tr> 
 <tr><td width="10%"><b>Ref. No:</b></td> <td><b><?=$ref_no;?></b></td></tr>
</table>  

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trsubhead"><td colspan="9">Item Details</td></tr> 
 <tr align="center" bgcolor="#FFFF09">    
       <td>SL</td>
       <td>Date</td>
       <td>Company</td>
       <td>SAP ID</td>
       <td>Retailer Name</td>
       <td>Address</td>
       <td>Type</td>
       <td>Qty (Unit)</td> 
       <td width="15%">Remarks</td>
         
 </tr>     
    <?
      $user_query="Select tbl_order.id,dtDate,tbl_company.name as comname,ref_no,
                   tbl_customer.name as cname,tbl_customer.codeno as codeno,tbl_customer.address as address,
                   donumber,tbl_order.qty,tbl_order.remarks,truckno,deliveryfair,locost,type
                  from tbl_order 
                  join tbl_company on tbl_order.company=tbl_company.id
                  join tbl_customer on tbl_order.customer=tbl_customer.id 
                  where ref_no='$_REQUEST[id]'
                  order by tbl_order.id asc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td><?
             $date=date_create($value[dtDate]);
             echo date_format($date,'d-M-y');
             ?></td>
          <td><?=$value[comname];?></td>
          <td><?=$value[codeno];?></td>
          <td><?=$value[cname];?></td>
          <td align="right"><?=$value[address];?></td>
          <td><?=$value[type];?></td>
          <td align="right"><?=number_format($value[qty],0);?></td>
          <td>&nbsp;</td>
                
       </tr>
       <?
       
       $totalqty=$totalqty+$value[qty];
       }
       echo"<tr align='right'><td colspan='6'><b>Total Qty: &nbsp;&nbsp;&nbsp;</b></td><td colspan='2' align='right'><b>".number_format($totalqty,0)."</b></td>";
       echo"<td colspan='1' align='right'>&nbsp;</td></tr>";
      }  
    ?>  
  </tr>
 </table>
    
<?php
 include "footer.php";
?>
