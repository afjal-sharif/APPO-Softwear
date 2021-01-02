<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
?>


 
 <?
 $invoice=$_GET[id];
 $user_query="Select tbl_dir_receive.date,tbl_dir_receive.mrno,
                   tbl_dir_receive.invoice,tbl_dir_receive.hcash,tbl_customer.name,tbl_customer.address,tbl_customer.mobile,
                   tbl_dir_receive.cash,tbl_dir_receive.discount, 
                   tbl_dir_receive.bank,tbl_dir_receive.branch,tbl_sales.customername,
                   tbl_dir_receive.chequeno, tbl_dir_receive.amount,
                   tbl_dir_receive.cheqdate,tbl_dir_receive.depositebank 
                   from tbl_dir_receive 
                   left join tbl_sales on tbl_sales.invoice=tbl_dir_receive.invoice 
                   left join tbl_customer on tbl_sales.customerid=tbl_customer.id 
                   where tbl_dir_receive.mrno='$invoice'";
 $users = mysql_query($user_query);
 $total = mysql_num_rows($users);   
  
 if ($total>0)
    {
 ?>
   <table width="680px" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr><td colspan="8" height="6px" align="left"><b><A HREF="javascript:void(0)" onclick="window.print()">Print</a></b></td></tr>
   <tr>
   <td colspan="8" height="60px" align="center">
       
   <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" width="65px" height="50px"  border="0">
   <div id="invoice"><?=$global['site_name']?></div><br>
       <?=$global['add1']?>
       <?=$global['add2']?>
       <?=$global['add3']?><br>
       Mobile : <?=$global['mobile']?><br>
       T & T : <?=$global['t&t']?><br>
       Fax : <?=$global['fax']?><br>
       <!-- E-Mail : <?=$global['email']?>-->
     </td>
   </tr>
   <tr><td colspan="8" align="left">Print Date : <?=date('d-M-Y')?></td></tr>
   <tr><td colspan="8" align="left" style="font-size:14px"> MR No :<b><?echo $invoice;?></b> </td></tr>
   <tr id="trhead" align="center"><td colspan="8">Customer Information</td></tr> 
    <? 
       while($value=mysql_fetch_array($users))
       {
       if($custid!==$value[name])
       {
    ?>
    <tr>    
       <td colspan="8" align="left" style="font-size:14px"><?=$value[name];?>  <?=$value[customername];?>
        <br><br>Address: <?=$value[address];?>
       <br><br>Mobile :<?=$value[mobile];?></td>   
   </tr>
   
   <?
    } 
    $custid=$value[name];
    }
    
     $user_query="Select * from tbl_dir_receive where mrno='$invoice'";
     $users = mysql_query($user_query);
     $total = mysql_num_rows($users);
     $payment=0;    
     if ($total>0)
      {
     ?>
       <tr bgcolor="#FFCC09"><td id="trsubhead" colspan="8"><b>Receive Payment Details.</b></td></tr>
      
       <tr >
             <td colspan="1" align="center">Invoice No</td>
             <td align="right">Cash Amount</td>
             <td>Bank Name</td>
             <td>Branch</td>
             <td>Cheque No</td>
             <td>Cheque Date</td>
             <td align="right">Bank Amount</td>
             <td align="right">Total Amount</td>
       </tr>
       <?
      while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
        <td align="center" style="font-size:14px"><?=$value[invoice];?></td>
        <td colspan="1" align="right" style="font-size:14px"><?=number_format($value[hcash],2);?></td>
        <td colspan="1" align="center" style="font-size:14px"><?=$value[bank];?></td>
        <td colspan="1" align="center" style="font-size:14px"><?=$value[branch];?></td>
        <td colspan="1" align="center" style="font-size:14px"><?=$value[chequeno];?></td>
        <td colspan="1" align="center" style="font-size:14px">
           
           <? if($value[amount]<>0){ echo $value[cheqdate];} else { echo "&nbsp;";}?></td>
        <td colspan="1" align="right" style="font-size:14px"><?=number_format($value[amount],2);?></td>
        <td colspan="1" align="right" style="font-size:14px"><?=number_format($value[amount]+$value[hcash],2);?></td> 
       </tr>
       <?
      $payment=$payment+($value[hcash]+$value[amount]);
       }      
      }
      ?>
   <tr>
        <td colspan="3" align="center" style="font-size:14px">Total Amount :</td>
        <td colspan="5" align="right" style="font-size:14px">Tk  <?=number_format($payment,2);?></td> 
       </tr>
      
      
      <tr height="70px" valign="bottom">
         <td colspan="4" align="left"  height="70px" valign="bottom">Customer Signature</td>
         <td colspan="4" align="right"  height="70px" valign="bottom"><? echo $_SESSION[userName];?> <br>Signature</td></tr>
      
   </table>
   <?
   }
   ?>
    
<?php
 // include "footer.php";
?>
