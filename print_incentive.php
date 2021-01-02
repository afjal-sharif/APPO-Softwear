<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 include "rptheader.php";
 date_default_timezone_set('Asia/Dacca');
?>

 
 <?
 
 
 $user_query=$_SESSION[print_incentive_pay];
 $users = mysql_query($user_query);
 $total = mysql_num_rows($users);   
  
 if ($total>0)
    {
 ?>
   <table width="100%" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr><td colspan="11" height="6px" align="left" bgcolor="#FFFFFF"><A HREF="javascript:void(0)" onclick="window.print()">Print</a></td></tr>
   <tr>
     <td colspan="11" height="60px" align="center">
          <IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" height="40px"  border="0"> &nbsp;
           <div id="invoice"><?=$global['site_name']?></div><br>
           <?=$global['add1']?>
           <?=$global['add2']?>
           <?=$global['add3']?><br>
           Mobile : <?=$global['mobile']?><br>
           T & T : <?=$global['t&t']?><br>
      </td>
   </tr>
   <tr id="trsubhead">
      <td align="center">SL</td>
      <td align="center">Batch</td>
      <td align="center">Incentive Date</td>
      <td align="center">Customer</td>
      <td align="center">Company</td>
      <td align="center">Qty</td>
      <td align="center">Per/Bag</td>
      <td align="center">Sales Comission</td>
      <td align="center">Extra Comission</td>
      <td align="center">Adjust With<br> Oustandin</td>
      <td align="center">Balcnce</td>
   </tr>          
 <?
      $count=0;
      while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr>
          <td align="center"><?=$count;?></td>
          <td align="center"><?=$value[batch];?></td>
          <td align="center">
             <?
              //echo $value[indate];
              if($value[indate]=='')
                {
                  echo $value[date];   
                }
              else
                {
                 echo $value[indate];
                }   
             ?>
          </td>
          <td align="center"><?=$value[custname];?></td>
          <td align="center"><?=$value[cname];?><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[qty],0);?></td>
          <td align="center"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[pay],2);?></td>
          <td align="right"><?=number_format($value[adjust],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td align="right"><?=number_format($value[pay]+$value[adjust]-$value[withdraw],2);?></td>
      <?         
        $incustname=$value[custname];
        $totalqty=$totalqty+$value[qty];
        $totalpay=$totalpay+$value[pay];
        $totaladjust=$totaladjust+$value[adjust];
        $totalwithdraw=$totalwithdraw+$value[withdraw];
        
        $totalbal=$totalbal+$value[pay]+$value[adjust]-$value[withdraw]; 
        }      
      ?>
       </tr>
       <tr id="trsubhead" align="center">
          <td colspan="5">Total </td>
          <td colspan="1" align="right"><?=number_format($totalqty,0);?></td>
          <td colspan="1" align="right"><?=number_format($totalpay/$totalqty,2);?></td>
          <td colspan="1" align="right"><?=number_format($totalpay,2);?></td>
          <td colspan="1" align="right"><?=number_format($totaladjust,2);?></td>
          <td colspan="1" align="right"><?=number_format($totalwithdraw,2);?></td>
          
          
          <td colspan="3" align="right"><?=number_format($totalbal,2);?></td>
       </tr>       
    </table>

 
 
 <?php
 
  }
 ?>  
    
<?php
 // include "footer.php";
?>
