<?php
 session_start();
 $mnuid=508;
 include "includes/functions.php";
 $msgmenu="New Customer";
 include "session.php";  
 include "header.php";
 $id=$_GET[id];
?>
<script language="javascript">
function ConfirmSales()
{
answer = confirm("Are You Sure To Delete This Sales.?")
if (answer !=0)
{
 window.submit();
}
}	
</script>


<? 
 if($id==1)
 {
  $custid=$_GET[cust];
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Select Product Category</td></tr>  
    <tr bgcolor="#FFCCAA">    
      <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,address,climit,type,status,area  FROM tbl_customer  where status=0  order by name"; 
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  onchange="cname()" style="width: 250px;" id="customer_sec">
             <option value="1">Cash Customer ::</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST[customer]==$row_sql['id']) echo "selected";?> <?php if($custid==$row_sql['id']) echo "selected";?>  >
                <?php echo $row_sql['name']?> :: <?php echo $row_sql['area'];?> :: <?php echo $row_sql['address']?>::
             </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
      </td>
      <td>
       Product Category:
       <?
           $query_sql = "SELECT id,g_name,name  FROM `tbl_product_category` where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="product" style="width: 200px;">    
               <option value=""></option>      
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['id'];?>::<?php echo $row_sql['name'];?>" <?php if($_POST["product"]=="$row_sql[id]::$row_sql[name]") echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['g_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
         <input type="submit" name="view" value= "  View  "> 
       </td> 
  </tr>
 </table>
</form>
<!--  Company Info Details Here -->
<form name="po" id="vendor" action="cash_sales_process.php" method="post"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Product List: <b>Daily Cash Sales</b> </td></tr> 

 <tr bgcolor="#F3F3F3" align="center">   
         <td>SL No</td> 
         <td>Product Name</td>
         <td>Unit</td>       
         <td>Sales Qty</td>   
         <td>Sales Rate</td> 
         <td>Cost/Total</td>    
                        
         <td>Remarks</td>           
   </tr>     
 <?
   if(isset($_POST["view"]))
    {
      $strpos=strpos($_POST[product],'::')+2;
      $custid=$_POST[customer];
      $strid=substr($_POST[product],0,$strpos-2);
      $user_query="select * from tbl_product where category_id='$strid' order by name asc";   
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[unit];?></td>
          <td align="center">
           <input type="text" name="qty[<?=$value[id];?>]" size="6"  value="0" />
           <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
           
           <input name="custid" type="hidden" value="<?=$custid;?>" />
           <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" />
           <input name="product_name[<?=$value[id];?>]" type="hidden" value="<?=$value['name'];?>" />  
          </td>
          
          <td align="center">
             <input type="text" name="rate[<?=$value[id];?>]" size="6"  value="<?=$value[price]?>" />
          </td>
          <td align="center">
             <input type="text" name="cost[<?=$value[id];?>]" size="6"  value="0" />
          </td>
          
          
          <td align="center">
             <input type="text" name="remarks[<?=$value[id];?>]" size="15"  value="-" />
          </td>
       </tr>
       <?
         }
        }
       ?>
       <tr align="center" bgcolor="#FFEE09">
          <td>Cash:<input type="text" name="cash" value="0"  size="8" /></td>
          <td>Online Cash:<input type="text" name="bank" value="0"  size="8" /></td>
          <td>Discount:<input type="text" name="discount" value="0"  size="6" /></td>
          <td colspan="2">Bank 
           <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name where isCustomer=0 order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
           ?>
           <select name="depositebank"  style="width: 220px;">
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["depositebank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>  
          </td>
          
          <td colspan="2"> Remarks <input type="text" name="remarks"   size="15" /></td>
       </tr>
       <tr align="center" id="trsubhead">
             <td colspan="7">
                    <input type="submit" name="submitqry"  value=" ADD TO CARD ">
             </td>
        </tr>
       <?
       }
       ?>
   </table>
       <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
       <tr id="trhead"><td colspan="9">Product in Sales Card. </td></tr> 
  
      <? 
      
      $user_query="select tbl_daily_sales.*,name from tbl_daily_sales    
                 join tbl_customer on tbl_customer.id=tbl_daily_sales.cust_id 
                 where tbl_daily_sales.user='$_SESSION[userName]'
                 order by product_name asc";
      $users = mysql_query($user_query);
      $total_sal = mysql_num_rows($users);    
      if ($total_sal>0)
      {
     ?>
      
       <tr bgcolor="#F3F3F3" align="center">   
               <td>SL No</td> 
               <td>Customer</td>
               <td>Product</td>       
               <td>Sales Qty</td>   
               <td>Sales Rate</td> 
               <td>Cost(Total)</td>               
               <td>Total Amount</td>    
               <td>Remarks</td>    
               <td>&nbsp;</td>           
         </tr>           
     <? 
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
          <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[product_name];?></td>
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[cost],2);?></td>
          <td align="right"><?=number_format(($value[qty]*$value[rate])+ $value[cost],2);?></td>
          <td><?=$value[remarks];?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=cash_sales&type=1&cust=<?=$value[cust_id];?>" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
          </td>         
       </tr>
       <?
         $totalqty=$totalqty+$value[qty];
         $totalvalue=$totalvalue+(($value[qty]*$value[rate])+$value[cost]);
        }
        echo "<tr align='center'><td colspan='4'>Total Qty:".number_format($totalqty,2)."</td><td colspan='5'>Total Value :".number_format($totalvalue,2)."</td></tr>";
           
        
      }   
      $user_query="select * from tbl_daily_cash_sales where user='$_SESSION[userName]'";
      $users_payment = mysql_query($user_query);
      $total_pay = mysql_num_rows($users_payment);    
      if ($total_pay>0)
      {
      ?>
      
      <?
      while($value=mysql_fetch_array($users_payment))
       { 
       ?>
        <tr align="center">
          <td colspan="2">Cash : <?=number_format($value[cash],2);?></td>
          <td colspan="1">Online Cash : <?=number_format($value[bank],2);?></td>
          <td colspan="1">Discount : <?=number_format($value[discount],2);?></td>
          <td colspan="2">Total:<?=number_format($value[cash]+$value[bank],2);?> </td>
          <td colspan="1"><?=$value[depositebank];?> &nbsp; <?=$value[remarks];?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=cash_sales_pay&type=1&cust=<?=$value[custid];?>" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
          </td> 
        </tr>
       <? 
       } 
      }
       if(($total_sal>0) or ($total_pay>0))
       {
       ?>
       <tr>
            <td colspan="9" align="center" id="trsubhead">
             <b><a href="sales_cash.php?id=2">CHECK OUT</a></b>       
            </td>  
       </tr>
       <?  
        }
         echo "</table>";   
       ?>
 <?
 }
 elseif($id==2)
 {
 ?> 
 <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="9">Display Sales</td></tr>
   <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Name</td> 
       <td>Product</td>
       <td>Sales Qty</td>
       <td>Rate</td>
       <td>Cost</td>
       <td>Total Amount</td>
       <td>Remarks</td>
       <td>Delete</td>              
  </tr>     
  
 <? 
    $user_query="select tbl_daily_sales.*,name,address,sp from tbl_daily_sales    
                 join tbl_customer on tbl_customer.id=tbl_daily_sales.cust_id 
                 where tbl_daily_sales.user='$_SESSION[userName]'
                 order by product_name asc";
    $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
          <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[product_name];?></td>
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[cost],2);?></td>
          <td align="right"><?=number_format(($value[qty]*$value[rate])+ $value[cost],2);?></td>
          <td><?=$value[remarks];?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=cash_sales&type=2" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
          </td>         
       </tr>
       <?
        $total_2_qty=$total_2_qty+$value[qty];
        $total_2_value=$total_2_value+(($value[qty]*$value[rate])+$value[cost]);
         }
       ?>
      <tr align="center">
        <td colspan="4">Total Qty : <?=number_format($total_2_qty,2)?></td>
        <td colspan="5">Total Value : <?=number_format($total_2_value,2)?></td>
      </tr> 
      <?
       
      }
      $totalcash=0;
      $totalbank=0;
      $user_query="select * from tbl_daily_cash_sales where user='$_SESSION[userName]'";
      $users_payment = mysql_query($user_query);
      $total = mysql_num_rows($users_payment);    
      if ($total>0)
      {
      while($value=mysql_fetch_array($users_payment))
       { 
       ?>
        <tr align="center">
          <td colspan="2">Cash : <?=number_format($value[cash],2);?></td>
          <td colspan="2">Online Cash : <?=number_format($value[bank],2);?></td>
          <td colspan="2">Discount :<?=number_format($value[discount],2);?> </td>
          <td colspan="2">Bank:<?=$value[depositebank];?> &nbsp;<?=$value[remarks];?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=cash_sales_pay&type=2" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
          </td> 
        </tr>
       <? 
        $totalcash=$totalcash+$value[cash];
        $totalbank=$totalbank+$value[bank];
        }
       echo "<tr align='center'><td colspan='2'>".number_format($totalcash,2);
       echo "<td colspan='3'>".number_format($totalbank,2);
       echo "<td colspan='4'>  Total Tk.: ".number_format($totalcash+$totalbank,2);
       echo "</tr>";   
       }
       ?>      
       <tr align="center" id="trsubhead">
             <td colspan="9">
                  <form name="newcash" method="post" action="process.php">
                    <input type="hidden" name="data_type" value="sales_cash">
                    <input type="submit" name="submitqry"  value="Confirm Daily Sales ">
                  </form>  
             </td>
        </tr>
       
      
 </table>   
 <?
 }if($id==3)
  {
   echo "<b><img src='images/active.png'>Daily Sales Successfully.</b>";
   echo "<br><br>";
 ?>
  <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
    <tr id="trsubhead">
        <td>Sl No</td>
        <td>Product</td>
        <td>Sales Qty</td>
        <td>Actual Sales Qty</td>
        <td>Remarks</td>
    </tr>                   
    <?
      $user_query="select * from tbl_daily_sales     
                 where tbl_daily_sales.user='$_SESSION[userName]'
                 order by product_name asc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
          <tr align="center">
          <td><?=$count;?></td>
          <td><?=$value[product_name];?></td>
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[stock],2);?></td>
          <td><? if($value[status]==0)
                   {echo "No Sales, due to no stock";}           
                 elseif($value[status]==1) 
                   {echo "Full Sales";}
                 elseif($value[status]==2)
                   {echo "Partial Sales.";}  
             ?>
          </td>
       </tr>
       <?
        }
       } 
      
      $totalcash=0;
      $totalbank=0;
      $user_query="select * from tbl_daily_cash_sales where user='$_SESSION[userName]'";
      $users_payment = mysql_query($user_query);
      $total = mysql_num_rows($users_payment);    
      if ($total>0)
      {
      while($value=mysql_fetch_array($users_payment))
       { 
       ?>
        <tr align="center">
          <td colspan="2">Cash : <?=number_format($value[cash],2);?></td>
          <td colspan="1">Online Cash : <?=number_format($value[bank],2);?></td>
          <td colspan="1">Discount :<?=number_format($value[discount],2);?> </td>
          <td colspan="1">Bank:<?=$value[depositebank];?> &nbsp;<?=$value[remarks];?></td>
        </tr>
       <? 
        $totalcash=$totalcash+$value[cash];
        $totalbank=$totalbank+$value[bank];
        }
       echo "<tr align='center'><td colspan='2'>".number_format($totalcash,2);
       echo "<td colspan='2'>".number_format($totalbank,2);
       echo "<td colspan='1'>  Total Tk.: ".number_format($totalcash+$totalbank,2);
       echo "</tr>";   
       }
      
       ?>
  </table>
  <br>
  <?  
   echo "<a href='sales_cash.php?id=1'><b>Continue with Sales</b></a>";
   $sql="delete from tbl_daily_sales where user='$_SESSION[userName]'";
   db_query($sql);  
  
   $sql="delete from tbl_daily_cash_sales where user='$_SESSION[userName]'";
   db_query($sql);  
  
  }
 ?>

 
 
<?php
 include "footer.php";
?>

