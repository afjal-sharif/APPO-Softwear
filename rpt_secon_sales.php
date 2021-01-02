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
  
  $con="where (view_secon_sales.date between '$_POST[demo11]' and '$_POST[demo12]') and scid is not null";
  
  if ($_POST[sub_cat]!='')
   {
   $con=$con." and view_secon_sales.scid=$_POST[sub_cat]";
   }
  
  if ($_POST[customer]!='')
   {
   $con=$con." and view_secon_sales.customerid=$_POST[customer]";
   }
        
    $user_query="select view_secon_sales.*, tbl_secondary_customer.name as sname
                   from  view_secon_sales
                   join tbl_secondary_customer on view_secon_sales.scid=tbl_secondary_customer.id
                   $con                 
                   order by view_secon_sales.id desc,invoice";

 }
else
 {
   $user_query="select view_secon_sales.*, tbl_secondary_customer.name as sname
                   from  view_secon_sales
                   join tbl_secondary_customer on view_secon_sales.scid=tbl_secondary_customer.id
                   order by view_secon_sales.id desc limit 0,10";
   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Sales Details On Secondary Customer</b></td></tr>
 <tr>
   <td>Date: <input type="Text" id="demo11" maxlength="15" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   
    &nbsp;&nbsp;&nbsp; To: 
       <input type="Text" id="demo12" maxlength="15" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>
         Cust: 
          <?
           $query_sql = "SELECT  distinct  cid, tbl_customer.name,tbl_customer.mobile,tbl_customer.type  FROM 
                         tbl_secondary_customer
                         join tbl_customer on tbl_customer.id =tbl_secondary_customer.cid
                         order by tbl_customer.name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  style="width: 200px;" id="customer_sec">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['cid'];?>" <?php if($_POST["customer"]==$row_sql['cid']) echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['mobile']?> : <?php echo $row_sql['type']?>   </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
      </td>
      <td>
        <div id="div_secondary_cust">
             <select style="width:250px" id="sub_cat" name="sub_cat">
                 <option value=""></option>
             </select>
            </div>
      </td>    
      <td>    
        <input type="submit" name="view" value= "  View  "> 
      </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Secondary Sales Details.</td></tr> 
   <tr id="trsubhead">    
       <td>Invoice</td>
       <td>Date</td>
       <td>Parent Customer</td>
       <td>Customer</td>
       <td>Product</td>
       <td>Qty</td>
       <td>Rate/Unit</td>
       <td>Total Taka</td>
   </tr>     
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
         if($inid==$value[invoice])
         {
       ?>  
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
       <?  
         }
        else
         { 
       ?>
       <tr>
          <td align="center">
           <a href="invoice.php?id=<?=$value[invoice];?>" target="_blank" title="View Details">
             <?=$value[invoice];?>
           </a>
          </td>
          <td><?=$value[date];?></td>
          <td>
             <?=$value[cname];?>
             <?
              if($value[customerid]==1)
               {
                echo "$value[customername]";
               }
             ?> 
          </td>
          <td><?=$value[sname];?></td>
         <?
          }
         ?>  
          <td> <?=$value[catname];?> <?=$value[pname];?></td>
          
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[rate]+$value[df]+$value[loadcost],2);?></td>      
          <td align="right"><?=number_format(($value[qty]*$value[rate])+($value[qty]*($value[df]+$value[loadcost])),2);?></td>         
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $amount=$value[qty]*$value[rate]+($value[qty]*($value[df]+$value[loadcost]));
       $totalamount=$totalamount+$amount;
       $unit=$value[unit];
       $inid=$value[invoice];
       }
       ?>
       <tr id="trsubhead"><td colspan="3"> Total Amount</td>
       <td colspan="2" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
       <td colspan="2" align="right"><?=number_format($totalamount/$totalqty,2);?></td>
       <td colspan="3" align="right"><?=number_format($totalamount,2);?></td></tr>
             
       <?
      }
    ?>  
 </table>

<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
