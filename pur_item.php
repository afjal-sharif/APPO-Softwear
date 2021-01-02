<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Multiple Sales";
 include "session.php";  
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Confirm Order ?")
if (answer !=0)
{
window.submit();
}
}	


function ConfirmSales()
{
answer = confirm("Are You Sure To Delete Item.?")
if (answer !=0)
{
 window.submit();
}
}	

</script>


<?php 
$_SESSION[ref_id]=$_POST[id];

if($_SESSION[ref_id]!='')
{

}
else
{
  $_SESSION[ref_id]=$_REQUEST[id];
}


if(isset($_POST["confirrm"]))
{
 $update_query = "update tbl_order set status=1 where  donumber=$_POST[donumber];"; 
 db_query($update_query) or die(mysql_error());
 
 /*
 $dfcost=$_POST[con_dfcost];
 $locost=$_POST[con_locost];
 $totalcost=$dfcost+$locost;
 $totalamount=$_POST[con_totalvalue];
 
 if($totalcost>0)
  {
       $sql_con="select id,qty,rate from tbl_receive where donumber=$_POST[donumber]"; 
       $users_con = mysql_query($sql_con);
       $total_con = mysql_num_rows($users_con);    
       if ($total_con>0)
        {
          while($value_con=mysql_fetch_array($users_con))
          {
            $sql="update tbl_receive set dfcost=(($dfcost*$value_con[qty]*$value_con[rate])/$totalamount)/$value_con[qty], locost=(($locost*$value_con[qty]*$value_con[rate])/$totalamount)/$value_con[qty] where id=$value_con[id]";
            db_query($sql);           
          }
        }    
  }
 */ 
  
echo $_SESSION[ref_id]=$_POST[donumber];
}


if(isset($_POST["submit"]) and $_POST[quantity]<>0)
 {
 $dfcost=$_POST[dfcost]/$_POST[quantity];
 $locost=$_POST[locost]/$_POST[quantity];
 $sql="insert into tbl_receive(date,donumber,product,qty,bundle,rate,user,dfcost,locost) 
         value('$_SESSION[dtcustomer]',$_POST[donumber],'$_POST[sub_cat]',$_POST[quantity],$_POST[bundle],$_POST[rate],'$_SESSION[userName]','$dfcost','$locost')"; 
 db_query($sql) or die(mysql_error());
 echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Item Receive successfully</b>";
 $_SESSION[ref_id]=$_POST[donumber];
 }
     
    
      $sql="Select tbl_order.id,dtDate,name,donumber,tbl_order.remarks,sp,truckno,tbl_order.status as sta,deliveryfair,locost,qty from tbl_order 
                 join tbl_company on tbl_order.company=tbl_company.id 
                 where donumber='$_SESSION[ref_id]'";
      
      $users_sql = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users_sql);
      
      $order_id=$row_sql_adj[id];
      $order_dt=$row_sql_adj[dtDate];
      $order_order=$row_sql_adj[donumber];
      $order_company=$row_sql_adj[name];
      $order_remarks=$row_sql_adj[remarks];
      $order_truck=$row_sql_adj[truckno];  
      $order_sp=$row_sql_adj[sp];
      $order_status=$row_sql_adj[sta]; 
      
      $order_dfcost=$row_sql_adj[deliveryfair];
      $order_locost=$row_sql_adj[locost];
      $order_qty=$row_sql_adj[qty];
      
      if($order_status==0)
       {
 ?> 
 
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Purchase</td></tr> 
 <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Order Ref</td>
       <td>Company</td>
       <td>Remarks</td>
       <td>Truck No</td>
       <td>Order Qty</td>
       <td>Action</td> 
 </tr> 
  <tr align="center">    
       <td><?=$order_dt;?></td>
       <td><?=$order_order;?></td>
       <td><?=$order_company;?></td>
       <td><?=$order_remarks;?></td>
       <td><?=$order_truck;?></td>
       <td alifn="right"><?=number_format($order_qty,2);?></td>
       <td>
         <a href="indelete.php?id=<?=$order_id;?>&mode=pur_order&donumber=<?=$order_order;?>" title="Delete" onClick="return (confirm('Are you sure to delete purchase!!!')); return false;"><img src="images/inactive.png" height="15px" width="15px"></a>
       </td> 
 </tr>     
</table>  
   
<form name="myform" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">:: ITEM RRECEIVE ::</td></tr> 
   <tr id="trsubhead">    
       <td>Category</td>
       <td>Item</td>
       <td>Quantity</td>
       <td>Bundle</td>
       <td>Rate</td>
       <td>DF(Total)</td>
       <td>Unload(Total)</td>
       <td bgcolor="#FF00CA" align="center">Action</td> 
   </tr>     
   <tr align="center">
        <td>  
         <input type="hidden" name="donumber" value="<?=$order_order;?>" /> 
         <input type="hidden" name="dtDate" value="<?=$order_dt;?>" /> 
          <?
           $query_sql = "SELECT id,name  FROM tbl_product_category order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="category" id="category" style="width: 150px;">
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
     
     
       <td align="center">
            <div id="divcategory">
             <select style="width:250px" id="sub_cat" name="sub_cat">
                 <?      
                if($_POST[category]!='')
                {
                $query_sql = "SELECT  tbl_product.id,tbl_product.name as pname,tbl_product_category.name as catname,punit                
                              FROM `tbl_product`
                              join tbl_product_category on tbl_product.category_id=tbl_product_category.id 
                              where category_id='$_POST[category]'  order by tbl_product_category.name";
                }
                else
                {
                 $query_sql = "SELECT  tbl_product.id,tbl_product.name as pname,tbl_product_category.name as catname,punit               
                              FROM `tbl_product`
                              join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                              order by tbl_product_category.name";
                }
                $sql = mysql_query($query_sql) or die(mysql_error());
                 echo"<option value='-1'></option>";
		               
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['id'];?>" <? if($_POST[sub_cat]==$rs[id]) {echo "SELECTED";}?> ><?=$rs['catname'];?>::<?=$rs['pname'];?>::<?=$rs['punit'];?></option>
                 <?    
		             }
                ?>
             </select>
            </div>
       </td>
       <td><input type="text"  size="10" name="quantity"  /> </td>
       <td><input type="text"  size="6" name="bundle" /> </td>
       <td><input type="text"  size="6" name="rate"  /> </td>
       <td><input type="text"  size="8" name="dfcost"  /> </td>
       <td><input type="text"  size="8" name="locost"  /> </td>
       
       <td bgcolor="#FF00CA" align="center"><input type="submit" name="submit" value="&nbsp;Receive&nbsp;" /> </td>
    </tr>
 </table>
</form>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="10">Receive Item List</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Category</td>
       <td>Item Name</td>
       <td>Qty</td>
       <td>Bundle</td>
       <td>Rate</td> 
       <td>DF (Total)</td> 
       <td>UnLoad(Total)</td> 
       <td>Value</td>  
       <td>Action</td>  
      </tr>     
    <?
      $user_query="select tbl_receive.id,tbl_receive.date,tbl_product_category.name as cat_name,tbl_product.name as p_name,
                qty,bundle,tbl_receive.rate,tbl_receive.dfcost,tbl_receive.locost
                  from tbl_receive 
                  join tbl_product on tbl_receive.product=tbl_product.id
                  join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                  where donumber=$order_order order by tbl_receive.id desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $bal=$value[qty]*$value[rate];
       ?>
       <tr align="center">
          <td><?=$value[date];?></td>
          <td><?=$value[cat_name];?></td>
          <td><?=$value[p_name];?></td>
          <td><?=$value[qty];?></td>
          <td><?=$value[bundle];?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[dfcost]*$value[qty],2);?></td>
          <td align="right"><?=number_format($value[locost]*$value[qty],2);?></td>
          <td align="right"><?=number_format($bal,2);?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=order&donumber=<?=$order_order;?>" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a> 
          </td>        
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $totaldf=$totaldf+($value[qty]*$value[dfcost]);
       $totallo=$totallo+($value[qty]*$value[locost]);
       $totalbundle=$totalbundle+$value[bundle];
       $totalamount=$totalamount+$bal;
       }
       echo"<tr id='trsubhead'><td colspan='3'>Total Amount:</td><td colspan='1' align='center'>".number_format($totalqty,2)."</td><td colspan='1' align='center'>".$totalbundle."</td>";
       echo"<td colspan='1' align='right'>".number_format($totalamount/$totalqty,2)."</td>
       <td colspan='1' align='right'>".number_format($totaldf,2)."</td><td colspan='1' align='right'>".number_format($totallo,2)."</td>
       <td colspan='1' align='right'>".number_format($totalamount,2)."</td><td>&nbsp;</td></tr>"; 
       
       //echo 
       if(($order_qty==0) or ($order_qty<>$totalqty))
       {
      ?>
       <form name="overallcom" method="post" action="">
         <tr id="trhead">
           <td align="center" height="40px" colspan="10">
            <input type="hidden" name="donumber" value="<?=$order_order;?>" /> 
            <input type="hidden" name="con_dfcost" value="<?=$order_dfcost;?>" /> 
            <input type="hidden" name="con_locost" value="<?=$order_locost;?>" /> 
            <input type="hidden" name="con_totalvalue" value="<?=$totalamount;?>" /> 
            <input type="submit" name="confirrm" onclick="ConfirmChoice(); return false;" value=" Purchase Confirm " / > 
          </td>
         </tr>    
       </form>     
      <?php
      }
      }
    ?>  
  </tr>
 </table>




<script type="text/javascript" src="sp.js"></script>
 <?php
  }
  else
  {
   echo "Order is already closed.<br>";
   echo "<a href='pur_view.php?id=$_SESSION[ref_id]'  target='_blank'><img src='images/report.jpg'><br><b>View Purchase Details</b></a>";
  }
 ?>
<?php
 include "footer.php";
?>
