<?php
 session_start();
 $mnuid="452";
 include "includes/functions.php";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Others Assets ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 




<?
if(isset($_POST["submit"]))
 {
  if ((empty($_POST[remarks]) and empty($_POST[remarksnew])) or !Is_Numeric($_POST[amount])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $msgremarks=$_POST[remarks];
   if($msgremarks=='')
    {
    $msgremarks=$_POST[remarksnew];
    }
   else
    {
    $msgremarks=$_POST[remarks];
    } 


      

   
   if($_POST[finance]=='OE')
   {
     $amount=$_POST[amount];
     $description="Others Assets";
     $remarks=$msgremarks;
     $sql="insert into tbl_assets_liab (date,description,assets,liab,user,remarks,type,remarks1,financeby) 
           value('$_POST[demo12]','$description',$amount,0,'$_SESSION[userName]','$msgremarks',4,'$_POST[remarks1]','OE')"; 
     db_query($sql) or die(mysql_error());
         
     
     $description="Owners Equity";
     $remarks=$msgremarks;
     $sql="insert into tbl_assets_liab (date,description,assets,liab,user,remarks,type,remarks1,financeby) 
           value('$_POST[demo12]','$description',0,$amount,'$_SESSION[userName]','$msgremarks',3,'$_POST[remarks1]','OE')"; 
     db_query($sql) or die(mysql_error());   
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Cash Information Insert Successfully</b>";
   }
   else
   {
     $amount=$_POST[amount];
     $description="Others Assets";
     $remarks=$msgremarks;
     $sql="insert into tbl_assets_liab (date,description,assets,liab,user,remarks,type,remarks1,financeby) 
           value('$_POST[demo12]','$description',$amount,0,'$_SESSION[userName]','$msgremarks',4,'$_POST[remarks1]','CASH')"; 
     db_query($sql) or die(mysql_error());
   
     $remarks="Fixed Assets Transection:".$msgremarks ." ". $_POST[remarks1];
     $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
        value('$_POST[demo12]','$remarks',0,$amount,$amount*(-1),'$_SESSION[userName]')"; 
     db_query($sql) or die(mysql_error());
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Cash Information Insert Successfully</b>";
   }
   
   
   } // Error chech If
 }// Submit If
?>



<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="4">Others Assets Entry Form</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td> Assets </td><td> Finance From</td> <td>Amount </td> </tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>

       <td align="center">
          <?
           $query_sql = "SELECT distinct `remarks` FROM `tbl_assets_liab` WHERE `type`=4 group by `remarks` having sum(`assets`-`liab`)<>0";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="remarks"  style="width: 220px;">
           <option value=""></option>
         <?
             do {  
         ?> 
            <option value="<?php echo $row_sql['remarks'];?>" <?php if($_POST["remarks"]==$row_sql['remarks']) echo "selected";?> ><?php echo $row_sql['remarks']?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>

       
       <input type="text" name="remarksnew" value="" size="45" /></td>
       
       <td>
          <select name="finance"  style="width: 120px;">
            <option value="OE">Owners Equity</option>
            <option value="CASH">Cash</option> 
          </select>
          <?
           $query_sql = "SELECT id,head_name from tbl_coa where liabalities=1 order by id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="remarks"  style="width: 220px;">
           <option value=""></option>
         <?
             do {  
         ?> 
            <option value="<?php echo $row_sql['remarks'];?>" <?php if($_POST["remarks"]==$row_sql['remarks']) echo "selected";?> ><?php echo $row_sql['remarks']?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
          
       </td>
       
       <td align="center"> <input type="text"  name="amount"  size="10"  value="0"  /> </td>
     </tr>    
     <tr>
       <td  colspan="4" align="center">
          <b>Reamrks:</b> <input type="text" name="remarks1" value="" size="60" />
       </td>
     </tr> 
     <tr id="trsubhead"><td colspan="4" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit" value="   Save  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Assets</td>
       <td>Remarks</td>
       <td>Finance From</td>
       <td>Amount</td> 
       <td>User</td>
  </tr>     
    <?
      $user_query="Select * from tbl_assets_liab where type=4 order by id desc limit 0,10";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[remarks1];?></td>
          <td><?=$value[financeby];?></td>
          <td align="right"><?=number_format($value[assets],2);?></td>
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
