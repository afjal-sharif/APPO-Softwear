
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
         $query_sql = "SELECT  *  FROM `tbl_product` where  category_id=$cat order by name";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = '<select name="sub_cat"   id ="sub_cat" style="width:250px">';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['id'];
			     $combo=$combo.'">'.$rs['name'].'::'.$rs['punit'].'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo;          
?>
