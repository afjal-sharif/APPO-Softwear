<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
         $query_sql = "SELECT `dtDate`,`donumber`,`company`,tbl_company.name FROM `tbl_order` 
                          join tbl_company on tbl_company.id=tbl_order.company 
                          where tbl_company.status<>2 and company='$cat'
                          order by dtDate desc,donumber desc,name limit 0,30";
         $sql = mysql_query($query_sql) or die(mysql_error());
         $combo = 'Ref No: <select name="donumber"  style="width:250px">';
		     //$combo = $combo .'<option value=""'.'></option>';
		     while ($rs = mysql_fetch_assoc($sql)) { 		
			     $combo=$combo.'<option value="'.$rs['donumber'];
			     $combo=$combo.'">'.$rs['donumber'].' :: '. $rs['name'].' ::'.$rs['dtDate'] .'</option>'; 
		     }
		     $combo=$combo.'</select>';
		     echo $combo; 
        
?>
