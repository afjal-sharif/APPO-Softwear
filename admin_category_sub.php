
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
         $query_sql = "SELECT  tbl_product.id,tbl_product.name as pname,tbl_product_category.name as catname,punit                
                              FROM `tbl_product`
                              join tbl_product_category on tbl_product.category_id=tbl_product_category.id  where  category_id=$cat order by tbl_product_category.name";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = '<select name="sub_cat"   id ="sub_cat" style="width:250px">';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['id'];
			     $combo=$combo.'">'.$rs[catname].'::'.$rs['pname'].'::'.$rs['punit'].'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo;          
?>
