<?php
 session_start();
 $msgmenu="Expense Head";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add expense category ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[name])) 
   {
    echo " <img src='images/inactive.png' height='15px' width='15px'><b>Error !! Pls give input properly</b>";
   }
  else
   {
   $sql="insert into tbl_income_head (name,details,user) value('$_POST[name]','$_POST[details]','$_SESSION[userName]')"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'>  Success !! Others Income Head Insert Successfully</b>";
   } // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3">Others Income Head</td></tr>  
    <tr bgcolor="#FFCCAA">    
      <td> Income Head Name: <input type="text" size="30" name="name" /> </td>
      <td> Details :<input type="text"  name="details" size="30" /> </td>
             
  </tr>
  <tr id="trsubhead"><td colspan="3" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>



<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Display Existing Income Head</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>ID</td>
       <td>Name</td>
       <td>Details</td>
       <td>User</td>
       <?if($_SESSION[userType]=='A')
        {
         echo "<td align='center'>Action</td>";
        }
       ?>
      </tr>     
    <?
      $user_query="select * from tbl_income_head order by id desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[id];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[details];?></td>
          <td><?=$value[user];?></td>
          <td align="center"> 
          <?  
            if($_SESSION[userType]=='A')
             {
              ?>
               <!--<a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=customer" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a>-->
               <A HREF=javascript:void(0) onclick=window.open('editexpense.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Expense Info"><img src="images/edit.png" height="15px" width="15px"></a>
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

