<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Transection Date ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[demo12])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
    $sql="delete from tbl_sys_date";
    db_query($sql) or die(mysql_error());
   
    $sql="insert into tbl_sys_date (receive,sales,cash,user,remarks) 
                value('$_POST[demo12]','$_POST[demo12]','$_POST[demo12]','$_SESSION[userName]','$_POST[remarks]')"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Date Update Successfully</b>";
   
   $user_query="select * from tbl_sys_date";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   echo $_SESSION[dtcompany]='';
   echo $_SESSION[dtcompany]=$row_sql[receive];
   $_SESSION[dtcustomer]=$row_sql[sales];
   $_SESSION[dttransection]=$row_sql[cash];
   } // Error chech If
 }// Submit If
?>

<?
      $user_query="select * from tbl_sys_date";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $dtreceive=$row_sql[receive];
      $dtsales=$row_sql[sales];
      $dtcash=$row_sql[cash];
?>


<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="1" align="center"> Transection Date Setup Form.</td></tr>  
    <tr bgcolor="#FFEE09" align="center">    
      <td><b> Transection Date:</b>
           <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$dtreceive?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
      </td>          
  </tr>     
      
  <tr align="center">     
       <td colspan="1"> Remarks <input type="text"  name="remarks" size="100" /> </td>      
  </tr>    
  <tr id="trsubhead"><td colspan="1" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Update  " /> </td> </tr>
</table>
</form>





<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trsubhead"><td colspan="3" align="left">Display Current System Date</td></tr> 

  <tr bgcolor="#FFCCAA">    
       <td> Current Transection Date</td>
       <td>Set By</td>    
       <td>Date & Time </td>   
      </tr>     
    <?
      $user_query="select * from tbl_sys_date order by id asc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[receive];?></td>
          
          
          <td><?=$value[user];?></td>
          <td><?=$value['date&time'];?></td>
       </tr>
       <?
       }
      }
    ?>  
 </table>

<?php
 include "footer.php";
?>

