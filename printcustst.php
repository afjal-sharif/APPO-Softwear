<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
 
  $prebal=$_SESSION[prebal];
  $cust=$_SESSION[custid];
  $user_query=$_SESSION[printsql];
  $con2=$_SESSION[dt];
  $users = mysql_query($user_query);
  $total = mysql_num_rows($users);

  $sql_name="Select name,address,mobile,sp,climit from tbl_customer  where id=$cust";
  $sql_name = mysql_query($sql_name);
  $row_sql= mysql_fetch_assoc($sql_name);
  $name=$row_sql[name];
  $address=$row_sql[address];
  $mobile=$row_sql[mobile];
  $sp=$row_sql[sp];
  $climit=$row_sql[climit];
  
 if ($total>0)
    {
      $bal=0;
      $debit=0;
      $credit=0;
      $total=$prebal;
 ?>
   <table width="920px" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="4" cellspacing="10" cellpadding="30" style="border-collapse:collapse;">
   <tr><td colspan="11" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
 

  <tr>
   <td colspan="11" height="60px" align="center">
       <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" width="65px" height="50px"  border="0">
       <div id="invoice"><?=$global['site_name']?></div>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
  </td>
   </tr>
   
   <tr id="trsubhead">
     <td colspan="11" align="center">Statements Of Accounts</td>
   </tr>
  
   <tr>
     <td colspan="8">
      <b><? echo $name;?></b>,
       &nbsp;
       <? echo $address;?>,
       &nbsp;
       <? echo $mobile;?>
     </td>
     <td colspan="3" align="right">
       Take Care By : <? echo $sp;?>
     </td>
   </tr>
   <!--
   <tr>
     <td colspan="5" align="left">Current Credit Limit:</td>
     <td colspan="6" align="right"><? echo number_format($climit,2);?></td>
   </tr>
   -->
  <?
    echo "<tr><td colspan='6' align='left'>Previous Balance :</td><td colspan='6' align='right'>". number_format($prebal,2)."</td></tr>"; 
  ?> 

<tr bgcolor="#FFCCAA" align="center" id="trsubhead">
    <td>Date</td>
    <td>Type</td>
    <td>Ref. No</td>
    <td>Qty</td>
    <td>Cash</td>
    <td>Bank</td>
    <td>Remarks</td>
    <td>Debit</td>
    <td>Credit</td>
    <td>Balance</td>
</tr>          
 <?
      while($value=mysql_fetch_array($users))
       {
         $date=date_create($value[dt]);
         if($value[porder]==1)
               {
                  
                   echo "<tr align='center'>"; 
                   echo "<td>".date_format($date,'d-M-y')."</td>";
                   echo "<td>Sales</td>";                    
                   echo "<td>".$value[refno]."</td>";
                   echo "<td align='right'>".$value[qty]."</td>";
                   echo "<td>&nbsp;</td>";
                   echo "<td>&nbsp;</td>";
                   echo "<td>".$value[remarks]."</td>";
                   $credit=0;
                   
                   echo "<td align='right'>". number_format($value[salesvalue],2)."</td>";
                   echo "<td>&nbsp;</td>";    
              
                  $totaldebt=$totaldebt+$value[salesvalue];
                  $totalcredit=$totalcredit+$credit;
                  $debit=$value[salesvalue];
                  
                  $bal=($debit-$credit);
                  $total=$total+$bal;
                  echo "<td align='right'>".number_format($total,2)."</td>";
                  echo "</tr>";                      
               }

             if($value[porder]==2)
               {
                 echo "<tr align='center' bgcolor='#FFFFCC'>"; 
                 echo "<td>".date_format($date,'d-M-y')."</td>";
                 echo "<td>Payment</td>";
                 echo "<td>".$value[refno]."</td>";
                 echo "<td>&nbsp;</td>";
                 echo "<td align='right'>". number_format($value[cash],2)."</td>";
                 echo "<td align='right'>". number_format($value[athand],2)."</td>";
                 
                 
                 if($value[status]=='B')
                   {
                    $status="Bounce";
                   }
                 elseif($value[status]=='C')
                  {
                   $status="Clear";
                  }
                 else
                  {
                   $status="New";
                  }   
                  echo "<td>".$value[cheqno].' &nbsp;'. $status.'&nbsp;'.$value[remarks]."</td>";
                 
                                    $debit=0;
                  $credit=$value[cash]+$value[bank]; 
                  $totalcredit=$totalcredit+$credit;
                  echo "<td>&nbsp;</td>";
                  echo "<td align='right'>".number_format($credit,2)."</td>";
                 
                  
                  
                  $bal=($debit-$credit);
                  $total=$total+$bal; 
                  $totalqty=$totalqty+$value[quantity];
                  echo "<td align='right'>".number_format($total,2)."</td>";
                  
                  echo "</tr>"; 
                 }                
               
           ?>
       
  <?
       }
       
       echo "<tr bgcolor='#FFCC09'><td colspan='4' align='center'><b>Balance As Of Date: ". date('d-M-Y', strtotime($con2))  ."</b></td>";
                                   echo"<td colspan='2'></td><td colspan='1'>&nbsp;</td>";
                      echo "<td align='right'>".number_format($totaldebt,2) ."</td><td align='right'>".number_format($totalcredit,2)."</td><td colspan='1' align='right'><b>".number_format($total,2)."</b> </td> </tr>";
       
   
    }
  ?>
  
</table> 
 
<?php
 include "footer.php";
?> 
      
