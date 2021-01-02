<?php
 session_start();
 include "includes/functions.php";
 $mnuid=433;
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
answer = confirm("Are You Sure To Withdraw Taka from Bank To Cash ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 





<?
if(isset($_POST["submit"]))
 {
  if (!Is_Numeric($_POST[withdraw])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly. </b>";
   }
  else
   {
   $deposite=0;
   $withdraw=$_POST[withdraw];
   $balance=$deposite-$withdraw;
   $bank=$_POST[bank];
   $remarks="Bank To Cash,Cheque :". $_POST[cheque]." ".$_POST[remarks];
   $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
        value('$_POST[demo12]','$remarks',0,$withdraw,$balance,'$_SESSION[userName]','$bank',3)"; 
   db_query($sql) or die(mysql_error());

   $remarks="Cash From Bank($bank),Cheque :". $_POST[cheque]." ".$_POST[remarks];
   $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type) 
        value('$_POST[demo12]','$remarks',$withdraw,0,$balance*(-1),'$_SESSION[userName]',3)"; 
   db_query($sql) or die(mysql_error());
  
   
   echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Cash Withdraw Form Bank And Cash Receive Successfully</b>";
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
      $user_query="Select bankname,branch,accountcode,blimit,sum(deposite-withdraw) as balance from tbl_bank 
                   join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode 
                   where isDPS=1
                   group by  bankname,branch,accountcode";
      $users = mysql_query($user_query);
      
  ?>
  <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
  <tr id="trhead">
     <td>Bank Name</td>
     <td>Branch Name</td>
     <td>Account Code</td>
     <td>Current Balance</td>
     <td>CC Limit</td>
     <td>Balance</td>
  </tr>
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
          <td align="right"><?=number_format($value[blimit],0)?></td>
          <td align="right"><?=number_format($value[balance]+$value[blimit],0)?></td>
        </tr>
       <?
       $bankbal=$bankbal+$value[balance];
       }
?>
</table>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">!!!!--- Current Balance ---!!!!</td></tr>
 <tr id="trsubhead">
     <td colspan="1" id="trsubhead">Cash: </td>
     <td colspan="2" id="trsubhead"><b><?=number_format($cashbal,2);?></b></td>
     <td colspan="1" >Bank: </td>
     <td colspan="2" ><b><?=number_format($bankbal,2);?></b></td>
     <td colspan="2" bgcolor="#FFCD9E"  id="trsubhead">= <?=number_format($cashbal+$bankbal,2);?> Tk.</td>
 </tr>
 <!--<tr id="trsubhead"><td colspan="8">&nbsp;</td></tr>-->
</table>


<?
/*
      $user_query="Select sum(deposite-withdraw) as balance from tbl_bank";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
 */     
?>





<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <!--
 <tr id="trhead"><td colspan="5"><b>Current Bank Balance : Tk. <?=number_format($balance,2);?> </b></td></tr>
 <tr id="trsubhead"><td colspan="5">&nbsp;</td></tr>
 -->
 <tr id="trhead"><td colspan="5">Bank To Cash Deposite</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td> Bank Code.</td><td>Cheque No</td> <td> Remarks </td><td>Withdraw </td> </tr>
    <tr bgcolor="#FFCCAA">  
        <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12" READONLY maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dttransection]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <!--<img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     -->
        </td>
         <td>     
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name where isDPS=1 order by bankname";
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

      <td align="center"> <input type="text"  name="cheque"  size="12"    /> </td>
       <td align="center"><input type="text" name="remarks" value="" size="30" /></td>
       
  
       <td align="center"> <input type="text"  name="withdraw"  size="12"  value=""  /> </td>
     </tr>    
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Account Code</td>
       <td>Remarks</td>
       <td>Deposite</td>
       <td>Withdraw</td> 
       <td>Balance.</td>
       <td>User</td>
       <td>&nbsp;</td>        
      </tr>     
    <?
      $user_query="Select * from tbl_bank where type=0 or type=3 order by id desc limit 0,10";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[bank];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td align="right"><?=number_format($value[balance],2);?></td>
          <td><?=$value[user];?></td>  
          <td align="center"><!--<b><a href="clearbank.php?id=<?=$value[id];?>&mode=banktra" title="Delete">X</a></b>--></td>      
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
