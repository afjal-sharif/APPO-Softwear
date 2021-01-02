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
  
  $con="where (tbl_receive.date between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[company]!='')
   {
   $con=$con." and tbl_order.company=$_POST[company]";
   }
  $user_query="select tbl_receive.id, tbl_receive.date,tbl_receive.donumber,tbl_product.punit as unit,
                   tbl_receive.gpnumber,tbl_order.rate,tbl_receive.qty,tbl_receive.truckno,tbl_receive.df,tbl_receive.otherscost,
                   tbl_company.name as company,tbl_product.name as product
                   from tbl_receive
                   join tbl_order on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   $con                 
                   order by tbl_receive.id desc";


 }
else
 {
    $user_query="select tbl_receive.id, tbl_receive.date,tbl_receive.donumber,tbl_product.punit as unit,
                   tbl_receive.gpnumber,tbl_order.rate,tbl_receive.qty,tbl_receive.truckno,tbl_receive.df,tbl_receive.otherscost,
                   tbl_company.name as company,tbl_product.name as product
                   from tbl_receive
                   join tbl_order on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   order by tbl_receive.id desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Receive Goods Details Report</b></td></tr>
 <tr>
   <td>From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company" style="width:120px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="12">Receive Goods Details.</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <td>Company Name</td>
       <td>Product</td>
       <td>DO Number </td>
       <td>Truck No</td>
       <td>GP Number </td>  
       <td>Qty</td>
       <td>Rate</td>
       <td>DF/Unit</td>
       <td>OC/Unit</td>
       <td>Total Taka</td>
       <td>Delete</td>
    </tr>     
  <tr>
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);  
      $totalamount=0;  
      $totalqty=0;
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><b><?=$value[company];?></b></td>
          <td><b><?=$value[product];?></b></td>
          <td align="right"><?=$value[donumber];?></td>
          <td><?=$value[truckno];?></td>
          <td align="right"><b><?=$value[gpnumber];?></b></td>
          <td align="right"><?=$value[qty];?> &nbsp; <?=$value[unit];?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[df],2);?></td>
          <td align="right"><?=number_format($value[otherscost],2);?></td>
          <td align="right"><?=number_format($value[qty]*$value[rate],2);?></td> 
          <td align="center"><A HREF=javascript:void(0) onclick=window.open('editreciv.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Receive Info"><img src="images/edit.png" height="15px" width="15px"></a> &nbsp;
                             <a href="indelete.php?id=<?=$value['id'];?>&mode=receive&type=1" onClick="return (confirm('Are you sure to delete receive data?')); return false;" title="Delete"><img src="images/inactive.png" height="15px" width="15px"></a></td>        
       </tr>
       <?
       $totaldf=$totaldf+($value[qty]*$value[df]);
       $totaloc=$totaloc+($value[qty]*$value[otherscost]);
       $totalamount=$totalamount+($value[qty]*$value[rate]);
       $totalqty=$totalqty+$value[qty];
       $cost=$cost+$value[df]+$value[otherscost];
       }
      }
    ?>  
  </tr>
 <tr bgcolor="#FFCCEE"><td colspan="1" align="left" bgcolor="#FFCCEE"><!--<b>Print</b>--></td>
                      <td colspan="5" align="left">Total Amount :</td>
                      <td align="right"><b><?=number_format($totalqty,2);?></b></td>
                      <td><b><?=number_format($totalamount-$totaldf-$totaloc,2);?></b></td>
                      <td align="right"><b><?=number_format($totaldf,2);?></b></td>
                      <td align="right"><b><?=number_format($totaloc,2);?></b></td>
                      <td align="right"><b><?=number_format($totalamount,2);?></b></td><td>&nbsp;</td></tr>
 </table>


<?php
 include "footer.php";
?>
