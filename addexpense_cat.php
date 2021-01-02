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
answer = confirm("Are You Sure To Add expense head ?")
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
   $sql="insert into tbl_expense_main (name,in_bal,user) value('$_POST[name]','$_POST[type]','$_SESSION[userName]')"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'>  Success !! Expense Main Head Create Successfully</b>";
   } // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="2">Expense Head.</td></tr>  
    <tr bgcolor="#FFCCAA">    
      <td> Expense Head: <input type="text" size="30" name="name" /> </td>
      <td>Expense Impact:
          <select name="type" style="width: 220px;">
            <option value="0" <?if($_POST[type]=='0') echo "SeLECTED";?>>Income Statement - Expense Type</option>
            <option value="1" <?if($_POST[type]=='1') echo "SeLECTED";?>>Balance Sheet- Assets Type</option>
            <option value="2" <?if($_POST[type]=='2') echo "SeLECTED";?>>Adjustment - Expense</option>
          </select>
      </td>       
  </tr>
  <tr id="trsubhead"><td colspan="2" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>



<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Display Existing Expense Head</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>ID</td>
       <td>Name</td>
       <td>Type</td>
       <td>User</td>
       <?if($_SESSION[userType]=='A')
        {
         echo "<td align='center'>Action</td>";
        }
       ?>
      </tr>     
  
    <?
      $user_query="select * from tbl_expense_main order by id desc";
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
        <td><? if($value[in_bal]==1){ echo " Balance Sheet Item";}
               if($value[in_bal]==0){ echo " Income Sheet Item";}
               if($value[in_bal]==2){ echo " Adjustment";}
             ?>
        </td>
        <td><?=$value[user];?></td>
        <td align="center"> 
          <?  
            if($_SESSION[userType]=='A')
             {
              ?>
               <!--<a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=customer" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a>-->
               <A HREF=javascript:void(0) onclick=window.open('editexpense_cat.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Expense Info"><img src="images/edit.png" height="15px" width="15px"></a>
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

