<?php
 session_start();
 include "includes/functions.php";
 $mnuid="451";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Delete This Transection ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 




<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[income_head]) or !Is_Numeric($_POST[deposite])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $deposite=$_POST[deposite];
   $withdraw=0;
   $balance=$deposite-$withdraw;
 
   if($_POST[bank]=='Cash')
   { 
     $remarks="Others Income: $_POST[income_head] $_POST[remarks]"; 
     $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type,balitem,income_id) 
           value('$_POST[demo12]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]',5,2,'$_POST[income_head]')"; 
     db_query($sql) or die(mysql_error());
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Cash Receive From Others Income Insert Successfully</b>";
   }
   else
   {
     $remarks="Others Income: $_POST[income_head] $_POST[remarks]";
     $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,type,bank,income_id) 
           value('$_POST[demo12]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]',5,'$_POST[bank]','$_POST[income_head]')"; 
     db_query($sql) or die(mysql_error());
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Bank:$_POST[bank] Receive From Others Income Insert Successfully</b>";
   }
   } // Error chech If
 }// Submit If
?>


<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
?>





<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5"><b>Current Cash Balance : Tk. <?=number_format($balance,2);?> </b></td></tr>
 <tr id="trsubhead"><td> Date</td><td>Income Head</td><td> Remarks </td><td>Deposite To</td><td>Amount(Tk)</td></tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12"  maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dttransection]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>   
        </td>
        <td>
          <?
           $query_sql = "SELECT id,name  FROM tbl_income_head order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="income_head" style="width: 220px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value[expensetype]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          
          </select>
         </td> 
       <td align="center"><input type="text" name="remarks" value="" size="30" /></td>
       <td>
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="bank"  style="width: 200px;" onchange="PayMethod()">
             <option value="Cash" <?php if($_POST["bank"]=='Cash') echo "selected";?> >Cash </option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
       </td>
       <td align="center"> <input type="text"  name="deposite"  size="12"  value="0"  /> </td>
       <input type="hidden"  name="withdraw"  size="12"  value="0"  /> 
     </tr>    
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit" value="   Save  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Income Head</td>
       <td>Remarks</td>
       <td>Deposite To</td>
       <td>Deposite</td>
       <td>User</td>
       <td>&nbsp;</td>        
  </tr>     
  <?
      $user_query=" select e.id,e.date,e.stype,e.remarks,e.deposite,e.name,e.user from (
                         Select tbl_cash.id,'Cash' as stype,tbl_cash.date,tbl_cash.remarks,deposite,tbl_cash.user,name 
                         from tbl_cash join tbl_income_head on tbl_cash.income_id=tbl_income_head.id where type=5
                          union all Select tbl_bank.id,bank as stype,tbl_bank.date,tbl_bank.remarks,deposite,tbl_bank.user,name 
                          from tbl_bank join tbl_income_head on tbl_bank.income_id=tbl_income_head.id where type=5 ) 
                          as e
                          order by e.date limit 0,100000";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[stype];?></td>
          <td><?=number_format($value[deposite],2);?></td>
          <td><?=$value[user];?></td>  
          <td align="center"><b><a href="clearbank.php?id=<?=$value[id];?>&mode=othersincome&bank=<?=$value[stype];?>" title="Delete" onclick="ConfirmChoice(); return false;">X</a></b></td>      
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
