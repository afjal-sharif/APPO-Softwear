<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
 if($cat==0)
  {  
         $query_sql = "SELECT  id,name,address,mobile  FROM `tbl_company` where status<>2 order by name";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = 'Supplier: <select name="ref_id"   id ="ref_id" style="width:300px">';
		     //$combo = $combo .'<option value=""'.'></option>';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['id'];
			     $combo=$combo.'">'.$rs['name'].' :: '. $rs['address'].'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo;
  }
 else
  { 
         $query_sql = "SELECT  id,name,address,mobile  FROM `tbl_customer`  where status<>2 order by name";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = 'Customer: <select name="ref_id"   id ="ref_id" style="width:300px">';
		     //$combo = $combo .'<option value=""'.'></option>';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['id'];
			     $combo=$combo.'">'.$rs['name'].' :: '. $rs['address'].' ::</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo; 
   }        
?>
