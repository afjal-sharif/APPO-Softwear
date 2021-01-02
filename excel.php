<?php
ob_start("ob_gzhandler"); 
session_start();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
  
<? 
	include "includes/functions.php";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=today_sales.xls;");
	header("Content-Type: application/ms-excel");
	header("Pragma: no-cache");
	header("Expires: 0");
?>

 <?
    $con1=$_SESSION[t_excel_con];
 
         $con="where tbl_order.dtDate='$con1'";
         $user_query="select tbl_order.dtDate as date,tbl_order.donumber,tbl_order.remarks,tbl_order.qty as orderqty,
                   tbl_order.truckno,sum(tbl_receive.qty) as qty, 
                   sum((tbl_receive.rate +tbl_receive.dfcost+tbl_receive.locost) * tbl_receive.qty) as goodsvalue,tbl_company.name as company
                   from tbl_order
                   join tbl_company on tbl_order.company=tbl_company.id
                   left join tbl_receive on tbl_receive.donumber=tbl_order.donumber
                   $con
                   group by tbl_order.donumber                
                   order by tbl_order.id desc";
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      $_SESSION[sqlorder]=$user_query;
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">

 <tr id="trhead"><td colspan="8">Receive Goods Details.</td></tr> 
 <tr id="trsubhead">    
       <td>Date</td>
       <td>Company</td>
       <td>Ref.No</td>
       <td>Truck No</td>
       <td>Remarks</td>
       <td>Order Qty</td>
       <td>Receive Qty</td>
       <td>Total Cost</td>
    </tr>     

    <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[company];?></td>
          <td align="center">
               <?=$value[donumber];?>
          </td>
          <td><?=$value[truckno];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=$value[orderqty];?></td>
          <td align="right"><?=$value[qty];?></td>
         <td align="right"><?=number_format($value[goodsvalue]+$value[dfcost]+$value[locost],2);?></td> 
       </tr>
       <?
      
       $totalamount=$totalamount+$value[goodsvalue];
       $totalqty=$totalqty+$value[qty]; 
       $totallorder=$totallorder+$value[orderqty];
       }
      
    ?>  
  </tr>
   <tr id="trsubhead">
                      <td colspan="5" align="center">Total Amount :</td>
                     <td align="right"><?=number_format($totallorder,2);?></td>
                      <td align="right"><?=number_format($totalqty,2);?></td>
                      
                      <td align="right"><?=number_format($totalamount+$totaldfcost+$totallocost,2);?></td>
  </tr>
       <?
       
       echo "</table>";
      }
    ?>  

 

<!-- Sales Details --> 


 <?
    $totalamount=0;
    $totalqty=0;
    $con="where tbl_sales.date='$con1'";
    $user_query="select tbl_sales.date,tbl_sales.invoice,sum((tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty) as value,sum(tbl_sales.qty) as qty,
                   tbl_customer.name as customer
                   from tbl_sales
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   $con
                   group by tbl_sales.invoice, tbl_sales.customerid
                   order by tbl_sales.id desc,invoice";
      $users = mysql_query($user_query);
      $_SESSION[sqlreceive]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Sales Goods Details.</td></tr> 
   <tr id="trsubhead">    
       
       <td>Date</td>
       <td>Customer</td>
       <td>Invoice</td>
       <td>Qty</td>
       <td>Total Value</td>
   </tr>     
    <?
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
        ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[customer];?></td>
          <td><?=$value[invoice];?></td>
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[value],2);?></td>
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $totalamount=$totalamount+$value[value];
       }
      
    ?>  
        <tr id="trsubhead"><td colspan="3"> Total Amount</td>
         <td colspan="1" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
         <td colspan="1" align="right"><?=number_format($totalamount,2);?></td></tr>
     </table>
     <? 
      }
    ?>  

 
 
 
<!-- Payment Details --> 

 <?
 $con="";
 $con2="";
      $con="where tbl_com_payment.paydate='$con1'";
      $user_query="select paydate,tbl_company.name,chequeno,bank,amount,cheqdate,bamount,remarks,tbl_com_payment.status from tbl_com_payment 
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                   $con
                   order by tbl_com_payment.id";
      $users = mysql_query($user_query);
      $_SESSION[sqlpayment]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="9">Payment To Supplier</td></tr>
<tr id="trsubhead">     
       <td>Date</td>
       <td>Company</td>
       <td>Cheque No</td>
       <td>Cash/Bank</td>
       <td>Cheque Date</td>
       <td>Remarks</td>
       <td>Amount</td>
       <td>Status</td>
       <td>BC Amount</td>   
</tr> 

      <?
      $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[paydate];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[chequeno];?></td>
          <td align="center"><?=$value[bank];?></td>
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
          <td align="right"><?=number_format($value[amount],2);?></td>
           <td align="center"><?=$value[status];?></td>
          <td align="right"><?=number_format($value[bamount],2);?></td>  
          
            
       </tr>
       <?
       $totalbcamount=$totalbcamount+$value[bamount];
       $totalamount=$totalamount+$value[amount];
       }
      echo "<tr id='trsubhead'><td colspan='5'>Total Payment :</td><td colspan='2' align='right'>".number_format($totalamount,2)."</td>";
                                                           echo "<td colspan='2' align='right'>".number_format($totalbcamount,2)."</td>";
                                                           
       echo "</tr>"; 
       echo "</table>";
      }
    ?>  

 
 

<!-- Payment Receive Details --> 

 <?
      $con="where tbl_dir_receive.date='$con1'";
      $user_query="select customerid,tbl_customer.name,type,tbl_dir_receive.date, tbl_customer.address,tbl_customer.mobile,tbl_dir_receive.invoice,
                   paytype,hcash,amount,bank,chequeno,tbl_customer.status,tbl_dir_receive.mrno,
                   tbl_company.name as cname
                   from tbl_dir_receive
                   join tbl_customer on tbl_customer.id=tbl_dir_receive.customerid
                   left join tbl_company on tbl_dir_receive.paycompany=tbl_company.id
                   $con order by tbl_dir_receive.id desc";
      $users = mysql_query($user_query);
      $_SESSION[sqlreceive]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="10">Payment Receive From Customer</td></tr>
<tr bgcolor="#FFCCAA"><td>Date</td><td>Customer</td><td>Invoice</td><td>Cash</td><td>Cheque No</td><td>Bank</td><td>Amount</td><td>Cheque Date</td><td>Status</td><td>User</td></tr>          
      <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[invoice];?></td>
          <td align="right"><?=number_format($value[hcash],2);?></td>
          <td><?=$value[chequeno];?></td>
          <td><?=$value[bank];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>
          <td><?=$value[cheqdate];?></td>
          <td>
          <?
           
            if($value[cstatus]=='C')
             {
              echo "Clear";
             }
            elseif($value[cstatus]=='B')
             {
             echo "Bounce";
             } 
           else
             {
             echo "New";
             }           
          ?>
          
          </td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $totalcash=$totalcash+$value[hcash];
       $totalch=$totalch+$value[amount];
       }
      echo "<tr id='trsubhead'><td colspan='2'>Total :</td><td colspan='2' align='right'>".number_format($totalcash,2)."</td><td colspan='3' align='right'>".number_format($totalch,2)."</td><td colspan='4' align='right'>$nbsp</td></tr>";
      echo "</table>";
      }
    ?>  

 
 
 
<!-- Bank Transection Details --> 

 <?
      $con="where tbl_bank.date='$con1'";
      $user_query="SELECT * from tbl_bank $con ";
      $users = mysql_query($user_query);
      $_SESSION[sqlbank]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $deptotal=0;
       $withtotal=0;
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="4">Bank Transection</td>
<!--<td><A HREF=javascript:void(0) onclick=window.open('printtodayCB.php','Holcim','width=700,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><b>Print</b></a> </td>-->
</tr>
<tr bgcolor="#FFCCAA"><td>Description</td><td>Deposite</td><td>Withdraw</td><td>User</td></tr>          
      <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[bank];?>:<?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $deptotal=$deptotal+$value[deposite];
       $withtotal=$withtotal+$value[withdraw];
       }
       echo "<tr id=trsubhead><td>Total : </td><td align='right'>". number_format($deptotal,2)."</td><td align='right'>". number_format($withtotal,2)." </td><td>= ". number_format($deptotal-$withtotal,2)."</td></tr>";
       echo "</table>";
      }
    ?>  
 


<!-- Cash Transection Details --> 

 <?
      $con="where tbl_cash.date<'$con1'";
      $sql="select sum(deposite-withdraw) as balance from tbl_cash $con";
      $users_skills = mysql_query($sql); 
      $value=mysql_fetch_array($users_skills);
      $opencash=$value[balance];
       
      $_SESSION[opencash]=$opencash; 
      
      $con="where tbl_cash.date='$con1' ";
      $user_query="SELECT * from tbl_cash $con and (deposite<>0 or withdraw<>0) ";
      $users = mysql_query($user_query);
      $_SESSION[sqlcash]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $deptotal=0;
       $withtotal=0;
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="4">Cash Transection</td>
<!--<td><A HREF=javascript:void(0) onclick=window.open('printtodayCB.php','Holcim','width=700,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><b>Print</b></a> </td>-->
</tr>
<tr bgcolor="#FFCCAA"><td>Description</td><td>Deposite</td><td>Withdraw</td><td>User</td></tr>          
<tr id="trsubhead"><td colspan="1">Openning Cash Balance :</td>
                   <td colspan="1" align="right"> <?=number_format($opencash,2);?></td>
                   <td colspan="1">&nbsp;</td>
                   <td colspan="1">&nbsp;</td>
</tr>


      <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $deptotal=$deptotal+$value[deposite];
       $withtotal=$withtotal+$value[withdraw];
       }
       echo "<tr><td>Total : </td><td align='right'>". number_format($deptotal,2)."</td><td align='right'>". number_format($withtotal,2)." </td><td>= ". number_format($deptotal-$withtotal,2)."</td></tr>";
       echo "<tr id='trsubhead'><td>Closing Balance:($con1) </td><td align='right'>". number_format($deptotal-$withtotal+$opencash,2)."</td><td colspan='2'>&nbsp;</td></tr>";
       echo "</table>";
      }
    ?>  
 
<?php
 include "footer.php";
?>
