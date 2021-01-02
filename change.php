<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $_SESSION[iss]='';
 $_SESSION['sqlstock']='';
?>
		  
 <?
  $flag=false;
  
  if(isset($_POST["submit"]))
   {
    if ($_POST[newPass] == $_POST[connewPass])
    {
	    $userPassword = md5($_POST['oldPass']);
	    $userName=$_POST['name'];
		$pwd = $_POST['newPass'];
		if( strlen($pwd) < 8 ) {
			$error .= "Password too short! ";
		}
		if( strlen($pwd) > 20 ) {
			$error .= "Password too long! ";
		}
		if( !preg_match("#[0-9]+#", $pwd) ) {
			$error .= "Password must include at least one number! ";
		}
		if( !preg_match("#[a-z]+#", $pwd) ) {
			$error .= "Password must include at least one letter! ";
		}
		if( !preg_match("#[A-Z]+#", $pwd) ) {
			$error .= "Password must include at least one CAPS! ";
		}
		if( !preg_match("#\W+#", $pwd) ) {
			$error .= "Password must include at least one symbol! ";
		}
		if ($error){
			$msg = "Password validation failure(your choise is weak): $error";
		} else {
		    $user_query="Select * from web_tbl_users where userName='$userName'  and userPassword='$userPassword'";
		    $users = mysql_query($user_query);
		    $total = mysql_num_rows($users);
		    if ($total>0)
		    {      
			  $newPass=md5($pwd);
		      $sql="update web_tbl_users set userPassword='$newPass' where userName='$userName'";
		      db_query($sql);
		      $msg="<img src='images/active.png'><b>User : $userName  >> Password Change Successfully. </b>";  
		      $flag=true;   
		    }
		    else
		    {
		      $msg=" Error : $userName  >> Old Password Wrong.";     
		    }
		} 
    }
    else
     {
      $msg=" Error !!! New Password & Confirm Password are not same.";
     }      
   }   
 ?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Change Password ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 
 
 <?
  if($flag==false)
  {
 ?>
 
 <table width="960px" bgcolor="#FFFFFF"  border="1" cellpadding="5" cellspacing="5" align="center" style="border-collapse:collapse;">    
  <form name="po"  action="" method="post">
  <tr height="25px"><td colspan="2" bgcolor="#FCDACD" id="trsubhead">Password Change Form</td></tr>
  <tr height="25px"><td colspan="2" bgcolor="#FFCCCC" id="trsubhead"><b> <? echo $msg; ?> </td></b></tr>
  
  <tr bgcolor="#FFCCCC" align="center" height="25px">
    <td> User Name :</td><td><input type="text"  name="name" size="18" value="<? echo $_SESSION[userName];?>" readonly></td>
  </tr>
  <tr align="center" height="25px">  
    <td> Old Password</td><td><input type="password"  name="oldPass" size="20" value=""></td>
  </tr>
  <tr align="center" height="25px">  
    <td> New Password :</td><td><input type="password"  name="newPass" size="20" value=""></td>
  </tr>
  <tr align="center" height="25px">  
    <td> Confirm Password :</td><td><input type="password"  name="connewPass" size="20" value=""></td>
  </tr>
  <tr align="center" id="trsubhead"><td colspan="2"> <input name="submit" type="submit" onclick="ConfirmChoice(); return false;" class="button" value="   Change Password   " />  </td> </tr>
  </form>
 </table>

<?
 }
 else
 {
  echo $msg;
 }
?>

      
<?
//include "leftadmin.php";
include "footer.php";
?>
 
  
