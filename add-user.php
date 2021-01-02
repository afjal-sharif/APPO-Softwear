<?php
 include "includes/functions.php";
 include "session.php";
 
 
 if($_GET['mode']=='update' AND is_numeric($_GET['userId'])){ 
     $user_query = "SELECT * FROM hbl_users WHERE id=$_GET[userId]";
     $user_result = mysql_query($user_query);
     $uinfo = mysql_fetch_array($user_result);         
 }
 
   
 include "header.php";
?>

  
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td colspan="2" align="left" style="height:18px;"><strong>Date: <?=date("M,d Y",time());?></strong></td>
    <td width="33%">&nbsp;</td>
  </tr>
    
  <tr>
  <td width="66%" class="contents" valign="top">
  
  <table width="100%"  border="0" cellspacing="1" cellpadding="2">
  <form name="manage_users" action="update-user.php" method="post">
  <input  type="hidden" name="mode" value="<?=($uinfo['userId']!='')?'update':'add';?>" />
  <?
  if(is_numeric($_GET['userId'])){
  ?>
  <input  type="hidden" name="userId" value="<?=$uinfo['userId'];?>" />
  <?
  }
  ?>
  <tr>
    <td colspan="2" class="content_title">Add User</td></tr>
	<tr><td align="left" width="20%">Name</td><td width="80%" align="left"><input type="text"  name="screenName" size="42" value="<?=$uinfo['screenName']?>" /></td>
		<tr><td align="left" width="20%">Designation</td><td width="80%" align="left"><input type="text"  name="designation" size="42" value="<?=$uinfo['designation']?>" /></td>
  
  
	

	
	
  <tr><td align="left" width="20%">Login Name</td><td width="80%" align="left"><input name="userName" size="42" value="<?=$uinfo['userName']?>" type="text" /></td>
  
  <tr><td align="left" width="20%">Password</td><td width="80%" align="left"><input name="userPassword" size="42" value=""  type="password" />
   <?
  if(is_numeric($_GET['userId'])){
  ?>
  <br />keep empty to keep the previous password 
  <?
  }
  ?>
  </td>
  
    <tr><td align="left" width="20%">Status</td><td width="80%" align="left"><input name="status" type="checkbox"  <?if(is_numeric($uinfo['status'])){   if($uinfo['status']==1) echo "checked"; ?><? }else{?>checked<?} ?> /> Enabled</td>
	
  <tr><td align="left" width="20%">&nbsp;</td><td width="80%" align="left">
  <input name="submit" type="submit" class="button" value="Submit" /></td>
  
  </tr>
  </form>
  </table>
  
  
  </td>
  <td>&nbsp;</td>
  <td width="33%" valign="top">
  <?php  include "manage-user-menu.php"; ?>
  </td>
  </tr>
  
  
  
</table>

<?php
include "footer.php";
?>
