<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add expense ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 


<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[company]) or !Is_Numeric($_POST[amount])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
   $withdraw=0;
   $deposite=$_POST[amount];
   $balance=$deposite-$withdraw;
   
   
      
   if($_POST[bank]=='CASH')
    {
      
      $remarks="Incentive-CID-".$_POST[company]." ".$_POST[remarks];
      
      $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
        value('$_POST[demo11]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]')"; 
      db_query($sql) or die(mysql_error());
      echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Cash Receive</b><br>";
      
    }
   else
    {
       $bank=$_POST[bank];
       $remarks="Incentive-CID-".$_POST[company]." ".$_POST[remarks];
       $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank) 
        value('$_POST[demo11]','$remarks',$deposite,$withdraw,$balance,'$_SESSION[userName]','$bank')"; 
       db_query($sql) or die(mysql_error());
       echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Bank Deposite Successfully</b><br>";
       
    }
    $sql="insert into tbl_incentive (date,ttype,companyid,remarks,deposite,withdraw,user,type) 
         value('$_POST[demo11]','Incentive Adjust',$_POST[company],'$remarks',$withdraw,$deposite,'$_SESSION[userName]',1)"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Incentive Balance Adjusted</b>"; 
      
   } // Error chech If
 }// Submit If
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr bgcolor="#CCAABB" id='trsubhead'>  
        <td align="left"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>       
        </td>  
       <td>Company: 
            <?
           $query_sql = "Select tbl_incentive.companyid,name,sum(deposite-withdraw) as balance from tbl_incentive 
                      join tbl_company on tbl_incentive.companyid=tbl_company.id
                      group by tbl_incentive.companyid
                      having sum(deposite-withdraw)>0";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company" style="width:250px">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['companyid'];?>" <?php if($_POST["company"]==$row_sql['companyid']) echo "selected";?> ><?php echo $row_sql['name']?>::Amount:<?=number_format($row_sql[balance]);?> </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
       </td>       
       <td> Receive Amount :<input type="text"  name="amount" size="10" value="" /> </td>
     </tr>
     <tr>
       <td align="center" colspan="2">Remarks:<input type="text" name="remarks" size="60" /></td>
       <td>Deposite to:
       <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name  order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="bank"  style="width: 200px;">
               <option value="CASH" <?php if($_POST[bank]=='CASH') echo "SELECTED";?>>CASH - DEPOSITE</option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
        </td>
     </tr>
     <tr id="trsubhead"><td colspan="3" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>

<br>
<!-- Order Details -->

 <?
      if($_POST[company]!='')
      {
      $user_query="Select tbl_incentive.id,ttype,date_format(tbl_incentive.date,'%d-%M-%Y') as dt,tbl_incentive.donumber,name,remarks,deposite,withdraw,tbl_incentive.user,type from tbl_incentive  join tbl_company on tbl_incentive.companyid=tbl_company.id
                   where tbl_incentive.companyid='$_POST[company]' 
                   order by tbl_incentive.id desc limit 0,10";
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      }
      else
      {
      $total=0;
      }
      
      if ($total>0)
      {
      $bal=0;
      $debit=0;
      $credit=0;
      $totalbal=0;
      
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="6">Incentive Details.</td></tr>
<tr bgcolor="#FFCCAA">
    <td align="center">Date</td>
    <td align="center">Type</td>
    <td align="center">Company</td>    
    <td align="center">Description</td>
    <td align="center">Receive</td>
    <td align="center">Adjusted</td>
</tr>          
 <?
      while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td align="center"><?=$value[dt];?></td>
          <td align="center"><?=$value[ttype];?></td>
          <td align="center"><?=$value[name];?></td>
          <td align="center"><?=$value[remarks];?></td>
          <td align="center"><?=number_format($value[deposite],2);?></td>
          <td align="center"><?=number_format($value[withdraw],2);?></td>
  
      <? 
               
        $debit=$debit+$value[deposite];
        $credit=$credit+$value[withdraw];
        $bal=($debit-$credit);
        $totalbal=$bal; 
        }      
      ?>
       </tr>
       <tr id="trsubhead" align="center">
          <td colspan="2">Total </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?=number_format($debit,2);?></td>
          <td><?=number_format($credit,2);?></td>
       </tr>
   <tr id="trsubhead" align="center">
          <td colspan="3">Balance :</td>
          <td colspan="3" align="center">= <?=number_format($totalbal,2);?> Tk.</td>
       </tr>
       
       
  <?
       
       
       
       
   echo "</table>";
    }
  ?>  

 
 
<?php
 include "footer.php";
?>
