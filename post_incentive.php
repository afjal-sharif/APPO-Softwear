<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To PROCESS INCENTIVE ?")
if (answer !=0)
{
window.submit();
}
}	
	
</script> 


<?php 
 // DISPLAY  TEMP DATA.
 
   $id=$_GET[id];
   if($id==1)
   {
    echo "<b>INCENTIVE ADJUST SUCCESSFULLY</b>";
   }
 
      $user_dispaly="select tbl_temp_incentive.*,tbl_customer.name as cust_name,tbl_company.name as com_name 
                     from tbl_temp_incentive
                     join tbl_customer on tbl_customer.id=tbl_temp_incentive.customer
                     join tbl_company on tbl_company.id=tbl_temp_incentive.company
                     ";
      $users = mysql_query($user_dispaly);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
  ?>
    <br>
       
        <table width="900px" align="center" bordercolor="#AACCBB" border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
           <tr id="trhead"><td colspan="10">POST INCENTIVE</td></tr>       
           <tr bgcolor="#FFCCAA" align="center">    
               <td>SL</td>
               <td>COMPANY</td>
               <td>CUSTOMER</td>
               <td>PEROID</td>
               <td>QTY</td>
               <td>RATE</td>
               <td>ADDITION</td>
               <td>AMOUNT</td>
               <td>USER</td>  
               <td>&nbsp;</td>            
            </tr>    
   <?php    
       $count=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
         <tr align="center">  
             <td><?=$count?></td>
             <td><?=$value[com_name];?></td>
             <td><?=$value[cust_name];?></td>
             <td><?=$value[date_from];?> :: <?=$value[date_to];?></td>
             <td><?=number_format($value[qty],0);?></td>
             <td><?=number_format($value[rate],2);?></td>
             <td><?=number_format($value[addition],2);?></td>
             <td><?=number_format((($value[qty]*$value[rate])+($value[qty]*$value[addition])),2);?></td>
             <td><?=$value[user];?></td>
             <td>
                  <A HREF=javascript:void(0) onclick=window.open('edit_incentive.php?smsId=<?=$value[id];?>','Accounts','width=450,height=300,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="EDIT INCENTIVE"><img src="images/edit.png" height="15px" width="15px"></a>
             </td>
         </tr>
  <?php
       
       $totalqty=$totalqty+$value[qty];
       $totaladd=$totaladd+$value[addition];
       $totalvalue=$totalvalue+($value[qty]*$value[rate])+($value[addition]*$value[qty]);
      
      
      }
      echo "<tr id='trsubhead'>
              <td colspan='4'>TOTAL</td>
              <td>".number_format($totalqty,0)."</td>
              <td>".number_format($totalvalue/$totalqty,2)."</td>
              <td>".number_format($totaladd,2)."</td>
              <td>".number_format($totalvalue,2)."</td>
              <td>&nbsp;</td><td>&nbsp;</td>
           </tr>";
     ?> 
     <form name="incentive" method="post" action="incentive_process.php">
         <tr id="trsubhead">
             <td colspan="10"><input type="submit" name="confirm" onclick="ConfirmChoice(); return false;" title="PROCESS INCENTIVE" value=" POST INCENTIVE " />
         </tr>
     </form> 
      
     <?php 
      echo "</table>";
     } 
?>
 
 
 


  
<?php
 include "footer.php";
?>

