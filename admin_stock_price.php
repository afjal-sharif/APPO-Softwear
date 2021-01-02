
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
$cat=$_REQUEST['ctype'];
 
 if($cat!='')
  {
 
      $user_query="SELECT * from tbl_product where id=$cat";
      $users = mysql_query($user_query);
      $row_sql_adj= mysql_fetch_assoc($users);
      $cogs=$row_sql_adj[rate];  

      $combo=$combo.'<input type="text" size="8" name="salesrate" value='$cogs'  />';
      echo $combo;

  }              
?>
