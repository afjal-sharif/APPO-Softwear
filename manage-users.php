<?php
 session_start();
 $msgmenu="User Create";
 include "includes/functions.php";
 include "session.php"; 
 
 @checkaccess("manage-users.php");
  
   
   $user_query = "SELECT * FROM hbl_users ORDER BY userName";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);    
   include "header.php";
?>

  
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  
  <tr id="trhead" height="30px">
    <td colspan="2" align="left" style="height:18px;"><strong>New User Create Form</strong></td>
    <td width="33%">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td colspan="2" align="left" style="height:18px;"><strong>Date: <?=date("M,d Y",time());?></strong></td>
    <td width="33%">&nbsp;</td>
  </tr>
    
  <tr>
  <td width="66%" class="contents" valign="top">
  <table width="100%"  border="0" cellspacing="1" cellpadding="2">  
  
  <? if($total>0) { ?>
  <tr>
    <td colspan="6" class="content_title">User List</td></tr>
	<th><div align="left">Login Name</div></th><th><div align="left">Type</div></th><th><div align="left">Name</div><div align="left">Status</div></th><th></th><th></th>
	<?php
	while($value=mysql_fetch_array($users)){
	?>
	<tr>
	<td><?=$value['userName'];?></td>
	<td><? if($value['userType']=='A') echo 'Admin';
	       else if($value['userType']=='M') echo 'Member';
		   
	  ?></td>
 	<td><?=$value['screenName'];?></td>
  
  <td><? if($value['status']=='1') echo 'Active';
	       else if($value['status']=='0') echo 'InActive';
		   
	  ?></td>

  <td><a href="add-user.php?mode=update&userId=<?=$value['id'];?>">Edit</a></td>
  <td><a href="update-user.php?mode=delete&userId=<?=$value['id'];?>" title="delete">X</a></td>
	</tr>
    <? } ?>
	
   <? }else echo "No User Found !"; ?>	
</table>	

	
  
  
  </td>
  <td width="13%">&nbsp;</td>
  <td width="20%" valign="top">
  <?php  include "manage-user-menu.php"; ?>
  </td>
  </tr>
  
  
  
</table>

<?php
include "footer.php";
?>
