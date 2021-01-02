<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<script language="javascript">
function ConfirmChoiceOrder()
{
answer = confirm("Are You Sure To Delete DO ?")
if (answer !=0)
{
window.submit();
}
}	

function ConfirmChoiceInvoice()
{
answer = confirm("Are You Sure To Delete Invoice ?")
if (answer !=0)
{
window.submit();
}
}	

function ConfirmSales()
{
answer = confirm("Are You Sure To Delete Expense.?")
if (answer !=0)
{
 window.submit();
}
}	

function ConfirmMoney()
{
answer = confirm("Are You Sure To Delete Payment Receive.?")
if (answer !=0)
{
 window.submit();
}
}	


function ConfirmMoneyPay()
{
answer = confirm("Are You Sure To Delete Payment To Supplier.?")
if (answer !=0)
{
 window.submit();
}
}


</script>


<?php
 if(isset($_POST[submitorder]))
  {
   $donumber=$_POST[ref_id];
   
   $user_query="Select dtDate,tbl_order.donumber,company,count(tbl_receive.product) as item,sum(tbl_receive.qty*tbl_receive.rate) as value,tbl_order.remarks
         from tbl_order
         join tbl_receive on tbl_order.donumber=tbl_receive.donumber
         where tbl_order.donumber='$donumber'
         group by tbl_order.donumber
         ";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   $remarks=" $_POST[remarks] >>Item :".$row_sql[item]." Value:".number_format($row_sql[value],2).":".$row_sql[remarks];
            
   $sql="insert into tbl_delete_log(type,ref_date,ref_id,sup_cust,user,remarks)
         values(0,'$row_sql[dtDate]','$donumber','$row_sql[company]','$_SESSION[userName]','$remarks')";
   db_query($sql) or die(mysql_error());
   
   $sql="delete from tbl_receive where donumber='$donumber'";
   db_query($sql) or die(mysql_error());
   
   $sql="delete from tbl_order where donumber='$donumber'";
   db_query($sql) or die(mysql_error());
   
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! DO No :<b> $donumber </b>  Deleted.</b>";
  }
?>


<?php
 if(isset($_POST[submitinvoice]))
  {
   $invoice=$_POST[ref_id];
   
  $user_query = "SELECT invoice,customerid,name,max(date) as dtDate,sum(qty) as qty,sum(qty*rate) as value FROM `tbl_sales`
                         join tbl_customer on tbl_customer.id=`tbl_sales`.customerid
                         where invoice='$invoice'
                         group by invoice,customerid
                         having max(date)>=(($_SESSION[dtcustomer])-30)";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   $remarks="$_POST[remarks] >>Qty :".$row_sql[qty]." Value:".number_format($row_sql[value],2);
   
   $dtDate=$row_sql[dtDate];
   $cid=$row_sql[customerid];
            
   $sql="insert into tbl_delete_log(type,ref_date,ref_id,sup_cust,user,remarks)
         values(1,'$row_sql[dtDate]','$invoice','$row_sql[customerid]','$_SESSION[userName]','$remarks')";
   db_query($sql) or die(mysql_error());
   
   $sql="delete from tbl_sales where invoice='$invoice' and customerid='$cid'";
   db_query($sql) or die(mysql_error());
  
  
  
   $user_query = "SELECT * FROM `tbl_dir_receive` where invoice='$invoice' and date='$dtDate' and customerid='$cid'";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   $total = mysql_num_rows($users); 
   if($total>0)
   {
   $remarks='S:'.$row_sql[mrno].''. $row_sql[chequeno].''. $row_sql[depositebank].'C:'.$row_sql[hcash].'B:'.$row_sql[cash];
  
   $mrno=$row_sql[mrno];
   $bankamount=$row_sql[cash];
            
   $sql="insert into tbl_delete_log(type,ref_date,ref_id,sup_cust,user,remarks)
         values(3,'$row_sql[dtDate]','$invoice','$row_sql[customerid]','$_SESSION[userName]','$remarks')";
   db_query($sql) or die(mysql_error());
   
   
   $sql="delete from tbl_dir_receive where invoice='$invoice' and date='$dtDate' and customerid='$cid'";
   db_query($sql) or die(mysql_error());
     
   $sql="delete from tbl_cash where refid='$mrno'  and date='$dtDate' and withdraw=0 and type=0";
   db_query($sql) or die(mysql_error());
   
   if($bankamount>0)
   {
     $sql="delete from tbl_bank where rec_ref_id='$mrno'  and date='$dtDate' and withdraw=0 and type=1";
     db_query($sql) or die(mysql_error());
   }
   
   } 
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Invoice No :<b> $invoice </b>  Deleted.</b>";
  }
?>


<?php
 if(isset($_POST[submit_money]))
  {
   $mrno=$_POST[ref_id];
   
   
  
   $user_query = "SELECT * FROM `tbl_dir_receive` where mrno='$mrno'";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   $remarks="M:$row_sql[mrno] $row_sql[chequeno] $row_sql[depositebank].C:".$row_sql[hcash]."B:".$row_sql[cash];
  
   $mrno=$row_sql[mrno];
   $dtDate=$row_sql[date];
   $bankamount=$row_sql[cash];
            
   $sql="insert into tbl_delete_log(type,ref_date,ref_id,sup_cust,user,remarks)
         values(3,'$row_sql[dtDate]','$mrno','$row_sql[customerid]','$_SESSION[userName]','$remarks')";
   db_query($sql) or die(mysql_error());
   
   
   $sql="delete from tbl_dir_receive where mrno='$mrno' and date='$dtDate'";
   db_query($sql) or die(mysql_error());
     
   $sql="delete from tbl_cash where refid='$mrno'  and date='$dtDate' and withdraw=0";
   db_query($sql) or die(mysql_error());
   
   if($bankamount>0)
   {
    $sql="delete from tbl_bank where rec_ref_id='$mrno'  and date='$dtDate' and withdraw=0";
    db_query($sql) or die(mysql_error());
   }
   
    
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Payment Receive No :<b> $mrno </b>  Deleted.</b>";
  }
?>


<?php
 if(isset($_POST[submit_money_pay]))
  {
   $mrno=$_POST[ref_id];
   
   
   $del_reason=$_POST[remarks];
   $user_query = "SELECT * FROM `tbl_com_payment` where id='$mrno'";
   $users = mysql_query($user_query);
   $row_sql= mysql_fetch_assoc($users);
   
   $pay_source=$row_sql[bank];
   $dtDate=$row_sql[paydate];
   
   $remarks="D: $row_sql[paydate] .C:$row_sql[companyid] .S: $row_sql[bank] .CH:$row_sql[chequeno].A: $row_sql[bamount]. U:$del_reason";
  
            
   $sql="insert into tbl_delete_log(type,ref_date,ref_id,sup_cust,user,remarks)
         values(4,'$row_sql[paydate]','$mrno','$row_sql[companyid]','$_SESSION[userName]','$remarks')";
   db_query($sql) or die(mysql_error());
   
   
   $sql="delete from tbl_com_payment where id='$mrno' and paydate='$dtDate'";
   db_query($sql) or die(mysql_error());
   
   if($pay_source=='Cash')
   {
    $sql="delete from tbl_cash where refid='$mrno'  and date='$dtDate' and deposite=0";
    db_query($sql) or die(mysql_error());
   }
   else
   {
    $sql="delete from tbl_bank where rec_ref_id='$mrno'  and date='$dtDate' and deposite=0";
    db_query($sql) or die(mysql_error());
   }
   
    
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Payment To Supplier Deleted.</b>";
  }
?>









<?
$id=$_GET[id];

if($id=='order')
{
?>

<form name="order" method="post" action="">
<table width="955px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

   <tr><td colspan="4" align="center"  id="trhead"><b>:: Order Delete ::</b></td></tr>
   <tr>
       <td align="center">Existing Avaiable Order :
           <?
           $query_sql = "SELECT  distinct dtDate,company,`tbl_receive`.donumber   ,name FROM `tbl_receive`
                          left join tbl_sales on `tbl_receive`.donumber=tbl_sales.donumber
                          left join tbl_order on tbl_order.donumber=tbl_receive.donumber
                          join tbl_company on tbl_order.company=tbl_company.id
                          where tbl_sales.donumber is null and tbl_company.status<>2                       
                        order by dtdate desc,donumber desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="ref_id"   id ="ref_id" style="width:350px">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['donumber'];?>" <?php if($_POST["ref_id"]==$row_sql['donumber']) echo "selected";?> ><?php echo $row_sql['donumber']." ::  ".$row_sql['name']." :: ".$row_sql['dtDate']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>&nbsp;&nbsp;&nbsp;
          Reason For Delete :<input type="text" name="remarks"  size="50" />
       </td>
       </tr>
       <tr id="trsubhead">
        <td>   
          <input type="submit" name="submitorder" onclick="ConfirmChoiceOrder(); return false;" value= "&nbsp;&nbsp;Delete DO &nbsp;&nbsp;">
       </td>
   </tr>
</table>
</form>
<?
}
?>

<?
if($id=='invoice')
{
?>

<form name="order" method="post" action="">
<table width="955px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

   <tr><td colspan="2" align="center"  id="trhead"><b>:: Invoice Delete ::</b></td></tr>
   <tr><td colspan="1" align="center"  id="trhead"><b>Existing Avaiable Invoice</b></td>
       <td colspan="1" align="center"  id="trhead"><b>Reason For Delete</b></td>
   </tr>
   <tr>
       <td align="center">
           <?
          
           $query_sql = "SELECT invoice,customerid,name,date as dtDate,sum(qty) as qty,sum(qty*rate) as value FROM `tbl_sales`
                         join tbl_customer on tbl_customer.id=`tbl_sales`.customerid
                         group by invoice,customerid,date
                         having date>='$_SESSION[dtcustomer]'
                         order by tbl_sales.id desc
                         ";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
          
          ?>
          <select name="ref_id" style="width:450px">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['invoice'];?>" <?php if($_POST["ref_id"]==$row_sql['invoice']) echo "selected";?> ><?php echo $row_sql['invoice']." ::  ".$row_sql['name']." :: ".$row_sql['dtDate']?>:: Qty.<?=$row_sql['qty']?>:: Value. <?=number_format($row_sql['value'],0);?>  </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
           
       </td>
       <td><input type="text" name="remarks"  size="50" /></td>
       </tr>
       <tr id="trsubhead">
        <td colspan="2">   
          <input type="submit" name="submitinvoice" onclick="ConfirmChoiceInvoice(); return false;" value= "&nbsp;&nbsp;Delete Invoice &nbsp;&nbsp;">
       </td>
   </tr>
</table>
</form>
<?
}
?>

<?
if($id=='money')
{
?>

<form name="order" method="post" action="">
<table width="955px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

   <tr><td colspan="2" align="center"  id="trhead"><b>:: Payment Receive Delete ::</b></td></tr>
   <tr><td colspan="1" align="center"  id="trhead"><b>Existing Avaiable MR No</b></td>
       <td colspan="1" align="center"  id="trhead"><b>Reason For Delete</b></td>
   </tr>
   <tr>
       <td align="center">
           <?
          
           $query_sql = "SELECT mrno,customerid,name,date as dtDate,hcash,cash,invoice  FROM `tbl_dir_receive`
                         join tbl_customer on tbl_customer.id=`tbl_dir_receive`.customerid
                         where date>='$_SESSION[dtcustomer]'
                         order by tbl_dir_receive.id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
          
          ?>
          <select name="ref_id" style="width:450px">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['mrno'];?>" <?php if($_POST["ref_id"]==$row_sql['mrno']) echo "selected";?> >MR:<?php echo $row_sql['mrno']." ::Invoice:".$row_sql['invoice'] .$row_sql['name']." :: ".$row_sql['dtDate']?>:: Cash.<?=number_format($row_sql['hcash'],2)?>::Bank: <?=number_format($row_sql['cash'],0);?>  </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
           
       </td>
       <td><input type="text" name="remarks"  size="50" /></td>
       </tr>
       <tr id="trsubhead">
        <td colspan="2">   
          <input type="submit" name="submit_money" onclick="ConfirmMoney(); return false;" value= "&nbsp;&nbsp;Delete Payment Receive &nbsp;&nbsp;">
       </td>
   </tr>
</table>
</form>
<?
}
?>



<?
if($id=='moneypay')
{
?>

<form name="order" method="post" action="">
<table width="955px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

   <tr><td colspan="2" align="center"  id="trhead"><b>:: Payment To Supplier Delete ::</b></td></tr>
   <tr><td colspan="1" align="center"  id="trhead"><b>Existing Avaiable Cheque No</b></td>
       <td colspan="1" align="center"  id="trhead"><b>Reason For Delete</b></td>
   </tr>
   <tr>
       <td align="center">
           <?
          
           $query_sql = "SELECT tbl_com_payment.*, tbl_company.name as cname  FROM `tbl_com_payment`
                         join tbl_company on tbl_company.id=`tbl_com_payment`.companyid
                         where paydate='$_SESSION[dtcustomer]' and paydate>='2014-08-08'
                         order by tbl_com_payment.id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
          
          ?>
          <select name="ref_id" style="width:450px">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["ref_id"]==$row_sql['id']) echo "selected";?> >Date:<?php echo $row_sql['paydate']." ::From:".$row_sql['bank']." :: ".$row_sql['cname'].": Amount :".number_format($row_sql['bamount'],0) .":".$row_sql[remarks] ;?>  </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
           
       </td>
       <td><input type="text" name="remarks"  size="50" /></td>
       </tr>
       <tr id="trsubhead">
        <td colspan="2">   
          <input type="submit" name="submit_money_pay" onclick="ConfirmMoneyPay(); return false;" value= "&nbsp;&nbsp;Delete Payment To Supplier &nbsp;&nbsp;">
       </td>
   </tr>
</table>
</form>
<?
}
?>























<?
if($id=='expense')
{
$con1=$_SESSION[dttransection];
?>

<form name="order" method="post" action="">
<table width="955px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr><td colspan="1" align="center"  id="trhead"><b>:: Edit Expense  ::</b></td></tr>
   <tr>
     <td align="center" colspan="1"> 
           
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="submit"  name="submit_exp" value="   View  " /> 
        </td>
   </tr> 
 </table>
</form>
<?

  if(isset($_POST["submit_exp"]))
   {
    $con1=$_POST[demo11];
   }
  else
   {
    $con1=$_SESSION[dttransection];
   }
 
  $user_query="select id,date,remarks,withdraw, 1 as type from tbl_cash where date='$con1' and poorexp=2
             union all
             SELECT id,date,remarks,withdraw,2 as type FROM `tbl_bank` where exptype=1 and date='$con1' ";   
  
  $users = mysql_query($user_query);
      
  $total = mysql_num_rows($users);    
  if ($total>0)
      {
 ?>
 <table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
      <tr id="trhead"><td colspan="6">Expense Details.</td></tr> 
      <tr id="trsubhead">    
           <td>ID</td>
           <td>Date</td>
           <td>Source</td>
           <td>Remarks</td>
           <td>Amount</td>
           <td>Delete</td>
       </tr>     

      <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr  align="center">
          <td><?=$value[id];?></td>
          <td><?=$value[date];?></td>
          
          <td>
            <?
             if($value[type]==1)
              {
               echo " Cash";
              }
             else
              {
               echo "Bank";
              } 
            ?>
          </td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td>
              <a href="indelete.php?id=<?=$value['id'];?>&mode=exp_delete&source=<?=$value[type]?>&data='<?=$value[remarks];?> **amount: <?=$value[withdraw];?>'" title="Delete Expense" onclick="ConfirmSales(); return false;">
               <img src='images/inactive.png' height='15px' width='15px'>
              </a>
         </td> 
          
          
       </tr>
       <?
       }     
       ?>  
 



 </table>
 <?    
      }
}
?>


<?
if($id=='edit_invoice')
{
?>

<form name="order" method="post" action="">
<table width="955px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

   <tr><td colspan="2" align="center"  id="trhead"><b>:: Edit Invoice ::</b></td></tr>
   <tr>
     <td align="center" colspan="2">Enter Invoice No:<input type="text" size="20" name="invoiceid"  value="<?=$_POST[invoiceid];?>">
       <input type="submit" name="viewinvoice" value= " View ">
    </td>
  </tr>
</table>
</form>
<?
}
?>
<?
if($_POST["viewinvoice"])
{
 
  $user_query="Select tbl_sales.id,date_format(date,'%d-%M-%y') as dt,invoice,tbl_sales.qty as qty,tbl_sales.unit,tbl_sales.rate as rate,
                   tbl_sales.loadcost as loadcost,tbl_sales.otherscost as otherscost,tbl_sales.customername,tbl_sales.bundle as bundle,
                   tbl_sales.truckno,tbl_sales.df as df,
                   tbl_product.name as product,tbl_sales.customerid as cust,
                   tbl_product_category.name as cat_name
                   from tbl_sales 
                   left join tbl_product on tbl_sales.product=tbl_product.id
                   left join tbl_product_category on tbl_product_category.id=tbl_product.category_id
                   where invoice='$_POST[invoiceid]' ";
 $users = mysql_query($user_query);
 $total = mysql_num_rows($users);   
  
 if ($total>0)
    {
    ?>
     <br>
     <table width="100%" bgcolor="#FFFFFA" align="left" bordercolor="#AACCBB"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
     
      <tr align="center" id="trsubhead">
        <td>Product</td>
        <td>Qty</td>
        <td>Bundle</td>
        <td>Rate</td>
        <td>Total</td>
        <td>&nbsp;</td>
      </tr>  
    <?
     while($value=mysql_fetch_array($users))
     {
     ?>
    <tr align="center">    
       <td align="center" colspan='1'><?=$value[cat_name];?> : <?=$value[product];?></td>
       <td align="right" style="font-size:13px"><?=$value[qty];?> &nbsp; <?=$value[unit];?></td>
       <td align="center" style="font-size:13px"><?=number_format($value[bundle],0);?></td>
       <td align="right" style="font-size:13px"><?=number_format($value[rate],2);?></td>
       <td align="right" style="font-size:13px"><?=number_format(($value[qty]*$value[rate]),2);?></td>
       <td>
              <A HREF=javascript:void(0) onclick=window.open('edit_item_order.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Student Info"><img src="images/edit.png" height="15px" width="15px"></a>
      </td> 
    </tr> 

     <?
     }
   ?>
     </table> 
   <?
    }
 
}
?>




<?php
 include "footer.php";
?>
