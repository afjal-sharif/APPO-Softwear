<?php
 session_start();
 include "includes/functions.php";
 include "session.php"; 
 include "header.php"; 
 $type=$_REQUEST[type];
?>

 
 <table width="960px" bgcolor="#FFFFFF"  border="1" cellpadding="5" cellspacing="5" align="center" style="border-collapse:collapse;">    
   <form name="po"  action="Openbalance.php" method="post">
     <tr><td colspan="2" bgcolor="#FCDACD" id="trhead">Enter Administrator Password</td></tr>
     <tr><td colspan="2" bgcolor="#FFCCCC" id="trsubhead"><b> <? echo $msg; ?> </td></b></tr>
     <tr align="center">  
      <td>Admin Password :</td><td><input type="password"  name="newPass" size="20" value="**"></td>
      <input type="hidden" value="<?=$type;?>"  name="type"  />
     </tr>
     <tr align="center" id="trsubhead"><td colspan="2"> <input name="submit" type="submit" onclick="ConfirmChoice(); return false;" class="button" value="  Ok " />  </td> </tr>
   </form>
 </table>
      
<?
//include "leftadmin.php";
include "footer.php";
?>
 
  
