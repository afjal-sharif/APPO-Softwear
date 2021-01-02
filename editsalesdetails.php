<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>


<script src="./js/code_regen.js"></script> 
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Delete Sales?")
if (answer !=0)
{
window.submit();
}
}	
</script>

<?
 if(isset($_POST["submit"]))
  {
   $invoice=$_POST[invoice];
   //$payment=$_POST[payment];
   
  $sql="select customerid,invoice, sum(qty*(df+loadcost)+otherscost) as cost  from tbl_sales where invoice='$invoice' group by customerid,invoice";
  $users_skills = mysql_query($sql); 
  $value=mysql_fetch_array($users_skills);
  
  $amount=$value[cost];
  $remarks="Cash Withdraw for Goods Sales. Invoice $invoice Customer $value[customerid]";
  
  if ($amount<>0)
    { 
     $sql_cash="delete from tbl_cash where remarks='$remarks' and withdraw=$amount and type=2";
     db_query($sql_cash);
     $msg="Cash Transection.";
    }
  $update_query = "Select * from  tbl_sales where invoice=$invoice"; 
  $users = mysql_query($update_query);
  $total = mysql_num_rows($users);    
  if ($total>0)
   {
     while($value=mysql_fetch_array($users))
      {
       $sql="update tbl_sales set qty=0,orginalqty=$value[qty] where id=$value[id]";
       db_query($sql);
      }
   }     
 $msgdelete=$msg." Sales Delete $_POST[invoice].";
 }
 
 
 // Return Sales.
  if(isset($_POST["submitreturn"]))
  {
   $invoice=$_POST[invoice];
   $update_query = "Select * from  tbl_sales where invoice=$invoice"; 
   $users = mysql_query($update_query);
   $total = mysql_num_rows($users);    
   if ($total>0)
    {
     while($value=mysql_fetch_array($users))
      {
       $sql="update tbl_sales set qty=0,orginalqty=$value[qty] where id=$value[id]";
       db_query($sql);
      }
    }     
   $msgdelete=$msg." Sales Delete $_POST[invoice].";
   

  }
 
?>



<?
if(isset($_POST["view"]))
 {
  $con='';
  
  $con="where (tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[product]!='')
   {
   $con=$con." and tbl_order.product=$_POST[product]";
   }
  if ($_POST[customer]!='')
   {
   $con=$con." and tbl_sales.customerid=$_POST[customer]";
   }
    
    
    $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.loadcost,tbl_sales.otherscost,tbl_sales.truckno,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,bdestination,
                   tbl_customer.name as customer,tbl_product.name as product
                   from tbl_sales
                   join tbl_order on tbl_sales.donumber=tbl_order.donumber
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   $con                 
                   order by tbl_sales.id desc";


 }
else
 {
    $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.loadcost,tbl_sales.otherscost,tbl_sales.truckno,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,bdestination,
                   tbl_customer.name as customer,tbl_product.name as product
                   from tbl_sales
                   join tbl_order on tbl_sales.donumber=tbl_order.donumber
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   order by tbl_sales.id desc limit 0,10";
   
 }
?>
<table width="450px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<form name="invoicdel" method="post" action="">

  <tr><td colspan="1" align="center"  id="trsubhead"><b>Delete Incoice Number</b></td></tr>
      
  </tr>
  <tr><td colspan="1" align="center"><b><? echo $msgdelete; $msgdelete="";?></b></td>
     
  </tr>
  
  <tr><td colspan="1" align="center">
        Invoice Number : <input type="text" size="10" name="invoice" value="<?=isset($_POST[invoice])?$_POST[invoice]:''?>" size="4" />
                        <!-- <input type="checkbox" name="payment" <?if(isset($_POST[payment])) echo "CHECKED";?>  />Check if Payment also Delete-->
                         <input type="submit" name="submit" value=" Delete " onclick="ConfirmChoice(); return false;">
                          
      </td>
  </tr>
      

</form>

</table>

<br>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trsubhead"><b>Sales Goods Details Report</b></td></tr>
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
 <tr id="trhead"><td colspan="15">Sales Goods Details.</td></tr> 

   <tr bgcolor="#CCAABB">    
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
       <td>Destination</td>
       <td>Total Taka</td>
       <td>Return</td>
       <td>Edit</td>
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
          <td><?=$value[date];?></td>
          <td><b><?=$value[customer];?></b></td>
          <td><?=$value[product];?></td>
          <td align="right"><?=$value[donumber];?></td>
          <td><b><?=$value[invoice];?></b></td>
          
          <td align="right"><?=number_format($value[qty],0);?>&nbsp;<?=$value[unit];?></td>
          
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[df],2);?></td>
          <td align="right"><?=number_format($value[loadcost],2);?></td>
          <td align="right"><?=number_format($value[otherscost],2);?></td>
          <td align="right"><?=$value[truckno];?></td>
          <td align="right"><?=$value[bdestination];?></td>
          <td align="right"><?=number_format(($value[qty]*$value[rate])+($value[qty]*($value[df]+$value[loadcost])+$value[otherscost]),2);?></td>
          <td align="center"><a href="salesreturn.php?id=<?=$value[id];?>" onClick="return (confirm('Are you sure to Sales Return!!!')); return false;"><img src="images/edit.png" size="15px" width="15px" title="Retun Salse"></a></td>
          <td align="center">
          <A HREF=javascript:void(0) onclick=window.open('editsales.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Customer Info">
          <img src="images/edit_new.png" size="20px" width="20px" title="Edit Salse"></a></td>       
       </tr>
       <?
       $amount=$value[qty]*$value[rate]+($value[qty]*($value[df]+$value[loadcost]))+$value[otherscost];
       $totalamount=$totalamount+$amount;
       }
      }
    ?>  
  </tr>
 <tr id="trsubhead"><td colspan="5"> Total Amount</td><td colspan="7" align="right"><?=number_format($totalamount,2);?></td><td colspan="2">&nbsp;</td></tr>
 </table>


<?php
 include "footer.php";
?>
