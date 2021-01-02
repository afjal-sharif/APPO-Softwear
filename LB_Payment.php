<?php
 session_start();
 $mnuid="463";
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
answer = confirm("Are You Sure To Save Data ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 




<?
if(isset($_POST["submit"]))
 {
  if ((empty($_POST[remarks]) and empty($_POST[remarksnew])) or !Is_Numeric($_POST[deposite]) or !Is_Numeric($_POST[withdraw])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px' ><b> Error !! Pls give input properly</b>";
   }
  else
   {
   
    $person_id=$_POST[remarks];
   
   $sql="select name from tbl_lb_database where id= '$_POST[remarks]'";
   $users = mysql_query($sql);
   $row_sql= mysql_fetch_assoc($users);
   $msgremarks=$row_sql[name];   
  
   
   /*
   $msgremarks=$_POST[remarks];
   if($msgremarks=='')
    {
    $msgremarks=$_POST[remarksnew];
    }
   else
    {
    $msgremarks=$_POST[remarks];
    } 
   */
   
   $deposite=$_POST[deposite];
   $withdraw=$_POST[withdraw];
   $balance=$deposite-$withdraw;
   $bank=$_POST[bank];
   
   if($bank=='cash')
   {
     $remarks="Loan Payment :".$msgremarks ." ". $_POST[remarks1]; 
     $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
        value('$_POST[demo12]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]')"; 
     db_query($sql) or die(mysql_error());
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Cash Loan Payment to $msgremarks Successfully.</b>";    
   }
   else
   {
     $remarks="Loan Payment :".$msgremarks . " ". $_POST[remarks1];
     $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank) 
        value('$_POST[demo12]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]','$bank')"; 
     db_query($sql) or die(mysql_error());
     echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Bank Loan Payment to $msgremarks Successfully.</b>";
   }
   
   if($deposite>0)
    {
     $description="Borrow From ".$global['owner'];
     $remarks=$msgremarks;
     $sql="insert into tbl_assets_liab (date,description,assets,liab,user,remarks,type,remarks1,person_id,cash_bank) 
        value('$_POST[demo12]','$description',0,$deposite,'$_SESSION[userName]','$remarks',2,'$_POST[remarks1]','$person_id','$bank')"; 
     db_query($sql) or die(mysql_error()); 
    }
   if($withdraw>0)
    {
     $description="Receiveable From ".$global['owner'];
    
     $remarks=$msgremarks;
          
     $sql="insert into tbl_assets_liab (date,description,assets,liab,user,remarks,type,remarks1,person_id,cash_bank) 
        value('$_POST[demo12]','$description',$withdraw,0,'$_SESSION[userName]','$remarks',1,'$_POST[remarks1]','$person_id','$bank')"; 
     db_query($sql) or die(mysql_error());   
    } 
   
   } // Error chech If
 }// Submit If
?>

<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
     
     
      $user_query="Select bankname,branch,accountcode,sum(deposite-withdraw) as balance from tbl_bank 
                   join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode 
                   group by  bankname,branch,accountcode";
      $users = mysql_query($user_query);
      
  ?>
  <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
  <tr id="trhead"><td colspan="4">Current Cash & Bank Balance</td></tr>
  <tr id="trsubhead"><td>Bank Name</td><td>Branch Name</td><td>Account Code</td><td>Balance</td></tr>
  <tr><td>Cash Balance</td><td>-</td><td>-</td><td align="right"><?=number_format($balance,2)?></td></tr>
  
  <?    
      while($value=mysql_fetch_array($users))
       {
       ?>
        <tr>
          <td><?=$value[bankname]?></td>
          <td><?=$value[branch]?></td>
          <td><?=$value[accountcode]?></td>
          <td align="right"><?=number_format($value[balance],2)?></td>
        </tr>
       <?
       }
?>
</table>




<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
  
 <tr id="trhead"><td colspan="4">Lending & Borrowing : Payment Form</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td>Payment From</td><td> Person </td><td>Amount Payment</td></tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]: $_SESSION[dttransection]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>
         <td>     
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="bank"  style="width: 200px;">
           <option value="cash" <?php if($_POST["bank"]=='cash') echo "selected";?>>Cash</option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
        </td> 

 
       <td align="center">
         <?
           $query_sql = "SELECT distinct `remarks` FROM `tbl_assets_liab` WHERE `type`<>3 or `type`<>4  group by `remarks` having sum(`assets`-`liab`)<>0";
           $query_sql = "SELECT id,name,type,address from tbl_lb_database where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="remarks"  style="width: 280px;">
           <option value=""></option>
         <?
             do {  
         ?> 
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["remarks"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?>::<?php echo $row_sql['type']?>::<?php echo $row_sql['address']?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
        <input type="hidden" name="remarksnew" value="" size="20" />
       </td>
       
       <td align="center"> <input type="hidden"  name="deposite"  size="10"  value="0"  />
        <input type="text"  name="withdraw"  size="6"  value="0"  /> </td>
     </tr>    
    <tr bgcolor="#CCAABB">  
       <td  colspan="4" align="center">
          <b>Reamrks:</b> <input type="text" name="remarks1" value="" size="80" />
       </td>
     </tr>      
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>

<!--

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Account Code</td>
       <td>Remarks</td>
       <td>Deposite</td>
       <td>Withdraw</td> 
       <td>Balance.</td>
       <td>User</td>
           
      </tr>     
    <?
      $user_query="Select * from tbl_bank where type=0  and withdraw=0 order by id desc";
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
       </tr>
       <?
       }
      }
    ?>  
 </table>
-->
<?php
 include "footer.php";
?>
