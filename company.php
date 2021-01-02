<?php
 session_start();
 $msgmenu="Company";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[name]) or empty($_POST[address]) or empty($_POST[mobile])) 
   {
    echo " Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_company (name,address,person,mobile,tnt,email,user,creditday,custday) value('$_POST[name]','$_POST[address]','$_POST[person]','$_POST[mobile]','$_POST[tnt]','$_POST[email]','$_SESSION[userName]',$_POST[creditday],$_POST[custday])"; 
   db_query($sql) or die(mysql_error());
    echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Company <b>$_POST[name]</b> Name  insert successfully</b>";
   } // Error chech If
 }// Submit If
?>

<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="9">Display Existing Company Name</td></tr> 

   <tr bgcolor="#FFCCAA">    
       
       <td>Name</td>
       <td>Address</td>
       <td>Contact person</td> 
       <td>Mobile</td>
       <td>T & T </td>
       <td>E-Mail</td>
       <td>Company Credit Days</td>
       <td>Customer Credit Days</td>
       <td>Edit</td>
      </tr>     
    <?
      $user_query="select * from tbl_company where status=0 order by name";
     
       //$user_query="SELECT * FROM `tbl_company` order by id desc limit 0,2";
       $users = mysql_query($user_query);
       //$var1=mysql_result($users,0,0);
       //echo $var1;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       
       <tr>
          <td id="trsubhead" align="left"><?=$value[name];?></td>
          <td><?=$value[address];?></td>
          <td><?=$value[person];?></td>
          <td><?=$value[mobile];?></td>
          <td><?=$value[tnt];?></td>
          <td><?=$value[email];?></td> 
          <td><?=$value[creditday];?></td>  
          <td><?=$value[custday];?></td>  
          <td align="center"><A HREF=javascript:void(0) onclick=window.open('editcompany.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Supplier Info">
          <img src="images/edit.png" height="15px" weight="15px" ></a></td>  
       </tr>
       <?
       }
      }
    ?>  
  </tr>
 </table>
<br>
<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">New Company Entry Form</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td> Company <input type="text"  name="name" /> </td>
       <td> Address <input type="text"  name="address" /> </td>
       <td> Contact Person <input type="text"  name="person" /> </td>
       <td> Mobile <input type="text" size="11" name="mobile" /> </td>
       <td> T & T <input type="text"  size="10" name="tnt" /> </td>
       <td> E-Mail <input type="text" size="20" name="email" value="name@domain.com" /> </td>
       <td> Company Credit Day <input type="text"  name="creditday" value="30" size="3" /> </td>
       <td> Customer Credit Day <input type="text"  name="custday" value="25" size="3" /> </td>
       
     </tr>    
     <tr id="trsubhead"><td colspan="8" align="center"><input type="submit" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>



<?php
 include "footer.php";
?>

