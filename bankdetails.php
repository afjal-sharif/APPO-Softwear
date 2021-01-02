<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
   if(isset($_POST["view"]) and !empty($_POST[bank]) )
    {
    $user_query="Select sum(deposite-withdraw) as balance from tbl_bank where bank='$_POST[bank]'";
    $accountcode=" Account No :". $_POST[bank]." .";
    $users = mysql_query($user_query);
    $row_sql= mysql_fetch_assoc($users);
    $balance=$row_sql[balance];

    
    $user_query="Select sum(deposite-withdraw) as balance from tbl_bank where bank='$_POST[bank]' and tbl_bank.date<'$_POST[demo11]' "; 
    $users = mysql_query($user_query);
    $row_sql= mysql_fetch_assoc($users);
    $OpenBalance=$row_sql[balance];
    $OpenBalanceSub=$OpenBalance;
    
    }
   else
    {  
      $user_query="Select sum(deposite-withdraw) as balance from tbl_bank";
      $accountcode='';
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];

      $user_query="Select sum(deposite-withdraw) as balance from tbl_bank where  tbl_bank.date<'$_POST[demo11]' "; 
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $OpenBalance=$row_sql[balance];
      $OpenBalanceSub=$OpenBalance;
    } 
     
?>


<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Bank Transection Report</b></td></tr>
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
           <td> Bank :    
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="bank"  style="width: 230px;">
           <option value=""></option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
        </td> 

   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6"> <font color="#0000FF"><? echo $accountcode;?></font>  Current Bank Balance : Tk. <?=number_format($balance,2);?> </td></tr>
 

 <tr id="trhead"><td colspan="6">Display  Bank Transection</td></tr> 
  
  <?
         echo "<tr id='trsubhead'><td colspan='4' align='left'>Previous Balance : </td><td align='right' colspan='2'>".number_format($OpenBalance,2)."</td></tr>";  
  ?>
  

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <!--<td>Bank Name</td>
       <td>Account Code</td>
       -->
       <td>Remarks</td>
       <td>Deposite</td>
       <td>Withdraw</td>   
       <td>Balance</td>  
       <td>User</td>
   </tr>     
  
    <?
      if(isset($_POST["view"]))
      {
        if($_POST[bank]=='')    
         {
         $user_query="Select tbl_bank.date,remarks,tbl_bank.bank,tbl_bank.deposite,tbl_bank.withdraw,tbl_bank.user,tbl_bank_name.bankname from tbl_bank 
                      join tbl_bank_name on tbl_bank.bank=tbl_bank_name.accountcode
                      where tbl_bank.date between '$_POST[demo11]' and '$_POST[demo12]'  
                      order by tbl_bank.date asc,tbl_bank.id asc";
         }
        else
         {
          $user_query="Select tbl_bank.date,remarks, sum(deposite) as deposite,sum(withdraw) as withdraw,tbl_bank.user from tbl_bank 
                       where tbl_bank.date between '$_POST[demo11]' and '$_POST[demo12]' and bank='$_POST[bank]' 
                       group by tbl_bank.date,remarks
                       order by tbl_bank.date asc,tbl_bank.id asc";
         } 
      }
      else
      {
      $user_query="Select * from tbl_bank order by date desc,id desc limit 0,10";
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
         <!-- <td><?=$value[bankname];?></td>
          <td><?=$value[bank];?></td>
          -->
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
  </tr>
  <tr bgcolor="#FFCC09">
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
