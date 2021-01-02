<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Balance Sheet";
 include "session.php";  
 include "header.php";
 $totalcedit=0;
 $totaldebit=0;
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Save This Balance Sheet ?")
if (answer !=0)
{
window.submit();
}
}	
</script>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3"><?=$global['site_name']?> Balance Sheet</td>
 <td>
     <A HREF=javascript:void(0) onclick=window.open('printbs.php','','width=800,height=800,menubar=no,status=no,location=100,toolbar=no,scrollbars=yes') title="Profit Withdraw">Print</a>
 </td> 
 
 
 </tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Head</td>
       <td>Description</td>
       <td>Assets</td> 
       <td>Liabilities & OE</td>   
      </tr>     

<?
      if(isset($_POST["submit"]))
      {
       $sql="delete from tbl_bs  where date=curdate()";
       db_query($sql);
      }
?>

<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $cashbal=$row_sql[balance];
      $totalcedit=$totalcedit+$cashbal;
      if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)values(curdate(),'Cash At Hand','Cash Balance',$cashbal,0,'$_SESSION[userName]')";
       db_query($sql);
      } 
?>

    <tr align="center"> 
      <td>Cash At Hand</td>
      <td>Cash Balance</td>
      <td align="right"><?=number_format($cashbal,2)?></td>
      <td>&nbsp;</td>
    </tr>


<? 
      $user_query="Select sum(deposite-withdraw) as balance from tbl_bank";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);      
      $bankbal=$row_sql[balance];
      if($bankbal>0)
      {
      
      $totalcedit=$totalcedit+$bankbal;
      if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)values(curdate(),'Cash At Bank','Bank Balance',$bankbal,0,'$_SESSION[userName]')";
       db_query($sql);
      }
?>
    <tr align="center"> 
      <td>Cash At Bank</td>
      <td>Bank Balance</td>
      <td align="right"><?=number_format($bankbal,2)?></td>
      <td>&nbsp;</td>
    </tr>
<?
     }
     else
     {
      $totaldebit=$totaldebit+$bankbal*(-1);
      if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)values(curdate(),'Cash At Bank','Bank Balance',0,$bankbal*(-1),'$_SESSION[userName]')";
       db_query($sql);
      }
 ?>
  <tr align="center"> 
      <td>Cash At Bank</td>
      <td>Bank Balance</td>
      <td>&nbsp;</td>
      <td align="right"><?=number_format($bankbal*(-1),2)?></td>
    </tr>
  
      
<?     
     }
     // End Bank Bal
     
     // Start Incentive payment
     
     
      $user_query="Select sum(deposite-withdraw) as balance from tbl_incentive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $bankbal=$row_sql[balance];
      $totalcedit=$totalcedit+$bankbal;
      if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)values(curdate(),'Accumulated Incentive Bal','Incentive Balance on Company',$bankbal,0,'$_SESSION[userName]')";
       db_query($sql);
      }
     
?>

   
    <tr align="center"> 
      <td>Accumulated Incentive Bal</td>
      <td>Incentive Balance on Company</td>
      <td align="right"><?=number_format($bankbal,2)?></td>
      <td>&nbsp;</td>
    </tr>
   




    <?
            
      $user_query=" select sum(e.qty) as qty ,sum(e.totalvalue) as totalvalue from
                     (
                      select product,sum(qty) as qty,sum(qty*rate) as totalvalue from 
                         view_stock_details_base 
                         group by product
                         having sum(qty)<>0
                      ) as e   
                         ";
      
      $toalamount=0;
      $totalstock=0;
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $stockbal=$row_sql[totalvalue];
      $stockqty=$row_sql[qty];
      if($stockqty==0){$stockqty=1;}
      $totalcedit=$totalcedit+$stockbal;
      
      
          
    ?>  
  
 <tr align="center"> 
     <td> Inventory (Stock)</td>
     <td colspan="1">Goods:<?=number_format($stockqty,2)?> Qty
                     Average Price:  <?=number_format($stockbal/$stockqty,2)?> Tk.</td>
     <td colspan="1" align="right"><?=number_format($stockbal,2)?></td>
     <td colspan="1" align="right">&nbsp;</td>
 
  </tr>
   
   <?
    if(isset($_POST["submit"]))
      {
       $price=number_format($stockbal/$stockqty,2);
       $totalstock=number_format($stockqty,0);
       
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Inventory (Stock)','Goods: $totalstock Qty,Average Price:$price Tk.',$stockbal,0,'$_SESSION[userName]')";
       db_query($sql);
      }
   ?>
 


   <?
     
      $user_query="select sum(e.salevalue-e.payment-e.bank) as bal from (
                  select sum(salesvalue) as salevalue,sum(cash) as payment,sum(bank) as bank
                  from view_cust_stat_base 
                  group by custid
                  having sum(salesvalue-cash-bank)>1
                  ) as e
                  ";
      
      
      
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      
      //$recbal=$row_sql[salevalue];
      //$paybal=$row_sql[payment]+$row_sql[bank];
      //$bal=$recbal-$paybal;
      $bal=$row_sql[bal];
      echo "<tr align='center'>";
      echo "<td>Receiable From Customer</td>";
      echo "<td>Not Include Cheque In Hand</td>";
      if($bal>0)
      { 
       $totalcedit=$totalcedit+$bal;
       $assets=$bal;
       $liab="0";
       echo "<td align='right'>".number_format($assets,2)."</td>";
       echo "<td>&nbsp;</td>";
      }
      else
      {
       $totaldebit=$totaldebit+($bal*(-1));
       $assets=0;
       $liab=$bal*(-1);
       echo "<td>&nbsp;</td>";
       echo "<td align='right'>".number_format($liab,2)."</td>";
      }
      echo "</tr>"; 
    ?>  
    
  <?
    if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Receiable From Customer','Not Include Cheque In Hand',$assets,$liab,'$_SESSION[userName]')";
       db_query($sql);
      }
   ?>
 

 
   <?
     
      $user_query="select sum(e.salevalue-e.payment-e.bank)*(-1) as bal from (
                  select sum(salesvalue) as salevalue,sum(cash) as payment,sum(bank) as bank
                  from view_cust_stat_base 
                  group by custid
                  having sum(salesvalue-cash-bank)<1
                  ) as e
                  ";
      
      
      
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      
      //$recbal=$row_sql[salevalue];
      //$paybal=$row_sql[payment]+$row_sql[bank];
      //$bal=$recbal-$paybal;
      $bal=$row_sql[bal];
      echo "<tr align='center'>";
      echo "<td>Advance Receive From Customer</td>";
      echo "<td>Advance Receive</td>";
      if($bal>0)
      { 
       $totaldebit=$totaldebit+$bal;
       $assets=$bal;
       $liab="0";
       echo "<td>&nbsp;</td>";
       echo "<td align='right'>".number_format($assets,2)."</td>";
      }
      else
      {
       
       $totalcedit=$totalcedit+$bal*(-1);
       $assets=0;
       $liab=$bal*(-1);
       
       echo "<td align='right'>".number_format($liab,2)."</td>";
       echo "<td>&nbsp;</td>";
      }
      echo "</tr>"; 
    ?>  
    
  <?
    if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Advance Receive From Customer','Advance Receive',$liab,$assets,'$_SESSION[userName]')";
       db_query($sql);
      }
   ?>



  

 <?    
      $sql="  select sum(salesvalue-payment) as bal from (
                   select sum(rec) as totalrec,sum(svalue) as salesvalue,sum(pvalue) as payment
                   from view_com_stat_base group by company  having sum(svalue)-sum(pvalue)>1) as e
                          ";
      $users_sql = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users_sql);
      //$bal=$row_sql_adj[salesvalue]-($row_sql_adj[totalrec]-$row_sql_adj[payment]);  
      //$bal=$row_sql_adj[salesvalue]-$row_sql_adj[payment];
      $bal=$row_sql_adj[bal];
      echo "<tr align='center'>";
      echo "<td>Payable To Supplier</td>";
      echo "<td>Based On Goods Receive Item.(Not on Order Wise)</td>";
      if($bal<0)
      { 
       $totalcedit=$totalcedit+$bal*(-1);
       $assets=$bal*(-1);
       $liab="0";
       echo "<td align='right'>".number_format($assets,2)."</td>";
       echo "<td>&nbsp;</td>";
      }
      else
      {
       $totaldebit=$totaldebit+$bal;
       $assets=0;
       $liab=$bal;
       echo "<td>&nbsp;</td>";
       echo "<td align='right'>".number_format($liab,2)."</td>";
      }
      echo "</tr>"; 
       
    ?>

   <?
    if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Payable To Company','Based On Goods Receive Item.(Not on Order Wise)',$assets,$liab,'$_SESSION[userName]')";
       db_query($sql);
      }
   ?>    
    
 <?    
     $sql="  select sum(salesvalue-payment) as bal from (
                   select sum(rec) as totalrec,sum(svalue) as salesvalue,sum(pvalue) as payment
                   from view_com_stat_base group by company  having sum(svalue)-sum(pvalue)<1) as e
                          ";
      $users_sql = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users_sql);
      //$bal=$row_sql_adj[salesvalue]-($row_sql_adj[totalrec]-$row_sql_adj[payment]);  
      //$bal=$row_sql_adj[salesvalue]-$row_sql_adj[payment];
      $bal=$row_sql_adj[bal];
      echo "<tr align='center'>";
      echo "<td>Advance Payment to Supplier</td>";
      echo "<td>Advance Payment</td>";
      if($bal<0)
      { 
       $totalcedit=$totalcedit+$bal*(-1);
       $assets=$bal*(-1);
       $liab="0";
       echo "<td align='right'>".number_format($assets,2)."</td>";
       echo "<td>&nbsp;</td>";
      }
      else
      {
       $totaldebit=$totaldebit+$bal;
       $assets=0;
       $liab=$bal;
       echo "<td>&nbsp;</td>";
       echo "<td align='right'>".number_format($liab,2)."</td>";
      }
      echo "</tr>"; 
       
    ?>

   <?
    if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Advance Payment to Supplier','Advance Payment',$assets,$liab,'$_SESSION[userName]')";
       db_query($sql);
      }
   ?>    

  <!-- Others Payable & Receivable   Code Here  Start  -->
   
  





 <!-- Others Payable & Receivable   Code Here  End  -->
 <?
    /*
      $user_query="select sum(pay+adjust-withdraw) as  paybal from tbl_incentive_pay";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $paybal=$row_sql[paybal];
     */ 
     $payable=0
 ?>
   
    <tr align="center"> 
      <td> Acc. Incentive Payable</td>
      <td>Incentive Payable To Retailer</td>
      <td>&nbsp;</td>
      <td align="right"><?=number_format($paybal,2)?></td>
    </tr>

    <?
    
    $totaldebit=$totaldebit+$paybal;
    if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Acc. Incentive Payable','Incentive Payable To Retailer',0,$paybal,'$_SESSION[userName]')";
       db_query($sql);
      }
    ?>    


 <?
      $user_query="Select sum(cash+bank) as amount from view_expense_details where in_bal=1";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $prepaidexp=$row_sql[amount];
      
 ?>

    <tr align="center"> 
      <td>Advanace Expense</td>
      <td>Pre-Paid Expense</td>
      <td align="right"><?=number_format($prepaidexp,2)?></td>
      <td>&nbsp;</td>
    </tr>

    <?
    $totalcedit=$totalcedit+$prepaidexp;
    if(isset($_POST["submit"]))
      {
       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
             values(curdate(),'Pre-Paid Expense','Pre-Paid Expense',$prepaidexp,0,'$_SESSION[userName]')";
       db_query($sql);
      }
    ?>    





     <?
      $user_query="SELECT `description`,sum(`assets`) as assets,sum(`liab`) as lib,`remarks`,`remarks1` FROM `tbl_assets_liab`
                  where type<=2
                  group by `remarks`,remarks1
                  having sum(`assets`-`liab`)<>0";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {  
        $totalass=$totalass+$value[assets];
        $totallib=$totallib+$value[lib];
       }
       ?>
      <tr align="center"> 
       <td>Cash & Bank Receiveable From Owner</td>
       <td>Cash & Bank Lending To Others</td>
       <td align="right"><?=number_format($totalass,2)?></td>
       <td>&nbsp;</td>
      </tr>
      
       <tr align="center"> 
       <td>Cash & Bank Payable to Owner</td>
       <td>Cash & Bank Borrowing from Others</td>
       <td>&nbsp;</td>
       <td align="right"><?=number_format($totallib,2)?></td>
      </tr>      
       <?
       $totalcedit=$totalcedit+$totalass;
       $totaldebit=$totaldebit+$totallib;
       
       if(isset($_POST["submit"]))
          {
             $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                   values(curdate(),'Cash & Bank Receiveable From Owner','Cash & Bank Lending To Others',$totalass,0,'$_SESSION[userName]')";
             db_query($sql);
             $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'Cash & Bank Payable to Owner','Cash & Bank Borrowing from Others',0,$totallib,'$_SESSION[userName]')";
                       db_query($sql);
             
             
          }
      }
    ?>  


   <?
      $user_query="SELECT head_name,ref_id,sum(deposite-withdraw) as balance FROM tbl_account_coa 
                               join tbl_coa on ref_id=tbl_coa.id
                               where tbl_account_coa.type=2 group by ref_id
                               having sum(deposite-withdraw)<>0
                               ";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
              echo "<tr align='center'><td>$value[head_name]</td>";
              echo "<td>$value[head_name]</td>";
              echo "<td></td><td align='right'>".number_format($value[balance],2)."</td></tr>";
              $totaldebit=$totaldebit+$value[balance];
                   if(isset($_POST["submit"]))
                    {
                       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'$value[head_name]','$value[head_name]',0,$value[liab],'$_SESSION[userName]')";
                       db_query($sql);
                    }

        }
       }
    ?>  

 


    <?
      $user_query="Select sum(assets) as assets,sum(liab) as liab,type from tbl_assets_liab group by type order by type desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
              
            <?
            if($value[type]==4)
             {
              echo "<tr align='center'><td>Others Assets</td>";
              echo "<td>Others Assets</td>";
              echo "<td align='right'>".number_format($value[assets],2)."</td><td></td></tr>";
              $totalcedit=$totalcedit+$value[assets];
                   if(isset($_POST["submit"]))
                    {
                       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'Others Assets','Others Assets',$value[assets],0,'$_SESSION[userName]')";
                       db_query($sql);
                    }
             }
             
             
           if($value[type]==3)
             {
              echo "<tr align='center'><td>Owner Equity</td>";
              echo "<td>Owner Equity</td>";
              echo "<td></td><td align='right'>".number_format($value[liab],2)."</td></tr>";
              $totaldebit=$totaldebit+$value[liab];
                   if(isset($_POST["submit"]))
                    {
                       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'Owner Equity','Owner Equity',0,$value[liab],'$_SESSION[userName]')";
                       db_query($sql);
                    }

             }
       }
      }
    ?>  

 
  






 <?
  $sql="select COALESCE(sum(amount),0) as amount from tbl_profit";
  $users = mysql_query($sql);
  $row_sql= mysql_fetch_assoc($users);
  $profit=$row_sql[amount];   
  $totaldebit=$totaldebit+$profit;
  
            if(isset($_POST["submit"]))
                    {
                      $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'Cumulative Profit Withdraw','',0,$profit,'$_SESSION[userName]')";
                       db_query($sql);
                    }
 ?>



    <tr align="center">
     <td align="center">Cumulative Profit Withdraw</td>
     <td>&nbsp;</td>
     <td align="right"></td>
     <td align="right"><?=number_format($profit,2);?></td>

   </tr>





  <tr  align="center">
     <td colspan="2" align="center"><b>Retain Earning</b></td>
     <td align="right">&nbsp;</td>
     <td align="right"><?
               //echo $totalcedit;
               //echo $totaldebit;
               $RE=$totalcedit-$totaldebit;
               echo number_format($RE,2);
            
         ?></td>
   </tr>
   
<? 
           if(isset($_POST["submit"]))
                    {
                       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'Retain Earning','RE',0,$RE,'$_SESSION[userName]')";
                       db_query($sql);
                    }
 ?>

 
  
   <tr bgcolor="#FFCCEE" align="center" id="trsubhead">
     <td>&nbsp;</td>
     <td>Total </td>
     <td align="right"><?=number_format($totalcedit,2);?></td>
     <td align="right"><?=number_format($totaldebit+$RE,2);?></td>
   </tr>
 <? 
           if(isset($_POST["submit"]))
                    {
                       $sql="insert into tbl_bs(date,head,description,assets,liab,user)
                         values(curdate(),'','Total',$totalcedit,$RE+$totaldebit,'$_SESSION[userName]')";
                       db_query($sql);
                       $msg="<img src='images/active.png' height='20px' width='20px'> &nbsp;&nbsp;<B>Seccessfully Saved Balance Sheet.</B>";
                    }
 ?>
    
  
 </table>
 
<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr><td align="left"> <? echo $msg;?></td></tr>
     <tr align="left" id="trsubhead">  
         <td> Click Here to <input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> Balance Sheet</td>
     </tr>
</table>
</form>


<?php
 include "footer.php";
?>
