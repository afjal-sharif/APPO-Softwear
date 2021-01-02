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
    $con= $con. " and tbl_customer.sp='$_POST[sp]'";   
   }
   
  
  if ($_POST[category]!='')
   {
   $con=$con." and tbl_product.category_id=$_POST[category]";
   }
 
    
    $user_query=" select p.cname as customer, sum(p.cementqty) as cqty,sum(p.cementprice) as cprice,
                           sum(p.rodqty) as rqty,sum(p.rodprice) as rprice,
                           sum(p.secqty) as sqty,sum(p.secprice) as sprice
                        from(   
                select tbl_customer.name as cname,tbl_product_category.g_name as gname,
                   sum(tbl_sales.qty) as cementqty,sum((tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty)/sum(tbl_sales.qty)+
                   sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as cementprice,0 as rodqty,0 as rodprice,0 as secqty,0 as secprice
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   join tbl_customer on tbl_customer.id=tbl_sales.customerid
                   $con and g_name='CEMENT'                 
                   group by tbl_sales.customerid,tbl_product_category.g_name
                union all
                select tbl_customer.name as cname,tbl_product_category.g_name as gname,0 as cementqty,0 as cementprice,
                   sum(tbl_sales.qty) as rodqty,sum((tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty)/sum(tbl_sales.qty)+
                   sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as rodprice,0 as secqty,0 as secprice
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   join tbl_customer on tbl_customer.id=tbl_sales.customerid
                   $con and g_name='Rod'                 
                   group by tbl_sales.customerid,tbl_product_category.g_name
                union all
                select tbl_customer.name as cname,tbl_product_category.g_name as gname,0 as cementqty,0 as cementprice,0 as rodqty,0 as rodprice,
                   sum(tbl_sales.qty) as secqty,sum((tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty)/sum(tbl_sales.qty)+
                   sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as secprice
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   join tbl_customer on tbl_customer.id=tbl_sales.customerid
                   $con and g_name='Section Item'                 
                   group by tbl_sales.customerid,tbl_product_category.g_name)
                   as p group by p.cname
                   ";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      
 }
else
 {
    $user_query="select tbl_customer.name as cname,tbl_product_category.g_name as gname,
                   sum(tbl_sales.qty) as qty,tbl_product.unit,sum((tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty)/sum(tbl_sales.qty) as otherscost,
                   sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as rate
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   join tbl_customer on tbl_customer.id=tbl_sales.customerid
                   $con
                   group by tbl_sales.customerid,tbl_product_category.g_name
                   order by tbl_customer.name";
    $total=0;               
   
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
 <tr id="trhead"><td colspan="7">Sales Goods Summary.</td></tr> 
  
  <tr id="trsubhead">    
       <td>Customer</td>
       <td colspan="2">Rod</td>
       <td colspan="2">Cement</td>
       <td colspan="2">Section Item</td>
       
   </tr>     
   <tr id="trhead">    
       <td>&nbsp;</td>
       <td>Qty</td>
       <td>Rate</td>
       <td>Qty</td>
       <td>Rate</td>
       <td>Qty</td>
       <td>Rate</td>
       
       
   </tr>     
  
  
    <?
      if ($total>0)
      {
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>  
       <tr align="center">
          <td><?=$value[customer];?></td>
         
          <td align="right"><?=number_format($value[rqty],2);?></td>
          <td align="right"><?=number_format($value[rprice],2);?></td>
          
         
          <td align="right"><?=number_format($value[cqty],2);?></td>
          <td align="right"><?=number_format($value[cprice],2);?></td>
          
         
          <td align="right"><?=number_format($value[sqty],2);?></td>
          <td align="right"><?=number_format($value[sprice],2);?></td>   
       </tr>
       <?
       $rtqty=$rtqty+$value[rqty];
       $ctqty=$ctqty+$value[cqty];
       $stqty=$stqty+$value[sqty];
       
       if($rtqty==0){$drtqty=1;}else{$drtqty=$rtqty;}
       if($ctqty==0){$dctqty=1;}else{$dctqty=$ctqty;}
       if($stqty==0){$dstqty=1;}else{$dstqty=$stqty;}
       
       $r_amount=$r_amount+($value[rqty]*$value[rprice]);
       $c_amount=$c_amount+($value[cqty]*$value[cprice]);
       $s_amount=$s_amount+($value[sqty]*$value[sprice]);
       }
       ?>
       <tr id="trsubhead">
         <td colspan="1"> Total Amount</td>
         <td colspan="1" align="right"><?=number_format($rtqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($r_amount/$drtqty,2);?></td>
         
         <td colspan="1" align="right"><?=number_format($ctqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($c_amount/$dctqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($stqty,2);?></td>
         <td colspan="1" align="right"><?=number_format($s_amount/$dstqty,2);?></td>
      </tr>      
      <? 
      }
    ?>  
 </table>


<?php
 include "footer.php";
?>
