<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
if(isset($_POST["view"]))
 {
  $con='';
  
  $con=" where (tbl_dir_receive.date between '$_POST[demo11]' and '$_POST[demo12]')";
  
 
  if ($_POST[customer]!='')
   {
   $con=$con." and tbl_dir_receive.customerid=$_POST[customer]";
   }
    
   
    $user_query="select tbl_dir_receive.customerid,sum(discount) as amount,tbl_customer.id,                 
                   tbl_customer.name as customer,tbl_customer.address,tbl_customer.type
                   from tbl_dir_receive                   
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id
                   $con     
                   group by customerid 
                   Having sum(discount)>0        
                   order by tbl_customer.name";

 }
else
 {
    $user_query="select tbl_dir_receive.customerid,sum(discount) as amount, tbl_customer.id,                
                   tbl_customer.name as customer,tbl_customer.address,tbl_customer.type
                   from tbl_dir_receive                   
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id  
                   group by customerid    
                   Having sum(discount)>0      
                   order by tbl_customer.name";
   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Sales Discount Report</b></td></tr>
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
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">Sales Goods Details.</td></tr> 

   <tr bgcolor="#CCAABB">    
       <td>Customer ID</td>
       <td>Name</td>
       <td>Address</td>
       <td>Discount Amount</td>
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
          <td><?=$value[id];?></td>
          <td><b><?=$value[customer];?></b></td>
          <td><?=$value[address];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>
       </tr>
       <?
       
       $totalamount=$totalamount+$value[amount];
       }
      }
    ?>  
  </tr>
 <tr id="trsubhead"></td><td colspan="3"> Total Amount</td><td align="right"><?=number_format($totalamount,2);?></td></tr>
 </table>


<?php
 include "footer.php";
?>
