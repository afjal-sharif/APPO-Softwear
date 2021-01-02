<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
if(isset($_POST["view"]))
 {
  $con='';
  
  $con="where (tbl_com_payment.paydate between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[company]!='')
   {
   $con=$con." and tbl_com_payment.companyid=$_POST[company]";
   }
 
 // Define Status.  
 if ($_POST[cstatus]!='')
   {
   if(($_POST[cstatus]=='N') or ($_POST[cstatus]=='C')or ($_POST[cstatus]=='B')or ($_POST[cstatus]=='W')) 
   {
    $con=$con." and tbl_com_payment.status='$_POST[cstatus]'";
   }
   elseif($_POST[cstatus]=='P')
   {
    $con=$con." and tbl_com_payment.status='N' and tbl_com_payment.cheqdate>curdate()";
   }
   elseif($_POST[cstatus]=='I')
   {
    $con=$con." and tbl_com_payment.bank='Incentive Adjustment'";
   }
   
   }
  
   $user_query="select paydate,tbl_company.name,chequeno,bank,amount,cheqdate,bamount,remarks,tbl_com_payment.status from tbl_com_payment 
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                   $con
                   order by paydate";
 
 }
else
 {
  $user_query="select paydate,tbl_company.name,chequeno,bank,amount,cheqdate,bamount,remarks,tbl_com_payment.status from tbl_com_payment 
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                  where paydate='$_SESSION[dtcompany]'";  
 }
 $_SESSION[printquery]=$user_query;
 
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trhead"><b>Payment To Company Report</b></td></tr>
 <tr>
   <td>From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>

   <td>Status: 
              <select name="cstatus">
                <option value=""></option>
                <option value="N" <?if($_POST[cstatus]=='N') {echo "SELECTED";}?>>Current</option>
                <option value="P" <?if($_POST[cstatus]=='P') {echo "SELECTED";}?>>Post</option>
                <option value="C" <?if($_POST[cstatus]=='C') {echo "SELECTED";}?>>Clear</option>
                <option value="B" <?if($_POST[cstatus]=='B') {echo "SELECTED";}?>>Bounce</option>
                <option value="I" <?if($_POST[cstatus]=='I') {echo "SELECTED";}?>>Incentive Adj</option>
                <option value="W" <?if($_POST[cstatus]=='W') {echo "SELECTED";}?>>Withdraw</option>
             </select>
  
   </td>

  
  
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>

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
  </tr>
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
