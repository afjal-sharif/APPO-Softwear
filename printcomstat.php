<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
?>

 <? 
  $prebal=$_SESSION[prebal];
  $cust=$_SESSION[custid];
  $user_query=$_SESSION['printsql'];
  $con2=$_SESSION[con2];
  $users = mysql_query($user_query);
  $total = mysql_num_rows($users);

  $sql_name="Select name,address,mobile from tbl_company  where id=$cust";
  $sql_name = mysql_query($sql_name);
  $row_sql= mysql_fetch_assoc($sql_name);
  $name=$row_sql[name];
  $address=$row_sql[address];
  $mobile=$row_sql[mobile];
  
 if ($total>0)
    {
      $bal=0;
      $debit=0;
      $credit=0;
      $total=$prebal;
 
 ?>
   <table width="960px" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr><td colspan="10" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
 

  <tr>
   <td colspan="10" height="60px" align="center">
       <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>"  border="0">
       <div id="invoice"><?=$global['site_name']?></div>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
  </td>
   </tr>
   
   <tr id="trsubhead">
     <td colspan="10" align="center">Company Statements Of Accounts</td>
   </tr>
  
   <tr>
     <td colspan="10">
      <b> <? echo $name;?></b>
     </td>
   </tr>
   
   <tr id='trsubhead'>
     <td colspan='5' align='left'> Company Previous Balance :</td>
     <td colspan='5' align='right'><?=number_format($prebal,0);?></td>
    </tr>
    



<tr bgcolor="#FFCCAA">
    <td>Date</td>
    <td>Type</td>
    <td>Ref.No</td>
    <td>Media</td>
    <td>Remarks</td>  
    <td>Rec.Qty</td>
    <td>Amount Receive</td>   
    <td>Credit</td>
    <td>Debit</td>
    <td>Balance</td>
</tr>          
 
 <?
      while($value=mysql_fetch_array($users))
       {
        if($value[porder]==1)
         {
        ?>
         <tr>
            <td><?=$value[dt];?></td>
            <td><?=$value[ttype];?></td>
            <td><?=$value[refno];?></td>
            <td><?=$value[media];?></td>
            <td><?=$value[remarks];?></td>
            <td><?=$value[rec];?></td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($value[svalue],2);?></td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($value[svalue]+$totalamount,2);?></td>
         </tr>
        <? 
         $totalcredit=$totalcredit+$value[svalue];
         }
        if($value[porder]==2)
         {
        ?>
         <tr>
            <td><?=$value[dt];?></td>
            <td><?=$value[ttype];?></td>
            <td><?=$value[refno];?></td>
            <td><?=$value[media];?></td>
            <td><?=$value[remarks];?></td>
            <td>&nbsp;</td>
            <td><?=number_format($value[rec],2);?></td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($value[pvalue],2);?></td>
            <td align="right"><?=number_format($totalamount-$value[pvalue],2);?></td>
         </tr>
        <? 
         $totaldebit=$totaldebit+$value[pvalue];
         } 
         $totalamount=$totalamount+$value[svalue]-$value[pvalue];     
       }
       
      echo "<tr bgcolor='#FFCC09'><td colspan='7' align='center'><b>Balance As Of Date: ". date('d-M-Y', strtotime($con2))  ." </b></td>
        <td align='right'>".number_format($totalcredit,2) ."</td><td align='right'>".number_format($totaldebit,2)."</td>
        <td colspan='1' align='right'><b>".number_format($totalamount,2)."</b> </td> </tr>";
   echo "</table>";
    }
  ?>  

 
<?php
 include "footer.php";
?>
