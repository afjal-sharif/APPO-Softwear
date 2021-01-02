<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 $con1=$_SESSION[con];
?>


<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr>
   <td colspan="1" height="60px" align="center">
      <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" height="40px"  border="0"> &nbsp;
       <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
             
   
  </td>
   </tr>
 <tr id="trhead"><td colspan="1">Day Trial Balance : <? echo $con1;?></td></tr> 

</table>
 
 <!-- Receive Details -->

 <?
      $user_query=$_SESSION[sqlorder];
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">

 <tr id="trhead"><td colspan="9">Receive Goods Details.</td></tr> 
 <tr align="center">    
       <td>SL No</td> 
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
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[company];?></td>
          <td align="center"><?=$value[donumber];?></td>
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
   <tr align="center">
                      <td colspan="6" align="center">Total Amount :</td>
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
    
      $user_query=$_SESSION[sqlreceive];
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Sales Goods Details.</td></tr> 
   <tr align="center">   
       <td>SL No</td>
       <td>Date</td>
       <td>Customer</td>
       <td>Invoice</td>
       <td>Qty</td>
       <td>Total Value</td>
   </tr>     
    <?
       $totalamount=0;
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
        ?>
      <tr align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
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
        <tr align="center">
          <td colspan="3"> Total Amount</td>
         <td colspan="2" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
         <td colspan="1" align="right"><?=number_format($totalamount,2);?></td></tr>
     </table>
     <? 
      }
    ?>  

 
 
 
 <?
    $totalamount=0;
    $totalqty=0;
    
      $user_query=$_SESSION[sqlcategory];
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Product Group Wise Purchase & Sales</td></tr> 
   <tr align="center">  
       <td>SL No</td>
       <td>Date</td>
       <td>Group Name</td>
       <td colspan="1">Pur. Qty</td>
       <td colspan="1">Pur. Value</td>
       <td colspan="1"> Sales Qty</td>
       <td colspan="1"> Sales Value</td>
       
       
   </tr>     
    <?
       $totalamount=0;
       $count=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
        ?>
       <tr  align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[g_name];?></td>
                  
          <td align="right"><?=number_format($value[pqty],2);?></td>
          <td align="right"><?=number_format($value[pvalue],2);?></td>
          
          <td align="right"><?=number_format($value[sqty],2);?></td>
          <td align="right"><?=number_format($value[svalue],2);?></td>
          
       </tr>
       <?
       $ptotalamount=$ptotalamount+$value[pvalue];
       $stotalamount=$stotalamount+$value[svalue];
       }
      
    ?>  
        <tr align="center">
          <td colspan="3"> Total Amount</td>
          <td colspan="2" align="right"><?=number_format($ptotalamount,2);?></td>
          <td colspan="2" align="right"><?=number_format($stotalamount,2);?></td>
        </tr>
     </table>
     <? 
      }
    ?>  


<?
    $totalamount=0;
    $totalqty=0;
    
      $user_query=$_SESSION[sql_pro_category];
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Product Category Wise Purchase & Sales</td></tr> 
   <tr align="center">  
       <td>SL No</td>
       <td>Date</td>
       <td>Group Name</td>
       <td colspan="1">Pur. Qty</td>
       <td colspan="1">Pur. Value</td>
       <td colspan="1"> Sales Qty</td>
       <td colspan="1"> Sales Value</td>
       
       
   </tr>     
    <?
       $totalamount=0;
       $ptotalamount=0;
       $stotalamount=0;
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
        ?>
       <tr  align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[name];?></td>
                  
          <td align="right"><?=number_format($value[pqty],2);?></td>
          <td align="right"><?=number_format($value[pvalue],2);?></td>
          
          <td align="right"><?=number_format($value[sqty],2);?></td>
          <td align="right"><?=number_format($value[svalue],2);?></td>
          
       </tr>
       <?
       $ptotalamount=$ptotalamount+$value[pvalue];
       $stotalamount=$stotalamount+$value[svalue];
       }
      
    ?>  
        <tr align="center">
          <td colspan="3"> Total Amount</td>
          <td colspan="2" align="right"><?=number_format($ptotalamount,2);?></td>
          <td colspan="2" align="right"><?=number_format($stotalamount,2);?></td>
        </tr>
     </table>
     <? 
      }
    ?>  

 
 
 
 
 
 
 
 
<!-- Payment Details --> 

 <?
 
 
      $user_query=$_SESSION[sqlpayment];
      $users = mysql_query($user_query);
    
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="10">Payment To Supplier</td></tr>
<tr align="center">  
       <td>SL No</td>
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
      $count=0;
       while($value=mysql_fetch_array($users))
       {
      $count=$count+1;
       ?>
      <tr align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[paydate]);
           echo date_format($date,'d-M-y');
          ?></td>
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
      echo "<tr align='center'><td colspan='5'>Total Payment :</td><td colspan='3' align='right'>".number_format($totalamount,2)."</td>";
                                                           echo "<td colspan='2' align='right'>".number_format($totalbcamount,2)."</td>";
                                                           
       echo "</tr>"; 
       echo "</table>";
      }
    ?>  

 
 

<!-- Payment Receive Details --> 

 <?
      $user_query=$_SESSION[sqlpreceive];
      $users = mysql_query($user_query);
 
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="11">Payment Receive From Customer</td></tr>
<tr align="center"><td>SL No</td><td>Date</td><td>Customer</td><td>Invoice</td><td>Cash</td><td>Cheque No</td><td>Bank</td><td>Amount</td><td>Cheque Date</td><td>Status</td><td>User</td></tr>          
      <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[name];?> <?=$value[remarks];?></td>
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
      echo "<tr align='center'><td colspan='3'>Total :</td><td colspan='2' align='right'>".number_format($totalcash,2)."</td><td colspan='3' align='right'>".number_format($totalch,2)."</td><td colspan='4' align='center'>=".number_format($totalcash+$totalch,2)."</td></tr>";
      echo "</table>";
      }
    ?>  

 
 
 
<!-- Bank Transection Details --> 

 <?
      
      $user_query=$_SESSION[sqlbank];
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $deptotal=0;
       $withtotal=0;
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="5">Bank Transection</td>

</tr>
<tr align="center"><td>SL No</td><td>Description</td><td>Deposite</td><td>Withdraw</td><td>User</td></tr>          
      <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $deptotal=$deptotal+$value[deposite];
       $withtotal=$withtotal+$value[withdraw];
       }
       echo "<tr align='center'><td colspan='2'>Total : </td><td align='right'>". number_format($deptotal,2)."</td><td align='right'>". number_format($withtotal,2)." </td><td>= ". number_format($deptotal-$withtotal,2)."</td></tr>";
       echo "</table>";
      }
    ?>  
 


<!-- Cash Transection Details --> 

 <?
       
      $opencash=$_SESSION[opencash]; 
      
      $user_query=$_SESSION[sqlcash];
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $deptotal=0;
       $withtotal=0;
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="5">Cash Transection</td>
<!--<td><A HREF=javascript:void(0) onclick=window.open('printtodayCB.php','Holcim','width=700,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><b>Print</b></a> </td>-->
</tr>
<tr align="center"><td>SL No</td><td>Description</td><td>Deposite</td><td>Withdraw</td><td>User</td></tr>          
<tr align="center"><td colspan="2">Opening Cash Balance :</td>
                   <td colspan="1" align="right"> <?=number_format($opencash,2);?></td>
                   <td colspan="1">&nbsp;</td>
                   <td colspan="1">&nbsp;</td>
</tr>


      <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $deptotal=$deptotal+$value[deposite];
       $withtotal=$withtotal+$value[withdraw];
       }
       echo "<tr align='center'><td colspan='2'>Total : </td><td align='right'>". number_format($deptotal,2)."</td><td align='right'>". number_format($withtotal,2)." </td><td>= ". number_format($deptotal-$withtotal,2)."</td></tr>";
       echo "<tr align='center'><td colspan='2'>Closing Balance:($con1) </td><td align='right'>". number_format($deptotal-$withtotal+$opencash,2)."</td><td colspan='2'>&nbsp;</td></tr>";
       echo "</table>";
      }
    ?>  
 
<?php
 include "footer.php";
?>
