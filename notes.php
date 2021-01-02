<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Notes ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[discussion])) 
   {
    echo " <b>Error !! Pls give input properly</b>";
   }
  else
   {      
   $sql="insert into tbl_discussion (customer,company,discussion,alarmdate,user,comtype,`date`)
         value(0,0,'$_POST[discussion]','$_POST[demo11]','$_SESSION[userName]',1,curdate())"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Notes insert successfully</b>";
   } // Error chech If
 }// Submit If
?>


<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3">Add Any Notes to Remember...</td></tr>  

     <tr align="center">
       <td colspan="3">
         <textarea name="discussion" rows="10" cols="130"><?echo $_POST[discussion];?></textarea>
       </td>
     </tr>
     
     <tr id="trsubhead"><td colspan="3" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value="   Save  " /> </td> </tr>
</table>
</form>
<br>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">Display Existing Notes</td></tr> 
 <tr bgcolor="#FFCCAA" align="center">
    <td colspan="1">Sl No</td>
    <td colspan="1">Post Date</td>
    <td colspan="1">Notes</td>
    <td colspan="1">Post By</td>
  </tr> 
 <?
    
      $user_query="select  * from tbl_discussion 
                    where comtype=1 and acknow=0 order by tbl_discussion.id desc"; 
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $count=1;
       while($value=mysql_fetch_array($users))
       {
       ?>     
       <tr align="center">
          <td><?=$count;?></td>
          <td><? echo date("Y-m-d", strtotime("$value[date_time]"));?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[user];?></td>    
       </tr>
       <?
       $count=$count+1;
       }
      }
    ?>  
 </table>

<?php
 include "footer.php";
?>

