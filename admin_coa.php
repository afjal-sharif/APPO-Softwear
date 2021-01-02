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
answer = confirm("Are You Sure To Add Account Head ?")
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
   $assets=0;
   $liabalities=0;
   $equity=0;
   
   if($_POST[type]==0){ $assets=1; $type=1;}
   if($_POST[type]==1){ $liabalities=1;$type=2;}
   if($_POST[type]==2){ $equity=1;$type=3;}
   
   
   $sql="insert into tbl_coa (head_name,description,assets,liabalities,equity,user,type)
         value('$_POST[name]','$_POST[description]',$assets,$liabalities,$equity,'$_SESSION[userName]',$type)"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'>  Success !! Account Head Create Successfully</b>";
   } // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="2">Chart Of Accounts</td></tr>  
    <tr bgcolor="#FFCCAA" align="center">    
      <td> Account Head: <input type="text" size="30" name="name" /> </td>
      
      <td> Account Type:
          <select name="type" style="width: 220px;">
            <option value="0" <?if($_POST[type]=='0') echo "SeLECTED";?>>Assets</option>
            <option value="1" <?if($_POST[type]=='1') echo "SeLECTED";?>>Liabalities</option>
            <option value="2" <?if($_POST[type]=='2') echo "SeLECTED";?>>Owner Equity</option>
          </select>
      </td>       
  </tr>
  <tr align="center" bgcolor="#FFCCAA">
   <td colspan="2"> Description: <input type="text" size="60" name="description" /> </td>
  </tr> 
  <tr id="trsubhead"><td colspan="2" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>



<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Existing Account Head</td></tr> 

   <tr bgcolor="#FFCCAA" id="trsubhead">    
       <td>ID</td>
       <td>Name</td>
       <td>Description</td>
       <td>Assets</td>
       <td>Liabalities</td>
       <td>Equity</td>
       <td>User</td>
       <?if($_SESSION[userType]=='A')
        {
         echo "<td align='center'>Action</td>";
        }
       ?>
      </tr>     
  
    <?
      $user_query="select * from tbl_coa order by id desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center">
        <td><?=$value[id];?></td>
        <td><?=$value[head_name];?></td>
        <td><?=$value[description];?></td>
        <td><? if($value[assets]==1){ echo "<img src='images/active.png' width='15px' height='15px'>";} else { echo "&nbsp;";}?></td>
        <td><? if($value[liabalities]==1){ echo "<img src='images/active.png' width='15px' height='15px'>";} else { echo "&nbsp;";}?></td>
        <td><? if($value[equity]==1){ echo "<img src='images/active.png' width='15px' height='15px'>";} else { echo "&nbsp;";}?></td>
        <td><?=$value[user];?></td>
        <td align="center"> 
          <?  
            if($_SESSION[userType]=='A')
             {
              ?>
               <!--<a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=customer" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a>-->
               <!--
               <A HREF=javascript:void(0) onclick=window.open('editexpense_cat.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Expense Info"><img src="images/edit.png" height="15px" width="15px"></a>
               --> 
              <?
             }
          ?></td>
       </tr>
       <?
       }
      }
    ?>  
 </table>

<?php
 include "footer.php";
?>

