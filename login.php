<?php
    if(date("Y-m-d")>'2021-01-01')
    {
    ?>
    <div align="center"><span class="style1" style="color: #00000;font-weight: bold; size:20px">
      Software Licence is Expired, Pls contact with Company.
    </div> 
     <?
     exit;
    }

 include "login_header.php";
 $message = $_REQUEST['message'];
 
?>
<div align="center">  
<table width="50%"  border="0" cellspacing="0" cellpadding="0" summary="Login Form" >
  
  <?php
  if(!empty($message)){
  ?>
  <tr>
    <td colspan="2"><div align="center"><span class="style1" style="color: #F00;font-weight: bold;"><?=$message?></span></div></td>
  </tr>
   <?php
   }
   ?>
  <tr>
    <td colspan="2"><p>&nbsp;</p></td>
  </tr>
  
  <tr><td colspan="2" id="trhead" height="40px" style="border-right: 1px solid #990000;border-bottom: 1px solid #990000;border-left: 1px solid #990000;">LOGIN</td></tr>
  <tr><td colspan="2" style="border-right: 1px solid #990000;border-bottom: 1px solid #990000;border-left: 1px solid #990000;" align="center">
  <table width="100%" height="150px" border-color="#FFCCEE" border="0" cellspacing="5" cellpadding="2" summary="">
  <form name="login" method="post" action="welcome.php">
  <input type="hidden" name="mode" value="login" />
  <tr id="input"><td width="50%" align="right">User Name :</td><td width="50%"><input type="text" name="user" id="box1"  /></td</tr>
  <tr><td width="50%" align="right">Password :</td><td width="50%"><input type="password" name="userpwd" id="box1" /></td</tr>
  <tr><tr><td width="50%" align="right">&nbsp;</td><td align="left"><input type="submit" name="login" value="  Login   " /></td</tr>
  </form>
  </table>
  </td></tr>  
  
  <tr>
    <td colspan="2"><p>&nbsp;</p></td>
  </tr>
    
  <tr>
    <td colspan="2"><p>&nbsp;</p></td>
  </tr>
  
  <tr>
    <td colspan="2"><p>&nbsp;</p></td>
  </tr>
  
  <tr>
    <td colspan="2"><p>&nbsp;</p></td>
  </tr>
  
  <tr>
    <td colspan="2"><p>&nbsp;</p></td>
  </tr>
  
</table>
</div>
