<?php
 
  
 $con = db_connect($global['host'],$global['dbuser'],$global['dbpasswd']);

  //	
if (!$con) {
   die('Could not connect: ' . mysql_error());
}
  mysql_select_db($global['dbname'],$con);
?>
