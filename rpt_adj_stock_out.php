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
  
  $con="where (tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]') and tbl_customer.status=2 ";
  
  if ($_POST[category]!='')
   {
   $con=$con." and tbl_product.category_id=$_POST[category]";
   }
  
  if ($_POST[product]!='')
   {
   $con=$con." and tbl_sales.product=$_POST[product]";
   }
  
    
    
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
                   where tbl_customer.status=2
                   order by tbl_sales.id desc limit 0,10";
   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trsubhead"><b>Stock Decrease Report</b></td></tr>
 <tr>
   <td>Date: <input type="Text" id="demo11" maxlength="15" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
  
  <td>
        Category: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_product_category order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="category" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["category"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
        </td>


   <td>Product: 
            <?
             $query_sql = "SELECT tbl_product.id,tbl_product.name, tbl_product_category.name as cat_name,tbl_product.punit FROM tbl_product 
                           join tbl_product_category on tbl_product.category_id=tbl_product_category.id  
           order by tbl_product_category.name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="product">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["product"]==$row_sql['id']) echo "selected";?>><?php echo $row_sql['cat_name']?>::<?php echo $row_sql['name']?>::<?php echo $row_sql['punit']?></option>
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
 <tr id="trhead"><td colspan="7">Stock Decrease Report</td></tr> 
   <tr id="trsubhead">    
       <td>Ref.No</td>
       <td>Date</td>
       <td>Product</td>
       <td>DO</td>
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
           
       <?  
         }
        else
         { 
       ?>
       <tr>
          <td id="trsubhead">
           <a href="invoice.php?id=<?=$value[invoice];?>" target="_blank" title="View Details">
             <?=$value[invoice];?>
           </a>
          </td>
          <td><?=$value[date];?></td>
          
         <?
          }
         ?>  
          <td> <?=$value[catname];?> <?=$value[product];?></td>
          <td align="center"><?=$value[donumber];?></td>
          <td align="right"><?=number_format($value[qty],2);?><!-- &nbsp;<?=$value[unit];?> --></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
                  
          
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
       <td colspan="1" align="right"><?=number_format($totalamount/$totalqty,2);?></td>
       <td colspan="2" align="right"><?=number_format($totalamount,2);?></td></tr>
             
       <?
      }
    ?>  
 </table>


<?php
 include "footer.php";
?>
