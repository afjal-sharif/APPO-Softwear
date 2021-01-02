<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
  
 
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add New Person for LB ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[name]) or empty($_POST[address]) or empty($_POST[mobile]) or empty($_POST[type])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_lb_database (name,address,mobile,user,type)
         value('$_POST[name]','$_POST[address]','$_POST[mobile]','$_SESSION[userName]','$_POST[type]')"; 
   db_query($sql) or die(mysql_error());
    echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Person Name insert successfully</b>";
   } // Error chech If
 }// Submit If
?>







<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3">New Person For Landing & Borrowing</td></tr>  
 <tr bgcolor="#FFCCAA" align="center">    
       <td> Name: <input type="text"  name="name"  size="50" /> </td>
       <td> Mobile: <input type="text"  name="mobile" size="15" /> </td>
       <td>Type:
          <select name="type" style="width: 100px;">
            <option value="Personal">Personal</option>
            <option value="Employee">Employee</option>
            <option value="Customer">Customer</option>
            <option value="Company">Company</option>
            <option value="Others">Others</option>
          </select>
       </td>
</tr>       
<tr align="center">
       <td colspan="3">Address
           <textarea name="address" cols="80" rows="4"></textarea>   
       </td>
 </tr>
 <tr align="center" id="trsubhead">      
   <td colspan="3" ><input type="submit"  name="submit" value="   Save  " /> </td>
 </tr>
 </table>
</form>
<br>
<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Existing List</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Sl No</td>
       <td>Name</td>
       <td>Address</td>
       <td>Mobile</td>
       <td>Type</td>
       <td>Status</td>
       <?if($_SESSION[userType]=='A')
        {
         echo "<td align='center'>Action</td>";
        }
       ?>
  </tr>     
    <?
     if(isset($_POST["search"]))
      {
        $user_query="select * from tbl_customer where name like '%$_POST[name]%' order by name asc";
      }
     else
      {
        $user_query="select * from tbl_lb_database order by name asc";  
      }
      
     
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr>
          <td><?=$count;?></td>
          <td colspan="1"  align="left"><?=$value[id];?> : <?=$value[name];?></td>
          
          <td><?=$value[address];?></td>
          
          <td><?=$value[mobile];?></td>
          <td><?=$value[type];?></td>
          <td>
          <? if($value[status]==0) {echo "Active";}else{ echo "Inactive";}?>
          </td>
          <td align="center"> 
          <?  
            if($_SESSION[userType]=='A')
             {
              ?>
               <!--<a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=customer" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a> 
                &nbsp; | &nbsp; -->
                 <A HREF=javascript:void(0) onclick=window.open('lb_edit_person.php?smsId=<?=$value[id];?>','Accounts','width=600,height=500,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Customer Info"><img src="images/edit.png" height="15px" width="15px"></a>
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

