<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $msg="";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Data In Database ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 





<!-- Opening Bank Blance  Update..-->
<?
if(isset($_POST["submitbank"]))
 {
  if (empty($_POST[bank]) or empty($_POST[amount]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' weight='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
    $updatesql="update tbl_bank_name set openingbal=$_POST[amount] where accountcode='$_POST[bank]'";
    db_query($updatesql);
    $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
        value(curdate(),'Opening Balance',$_POST[amount],0,$_POST[amount],'$_SESSION[userName]','$_POST[bank]',9)";  
    db_query($sql) or die(mysql_error());
    echo "<img src='images/active.png' height='15px' width='15px'><b> A/C : $_POST[bank] Opeining Balance Update Successfully.</b>";
   } 
 }
?>

 
<!-- Bank Amount Update -->
<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
  <tr id="trhead"><td align="left" colspan="2"><img src="images/4.jpg">  Bank Opening Balance</td></tr>
    <tr bgcolor="#FFCCAA">  
        
        <td>
         Bank Account: 
          <?
           $query_sql = "SELECT * FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="bank"  style="width: 250px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']." - ".$row_sql['branch']." - ".$row_sql['accountcode'] ;?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>     
       <td><input type="text"  name="amount"  size="12"     /></td>      
       
     </tr>    
    <tr id="trsubhead"><td colspan="2" align="center"><input type="submit"  name="submitbank" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>












<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="4">Opening Bank Balance</td></tr>  
   <tr bgcolor="#FFCCAA">    
       <td>Bank Name</td>
       <td>Branch</td>     
       <td>Account Code</td>     
       <td> Opening Balance</td>   
    </tr>     
     <?
      $user_query="select * from tbl_bank_name where openingbal<>0 order by bankname";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       
       <tr>
          <td><?=$value[bankname];?></td>
          <td><?=$value[branch];?></td>
          <td align="center"><?=$value[accountcode];?></td>
          <td align="right"><?=number_format($value[openingbal],2);?></td>
       </tr>
       <?
       $sumtotal=$sumtotal+$value[openingbal];
       }
      }
    ?> 
    <tr id="trsubhead"><td colspan="4" align="right"><b>Total : <?=number_format($sumtotal,2);?></b> </td></tr> 
 </table>



<br><br>
<!-- Opening Cash Blance  Update..-->
<?
if(isset($_POST["submitcash"]))
 {
  if (empty($_POST[amount]) or $_POST[amount]<0 ) 
   {
    echo "<img src='images/inactive.png' height='15px' weight='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
    
      // Find Bank Open Balance.     
      $user_query="Select sum(openingbal) as balance from tbl_bank_name";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      
      $bankbal=abs($row_sql[balance]);
     
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $cashbal=abs($row_sql[balance]);
      
      
      $totalequity=$bankbal+$cashbal+$_POST[amount];
      
      $sql="insert into tbl_open_bal (companyid,productid,qty,amount,type) 
        value(0,0,0,$_POST[amount],5)"; 
      db_query($sql) or die(mysql_error());

      
      $sql="insert into tbl_assets_liab (date,description,assets,liab,user,type,remarks) 
        value(curdate(),'Owners Equity',0,$totalequity,'$_SESSION[userName]',3,'Business Capital')"; 
      db_query($sql) or die(mysql_error());

      $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type) 
        value(curdate(),'Cash Owner Equity',$cashbal,0,$cashbal,'$_SESSION[userName]',11)"; 
      db_query($sql) or die(mysql_error());
      
      $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type) 
        value(curdate(),'Cash Opening Balance',$_POST[amount],0,$_POST[amount],'$_SESSION[userName]',10)"; 
      db_query($sql) or die(mysql_error());     
    echo "<img src='images/active.png' height='15px' width='15px'><b> Cash Opeining Balance Insert Successfully.</b>";
   } 
 }
?>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td align="left" colspan="2"><img src="images/5.jpg"> Opening Cash Balance</td></tr>  
   <tr bgcolor="#FFCCAA">    
       <td>Opening Balance</td>
       <td align="center">Amount</td>        
    </tr>     
     <?
     $sumtotal=0;
      $user_query="select * from tbl_open_bal where companyid=0";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td>Opeining Balance</td>         
          <td align="center"><?=number_format($value[amount],2);?></td>
       </tr>
       <?
       $sumtotal=$sumtotal+$value[amount];
       }
      }
      
    ?>  
    <tr id="trsubhead"><td colspan="2" align="right"><b>Total : <?=number_format($sumtotal,2);?></b> </td></tr>
 </table>
<!-- Cash Amount Update -->
<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <!--<tr id="trhead"><td colspan="6">Company Opening Balance</td></tr>  -->
    <tr bgcolor="#FFCCAA">  
        
        <td align="right"> Opening Balance
        </td>     
       <td><input type="text"  name="amount"  size="12"     /></td>      
       
     </tr>    
    <tr id="trsubhead"><td colspan="2" align="center"><input type="submit"  name="submitcash" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>

<?php
 include "footer.php";
?>
