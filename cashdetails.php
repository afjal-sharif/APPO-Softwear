<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
    if(isset($_POST["view"]))
    {
      
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
      
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash where tbl_cash.date<'$_POST[demo11]'";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $Openbalance=$row_sql[balance];
      $OpenBalanceSub=$Openbalance;
      
    }
    else
    {
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
      
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash where tbl_cash.date<curdate()";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $Openbalance=$row_sql[balance];
      $OpenBalanceSub=$Openbalance;
      
    }  
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Cash Transection Details Report</b></td></tr>
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
   
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>

<br>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Current Cash Balance : Tk. <?=number_format($balance,2);?> </td></tr>
 <!--<tr id="trsubhead"><td colspan="8">&nbsp;</td></tr>-->

 <tr id="trhead"><td colspan="6">Display Cash  Transection</td></tr> 
  
  <?
         echo "<tr id='trsubhead'><td colspan='4' align='left'>Previous Balance : </td><td align='right' colspan='2'>".number_format($Openbalance,2)."</td></tr>";  
  ?>
  

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <!--<td>Account Code</td>-->
       <td>Remarks</td>
       <td>Deposite</td>
       <td>Withdraw</td> 
       <td>Balance</td> 
       <td>User</td>
       <!--<td>&nbsp;</td>  -->      
   </tr>     

    <?
      
     if(isset($_POST["view"]))
      {
       $user_query="Select tbl_cash.date,remarks,sum(deposite) as deposite,sum(withdraw) as withdraw,user from tbl_cash
                    where tbl_cash.date between '$_POST[demo11]' and '$_POST[demo12]'
                    group by tbl_cash.date,remarks,user
                    order by date asc,id asc";
      }
      else
      {
      $user_query="Select * from tbl_cash order by date desc,id desc limit 0,50";
      }
      $totaldepo=0;
      $totalwith=0;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <!--<td><?=$value[bank];?></td>-->
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></a></td>
          <?
          $OpenBalanceSub=$OpenBalanceSub+$value[deposite]-$value[withdraw]; 
          ?>
          <td align="right"><?=number_format($OpenBalanceSub,2);?></a></td>
          <td><?=$value[user];?></td>  
          <!--<td align="center"><b><a href="clearbank.php?id=<?=$value[id];?>&mode=banktra" title="Delete">X</a></b></td>     --> 
       </tr>
       <?
       $totaldepo=$totaldepo+$value[deposite];
       $totalwith=$totalwith+$value[withdraw];
       }
      }
    ?>  
  
  <tr bgcolor="#FFCCEE">
     <td colspan="2" align="center"><b>Total :</b></td>
     <td colspan="1" align="right"><b><?=number_format($totaldepo,2)?></b></td>
     <td colspan="1" align="right"><b><?=number_format($totalwith,2)?></b></td>
     <td colspan="1" align="right"><b><?=number_format($OpenBalanceSub,2)?></b></td>
     <td>&nbsp;</td>
  </tr>

 </table>

<?php
 include "footer.php";
?>
