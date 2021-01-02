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
  
  
  if ($_POST[company]!='')
   {
   $con=$con." and tbl_company.id=$_POST[company]";
   }
   
  if($_POST[topn]!='')
   {
   $limt="limit 0,$_POST[topn]";
   }
  else
   {
    $limt="limit 0,10";
   }  
    
    
    $user_query="select sum(tbl_sales.qty) as  qty,sum(tbl_sales.qty*tbl_sales.rate)as value, tbl_sales.unit,tbl_customer.name as customer,tbl_company.name as product,
                  tbl_customer.type,tbl_customer.address
                   from tbl_sales
                   join tbl_order on tbl_sales.donumber=tbl_order.donumber
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_company on tbl_order.company=tbl_company.id    
                   $con
                   group by tbl_customer.id,tbl_sales.unit,tbl_company.id,tbl_customer.type
                   order by sum(tbl_sales.qty) desc,tbl_customer.type,tbl_customer.name $limt";


 }
else
 {
     $user_query="select sum(tbl_sales.qty) as  qty, sum(tbl_sales.qty*tbl_sales.rate)as value, tbl_sales.unit,tbl_customer.name as customer,tbl_company.name as product,
                     tbl_customer.type,tbl_customer.address 
                      from tbl_sales
                      join tbl_order on tbl_sales.donumber=tbl_order.donumber
                      join tbl_customer on tbl_sales.customerid=tbl_customer.id
                      join tbl_company on tbl_order.company=tbl_company.id
                      Where (tbl_sales.date between curdate() and curdate())
                      group by tbl_customer.id,tbl_sales.unit,tbl_company.id,tbl_customer.type
                      order by sum(tbl_sales.qty) desc,tbl_customer.name $limt";

   
 }
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trsubhead"><b>Monthly Lifting</b></td></tr>
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

   <td>Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>
   
   <td>Top :<input type="text" name="topn" size="2" value="<?=isset($_POST["topn"])?$_POST["topn"]:10?>" /> </td>
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Top N Customer Based On Lifting</td></tr> 

   <tr bgcolor="#EEFF09">       
       <td>SL No.</td>
       <td>Customer</td>
       <td>Type</td>
       <td>Address</td>
       <td>Company</td>
       <td>Qty</td>
       <td>Unit</td>
       <td align="center">Value(Tk)</td>
     </tr>     
  <tr>
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
          echo "<td colspan='2' align='right'>".number_format($totalamount,2)."</td>";
          echo "<td colspan='1'>".$value[unit]."</td></tr>";
          $totaldircet=$totalamount;
          $totalamount=0;
          
         }
       ?>
       <tr>
          <td><?=$count;?></td>
          <td><?=$value[customer];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[address];?></td>
          <td><?=$value[product];?></td>     
          <td align="right"><?=number_format($value[qty],0);?></td><td align="left"><?=$value[unit];?></td>
          <td align="right"><?=number_format($value[value],0);?></td>
       </tr>
       <?
        $totalvalue=$totalvalue+$value[value];
        $totalamount=$totalamount+$value[qty]; 
        $id=$value[type]; 
        $unit=$value[unit];
        
       
       
       
       $count=$count+1;
       }
      }
            
      ?>  
  </tr>
 
 <tr id="trsubhead"><td colspan="4"> Total </td>
  <td colspan="2" align="right"><?=number_format($totalamount,2);?></td><td align="left"><?=$unit;?></td>
  <td colspan="1" align="right"><?=number_format($totalvalue,2);?></td>
  </tr>
 </table>


<?php
 include "footer.php";
?>
