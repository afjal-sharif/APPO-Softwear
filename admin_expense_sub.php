
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
         $query_sql = "SELECT  id,type  FROM `tbl_expense_cat`  where expensetype=$cat order by type";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = '<select name="type"   id ="type" style="width:150px">';
		     $combo = $combo .'<option value=""'.'></option>';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['id'];
			     $combo=$combo.'">'.$rs['type'].'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo; 
           
?>
