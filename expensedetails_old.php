<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>


<?
      $user_query="Select sum(withdraw) as balance from tbl_cash where type=1";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
?>


<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trhead"><b>Cash Transection Details Report</b></td></tr>
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
   <!--
      <td>Type: 
           
           <select name="exptype" style="width:150px">
             <option value=""></option>
             <option value="0" <? if($_POST[exptype]=='0') {echo "SELECTED";}?> >Cash Expense</option>
             <option value="1" <? if($_POST[exptype]=='1') {echo "SELECTED";}?>>Extra DO Cost</option>
          </select>
  
   </td>
 -->
   </td>
      <td>Category: 
          <?
           $query_sql = "SELECT id,type,details,expensetype  FROM tbl_expense_cat where expensetype<>'1' order by expensetype asc,type asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="company">
             <option value=""></option>
          <?
             do {  
               $type=$row_sql[expensetype];
             if($type==2)
              {
               $type=" :- Pre-Paid";
              }
             else
              {
               $type=" ";
              }
             
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['type'].' : '.$row_sql[details];?><? echo $type;?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
   </td>
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
</table>
</form>

<br>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Total Expense : Tk. <?=number_format($balance,2);?> </td></tr>
 <tr id="trsubhead"><td colspan="5">&nbsp;</td></tr>

 <tr id="trhead"><td colspan="5">Display Expense Transection.</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Date</td>
       <td>Category</td>
       <td>Remarks</td>
       <!--<td>Deposite</td> -->
       <td>Amount</td> 
       
       <td>User</td>
       <!--<td>&nbsp;</td>  -->      
      </tr>     
  <tr>
    <?
      if(isset($_POST["view"]))
      {
       $con='';
       if ($_POST[company]!='')
        {
          $con=$con." and tbl_cash.expensetype=$_POST[company]";
        }
       /*
       if ($_POST[exptype]!='')
        {
          $con=$con." and tbl_expense_cat.expensetype='$_POST[exptype]'";
        }
       */ 
       
       //if($_POST[company]=='')
       // {
          $user_query="Select tbl_cash.date,tbl_cash.remarks,tbl_cash.withdraw,tbl_expense_cat.type,tbl_cash.user from tbl_cash 
                      join tbl_expense_cat on tbl_cash.expensetype=tbl_expense_cat.id 
                      where tbl_cash.type=1 and (tbl_cash.date between '$_POST[demo11]' and '$_POST[demo12]') 
                      $con
                      order by tbl_cash.date desc,tbl_cash.id desc";
       // }
       //else
       // {
       //  $user_query="Select * from tbl_cash where type=1 and (tbl_cash.date between '$_POST[demo11]' and '$_POST[demo12]') and expensetype=$_POST[company]  order by date desc,id desc";
       // }  
      }
      else
      {   
      $user_query="Select tbl_cash.date,tbl_cash.remarks,tbl_cash.withdraw,tbl_expense_cat.type,tbl_cash.user from tbl_cash 
                   join tbl_expense_cat on tbl_cash.expensetype=tbl_expense_cat.id 
                   where tbl_cash.type=1 order by tbl_cash.date desc,tbl_cash.id desc limit 0,10";
      }
      $totaldepo=0;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[remarks];?></td>
          <!--<td align="right"><?=number_format($value[deposite],2);?></td>-->
          <td align="right"><?=number_format($value[withdraw],2);?></a></td>
          
          <td><?=$value[user];?></td>  
          <!--<td align="center"><b><a href="clearbank.php?id=<?=$value[id];?>&mode=banktra" title="Delete">X</a></b></td>     --> 
       </tr>
       <?
       $totaldepo=$totaldepo+$value[withdraw];
       }
      }
    ?>  
  </tr>
 <tr bgcolor="#FFCCEE">
     <td colspan="3" align="center"><b>Total :</b></td>
     <td colspan="1" align="right"><b><?=number_format($totaldepo,2)?></b></td>
     <td colspan="1" align="right">&nbsp;</td>
   
  </tr>
 </table>

<?php
 include "footer.php";
?>
