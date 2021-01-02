<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Gift ?")
if (answer !=0)
{
window.submit();
}
}	



function PayMethod()
{
  // alert("javed"); 
 if(document.myForm.cashreceive.checked)
  {
  answer = confirm("Are You Sure To Cash Receive this Incentive Amount?")
  if(answer!=0)
   {
   var orderqty=document.myForm.deposite.value;
   document.myForm.cashamount.disabled=false; 
   document.myForm.store.disabled=false; 
   document.myForm.cashamount.value=orderqty;
   document.myForm.cashexpense.checked=false;
   document.myForm.cashexpense.disabled=true; 
   }
   else
   {
   document.myForm.cashreceive.checked=false;
   document.myForm.cashexpense.disabled=false;
   } 
  }
 else
  {
   document.myForm.cashexpense.disabled=false;
   document.myForm.cashamount.disabled=true; 
   document.myForm.store.disabled=true; 
  } 
}



function PayMethodExp()
{
  // alert("javed"); 
 if(document.myForm.cashexpense.checked)
  {
  answer = confirm("Are You Sure To Expense This Amount From Cash ?")
  if(answer!=0)
   {
   var orderqty=document.myForm.deposite.value;
   document.myForm.cashexpamount.disabled=false;  
   document.myForm.cashexpamount.value=orderqty;
   document.myForm.cashreceive.checked=false;
   document.myForm.cashreceive.disabled=true; 

   }
   else
   {
   document.myForm.cashexpense.checked=false;
   document.myForm.cashreceive.disabled=false;
   } 
  }
 else
  {
   document.myForm.cashexpamount.disabled=true;
   document.myForm.cashreceive.disabled=false;  
  } 
}

</script> 



<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[gift_name]) or !Is_Numeric($_POST[deposite]) or !Is_Numeric($_POST[company]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
   $deposite=$_POST[deposite];
   $company=$_POST[company];
   $mgs=""; 

   $sql="insert into tbl_incentive_gift (date,companyid,remarks,gift_name,value,user) 
         value('$_POST[demo12]',$company,'$_POST[remarks]','$_POST[gift_name]',$deposite,'$_SESSION[userName]')"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Gift Receive Successfully. $msg</b>";
  
   } // Error chech If
 }// Submit If
?>



<form name="myForm" method="post" action="">
<table width="960" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="6">Gift Receive Form</td></tr>  
 <tr id="trsubhead"><td> Date</td><td>Company</td><td>Gift Name</td> <td> Remarks </td><td>Market Value</td></tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           <input type="Text" id="demo12" READONLY maxlength="12" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <!--<img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>   -->  
        </td>
        
       
        <td>
          
          <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company" style="width: 200px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
 
       <td align="center"><input type="text"  name="gift_name" value="" size="40" /></td>
       <td align="center"><input type="text"  name="remarks" value="" size="40" /></td>
       <td align="center"> <input type="text"  name="deposite"  size="8"  value="0"  /> </td>
       
     </tr>    
     
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit" value="   Receive Gift " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Company</td>
       <td>Gift Name</td>
       <td>Remarks</td> 
       <td>Market Value</td>
       <td>User</td>    
   </tr>     
    <?
      $user_query="Select tbl_incentive_gift.id,date_format(tbl_incentive_gift.date,'%d-%m-%Y') as dt,name,gift_name,remarks,value,tbl_incentive_gift.user 
                   from tbl_incentive_gift  join tbl_company on tbl_incentive_gift.companyid=tbl_company.id
                   order by tbl_incentive_gift.id desc limit 0,10";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr align="center">
          <td><?=$value[dt];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[gift_name];?></td>
          <td><?=$value[remarks];?></td>
          
          <td align="right"><?=number_format($value[value],2);?></td>
          
          
          <td><?=$value[user];?></td>  
       <!--
          <td align="center"><b>
          
           <? if($value[type]==1)
            {
           ?>
             <a href="clearbank.php?id=<?=$value[id];?>&mode=incentive" onClick="return (confirm('Are you sure to delete data? YOU MAY LOSE DATA!!!')); return false;" title="Delete">X</a></b>
           <?
            }
           ?>
           
          </td>
       -->   
                
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
