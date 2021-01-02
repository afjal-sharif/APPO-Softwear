<?php
 session_start();
 include "includes/functions.php";
 $mnuid="402";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Adjust Payments ?")
if (answer !=0)
{
window.submit();
}
}	

function OnChangeLoad()
{
 window.submit();
}	


function PayMethodPay()
{
  
 if(document.autoad.doreceive.checked)
  {
  answer = confirm("Are You Sure To Payment Clear From Your Bank ?")
  if(answer!=0)
   {
   }
   else
   {
   document.autoad.doreceive.checked=false;
   } 
  }
}




function PayMethod()
{
 var mtype;
 
 mtype=document.autoad.bank.value;
  
 if(mtype=="Cash")
  {  
  //document.autoad.chequeno.disabled=true;  
  //document.autoad.demo12.disabled=true;
  document.autoad.chequeno.value="Cash"; 
  document.autoad.doreceive.disabled=true; 
  }
 else if(mtype=="Incentive Adjustment")
  {
   document.autoad.chequeno.value="Incentive Adjustment"; 
   document.autoad.doreceive.disabled=true; 
   //document.autoad.chequeno.disabled=false;
   //document.autoad.demo12.disabled=false;
  }
  else
  {
   document.autoad.chequeno.value="";
   document.autoad.doreceive.disabled=false; 
  } 
}


</script> 


<?
if(isset($_POST["submit"])and $_SESSION[newflag]==true)
 {
  
  $cheqno=ltrim($_POST[chequeno]);
  if (empty($_POST[demo11]) or empty($_POST[bank]) or empty($_POST[amount]) or empty($cheqno)or empty($_POST[demo12])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   
      
      $rembal=$_POST[amount];  
      $bank=$_POST[bank];
      $customer=$_POST[cid];
      $chequeno=$_POST[chequeno];
      $chequedate=$_POST[demo12];
      $lasttdate=$_POST[demo11];
      $remarks=$_POST[remarks];
      $custid=$_POST[cid];
      
      $sql="select name from tbl_company where id=$custid";
      $users_sql = mysql_query($sql);
      $sql_name= mysql_fetch_assoc($users_sql);
      $company=$sql_name[name]; 
        
           
      if(($_POST[bank]=='Cash') or ($_POST[bank]=='Incentive Adjustment'))
        {
        $sql="insert into tbl_com_payment (paydate,donumber,amount,chequeno,cheqdate,bank,user,remarks,status,bamount,companyid) 
        value('$_POST[demo11]','-',$rembal,'$_POST[chequeno]','$_POST[demo12]','$_POST[bank]','$_SESSION[userName]','$_POST[remarks]','C',$rembal,$custid)"; 
        db_query($sql) or die(mysql_error());
        
        
        
        }
        else
        {
          if($_POST[doreceive]==on)
           {
            $status='C';
            $bamount=$rembal;
           }
          else
           {
            $status='N';
            $bamount=0;
           } 
           
        $sql="insert into tbl_com_payment (paydate,donumber,amount,bamount,status,chequeno,cheqdate,bank,user,remarks,companyid) 
        value('$_POST[demo11]','-',$rembal,$bamount,'$status','$_POST[chequeno]','$_POST[demo12]','$_POST[bank]','$_SESSION[userName]','$_POST[remarks]',$custid)"; 
        db_query($sql) or die(mysql_error());  
        }
      
      // If Rem Bal has then auto matic go to Advance Paymanes.
      
     if($_POST[bank]=='Incentive Adjustment')
      {
       $companyid=$_REQUEST[cid];
       $remarks="Incentive Adjust: $company, $_POST[chequeno]  $_POST[remarks]";
       $sql="insert into tbl_incentive(date,companyid,donumber,remarks,withdraw,user,type,ttype) values('$_POST[demo11]',$companyid,'$_POST[donumber]','$remarks',$_POST[amount],'$_SESSION[userName]',1,'Incentive Adjust')";
       db_query($sql) or die(mysql_error());
      }
      if($_POST[bank]=='Cash')
      {
       $sql="select max(id) as id from tbl_com_payment where user='$_SESSION[userName]'";
       $users_id = mysql_query($sql);
       $row_sql_id= mysql_fetch_assoc($users_id);
       $tid=$row_sql_id[id];
      
      
       $remarks="Purchase:Payment to : $company  $_POST[remarks]";
       $sql="insert into tbl_cash (date,remarks,withdraw,user,type,refid) values('$_POST[demo11]','$remarks',$_POST[amount],'$_SESSION[userName]',3,'$tid')";
       db_query($sql) or die(mysql_error());
      }
      elseif($_POST[doreceive]==on)
      {
       
        $sql="select max(id) as id from tbl_com_payment where user='$_SESSION[userName]'";
        $users_id = mysql_query($sql);
        $row_sql_id= mysql_fetch_assoc($users_id);
        $tid=$row_sql_id[id];
       
        $remarks="Purchase: On Line Clear.$company Cheque: $chequeno $_POST[remarks]";
        $sql="insert into tbl_bank (date,remarks,withdraw,user,type,bank,rec_ref_id) values('$_POST[demo11]','$remarks',$_POST[amount],'$_SESSION[userName]',3,'$bank','$tid')";
        db_query($sql) or die(mysql_error());
      }
      
    echo "<img src='images/active.png' height='15px' width='15px'><b>Payment Adjust Successfully. $msg</b>";
    $_SESSION[newflag]=false;
   } // Error chech If
 }// Submit If
?>




<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_bank";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $bank_balance=$row_sql[balance];

      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $cash_balance=$row_sql[balance];

?>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 
 <tr id="trhead">
     <td colspan="4">Current Cash : Tk. <?=number_format($cash_balance,2);?> </td>
     <td colspan="5">Current Bank : Tk. <?=number_format($bank_balance,2);?> </td>
    </tr>
 <tr id="trsubhead">
             <td colspan="9" align="left">
             <form name="autopay" method="post" onchange="this.submit()" action="autopaybalcom.php" >
              Company: 
             <?
               $query_sql = "SELECT id,name  FROM tbl_company where status<>2 order by name";
               $sql = mysql_query($query_sql) or die(mysql_error());
               $row_sql = mysql_fetch_assoc($sql);
               $totalRows_sql = mysql_num_rows($sql);    
             ?>
              <!--<select name="company" onchange="htmlData('prod.php', 'ch='+this.value)" style="width: 150px;">-->
              <select name="company" style="width: 250px;">
                <option value=""></option>
          <?
             do {  
          ?>
                <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
             </select>
             <input type="submit" name="view" value= "  View  "> </td>
             </form>
            </td>
 </tr>
 <?
 if(isset($_POST["company"]))
  {
  $_SESSION[newflag]=true;
  ?>
    <form name="autoad" method="post" action="">
     <tr bgcolor="#FFCCAA">  
         <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo11"   maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
        </td>
        
        <td colspan="2">     
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name where isCompany=0 order by bankname";
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
            <option value="Incentive Adjustment" <?php if($_POST["bank"]=='Incentive Adjustment') echo "selected";?> >Incentive Adjustment</option>
          </select>
        </td> 
        <td colspan="2">
          <input type="hidden" name="cid" value="<?=$_POST[company];?>">
          Cheque No:<input type="text" name="chequeno" value="Cash" size="12" />
       </td>  
       <td colspan="2">Amount :<input type="text"  name="amount"  size="12"  /> </td>
       <td colspan="2" align="left"> 
           Cheque Date :<input type="Text" id="demo12" maxlength="12" size="12"  value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>

     </tr> 
     <tr bgcolor="#FFCCAA">
         <td colspan="7" align="center">Remarks :<input type="text"  name="remarks" size="60" /> </td> 
         <td colspan="2" align="center">On-Line Cash/DD/TT <input type="checkbox" name="doreceive"  disabled onchange="PayMethodPay()" /></td>
      </tr>  
     <tr id="trsubhead"><td colspan="9" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Adjust  " /> </td> </tr>
    </form>
 </table>
 <?php 
  }
 ?>
 
 
 <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="9"><b>Today Payment To Company</b></td></tr> 
   <tr id="trsubhead">    
       <td>Date</td>
       <td>Company</td>
       <td>Cheque No</td>
       <td>Cash/Bank</td>
       <td>Amount</td>
       <td>Status</td>
       <td>BC Amount</td>
       <td>Cheque Date</td>
       <td>Remarks</td>
   </tr>     
    <?
      $user_query="select paydate,tbl_company.name,chequeno,bank,amount,cheqdate,bamount,remarks,tbl_com_payment.status from tbl_com_payment 
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                  where paydate='$_SESSION[dtcompany]'";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          
          <td><?=$value[paydate];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[chequeno];?></td>
          <td align="center"><?=$value[bank];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>
           <td align="center"><?=$value[status];?></td>
          <td align="right"><?=number_format($value[bamount],2);?></td>  
          <td align="right">
           <? 
           if(($value[bank]=='Cash') or ($value[bank]=='Incentive Adjustment'))
           {
           echo "&nbsp;";
           }
           else
           {
            echo $value[cheqdate];
           }
           ?>
          </td>
          <td align="right"><?=$value[remarks];?></td> 
       </tr>
       <?
       $totalbcamount=$totalbcamount+$value[bamount];
       $totalamount=$totalamount+$value[amount];
       }
      }
    ?>  
 <tr id="trsubhead">
   <td colspan="3"> Total Amount</td>
   <td colspan="2" align="right"><?=number_format($totalamount,2);?> <?=$unit;?></td>
   <td colspan="2" align="right"><?=number_format($totalbcamount,2);?></td>
   <td colspan="2">&nbsp;</td>
 </tr>
 </table>




<?php
 include "footer.php";
?>
