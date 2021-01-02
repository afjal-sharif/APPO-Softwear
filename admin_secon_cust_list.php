
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
         $query_sql = "SELECT  *  FROM `tbl_secondary_customer` where cid='$cat' order by name";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = 'Sec.Cust:<select style="width:250px" id="sub_cat" name="sub_cat">';
         $combo=$combo.'<option value="-1"></option>';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['id'];
			     $combo=$combo.'">'.$rs['name'].'::'.' Address '.$rs[address].':: Type '.$rs[c_type].'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo;          
?>
