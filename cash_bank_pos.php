<?php
 session_start();
 $datePicker=true;
 $mnuid=437;
 include "includes/functions.php";
 include "session.php";
 @checkmenuaccess($mnuid);
 include "header.php";
?>

<?
  if(isset($_POST["submit"]))
   {
    $con1=$_POST[demo11];
   }
  else
   {
    $con1=date("Y-m-d");
    $con1=$_SESSION[dttransection];
   }  
  
  //$con_display=date("Y-m-d");
  
  $_SESSION[con]=$con1; 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trsubhead">  
         <td align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
         <!--
         </td>   
         <td align="center">
         -->&nbsp;&nbsp;&nbsp;
         <input type="submit"  name="submit" value="&nbsp;&nbsp;  View  &nbsp;&nbsp;" /> </td>
     </tr>
     <!--
     <tr>    
         <td align="center"> <b> Date : <? echo $con1; ?></b></td>
         <td align="center"><A HREF=javascript:void(0) onclick=window.open('printtoday.php','POPUP','width=800,height=800,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><img src="images/printer.png" width="35px" height="35px" ></a> </td>
     </tr>
     -->
     
     <tr id="trhead">
       <td colspan="1"><b>Cash & Bank Position</b></td>
     </tr>
</table>
</form>

 
 <!-- Receive Details -->

 <?
         
         $user_query=" select sum(deposite-withdraw) as balance from tbl_cash where date<'$con1'";
         $users_cash_opbal = mysql_query($user_query);
         $sql_cashop= mysql_fetch_assoc($users_cash_opbal);
         $opencash=$sql_cashop[balance];
         
         $user_query=" select sum(deposite) as deposite,sum(withdraw) as withdraw from tbl_cash where date='$con1'";
         $users_cash_opbal = mysql_query($user_query);
         $sql_cashop= mysql_fetch_assoc($users_cash_opbal);
         $deposite=$sql_cashop[deposite];
         $withdraw=$sql_cashop[withdraw];
         $cashclose=$opencash+$deposite-$withdraw;
 ?>
  <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
    <tr id="trsubhead">
      <td>CASH/Bank A/C</td>
      <td>Previous Balance</td>
      <td>Deposite</td>
      <td>Withdraw</td>
      <td>Closing Balance</td>
    </tr>
    <tr align="right">
      <td align="center">Cash</td>
      <td><?=number_format($opencash,2);?></td>
      <td><?=number_format($deposite,2);?></td>
      <td><?=number_format($withdraw,2);?></td>
      <td><?=number_format($opencash+$deposite-$withdraw,2);?></td>
    </tr>
   <?
     $totalcash=$opencash+$deposite-$withdraw;
     // Cash Total.
     
    
     // For bank position
     
     $totalbal=0;
     $totaldep=0;
     $totalwithd=0;
     
     $user_query="select e.bank, sum(e.balance) as bal ,sum(e.deposite) as dep, sum(e.withdraw) as withd from (
                    select concat(bankname,'-',accountcode) as bank,sum(`deposite`-`withdraw`) as balance, 0 as deposite,0 as withdraw from tbl_bank 
                    join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode
                    where `date`<'$con1' and isDPS=1 and isCC=1
                     group by `bank`
                    union all
                    SELECT concat(bankname,'-', accountcode) as bank, 0 as balance,sum(`deposite`) as deposite,sum(`withdraw`) as withdraw FROM `tbl_bank` 
                    join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode
                    where `date`='$con1' and isDPS=1 and isCC=1
                    group by `bank`) as e
                 group by e.bank";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
        while($value=mysql_fetch_array($users))
         {
     ?>
     <tr align="right">
          <td align="center"><?=$value[bank];?></td>
          <td><?=number_format($value[bal],2);?></td>
          <td><?=number_format($value[dep],2);?></td>
          <td><?=number_format($value[withd],2);?></td>
          <td><?=number_format($value[bal]+$value[dep]-$value[withd],2);?></td>
    </tr>
     <?  
       $totalbal=$totalbal+$value[bal];
       $totaldep=$totaldep+$value[dep];
       $totalwithd=$totalwithd+$value[withd]; 
         }            
      }
    
     $totalbank=$totalbal+$totaldep-$totalwithd;
   ?>
   <tr id="trsubhead">
      <td>Total</td>
      <td align="right"><?=number_format($opencash+$totalbal,2);?></td>
      <td align="right"><?=number_format($deposite+$totaldep,2);?></td>
      <td align="right"><?=number_format($withdraw+$totalwithd,2);?></td>   
      <td align="right"><?=number_format($cashclose+$totalbal+$totaldep-$totalwithd,2);?></td>  
   </tr>
   

  <tr><td colspan="5">&nbsp;</td></tr>
   
   
  <?
         
     // For bank position
     
     $cctotalbal=0;
     $cctotaldep=0;
     $cctotalwithd=0;
     
     $user_query="select e.bank, sum(e.balance) as bal ,sum(e.deposite) as dep, sum(e.withdraw) as withd from (
                    select concat(bankname,'-',accountcode) as bank,sum(`deposite`-`withdraw`) as balance, 0 as deposite,0 as withdraw from tbl_bank 
                    join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode
                    where `date`<'$con1' and isDPS=1 and isCC=0
                     group by `bank`
                    union all
                    SELECT concat(bankname,'-', accountcode) as bank, 0 as balance,sum(`deposite`) as deposite,sum(`withdraw`) as withdraw FROM `tbl_bank` 
                    join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode
                    where `date`='$con1' and isDPS=1 and isCC=0
                    group by `bank`) as e
                 group by e.bank";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
        while($value=mysql_fetch_array($users))
         {
     ?>
     <tr align="right">
          <td align="center"><?=$value[bank];?></td>
          <td><?=number_format($value[bal],2);?></td>
          <td><?=number_format($value[dep],2);?></td>
          <td><?=number_format($value[withd],2);?></td>
          <td><?=number_format($value[bal]+$value[dep]-$value[withd],2);?></td>
    </tr>
     <?  
       $cctotalbal=$cctotalbal+$value[bal];
       $cctotaldep=$cctotaldep+$value[dep];
       $cctotalwithd=$cctotalwithd+$value[withd]; 
         }            
      }
    
     $cctotalbank=$cctotalbal+$cctotaldep-$cctotalwithd;
   ?>
   <tr id="trsubhead">
      <td>Total</td>
      <td align="right"><?=number_format($cctotalbal,2);?></td>
      <td align="right"><?=number_format($cctotaldep,2);?></td>
      <td align="right"><?=number_format($cctotalwithd,2);?></td>   
      <td align="right"><?=number_format($cctotalbal+$cctotaldep-$cctotalwithd,2);?></td>  
   </tr> 
   
   
   <tr><td colspan="5">&nbsp;</td></tr>
   
   
   <tr id="trhead">
     <td><b>Cash</b></td>
     <td colspan="2"><b>Saving A/C</b></td>
     <td colspan="2"><b>CC A/C</b></td>
   </tr>  
   <tr align="center">
      <td><b><?=number_format($totalcash,2);?></b></td>   
      <td colspan="2"><b><?=number_format($totalbank,2);?></b></td>
      <td colspan="2"><b><?=number_format($cctotalbank,2);?></b></td>  
   </tr>
   
         
 </table>
 
<?php
 include "footer.php";
?>
