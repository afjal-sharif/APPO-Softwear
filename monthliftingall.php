<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Sales Report";
 include "session.php";  
 include "header.php";
?>

<?
$con=" Where ";


if(isset($_POST["view"]))
 {
  
  
  $con=$con. "  (tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]')";
  $con_gol=$con;
  
  if ($_POST[category]!='')
   {
     $con=$con." and tbl_product.category_id=$_POST[category]";
   }
  
  if($_POST[profitwise]==0)
    {
     $group="group by tbl_customer.id,tbl_sales.unit,tbl_product.name,tbl_customer.type";
    }
  else
    {
     $group="group by tbl_customer.id";
    }
  
    
    $user_query="select tbl_sales.customerid as cid, sum(tbl_sales.qty) as  qty,tbl_sales.unit,tbl_customer.name as customer,tbl_product.name as product,tbl_product_category.name as cname,
                  tbl_customer.type,tbl_customer.address
                   from tbl_sales
                   join tbl_product on tbl_sales.product=tbl_product.id   
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id  
                   join tbl_product_category on tbl_product_category.id=tbl_product.category_id 
                   $con
                   $group
                   order by tbl_customer.type,tbl_customer.name";


 }
else
 {
    $user_query="select tbl_sales.customerid as cid,sum(tbl_sales.qty) as  qty,tbl_sales.unit,tbl_customer.name as customer,tbl_product.name as product,tbl_product_category.name as cname,
                     tbl_customer.type,tbl_customer.address 
                      from tbl_sales
                      join tbl_product on tbl_sales.product=tbl_product.id
                      join tbl_customer on tbl_sales.customerid=tbl_customer.id 
                      join tbl_product_category on tbl_product_category.id=tbl_product.category_id 
                      Where (tbl_sales.date between curdate() and curdate())
                      $group
                      order by tbl_customer.name";

   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trsubhead"><b>Monthly Lifting</b></td></tr>
 <tr>
   <td>Date: <input type="Text" id="demo11" maxlength="10" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="10" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>

   <td>Category: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_product_category order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="category" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["category"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>
   
   <td>
         <input type="radio" name="profitwise" value="0" CHECKED> &nbsp;Individual
         <input type="radio" name="profitwise" value="1" <? if($_POST[profitwise]==1){echo "CHECKED";}  ?> >&nbsp;Total 
   
  </td> 
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Monthly Lifting</td></tr> 

   <tr bgcolor="#EEFF09">       
       <td>SL No.</td>
       <td>Customer</td>
       <td>Type</td>
       <td>Address</td>
       <td>Product</td>
       <td>Qty</td>
     </tr>     
    <?
      $count=1;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       
       while($value=mysql_fetch_array($users))
       {
        
        if(($id<>$value[type]) and $count<>1)
         {
          echo "<tr id='trsubhead'><td colspan='4'>".$id." Total :</td>";
          echo "<td colspan='2' align='right'>".number_format($totalamount,0)."</td></tr>";
          $totalamount=0;   
         }
       ?>
       <tr>
          <td align="center"><?=$count;?></td>
          <td><?=$value[customer];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[address];?></td>
          <?
           if($_POST[profitwise]==0)
           {
          ?>
          <td><?=$value[product];?></td>     
          <?
           }
           else
           {
           echo "<td>$value[cname]</td>";
           }  
          ?>
          <td align="right"><?=number_format($value[qty],0);?></td>
       </tr>
       
       
       <?
        if(($_POST[profitwise]==1) and ($value[type]=='Golden Retailer'))
        {
          $scon_gol=$con. " and tbl_sales.customerid='$value[cid]' and tbl_sales.scid>=1";
          $sql_scid="select tbl_sales.scid,tbl_secondary_customer.name as sname, sum(qty) as ssales from tbl_sales 
                       join tbl_product on tbl_sales.product=tbl_product.id
                       join tbl_customer on tbl_sales.customerid=tbl_customer.id 
                       join tbl_product_category on tbl_product_category.id=tbl_product.category_id 
                       left join tbl_secondary_customer on tbl_sales.scid=tbl_secondary_customer.id
                       $scon_gol group by tbl_sales.scid";
          $users_golden = mysql_query($sql_scid);
          $total_golden = mysql_num_rows($users_golden);    
          if ($total_golden>0)
            {
             echo "<tr><td colspan='6'>";
             echo "<table bgcolor='#FFFF09' width='100%'>";
             echo "<table width='960px' align='center' bordercolor='#AACCBB' bgcolor='#FFFFFF'  border='1' cellspacing='5' cellpadding='5' style='border-collapse:collapse;'>";
             //echo "<tr align='center'><td>SL</td><td>SID</td><td>Name</td><td>Qty</td></tr>";
              while($value_golden=mysql_fetch_array($users_golden))
               {
                echo "<tr align='center'>"; 
                echo "<td>$value_golden[scid]</td>";
                echo "<td>$value_golden[sname]</td>";
                echo "<td align='right'>".number_format($value_golden[ssales],0)."</td>";
                echo "</tr>";
               }
             echo "</table></td></tr>";   
            }
        
        }
        $totalamount=$totalamount+$value[qty]; 
        $gtotalamount=$gtotalamount+$value[qty]; 
        $id=$value[type]; 
        $unit=$value[unit];       
        $count=$count+1;
       }
      }
            
      ?>  
 <tr id="trsubhead"><td colspan="4"> Retailer Total</td><td colspan="2" align="right"><?=number_format($totalamount,0);?></td></tr>
 <tr id="trsubhead"><td colspan="4"> Grand Total </td><td colspan="2" align="right"><?=number_format($gtotalamount+$totaldircet,0);?></td></tr>
 </table>


<?php
 include "footer.php";
?>
