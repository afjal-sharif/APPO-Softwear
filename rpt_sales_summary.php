<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
$con=''; 
$con="where (tbl_sales.date between '$_SESSION[dtcustomer]' and '$_SESSION[dtcustomer]')";
  
if(isset($_POST["view"]))
 {
  $con=''; 
  $con="where (tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if($_POST[g_name]!='')
   {
    $con= $con. " and tbl_product_category.g_name='$_POST[g_name]'";   
   }
  
  if($_POST[sp]!='')
   {
    $con= $con. " and tbl_sales.sp='$_POST[sp]'";   
   }
   
  
  if ($_POST[category]!='')
   {
   $con=$con." and tbl_product.category_id=$_POST[category]";
   }
 
    
    $user_query="select tbl_product_category.name as catname,tbl_product.name as product,
                   sum(tbl_sales.qty) as qty,tbl_product.unit,sum((tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty)/sum(tbl_sales.qty) as otherscost,
                   sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as rate
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   $con                 
                   group by tbl_sales.product
                   order by tbl_sales.product";

 }
else
 {
    $user_query="select tbl_product_category.name as catname,tbl_product.name as product,
                   sum(tbl_sales.qty) as qty,tbl_product.unit,sum((tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty)/sum(tbl_sales.qty) as otherscost,
                   sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as rate
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   $con
                   group by tbl_sales.product
                   order by tbl_sales.product";
   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="6" align="center"  id="trsubhead"><b>Sales Goods Summary Report</b></td></tr>
 <tr>
   <td>Date: <input type="Text" id="demo11" maxlength="15" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcustomer]?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   
    <td> SP:
       <select name="sp" style="width: 80px;">
          <option value=""></option>
             <?
           $query_sql = "SELECT id,shortname as  sp  FROM `tbl_sp`  order by shortname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["sp"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['sp']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
       </select>
   </td>
   
   <td> Group:
       <select name="g_name" style="width: 150px;">
          <option value=""></option>
             <?
           $query_sql = "SELECT distinct g_name  FROM `tbl_product_category`  order by g_name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['g_name'];?>" <?php if($_POST["g_name"]==$row_sql['g_name']) echo "selected";?> ><?php echo $row_sql['g_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
       </select>
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

   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>

</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Sales Goods Summary.</td></tr> 
   <tr id="trsubhead">    
       <td>Product</td>
       <td>Qty</td>
       <td>Rate/Unit</td>
       <td>Others/Unit</td>
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
       ?>  
       <tr align="center">
          <td><?=$value[catname];?>::<?=$value[product];?></td>
          <td align="right"><?=number_format($value[qty],2);?>&nbsp;<?=$value[unit];?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[otherscost],2);?></td>
          <td align="right"><?=number_format(($value[qty]*($value[rate]+$value[otherscost])),2);?></td> 
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $sale_amount=$sale_amount+($value[qty]*$value[rate]);
       $other_amount=$other_amount+($value[qty]*$value[otherscost]);
       
       }
       ?>
       <tr id="trsubhead">
         <td colspan="1"> Total Amount</td>
         <td colspan="1" align="right"><?=number_format($totalqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($sale_amount/$totalqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($other_amount/$totalqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($sale_amount+$other_amount,2);?></td>
      </tr>      
      <? 
      }
    ?>  
 </table>


<?php
 include "footer.php";
?>
