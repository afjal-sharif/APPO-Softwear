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
answer = confirm("Are You Sure To Pay this amount ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if ((empty($_POST[pay_head]) and empty($_POST[pay_from])) or !Is_Numeric($_POST[amount])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   $msgremarks=$_POST[remarks];
   
    $strpos=strpos($_POST[pay_head],':::');
    $ref_id=substr($_POST[pay_head],0,$strpos);
    $remarks=substr($_POST[pay_head],$strpos+3);
             
  if($_POST[pay_from]=='C-:CASH')
   {
     $amount=$_POST[amount];
     
     //$remarks="Cash- ".$msgremarks;
     $sql="insert into tbl_account_coa(date,ref_id,remarks,deposite,withdraw,user,type,exp_pro,exp_source) 
           value('$_POST[demo12]','$ref_id','$remarks',0,$amount,'$_SESSION[userName]',2,1,'CASH')"; 
     db_query($sql) or die(mysql_error());
   
     $remarks="Exp Pro Clear: Ref ID:". $_POST[pay_head]." ".$msgremarks;
     $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
        value('$_POST[demo12]','$remarks',0,$amount,$amount*(-1),'$_SESSION[userName]')"; 
     db_query($sql) or die(mysql_error());
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Expense Probition Clear From Cash.</b>";
   }
   else
   {
    $strtype=substr($_POST[pay_from],0,3);
    $finby=substr($_POST[pay_from],3);
    if($strtype=='B-:')
    {
     $amount=$_POST[amount];
     
     //$remarks="Bank- $_POST[pay_from] ".$msgremarks;
     $sql="insert into tbl_account_coa(date,ref_id,remarks,deposite,withdraw,user,type,exp_pro,exp_source) 
           value('$_POST[demo12]','$ref_id','$remarks',0,$amount,'$_SESSION[userName]',2,1,'$finby')"; 
     db_query($sql) or die(mysql_error());
   
     $remarks="Exp Pro Clear: Ref ID:". $_POST[pay_head]." ".$msgremarks;
     $sql="insert into tbl_bank(date,bank,remarks,deposite,withdraw,balance,user) 
        value('$_POST[demo12]','$finby','$remarks',0,$amount,$amount*(-1),'$_SESSION[userName]')"; 
     db_query($sql) or die(mysql_error());
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Expense Probition Clear From Bank $finby</b>";
    }
   }
   } // Error chech If
 }// Submit If
?>



<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="5">Probition Expense Payment</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td>Expense Probition Head</td><td> Pay From</td> <td>Amount</td></tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo12" maxlength="12" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>

       <td align="center">
         <?   
           $query_sql = "SELECT head_name,ref_id,remarks,sum(deposite-withdraw) as balance FROM tbl_account_coa 
                               join tbl_coa on ref_id=tbl_coa.id
                               where tbl_account_coa.type=2 and tbl_account_coa.exp_pro=1 group by ref_id,remarks";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="pay_head"  style="width: 320px;">
           <option value=""></option> 
         <?
             do {  
         ?> 
            <option value="<?php echo $row_sql['ref_id'];?>:::<?php echo $row_sql['remarks'];?>"><?php echo $row_sql['head_name']?>::<?php echo $row_sql['remarks']?> :: Bal Amount :<?php echo number_format($row_sql['balance'],2)?>  </option>
            
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
        
         ?>
          </select>        
       </td>
       <td>
         <?   
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name  order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="pay_from"  style="width: 220px;">
            <option value="C-:CASH">Cash</option> 
            
         <?
             do {  
         ?> 
            <option value="B-:<?php echo $row_sql['accountcode'];?>"><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
            
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
        
         ?>
          </select>
          
       </td>
       
       <td align="center"> <input type="text"  name="amount"  size="10"  value="0"  /> </td>
     </tr>    
     <tr>
       <td  colspan="4" align="center">
          <b>Reamrks:</b> <input type="text" name="remarks1" value="" size="80" />
       </td>
     </tr> 
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit" value="   Save  " /> </td> </tr>
</table>
</form>

  <div id="div_pay_head">     
  
  </div>

  <script type="text/javascript" src="sp.js"></script>



<?php
 include "footer.php";
?>
