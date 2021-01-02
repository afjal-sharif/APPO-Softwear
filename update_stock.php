<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 
 $sql="delete from tbl_stock";
 db_query($sql) or die(mysql_error());
 
 $sql="insert into tbl_stock(donumber,stockdt,product,stock)
       SELECT donumber,min(dt) as stockdt,product,sum(qty) as stock FROM `view_stock_union`
       group by donumber,product
       having sum(qty)>1
       order by min(dt),donumber
      ";
 db_query($sql) or die(mysql_error());
 
 echo "<img src='images/active.png'><b> Stock Update Successfully.</b>";
?>

<?php
 include "footer.php";
?>

