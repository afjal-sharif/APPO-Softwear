<?php
 session_start();
 $mnuid=508;
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmSales()
{
answer = confirm("Are You Sure To Delete This Order.?")
if (answer !=0)
{
 window.submit();
}
}	
</script>


<?
$id=$_GET[id];
if($id==1)
{
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">Holcim Receive</td></tr>  
 
    <tr bgcolor="#FFCCAA" align="center">
       <td>Ref No:
         <?php
           $ref_no= date("d").''.date("m").''.date("Y");
           //$mon=date("m")
         ?>
          <input type="text" name="ref_no" size="10"  value="<?=$_POST[ref_no]?>" />
       </td> 
       
       
      <td>Company:
          
           <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="company" style="width: 150px; height: 28px; border-width:1px;border-color:#FF0000;">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($row_sql['id']==2) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       
     <td> Sales Rate:
        <input type="text" name="rate" size="4"  value="<?=$_POST[rate]?>" />    
     </td>
      
     
     <td>
         <input type="submit" name="view" value= "  View  "> 
       </td> 
  </tr>
 </table>
</form>
<!--  Company Info Details Here -->
<form name="po" id="vendor" action="daily_order_process.php" method="post"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="12">Order List <b>Daily Holcim Receive</b> </td></tr> 
 <tr align="center" id="trsubhead"> 
    <td colspan="7" bgcolor="#FFFFAA">General Info</td>
    <td colspan="2" bgcolor="#FFFFC0">Good Receive</td>
    <td colspan="3">Good Sales</td>
 </tr>
 <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>DO No</td>
       <td>SAP ID</td>
       <td>Name</td>
       <td>Product</td>       
       <td>Order Qty</td>
       <td>Bal Qty</td>
       <td>Receive</td>
       <td>Qty</td>
       <td>Sales</td>
       <td>Rate</td>
       <td>Carring</td>
   </tr>     
 <?
     if(isset($_POST["view"]))
     {
     
     $con="where tbl_order.status=0";
     if($_POST[company]!=''){$con=$con. " and tbl_order.company='$_POST[company]'";}
     if($_POST[ref_no]!=''){$con=$con. " and tbl_order.ref_no='$_POST[ref_no]'";}
     
          
       $user_query="select tbl_order.donumber as id,tbl_order.dtDate as date,tbl_order.donumber,tbl_order.remarks,tbl_customer.sp,tbl_order.punit,
                   tbl_order.qty as oqty,tbl_order.product,tbl_order.rate,tbl_order.customer,
                   tbl_order.truckno,sum(tbl_receive.qty) as qty,tbl_company.name as company,
                   tbl_customer.name as cname,tbl_customer.codeno,tbl_product.name as pname
                   from tbl_order
                   left join tbl_receive on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   join tbl_customer on tbl_order.customer=tbl_customer.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   $con
                   group by tbl_order.donumber,tbl_order.product                
                   order by tbl_order.id asc";  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      }
      else
      {
       $total=0;
      }
      if (($total>0))
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       $balqty=$value[oqty]-$value[qty];
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[donumber];?></td>
          <td colspan="1"  align="center"><?=$value[codeno];?></td>
          <td colspan="1"  align="center"><?=$value[cname];?></td>
          <td><?=$value[pname];?></td>
          <td><?=number_format($value[oqty],0);?></td>
          <td><b><?=number_format($balqty,0);?></b></td>
          
          <?php
            if($balqty>0)
            {
          ?>
          
          
          <td bgcolor="#FFFFC0" align="center">
            <select name="receive[<?=$value[id];?>]" style="width: 50px; height: 28px; border-width:1px;border-color:#FF0000;">
               <option value="0" <?php if($_POST["receive"]=='0') echo "selected";?>>No</option>
               <option value="1" <?php if($_POST["receive"]=='1') echo "selected";?>>Yes</option>
            </select>  
          </td>
          <td align="center" bgcolor="#FFFFC0">
           
               
               <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
               <input name="data_type" type="hidden" value="holcim_receive" />
               
               <input type="text" name="qty[<?=$value[id];?>]" size="4"  value="<?=$balqty?>" />
                              
               <input type="hidden" name="donumber[<?=$value[id];?>]"   value="<?=$value[donumber]?>" />
               <input type="hidden" name="product[<?=$value[id];?>]"  value="<?=$value[product]?>" />
               <input type="hidden" name="rate[<?=$value[id];?>]"   value="<?=$value[rate]?>" />
               <input type="hidden" name="balqty[<?=$value[id];?>]"   value="<?=$balqty?>" />
               <input type="hidden" name="customer[<?=$value[id];?>]"   value="<?=$value[customer]?>" />
               <input type="hidden" name="cname[<?=$value[id];?>]"   value="<?=$value[cname]?>" />
               <input type="hidden" name="unit[<?=$value[id];?>]"   value="<?=$value[punit]?>" />
               <input type="hidden" name="sp[<?=$value[id];?>]"   value="<?=$value[sp]?>" />
               
               <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" />  
          </td>
          
          <td  id="trsubhead" align="center">
            <select name="sales[<?=$value[id];?>]" style="width: 50px; height: 28px; border-width:1px;border-color:#FF0000;">
               <option value="0" <?php if($_POST["receive"]=='0') echo "selected";?>>No</option>
               <option value="1" <?php if($_POST["receive"]=='1') echo "selected";?>>Yes</option>
            </select>  
          </td>
          <td  id="trsubhead" align="center">
            <input type="text" name="salrate[<?=$value[id];?>]" size="4"  value="<?=$_POST[rate]?>" />
          </td>
          <td  id="trsubhead" align="center">
             <input type="text" name="carring[<?=$value[id];?>]" size="4"  value="0" />
          </td>
           <?
            }else
            {
             echo "<td colspan='5'>&nbsp;</td>";
            }
           ?> 
       </tr>
       <?
         }
       ?>
       <tr align="center" id="trsubhead">
             <td colspan="12">
                    <input type="submit" name="submitqry"  value=" Receive Goods ">
             </td>
        </tr>
       
       <?  
        }
       
    ?>  
 </table>
<?php
}
if($id==2)
{
   echo "<b><img src='images/active.png'>Daily Order $_GET[status] Successfully.</b>";
   echo "<br><br><br><br>";
   
   echo "<a href='print_order.php?id=$ref_id' target='_blank' alt='Print Order'><img src='images/report.jpg' tittle='Print Report'></a>";
   
   echo "<br><br><br><br>";
   
   echo "<a href='holcim_receive.php?id=1'><b>Continue with Goods Receive</b></a>";
}
?>


<?php
 include "footer.php";
?>

