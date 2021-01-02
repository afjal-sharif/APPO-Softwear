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
  
  $con="where (date_format(tbl_order.dateandtime,'%Y-%m-%d') between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[company]!='')
   {
   $con=$con." and tbl_order.company=$_POST[company]";
   }
  
  
 
    $user_query="select tbl_order.id, date_format(tbl_order.dateandtime,'%d-%m-%Y') as dt,tbl_product.punit as unit,
                   tbl_order.donumber,tbl_company.name as company,tbl_product.name as product,
                   tbl_order.qty,tbl_order.rate,comission,dorec.qty as dobal 
                   from tbl_order join tbl_company on tbl_order.company=tbl_company.id
                                  join tbl_product on tbl_order.product=tbl_product.id
                                  left join dorec on tbl_order.donumber=dorec.donumber 
                   $con                 
                    order by tbl_order.id";


 }
else
 {
  $user_query="select tbl_order.id, date_format(tbl_order.dateandtime,'%d-%m-%Y') as dt,tbl_product.punit as unit,
                   tbl_order.donumber,tbl_company.name as company,tbl_product.name as product,
                   tbl_order.qty,tbl_order.rate,comission,dorec.qty as dobal 
                   from tbl_order join tbl_company on tbl_order.company=tbl_company.id
                                  join tbl_product on tbl_order.product=tbl_product.id
                                  left join dorec on tbl_order.donumber=dorec.donumber      
                    order by tbl_order.id desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Order Details Report</b></td></tr>
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
              <select name="company">
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
 <tr id="trhead"><td colspan="10">Display Order Details.</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <td>Company Name</td>
       <td>Product</td>
       <td>DO Number </td> 
       <td>Qty</td>
       <td>Rate</td>
       <td>DF</td>
       <td>Comission</td>
       <td>Total Taka</td>
       <td>Balance DO</td>    
      </tr>     
  <tr>
    <?
      $totalamount=0;  
      $totalqty=0;
      $baldo=0;
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $bal=$value[qty]-$value[dobal];
       ?>
       <tr>
          <td><?=$value[dt];?></td>
          <td><b><?=$value[company];?></b></td>
          <td><b><?=$value[product];?></b></td>
          <td align="right"><b><?=$value[donumber];?></b></td>
          <td align="right"><?=$value[qty];?><!-- &nbsp; <?=$value[unit];?>--></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[deliveryfair],2);?></td>
          <td align="right"><?=$value[comission];?></td>
          <td align="right"><?=number_format(($value[qty]*$value[rate])+($value[qty]*$value[deliveryfair]),2);?></td>
          
          <td align="right"><?=number_format($value[qty]-$value[dobal],2);?>&nbsp; <?=$value[unit];?></td>       
          <td align="center">
            <A HREF=javascript:void(0) onclick=window.open('editord.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Receive Info"><img src="images/edit.png" height="15px" width="15px"></a> &nbsp;
          </td>        
  
       </tr>
       <?
       $totalamount=$totalamount+($value[qty]*$value[rate]);
       $totalqty=$totalqty+$value[qty];
       $baldo=$baldo+($value[qty]-$value[dobal]);
       }
      }
    ?>  
  </tr>
 <tr bgcolor="#FFCCEE"><td colspan="1" align="left" bgcolor="#FFCCEE"><b><!-- Print --></b></td>
                      <td colspan="3" align="left">Total Amount :</td>
                      <td align="right"><b><?=number_format($totalqty,2);?></b></td>
                      <td colspan="2">&nbsp;</td>
                      <td colspan="1">&nbsp;</td>
                      <td align="right"><b><?=number_format($totalamount,2);?></b></td>
                      <td align="right"><b><?=number_format($baldo,2);?></b></td>
  </tr>

 </table>


<?php
 include "footer.php";
?>
