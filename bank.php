<?php
 session_start();
$msgmenu="Bank Account";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add New Bank Account?")
if (answer !=0)
{
window.submit();
}
}	
</script> 


<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[bank]) or empty($_POST[code])) 
   {
    echo " Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_bank_name (bankname,branch,accountcode,user,openingbal,blimit,contactperson,mobile) value('$_POST[bank]','$_POST[branch]','$_POST[code]','$_SESSION[userName]',$_POST[bal],$_POST[limit],'$_POST[contactperson]','$_POST[mobile]')"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Bank Name insert successfully</b>";
   
   if($_POST[bal]>0)
    {
   $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
        value(curdate(),'Opening Balance',$_POST[bal],0,$_POST[bal],'$_SESSION[userName]','$_POST[code]',1)";  
    db_query($sql) or die(mysql_error());
    }
  
  
   } // Error chech If
 }// Submit If
?>






<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="12">Display Existing Bank Account Name</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">
       <td>SL</td>
       <td>Bank Name</td>
       <td>Branch Name</td>
       <td>Account No</td> 
    
       
       <!--<td>Bank Limit</td>-->
       <td>Contact Person</td>
       <td>Mobile No</td>
       
       <td>Company</td>
       <td>Customer</td>
       <td>Saving</td>
       <td>DPS</td>
       <td>CC</td>
       <td>Edit</td>
    </tr>     
 
    <?
      $user_query="select * from tbl_bank_name order by bankname";
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
          <td><?=$value[bankname];?></td>
          <td><?=$value[branch];?></td>
          <td align="center"><?=$value[accountcode];?></td>
         
          <!--<td align="right"><?=number_format($value[blimit],2);?></td>-->
          
          <td><?=$value[contactperson];?></td>
          <td><?=$value[mobile];?></td>
         
         <td align="center"><? echo ($value[isCompany]=='0')?'<img src="images/active.png" width="15px" eight="15px">':"-";?></td>
         <td align="center"><? echo ($value[isCustomer]=='0')?'<img src="images/active.png" width="15px" eight="15px">':"-";?></td>
         <td align="center"><? echo ($value[isSave]=='0')?'<img src="images/active.png" width="15px" eight="15px">':"-";?></td>
         <td align="center"><? echo ($value[isDPS]=='0')?'<img src="images/active.png" width="15px" eight="15px">':"-";?></td>
         <td align="center"><? echo ($value[isCC]=='0')?'<img src="images/active.png" width="15px" eight="15px">':"-";?></td>
         <td>
           <A HREF=javascript:void(0) onclick=window.open('editBank.php?smsId=<?=$value[id];?>','Accounts','width=600,height=500,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Customer Info"><img src="images/edit.png" height="15px" width="15px"></a>
         </td>
       </tr>
       <?
       $count=$count+1;
       }
      }
    ?>  

 </table>
<br>
<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">New Bank Account Entry Form</td></tr>  
    <tr alifn="center">
      <td>Bank</td>
      <td>Branch</td>
      <td>A/C</td>
      <td>Limit</td>
      
      <td>Contact Person</td>
      <td>Mobile</td>
    </tr>
    <tr bgcolor="#FFCCAA">    
       <td><input type="text"  name="bank" size="30" /> </td>
       <td><input type="text"  name="branch"  size="30" /> </td>
       <td><input type="text"  name="code"  size="25" />
               <input type="hidden"  name="bal" size="6" value="0" />
       </td>
       <td><input type="text"  name="limit"  value=0 size="10" /> </td>
       <td><input type="text"  name="contactperson"  size="20" /> </td>
       <td><input type="text"  name="mobile"  size="12" /> </td>       
     </tr>    
     <tr id="trsubhead"><td colspan="7" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>


<?php
 include "footer.php";
?>

