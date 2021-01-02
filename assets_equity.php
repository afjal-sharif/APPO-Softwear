<?php
 session_start();
 $mnuid="452";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 @checkmenuaccess($mnuid);
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Others Investment ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if ((empty($_POST[remarks]) and empty($_POST[finance_from]) and empty($_POST[deposite_to]) )  or !Is_Numeric($_POST[amount])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   
   if($_POST[finance_from]=='O-:OE')
   {
     $amount=$_POST[amount];
     $remarks=$_POST[remarks];
     $sql="insert into tbl_investment (date,source,destination,remarks,deposite,user,type) 
           value('$_POST[demo12]','$_POST[finance_from]','$_POST[deposite_to]','$remarks',$amount,'$_SESSION[userName]',1)"; 
     db_query($sql) or die(mysql_error());
              
     $description="Business Capital";
     $sql="insert into tbl_assets_liab (date,description,assets,liab,user,remarks,type,remarks1,financeby) 
           value('$_POST[demo12]','$description',0,$amount,'$_SESSION[userName]','Business Capital',3,'$_POST[remarks]','OE')"; 
     db_query($sql) or die(mysql_error());   
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Owner Equity Increase</b>";
     
     if($_POST[deposite_to]=='C-:CASH')
      {
       $remarks="OE To Cash: ".$_POST[remarks];
       $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type) 
            value('$_POST[demo12]','$remarks',$amount,0,$amount,'$_SESSION[userName]',3)"; 
       db_query($sql) or die(mysql_error());
       echo "<b><img src='images/active.png' height='15px' width='15px'> &nbsp; Cash Deposited from OE.</b>";
      }
      else
      {
       $remarks="OE To Bank ".$_POST[remarks];
       $bank=$_POST[deposite_to];
       $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
             value('$_POST[demo12]','$remarks',$amount,0,$amount,'$_SESSION[userName]','$bank',3)"; 
       db_query($sql) or die(mysql_error());
       echo "<b><img src='images/active.png' height='15px' width='15px'> &nbsp; Bank Deposited from OE.</b>";
      }
    }
   else
   {
    $strtype=substr($_POST[finance_from],0,3);
    $finby=substr($_POST[finance_from],3);
    if($strtype=='L-:')
    {
     $amount=$_POST[amount];
     $remarks=$_POST[remarks];
     
     
     $remarks=$_POST[deposite_to]." ". $_POST[remarks];
     $sql="insert into tbl_account_coa(date,ref_id,remarks,deposite,withdraw,balance,user,type) 
        value('$_POST[demo12]','$finby','$remarks',$amount,0,$amount,'$_SESSION[userName]',2)"; 
     db_query($sql) or die(mysql_error());
      
     $sql="insert into tbl_investment (date,source,destination,remarks,deposite,user,type) 
           value('$_POST[demo12]','$_POST[finance_from]','$_POST[deposite_to]','$_POST[remarks]',$amount,'$_SESSION[userName]',3)"; 
     db_query($sql) or die(mysql_error());
              
     
     if($_POST[deposite_to]=='C-:CASH')
      {
       $remarks="$finby To Cash: ".$_POST[remarks];
       $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type) 
            value('$_POST[demo12]','$remarks',$amount,0,$amount,'$_SESSION[userName]',3)"; 
       db_query($sql) or die(mysql_error());
       echo "<b><img src='images/active.png' height='15px' width='15px'> &nbsp; Cash Deposited from $finby.</b>";
      }
      else
      {
       $remarks="$finby To Bank ".$_POST[remarks];
       $bank=$_POST[deposite_to];
       $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
             value('$_POST[demo12]','$remarks',$amount,0,$amount,'$_SESSION[userName]','$bank',3)"; 
       db_query($sql) or die(mysql_error());
       echo "<b><img src='images/active.png' height='15px' width='15px'> &nbsp; Bank Deposited from $finby.</b>";
      }
    }
   }
   } // Error chech If
 }// Submit If
?>



<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="4">Others Investment</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td>Finance From</td><td>Deposite To</td> <td>Amount</td></tr>
 <tr bgcolor="#CCAABB" align="center">
    <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12" maxlength="12" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>
     <td>
        <select name="finance_from"  style="width: 250px;">    
          <option value="O-:OE">Owners Equity</option>
         <?
           $query_sql = "SELECT id,head_name from tbl_coa where liabalities=1 order by id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
             do {
          ?>      
            <option value="L-:<?php echo $row_sql['id'];?>::<?php echo $row_sql['head_name'];?>"><?php echo $row_sql['head_name']?></option>     
          <?
                 } while ($row_sql = mysql_fetch_assoc($sql));    
         ?>
          </select>
       </td>     
       <td>
          <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name where isDPS=1  order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="deposite_to"  style="width: 250px;">
            <option value="C-:CASH">Cash</option> 
         <?
             do {  
         ?> 
            <option value="<?php echo $row_sql['accountcode'];?>"><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
            
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
          
       </td>
       

       <td align="center"> <input type="text"  name="amount"  size="10"  value="0"  /> </td>
     </tr>    
     <tr>
       <td  colspan="4" align="center">
          <b>Reamrks:</b> <input type="text" name="remarks" value="" size="80" />
       </td>
     </tr> 
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit" value="   Save  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Finance From</td>
       <td>Deposite To</td>
       <td>Remarks</td>
       <td>Amount</td> 
       <td>User</td>
  </tr>     
    <?
      $user_query="Select * from tbl_investment order by id desc limit 0,10";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr align="center">
          <td><?=$value[date];?></td>
          <td><?=$value[source];?></td>
          <td><?=$value[destination];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
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
