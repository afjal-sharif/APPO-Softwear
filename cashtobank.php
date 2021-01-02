<?php
 session_start();
 $mnuid=432;
 include "includes/functions.php";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>
<!--  Meeting Info Details Here -->
<script language="JavaScript">
function Total()
{
qty=eval(document.myForm.qty.value);
rate=eval(document.myForm.rate.value);
document.myForm.total.value=qty*rate;
}
</script>


<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Deposite Taka from Cash To Bank ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 




<?
if(isset($_POST["submit"]))
 {
  
  if (!Is_Numeric($_POST[deposite]) or ($_POST[deposite]<=0)) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly. </b>";
   }
  else
   {
   $withdraw=0;
   $deposite=$_POST[deposite];
   $balance=$deposite-$withdraw;
   $bank=$_POST[bank];
   $remarks="Cash Deposite From Cash ".$_POST[remarks];
   $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
        value('$_POST[demo12]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]','$bank',3)"; 
   db_query($sql) or die(mysql_error());

   $remarks="Cash To Bank ($bank)".$_POST[remarks];
   $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type) 
        value('$_POST[demo12]','$remarks',0,$deposite,$balance,'$_SESSION[userName]',3)"; 
   db_query($sql) or die(mysql_error());
  
   
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Cash Deposite Form Cash To Bank Successfully</b>";
   } // Error chech If
 }// Submit If
?>

<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $cashbal=$row_sql[balance];
?>

<?
      $user_query="Select bankname,branch,accountcode,sum(deposite-withdraw) as balance from tbl_bank 
                   join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode 
                   group by  bankname,branch,accountcode";
      $users = mysql_query($user_query);
      
  ?>
  <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
  <tr id="trhead"><td>Bank Name</td><td>Branch Name</td><td>Account Code</td><td>Balance</td></tr>
  <?  
  $bankbal=0;  
      while($value=mysql_fetch_array($users))
       {
       ?>
        <tr>
          <td><?=$value[bankname]?></td>
          <td><?=$value[branch]?></td>
          <td><?=$value[accountcode]?></td>
          <td align="right"><?=number_format($value[balance],0)?></td>
        </tr>
       <?
       $bankbal=$bankbal+$value[balance];
       }
?>
</table>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">!!!!--- Current Balance ---!!!!</td></tr>
 <tr id="trsubhead">
     <td colspan="1">Cash: </td>
     <td colspan="2"><b><?=number_format($cashbal,2);?></b></td>
     <td colspan="1"  id="trsubhead">Bank: </td>
     <td colspan="2"  id="trsubhead"><?=number_format($bankbal,2);?></td>
     <td colspan="2" bgcolor="#FFCD9E"  id="trsubhead">= <?=number_format($cashbal+$bankbal,2);?> Tk.</td>
 </tr>
 <!--<tr id="trsubhead"><td colspan="8">&nbsp;</td></tr>-->
</table>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <!--
 <tr id="trhead"><td colspan="5"><b>Current Bank Balance : Tk. <?=number_format($balance,2);?> </b></td></tr>
 <tr id="trsubhead"><td colspan="5">&nbsp;</td></tr>
 -->
 <tr id="trhead"><td colspan="4">Cash To Bank Deposite</td></tr>  
 
 <tr id="trsubhead"><td> Date</td> <td> Remarks </td><td> Bank Code.</td><td>Deposite</td> </tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12" READONLY maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dttransection]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <!-- <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>  -->    
        </td>
       <td align="center"><input type="text" name="remarks" value="" size="30" /></td>
         <td>     
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="bank"  style="width: 180px;">
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
        </td> 

      <!--<td align="center"> <input type="text"  name="cheque"  size="12"    /> </td>-->
       
       <input type="hidden" name="cashbal" value="<?=$cashbal;?>"  />
  
       <td align="center"> <input type="text"  name="deposite"  size="12"  value=""  /> </td>
     </tr>    
     <tr id="trsubhead"><td colspan="4" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Save  " /> </td> </tr>
</table>
</form>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Remarks</td>
       <td>Deposite</td>
       <td>Withdraw</td> 
       <td>Balance.</td>
       <td>User</td>
  </tr>     
    <?
      $user_query="Select * from tbl_cash where type=0 or type=3 order by id desc limit 0,10";
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
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td align="right"><?=number_format($value[balance],2);?></td>
          <td><?=$value[user];?></td>  
                
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
