<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>


<script language="javascript">
function ConfirmChoiceOne()
{
answer = confirm("Are You Sure To Change Sales Status ?")
if (answer !=0)
{
window.submit();
}
}	



function ConfirmSales()
{
answer = confirm("Are You Sure To Sales Confirm?")
if (answer !=0)
{
window.submit();
}
}	


</script>

<?

if(isset($_POST["submitConfirm"]))
 {
 $flag=true;
 $con=$_SESSION[constatus];
 
 $sql="update tbl_sales set status=1  $con";
 db_query($sql) or die(mysql_error());
 echo "<image src='images/active.png' size='15px'><b>All Sales Confirmation Successfully</b>";
 }

if(isset($_POST["submitConfirmcancel"]))
 {
 $flag=true;
 $con=$_SESSION[constatus];
 
 $sql="update tbl_sales set status=0  $con";
 db_query($sql) or die(mysql_error());
 echo "<image src='images/active.png' size='15px'><b>All Sales Confirmation  Cancel Successfully</b>";
 }




if(isset($_POST["view"]))
 {
  $con='';
  $flag=false;
  $con="where (tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[product]!='')
   {
   $con=$con." and tbl_order.product=$_POST[product]";
   }
  if ($_POST[customer]!='')
   {
   $con=$con." and tbl_sales.customerid=$_POST[customer]";
   }
    
    $_SESSION[constatus]=$con; 
    $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.loadcost,tbl_sales.otherscost,tbl_sales.truckno,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,
                   tbl_customer.name as customer,tbl_product.name as product,tbl_sales.status
                   from tbl_sales
                   join tbl_order on tbl_sales.donumber=tbl_order.donumber
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   $con                 
                   order by tbl_sales.id desc";


 }
else
 {
    if($_SESSION[constatus]!='')
     {
      $con=$_SESSION[constatus];
      $order="order by tbl_sales.id desc";
     }
    else
     {
      $_SESSION[constatus]='';
      $con="where (tbl_sales.date between curdate() and curdate())";
      $order="order by tbl_sales.id desc ";
     } 
    
    $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.loadcost,tbl_sales.otherscost,tbl_sales.truckno,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,
                   tbl_customer.name as customer,tbl_product.name as product,tbl_sales.status
                   from tbl_sales
                   join tbl_order on tbl_sales.donumber=tbl_order.donumber
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   $con
                   $order ";
   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr id="trsubhead"><td colspan="5"  align="left"><b>Sales Confirmation...</b></td></tr>
 <tr>
   <td>From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,mobile,type  FROM tbl_customer order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  style="width: 200px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['mobile']?> : <?php echo $row_sql['type']?>   </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>

   <td>Product: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_product order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="product">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["product"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="15">Sales Confirmation Window.....</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Yes</td>
       <td>No</td>
       <td>Date</td>
       <td>Customer</td>
       <td>Product</td>
       <td>DO</td>
       <td>Invoice</td>
       <td>Qty</td>
       <td>Rate/Unit</td>
       <td>DF/Unit</td>
       <td>Load/Unit</td>
       <td>Others Cost</td>
       <td>Truck No</td>
       <td>Total Taka</td>
       <td id="trsubhead">Status</td>
    
    </tr>     
  <tr>
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
        $bal=$value[qty]-$value[dobal];
       ?>
       <tr>
          
          <td align="center">
            <? 
             if($value[status]==0)
             {
             
              ?>
               <a href="indelete.php?id=<?=$value['id'];?>&mode=salesconup&status=0" title="Confirm Sales">
               <img src='images/active.png' height='15px' width='15px'></a>
               
              <? 
             
              } 
            ?>
          </td>
         <td align="center">
            <? 
            if($value[status]==0)
             {
              ?>
               <a href="indelete.php?id=<?=$value['id'];?>&mode=salesconup&status=1" title="Not Confirm" onclick="ConfirmSales(); return false;">
               <img src='images/inactive.png' height='15px' width='15px'></a>
              <? 
             }
            ?>
          </td>      
          <td><?=$value[date];?></td>
          <td><b><?=$value[customer];?></b></td>
          <td><?=$value[product];?></td>
          <td align="right"><?=$value[donumber];?></td>
          <td><b><?=$value[invoice];?></b></td>
          
          <td align="right"><?=number_format($value[qty],2);?>&nbsp;<?=$value[unit];?></td>
          
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[df],2);?></td>
          <td align="right"><?=number_format($value[loadcost],2);?></td>
          <td align="right"><?=number_format($value[otherscost],2);?></td>
          <td align="right"><?=$value[truckno];?></td>
          <td align="right"><?=number_format(($value[qty]*$value[rate])+($value[qty]*($value[df]+$value[loadcost])+$value[otherscost]),2);?></td>         
          <td align="center" id="trsubhead">
            <? 
             if($value[status]==1)
               {
             ?>
              <a href="indelete.php?id=<?=$value['id'];?>&mode=salescon&status=<?=$value[status];?>" title="Update Status" onclick="ConfirmChoiceOne(); return false;">
               <img src='images/active.png' height='15px' width='15px'></a>
              <? 
               }
             else 
               {
              ?>
               <a href="indelete.php?id=<?=$value['id'];?>&mode=salescon&status=<?=$value[status];?>" title="Update Status" onclick="ConfirmChoiceOne(); return false;">
               <img src='images/inactive.png' height='15px' width='15px'></a>
              <? 
               }
            ?>
          </td>          
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $amount=$value[qty]*$value[rate]+($value[qty]*($value[df]+$value[loadcost]))+$value[otherscost];
       $totalamount=$totalamount+$amount;
       $unit=$value[unit];
       }
      }
    ?>  
  </tr>
 <tr id="trsubhead"><td colspan="6"> Total Amount</td>
 <td colspan="2" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
 <td colspan="7" align="right"><?=number_format($totalamount,2);?></td></tr>
 
 <?
 if(isset($_POST["view"]) and ($flag==false) and $total>0)
 {
 ?>
 <tr id="trhead">
    <td colspan="15">
       <form name="confirm" action="" method="post">
         <input type="submit" onclick="ConfirmSales(); return false;" name="submitConfirm" value="   Confirm All Sales  " />
         &nbsp;&nbsp;&nbsp;
         <input type="submit" onclick="ConfirmSales(); return false;" name="submitConfirmcancel" value=" Cancel Confirm All Sales  " />
       </form>
    </td> 
</tr>
 <?
 }
 ?>
 
 </table>


<?php
 include "footer.php";
?>
