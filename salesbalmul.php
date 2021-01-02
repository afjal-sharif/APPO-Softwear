<?php
 session_start();
 include "includes/functions.php";
 $mnuid="301";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>
<?
 
 //echo $_POST[sub_cat];

if(isset($_POST["salessave"]) and ($_POST[salesqty]>0))
 { 
 if($_POST[salesbundle]=='')
 {
  $bundle=0;
 }
 else
 {
  $bundle=$_POST[salesbundle]; 
 }
 $product=$_POST[sub_cat];
 $qty=$_POST[salesqty];
 $rate=$_POST[salesrate];
 
 $sql="select sum(qty) as qty from view_stock_display where product='$product' ";
 
 $sql="select sum(stock) as qty from tbl_stock where product='$product' ";
 
 $sql_qty = mysql_query($sql);
 $sql_st_qty= mysql_fetch_assoc($sql_qty);
 $stockqty=$sql_st_qty[qty];
 $rembal=$qty;
 if($stockqty>=$qty)
 {
   $user_query="select * from view_stock_sales where product='$product' order by donumber";
   $user_query="select donumber,product,sum(stock) as qty,  
             tbl_product_category.name as catname,tbl_product.name as pname, category_id  FROM `tbl_stock`
             join tbl_product on tbl_stock.product=tbl_product.id
             join tbl_product_category on tbl_product.category_id=tbl_product_category.id
             where tbl_stock.product='$product'
         group by donumber,tbl_stock.product
         order by stockdt ";
         
         
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $flag=true;
   while($value=mysql_fetch_array($users) and ($flag==true))
   {
    if($rembal<=$value[qty])
     {
      $salesqty=$rembal;
      $rembal=0;
      $flag=false;
     }
    else
     {
      $salesqty=$value[qty];
      $rembal=$rembal-$value[qty];
      $flag=true;     
     }  
    
    $sql="insert into tbl_sales_temp(donumber,company,product,product_id,qty,rate,user,freeqty,unit) 
              values('$value[donumber]','$value[catname]','$value[pname]','$value[product]','$salesqty','$rate','$_SESSION[userName]',$bundle,'$value[unit]')";
    db_query($sql);   
   }// While loop for insert

 } 
 else
 {
  echo "<img src='images/inactive.png' border='0'> Sales Qty: $qty is greater than Stock Qty :$stockqty";
 }
 
  }
 
?>

<?
 $sql="SELECT `company`,`product`,`product_id`,unit,sum(qty)as qty,avg(freeqty) as bundle,avg(rate) as rate FROM `tbl_sales_temp`
        where user='$_SESSION[userName]' group by `product_id`,rate";
 $users = mysql_query($sql);
 $total = mysql_num_rows($users);    
 
 if ($total>0)
    {
 ?> 
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Product In Sales Card.</td></tr> 
 <tr bgcolor="#FFCCAA">           
       <td>Category</td>
       <td>Product</td>
       <td>Sales Qty</td>
       <td>Bundle</td>
       <td>Gross Rate</td>
       <td bgcolor="#FFEE09" align="center">Sales Total</td>        
       <td bgcolor="#FF00CA" align="center">Action</td> 
 </tr>     
  <?
   while($value=mysql_fetch_array($users))
       {
  ?>
      <tr>
          <td><?=$value[company];?></td>
          <td><?=$value[product];?></td>
          
          <td align="right"><?=number_format($value[qty],2);?> <?=$value[unit];?> </td>
          <td align="center"><?=number_format($value[bundle],0);?></td> 
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right" bgcolor="#FFEE09"><?=number_format($value[qty]*$value[rate],2);?></td>           
          <td align="center"><a href="indelete.php?id=<?=$value[product_id]?>&mode=tmpsale"><img src="images/inactive.png" height="15px" width="15px"></a></td>
       </tr>


  <? 
    $totalqty=$totalqty+$value[qty];
    $totalbundle=$totalbundle+$value[bundle];
    $totalvalue=$totalvalue+($value[qty]*$value[rate]);
    $grossvalue=$grossvalue+($value[qty]*($value[rate]+$value[df]+$value[load]))+$value[others]+$value[adjamount];
      }
      echo "<tr id='trsubhead'><td colspan='2' align='center'>Total </td>
                              <td colspan='1' align='right'> ".number_format($totalqty,0)."</td>
                              <td colspan='1' align='center'> ".number_format($totalbundle,0)."</td>
                              <td colspan='1' align='right'> ".number_format($totalvalue/$totalqty,2)."</td>
                              <td colspan='1' align='right'> ".number_format($totalvalue,2)."</td><td>&nbsp;</td>
                             
             </tr>";
             
             
      echo "<tr id='trsubhead'><td colspan='8'><a href='rsalemul.php?value=$totalvalue'>Checkout</a></td></tr>"  ;      
      echo "</table>";
    }
    
?>



<form name="productform" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Product In Stock</td></tr> 
 <tr bgcolor="#FFCCAA" align="center">           
       <td>Category</td>
       <td>Product</td>
       <td>Sales Qty</td>
       <td>Bundle</td>
       <td>Rate</td>        
       <td bgcolor="#FF00CA" align="center">Action</td> 
 </tr>     
 
 
 <tr align="center">
   <td colspan="1">
          <?
           $query_sql = "SELECT distinct catid,catname  FROM view_stock_display order by catname";
           $query_sql = "SELECT id as catid,g_name,name as catname  FROM `tbl_product_category` where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="category" id="category_stock" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['catid'];?>" <?php if($_POST["category"]==$row_sql['catid']) echo "selected";?> ><?php echo $row_sql['catname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
    </td>
    <td colspan="1">
  
            <div id="divcategory_stock">
             <select style="width:250px" id="sub_cat" name="sub_cat">
                 <?      
                 if(isset($_POST[category]) and ($_POST[category]!=''))
                 {
                  $query_sql = "SELECT  *  FROM `view_stock_display` where catid='$_POST[category]' order by catname";
                  $query_sql = "SELECT  tbl_stock.product,sum(tbl_stock.stock) as qty,tbl_product.name as pname,
                               tbl_product_category.name as catname, category_id  FROM `tbl_stock`
                               join tbl_product on tbl_stock.product=tbl_product.id
                               join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                               where tbl_product.category_id='$_POST[category]'
                               group by tbl_stock.product
                              order by category_id";
                  
                  
                  $sql = mysql_query($query_sql) or die(mysql_error());
                  echo"<option value='-1'></option>";
		               
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['product'];?>" <? if($_POST[sub_cat]==$rs[product]) {echo "SELECTED";}?>><?=$rs['catname'];?>::<?=$rs['pname'];?>::Stock <?=$rs['qty']?></option>
                 <?    
		             }
		            } 
                
                 else
                 {
                  $query_sql = "SELECT  tbl_stock.product,sum(tbl_stock.stock) as qty,tbl_product.name as pname,
                               tbl_product_category.name as catname, category_id  FROM `tbl_stock`
                               join tbl_product on tbl_stock.product=tbl_product.id
                               join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                               group by tbl_stock.product
                              order by category_id";
                  $sql = mysql_query($query_sql) or die(mysql_error());
                  echo"<option value='-1'></option>";
		               
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['product'];?>" <? if($_POST[sub_cat]==$rs[product]) {echo "SELECTED";}?>><?=$rs['catname'];?>::<?=$rs['pname'];?>::Stock <?=$rs['qty']?></option>
                 <?    
		             }
                 echo"<option value='-1'></option>";
                 }
                ?> 
             </select>
            </div>
     </td>
     <td><input type="text" size="12" name="salesqty" value="0"  /> </td>
     <td><input type="text" size="4" name="salesbundle" value="0"  /> </td>
     <td><input type="text" size="8" name="salesrate" value="0"  /> </td>
     <td><input type="submit" name="salessave" value= "  Add To Card  "> </td>
 </tr>  
 </form>
</table>
<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
