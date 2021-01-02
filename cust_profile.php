<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 //include "rptheader.php";
 $SID=$_REQUEST['SID'];
 $con="where id=$SID";
?>
<link href="skin.css" rel="stylesheet" type="text/css" />
<table width="70%" align="center" bgcolor="#FFFFFF"  bordercolor="#AABBCC" border="1"  cellspacing="3" cellpadding="5" style="border-collapse:collapse;">
<?             
   $user_query="Select * from tbl_customer  $con";     
   $users = mysql_query($user_query);
   while($value=mysql_fetch_array($users)){ 
?>    
 <tr><td colspan="2" height="30px" align="center"><IMG  alt="logo" src="images/logo.png"  border=0></td></tr>
 <tr><td colspan="2" height="10px" id="dealer" align="left" bgcolor="#FFCC00"><b><?=$value[name];?></b></td></tr>
 
 
 
 <tr><td colspan="2" height="10px" align="left" bgcolor="#FFDD09">Customer Information</td></tr> 
 <tr>
     <td align="right">
       <table align="center" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
          <tr><td align="left">Code No :</td><td align="right"><b><?=$value['codeno'];?></b></td></tr>
          <tr><td align="left">Owner :</td><td><b><?=$value['owner'];?></b></td></tr>
          <tr><td align="left">Address:</td><td><?=$value['address'];?></td></tr>
          <tr><td align="left">Type:</td><td><?=$value['type'];?></td></tr>
          <tr><td align="left">SP:</td><td><?=$value['sp'];?></td></tr>
          <tr><td align="left">Area:</td><td><?=$value['area'];?></td></tr>
          <tr><td align="left">Mobile:</td><td><?=$value['mobile'];?></td></tr>
          <tr><td align="left">T & N:</td><td><?=$value['tnt'];?></td></tr>
          <tr><td align="left">E-Mail:</td><td><?=$value['email'];?></td></tr>
          <tr><td align="left">TIN:</td><td><?=$value['tin'];?></td></tr>
          <tr><td align="left">Trade Licence:</td><td><?=$value['trade_lic'];?></td></tr>
          
          <tr><td align="left">Date of Birth:</td><td><?=$value['dob'];?></td></tr>
          <tr><td align="left">Remarks:</td><td><?=$value['remarks'];?></td></tr>
       </table>
     </td>
     <td width="35%" align="center">
     <? if($value[picture]==''){?>
       <IMG  alt="No Picture" src="profile/noimage.jpg" height="150" width="140"  border="1">
       <?}else{
       ?>
       <IMG  alt="<?=$value[owner];?>" src="profile/<?=$value[picture];?>" height="150" width="140"  border="1">
       <?}?>

      <!-- <IMG  alt="No Picture" src="<?=$value[imagename];?>" height="150" width="140"  border="1">
       <a href="picture.php?SID=<?=$value['id']?>&type=1&msg=Owner Picture" target="_blank">C</a>-->
     </td>
 </tr>
 
 
 <tr><td colspan="2" height="10px"  align="left" bgcolor="#FFEE09">Wife Information</td></tr>
 <tr>
     <td>
       <table align="center" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
          <tr><td>Name :</td><td><b><?=$value['wife_name'];?></b></td></tr>
          <tr><td>Mobile:</td><td><?=$value['w_mobile'];?></td></tr>
          <tr><td>Date of Birth :</td><td><?=$value['w_dob'];?></td></tr>
          <tr><td>Marrige Date:</td><td><?=$value['aniversery'];?></td></tr>
              
       </table>
     </td>
     <td width="35%" align="center">
      <? 
      
      if($value[w_picture]==''){?>
       <IMG  alt="No Picture" src="profile/noimage.jpg" height="150" width="140"  border="1">
       <?}else{
       ?>
       <IMG  alt="<?=$value[wife_name];?>" src="profile/<?=$value[w_picture];?>" height="150" width="140"  border="1">
       <?}?>
       <!--<a href="picture.php?SID=<?=$value['id']?>&type=2&msg=Dealer Wife Picture" target="_blank">C</a>-->
     </td>
 </tr>
 <?
}?>      
</table>  
