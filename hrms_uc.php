<?php
 session_start();
 $mnuid=101;
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 ?>
<?
   if(@checkmenuaccess($mnuid))
    {
 ?>


<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trsubhead"><td colspan="8">:::   Under Construction  :::</td></tr>  
</table>
</form>


<?php
 }
 else
 {
  echo "<b>Un-authorized Access.</b>";
 }
 include "footer.php";
?>

