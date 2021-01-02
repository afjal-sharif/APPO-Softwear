<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<link href="skin.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Payment Amount To Reatiler ?")
if (answer !=0)
{
window.submit();
}
}	


function ConfirmChoice1()
{
answer = confirm("Are You Sure To Add Payment & Adjust With Oustanding ?")
if (answer !=0)
{
window.submit();
}
}	


</script> 


<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[customer]) or empty($_POST[cityList]) or empty($_POST[batch]) or empty($_POST[amount])) 
   {
    echo "<img src='images/inactive.png'> Error !! Pls give input properly";
   }
  else
   {
  
  $customer=$_POST[customer];
  $company=$_POST[cityList];
  $batch=$_POST[batch];
  $rate=$_POST[rate];
  $qty=$_POST[qty];
  $amount=$_POST[amount];
  
  if($rate==''){$rate=0;}
  if($qty==''){$qty=0;}  
  
  
   $sql="insert into tbl_incentive_pay(customerid,company,batch,qty,rate,pay,user,date) 
        value($customer,$company,'$batch',$qty,$rate,$amount,'$_SESSION[userName]','$_SESSION[dtcustomer]')"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png'> <b>Data Insert Successfully.</b>";
    } // Error chech If
 }// Submit If
?>

<?
if(isset($_POST["submit_adjust"]))
 {
  if (empty($_POST[customer]) or empty($_POST[cityList]) or empty($_POST[batch]) or empty($_POST[amount])) 
   {
    echo "<img src='images/inactive.png'> Error !! Pls give input properly";
   }
  else
   {
  
  $customer=$_POST[customer];
  $company=$_POST[cityList];
  $batch=$_POST[batch];
  $rate=$_POST[rate];
  $qty=$_POST[qty];
  $amount=$_POST[amount];
  
  if($rate==''){$rate=0;}
  if($qty==''){$qty=0;}  
  
  
   $sql="insert into tbl_incentive_pay(customerid,company,batch,qty,rate,pay,user,date) 
        value($customer,$company,'$batch',$qty,$rate,$amount,'$_SESSION[userName]','$_SESSION[dtcustomer]')"; 
   db_query($sql) or die(mysql_error());
   echo "<img src='images/active.png'> <b>Incentive Payment Insert Successfully.</b>";
   
   // Start Payment Adjust With Oustanding Module.
  
   $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   $newmrnomain=$row_sql[mrno];
 
 
   $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,mrno,remarks,automrno,customerid,paytype) 
         value('$_SESSION[dtcustomer]','-',$amount,0,'$_SESSION[userName]','$newmrnomain-Incentive Adj.','Incentive Adjust',$newmrnomain,$customer,'Incentive Adj.')";     
   db_query($sql) or die(mysql_error());  
   echo "<img src='images/active.png'> <b>Payment Receive Successfully.</b>";     
   
       
   $remarks="Incnetive Adjust With MrNo:$newmrnomain";
   $sql="insert into tbl_incentive_pay(batch,date,indate,customerid,withdraw,company,remarks,user,type)
                values('Adjust-$batch','$_SESSION[dtcustomer]','$_SESSION[dtcustomer]',$customer,$amount,'$company','$remarks','$_SESSION[userName]',2)";
   db_query($sql) or die (mysql_error());  
   echo "<img src='images/active.png'> <b>Adjust With Oustanding Successfully.</b>";
   
    } // Error chech If
 }// Submit If
?>



<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr bgcolor="#FFEEEE"><td align="left"  colspan="6">Add Incentive Balance(Manually)</td></tr> 
    <tr bgcolor="#FFCCAA" align="center">
     <td>Customer</td>
     <td>Company</td>
     <td>Batch</td>
     <td>Quantity</td>
     <td>Rate</td>
     <td>Amount</td>
    </tr>
   
    <tr bgcolor="#FFCCAA">  
        
        <td>
         
          <?
           $query_sql = "SELECT id,name,address,sp  FROM tbl_customer where type='Retailer' order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
              
          ?>
              <select name="customer"  style="width: 180px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name'] ?>  ::  <?php echo $row_sql['type'] ?> ::  <?php echo $row_sql['address'] ?> ::  <?php echo $row_sql['sp'] ?>   </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td>
       
         <select name="cityList" style="width:180px">     
         <?
         $sql="Select id,name from tbl_company where status<>2";

          $sql = mysql_query($sql) or die(mysql_error());
          $row_sql = mysql_fetch_assoc($sql);

             do {  
         ?>
            <option value="<?php echo $row_sql['id'];?>"><?php echo $row_sql['name'] ;?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
       </td>
       <td><input type="text" size="10"  name="batch" /> </td>         
       <td><input type="text" size="8"  name="qty" /> </td>
       <td><input type="text" size="8"  name="rate" /> </td>
       <td><input type="text" size="10"  name="amount" /> </td>
     </tr>    
     <tr id="trsubhead"><td colspan="6" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Payment  " /> </td> </tr>
     <tr id="trsubhead"><td colspan="6" align="center"><input type="submit"  name="submit_adjust" onclick="ConfirmChoice1(); return false;" value="   Payment & Adjust With Oustanding  " /> </td> </tr>
</table>
</form>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr bgcolor="#FFCC09"><td align="center" colspan="8">Add Incentive Manually.</td></tr> 
   <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Customer</td>
       <td>Company</td>     
       <td>Batch Name</td>
       <td>Qty</td>
       <td>Per/Unit(Rate)</td>
       <td>Pay Amount</td>
       <td>Adj Amount</td>   
      </tr>     
  
   <?
     $user_query="select date,batch,tbl_customer.name as cust,tbl_company.name as com,qty,rate,pay,adjust,withdraw from tbl_incentive_pay 
                  join  tbl_customer on tbl_customer.id=tbl_incentive_pay.customerid
                  join  tbl_company on tbl_company.id=tbl_incentive_pay.company
                  order by tbl_incentive_pay.id desc
                  ";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[cust];?></td>
          <td><?=$value[com];?></td>
          <td><?=$value[batch];?></td>
          <td><?=$value[qty];?></td>
          <td><?=$value[rate];?></td>
          <td align="right"><?=number_format($value[pay],2);?></td>
          <td align="right"><?=number_format($value[adjust]+$value[withdraw],2);?></td>
       </tr>
       <?
        $sumtotal=$sumtotal+$value[pay];
        $sumtotaladj=$sumtotaladj+$value[adjust]+$value[withdraw];
       }
      }
    ?>  
  <tr align="right"><td colspan="6" align="center">Total :</td><td><?=number_format($sumtotal,2);?></td><td colspan="1" align="right"><?=number_format($sumtotaladj,2);?></td></tr>
  <tr id="trsubhead"><td colspan="8" align="right"><b>Balance Amount : <?=number_format($sumtotal-$sumtotaladj,2);?></b> </td></tr>
 </table>

<?php
 include "footer.php";
?>
