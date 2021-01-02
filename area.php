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
  if (empty($_POST[area])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_area (area_name,user,status) 
                value('$_POST[area]','$_SESSION[userName]','$_POST[ttype]')"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! New Name insert successfully</b>";
   } // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3" align="left">New Customer Business Type/Customer Type/ Area / Incentive Type Entry Form</td></tr>  
  <tr bgcolor="#FFCCAA" align="center">    
       <td>Type: 
          <select name="ttype" style="width: 140px;">
             <option value="0" <?php if($_POST["ttype"]=='0') echo "selected";?>>New Area</option>
             <option value="2" <?php if($_POST["ttype"]=='2') echo "selected";?>>Customer Type</option>
             <option value="4" <?php if($_POST["ttype"]=='4') echo "selected";?>>Business Type</option>
             <option value="6" <?php if($_POST["ttype"]=='6') echo "selected";?>>Incentive Type</option>
          </select>
        </td>
  
       <td> Name: <input type="text" size="15"  name="area" /> </td>          
  
  <td colspan="1" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>





<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="10" align="left">Display Existing Parameter Name</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Type</td>
       <td>Name</td>
       <td>User</td>       
   </tr>     
    <?
      $user_query="select * from tbl_area order by status, area_name";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>    
        <tr align="center">    
          <td>
             <?
               if($value[status]=='0') { echo "Area";}
               if($value[status]=='2') { echo "Customer Type";}
               if($value[status]=='4') { echo "Business Type";}
               if($value[status]=='6') { echo "Incentive";}else{echo "";}
               
          
             ?>
          </td>
          <td><?=$value[area_name];?></td>
          <td><?=$value[user];?></td>
        
       </tr>
       <?
       }
      }
    ?>  
 </table>

<?php
 include "footer.php";
?>

