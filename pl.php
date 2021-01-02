<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $totalcedit=0;
 $totaldebit=0;
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b><?=$global['site_name']?> Income Statement (P/L)</b></td></tr>
 <tr bgcolor="#FFEB9C">
   <td align="right">From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
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
<?
if(isset($_POST["view"]))
{
?>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3"><?=$global['site_name']?> Income Statement</td>
   <td>
     <A HREF=javascript:void(0) onclick=window.open('printpl.php','','width=800,height=800,menubar=no,status=no,location=100,toolbar=no,scrollbars=yes') title="Profit Withdraw">Print</a>
   </td> 
 
 </tr> 
 <tr id="trhead"><td colspan="4">Date Between <?=$_POST[demo11];?> and <?=$_POST[demo12];?> </td></tr>
   <tr bgcolor="#FFCCAA" align="center">    
       <td>Head</td>
       <td>Description</td>
       <td>Tk</td> 
       <td>Tk</td>   
      </tr>     
<?

    
       $user_query="Select sum(tbl_sales.qty*(tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)) as revenue,
                    sum(tbl_sales.qty*(tbl_receive.rate+tbl_receive.dfcost)) as cogs
                   from tbl_sales
                   join tbl_receive on (tbl_sales.donumber=tbl_receive.donumber  and tbl_sales.product=tbl_receive.product)
                   where tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]'";
      $users = mysql_query($user_query);
      $row_sql_adj= mysql_fetch_assoc($users);
      $revenue=$row_sql_adj[revenue];
      $cogs=$row_sql_adj[cogs];  
      
      $balance=$revenue-$cogs;
      
      $totalcedit=$revenue;
      $totaldebit=$cogs;
      
      ?>
    <tr align="center">
      <td>Revenue</td>
      <td>Product Sales Value</td>
      <td align="right"><?=number_format($revenue,2)?></td>
      <td>&nbsp;</td>
    </tr>
   
   <?
    $sql_sad="select sum(adjamount) as amount from tbl_sales  where tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]'";
    $users_sad = mysql_query($sql_sad);
    $row_sad= mysql_fetch_assoc($users_sad);
    $sal_adj=$row_sad[amount]; 
    $totalcedit=$totalcedit+$sal_adj;
   ?>
   
   
   
    <tr align="center">
      <td> Sales Adjustment</td>
      <td> Any Sales Amount Adjust</td>
      <td align="right"><?=number_format($sal_adj,2)?></td>
      <td>&nbsp;</td>
    </tr> 
   
    <tr align="center">
      <td>COGS</td>
      <td>Product Purchase Value</td>
      <td>&nbsp;</td>
      <td align="right"><?=number_format($cogs,2)?></td>
    </tr>
 
   <?
    $sql_pad="select sum(adjamount) as amount from tbl_receive  where tbl_receive.date between '$_POST[demo11]' and '$_POST[demo12]'";
    $users_pad = mysql_query($sql_pad);
    $row_pad= mysql_fetch_assoc($users_pad);
    $pur_adj=$row_pad[amount]; 
    $totaldebit=$totaldebit+$pur_adj;
   ?>
   
   
   
    <tr align="center">
      <td> Purchase Adjustment</td>
      <td> Any Purchase Amount Adjust</td>
      <td>&nbsp;</td>
      <td align="right"><?=number_format($pur_adj,2)?></td>
    </tr> 
 
    <tr bgcolor="#FFCC09">
      <td><b>Gross Profit</b></td>
      <td>Profit from Sales</td>
      <td>&nbsp;</td>
      <td align="right"><?=number_format($revenue+$sal_adj-$cogs-$pur_adj,2)?></td>
    </tr>

 



  <tr>
      <td colspan="4"><b>Others Expense</b></td>
  </tr>


  <!--Add Expense Head. -->


    <?
      $user_query="Select headname,sum(cash+bank) as amount from view_expense_details 
              where (date between '$_POST[demo11]' and '$_POST[demo12]') and in_bal<>1 group by headname"; 
  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center"> 
          <td><?=$value[headname];?></td>
          <td>&nbsp;</td>
          <?
           if($value[amount]>0)
           {
          ?>
             <td align="right">&nbsp;</td>
             <td align="right"><?=number_format($value[amount],2);?></td>
          <?
             $totaldebit=$totaldebit+$value[amount];
           }
           else
           {
          ?>
             
             <td align="right"><?=number_format($value[amount]*(-1),2);?></td>
             <td align="right">&nbsp;</td>
       <?
          $totalcedit=$totalcedit+$value[amount]*(-1);
          }
        echo "</tr>";  
       }
      }
    ?>  
 
    <tr bgcolor="#FFCC09">
      <td><b>Operating Profit</b></td>
      <td>Profit from Sales Net of Expense</td>
      <td>&nbsp;</td>
      <td align="right"><?=number_format($totalcedit-$totaldebit,2)?></td>
    </tr>

  
 
  <tr>
      <td colspan="4"><b>Others Income</b></td>
  </tr>

    
   
   
   <!-- Others Income  -->  
<?
      $user_query="select sum(e.deposite) as amount,e.name from (
                         Select tbl_cash.id,'Cash' as stype,tbl_cash.type,tbl_cash.income_id,tbl_cash.date,tbl_cash.remarks,deposite,tbl_cash.user,name 
                         from tbl_cash join tbl_income_head on tbl_cash.income_id=tbl_income_head.id where type=5
                          union all Select tbl_bank.id,bank as stype,tbl_bank.type,tbl_bank.income_id, tbl_bank.date,tbl_bank.remarks,deposite,tbl_bank.user,name 
                          from tbl_bank join tbl_income_head on tbl_bank.income_id=tbl_income_head.id where type=5 ) 
                          as e
                          where e.date between '$_POST[demo11]' and '$_POST[demo12]'
                          group by e.name
                          ";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center"> 
          <td><?=$value[name];?></td>
          <td>&nbsp;</td>
          <?
           if($value[amount]>0)
           {
          ?>
             <td align="right"><?=number_format($value[amount],2);?></td>
             <td align="right">&nbsp;</td>
             
          <?
             $totalcedit=$totalcedit+$value[amount];
             
           }
           else
           {
          ?>
             <td align="right">&nbsp;</td>   
             <td align="right"><?=number_format($value[amount]*(-1),2);?></td>
          
       <?
          
          $totaldebit=$totaldebit+$value[amount]*(-1);
          }
        echo "</tr>";  
       }
      }
    ?>  

<!-- Incentive Receive -->  

<tr align="center"> 
      <td colspan="1">Incentive Receive</td>
      <td> From Company</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
 
<?
      $_SESSION[date1]=$_POST[demo11];
      $_SESSION[date2]=$_POST[demo12];

      $user_query="Select ttype,sum(deposite) as balance from tbl_incentive 
                  where type=1 and ttype!='Incentive Adjust'
                  and  tbl_incentive.date between '$_POST[demo11]' and '$_POST[demo12]'
                  group by ttype
                  ";
      $users = mysql_query($user_query);
      //$row_sql= mysql_fetch_assoc($users);
      //$balance=$row_sql[balance];
      //$totalcedit=$totalcedit+$balance;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
?>

    <tr align="center"> 
      <td>&nbsp;</td>
      <td><?=$value[ttype];?></td>
      <td align="right"><?=number_format($value[balance],2)?></td>
      <td>&nbsp;</td>
    </tr>
<?
  $totalcedit=$totalcedit+$value[balance];
 }
 }
?>



 <?
  $sql="select sum(amount) as amount from tbl_profit where  tbl_profit.date between '$_POST[demo11]' and '$_POST[demo12]'";
  $users = mysql_query($sql);
  $row_sql= mysql_fetch_assoc($users);
  $profit=$row_sql[amount];   
  $totaldebit=$totaldebit+$profit; 
 ?>



    <tr bgcolor="#FFCCEE" align="center" id="trsubhead">
     <td align="left">Profit Withdraw</td>
     <td>&nbsp;</td>
     <td align="right"></td>
     <td align="right"><?=number_format($profit,2);?></td>
   </tr>

  
  
  
   <tr bgcolor="#FFCCEE" align="center" id="trsubhead">
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td align="right"><?=number_format($totalcedit,2);?></td>
     <td align="right"><?=number_format($totaldebit,2);?></td>
   </tr>
  
  <tr bgcolor="#FFCC09" id="trhead">
      <td><b>Net Profit</b></td>
      <td>Net Profit from Total Business</td>
      <!--<td>&nbsp;</td>-->
      <td align="right" colspan="2"><?=number_format($totalcedit-$totaldebit,2)?></td>
  </tr>
  
   
  
    
  
 </table>
 
 <?
 }
 if(($totalcedit-$totaldebit)>0)
  {
  ?>
     <br><div id="profit"><A HREF=javascript:void(0) onclick=window.open('profitwith.php?&amount=<?=($totalcedit-$totaldebit);?>','','width=600,height=400,menubar=no,status=no,location=100,toolbar=no,scrollbars=yes') title="Profit Withdraw">Click Here To Profit Withdraw.</a></div>
  <? 
  }
 
 ?> 


<?php
 include "footer.php";
?>
