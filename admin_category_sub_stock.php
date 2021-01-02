
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
         $query_sql = "SELECT  *  FROM `view_stock_display` where catid='$cat' order by catname";
         
         $query_sql = "SELECT  tbl_stock.product,sum(tbl_stock.stock) as qty,tbl_product.name as pname,
                               tbl_product_category.name as catname, category_id  FROM `tbl_stock`
                               join tbl_product on tbl_stock.product=tbl_product.id
                               join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                               where tbl_product.category_id='$cat'
                               group by tbl_stock.product
                              order by category_id";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = '<select style="width:250px" id="sub_cat" name="sub_cat">';
         $combo=$combo.'<option value="-1"></option>';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['product'];
			     $combo=$combo.'">'.$rs[catname].'::'.$rs['pname'].'::'.' Stock '.$rs[qty].'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo;          
?>
