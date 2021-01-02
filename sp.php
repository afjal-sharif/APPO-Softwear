<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="New Customer";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add New Customer ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[shortname]) or empty($_POST[address]) or empty($_POST[mobile])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_sp (shortname,fullname,address,mobile,reference,user,area,remarks,type) 
                value('$_POST[shortname]','$_POST[fullname]','$_POST[address]','$_POST[mobile]','$_POST[reference]','$_SESSION[userName]','$_POST[area]','$_POST[remarks]','$_POST[type]')"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Customer Name insert successfully</b>";
   } // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4" align="left">New SP Entry Form</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td> Short Name *: <input type="text" size="15"  name="shortname" /> </td>
       <td> Full Name: <input type="text" size="25"  name="fullname" /> </td>
       <td> Address *: <input type="text"  name="address" /> </td>
       <td> Area <input type="text"  name="area" size="8" /> </td>
                 
  </tr>
  <tr bgcolor="#FFCCAA">
       <td> Mobile *: <input type="text"  name="mobile" size="13" /> </td>
       <td> Reference<input type="text"  name="reference" size="15" /> </td>
       <td>Type:
          <select name="type" style="width: 80px;">
            <option value="Own">Own</option>
            <option value="Company">Company</option>
          </select>
       </td>

       <td colspan="1"> Remarks <input type="text"  name="remarks" size="30" /> </td>      
  </tr>    
  <tr id="trsubhead"><td colspan="4" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>





<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="10" align="left">Display Existing SP List</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Short Name</td>
       <td>Full Name</td>
       <td>Address</td>
       <td>Area</td>
       <td>Mobile</td>
       <td>Reference</td> 
       <td>Type</td>  
       <td>Remarks </td>
       <td>Status</td>
       <?if($_SESSION[userType]=='A')
        {
         echo "<td align='center'>Action</td>";
        }
       ?>
              
      </tr>     
    <?
      $user_query="select * from tbl_sp order by shortname asc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr><td colspan="1" id="trsubhead" align="left"><?=$value[id];?> : <?=$value[shortname];?></td>
       
          <td><?=$value[fullname];?></td>
          <td><?=$value[address];?></td>
          <td><?=$value[area];?></td>
          <td><?=$value[mobile];?></td>
          <td><?=$value[reference];?></td>
          <td><?=$value[type];?></td>
          
          <td><?=$value[remarks];?></td>
          <td>
          <? if($value[status]==0) {echo "Active";}else{ echo "Inactive";}?>
          </td>
          <td align="center"> 
          <?  
            if($_SESSION[userType]=='A')
             {
              ?>
               <a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=sp" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a>               
               | <A HREF=javascript:void(0) onclick=window.open('editSP.php?smsId=<?=$value[id];?>','Accounts','width=600,height=450,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit SP Info"><img src="images/edit.png" height="15px" width="15px">
              <?
             }
          ?></td>
       </tr>
       <?
       }
      }
    ?>  
  </tr>
 </table>

<?php
 include "footer.php";
?>

