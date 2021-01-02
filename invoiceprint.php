<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To DO Sales ?")
if (answer !=0)
{
window.submit();
}
}	
</script>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<?
 $id=$_GET[id];
 if ($id=='invoice')
  {
?>
<form name="order" method="get" action="invoice.php" target="_blank">
<tr><td colspan="4" align="center"  id="trhead"><b>Invoice Print</b></td></tr>
 <tr>
   <td align="center">Enter Invoice No:<input type="text" size="8" name="id"  value="<?=$_SESSION[invoice];?>">
       <input type="submit" name="view" value= " Print ">
   </td>
 </tr>
 <?
 }
 elseif ($id=='mr')
  {
  ?>
  <form name="order" method="get" action="mrprint.php" target="_blank">
<tr><td colspan="4" align="center"  id="trhead"><b>Money Receipt Print</b></td></tr>
 <tr>
   <td align="center">Enter Money Receipt No:<input type="text" size="8" name="id"  value="<?=$_SESSION[mrno];?>">
       <input type="submit" name="view" value= " Print ">
   </td>
 </tr>
  </form>
  <?
  }elseif ($id=='challan') 
  {
 ?> 
<form name="order" method="get" action="challan.php" target="_blank">
<tr><td colspan="4" align="center"  id="trhead"><b>Challan Print</b></td></tr>
 <tr>
   <td align="center">Enter Invoice No:<input type="text" size="8" name="invoice"  value="<?=$_SESSION[invoice];?>">
       <input type="submit" name="view" value= " Print ">
   </td>
 </tr>
 <?
 }elseif ($id=='dosales') 
  {
  $mnuid=308;
  @checkmenuaccess($mnuid);
  
 ?> 
  <form name="order" method="post" action="invoiceprint.php?id=dosalesview" target="_blank">
   <tr><td colspan="4" align="center"  id="trhead"><b>DO Sales Form</b></td></tr>
   <tr>
       <td align="center">Select Ref No:
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
          <input type="submit" name="view" value= "&nbsp;&nbsp;View&nbsp;&nbsp;">
       </td>
   </tr>
 <?
 }elseif ($id=='dosalesview') 
  {
 
    if(isset($_POST[ref_id]))
     {
      $_SESSION[ref_id]=$_POST[ref_id];
      $ref_id=$_SESSION[ref_id];
     }
    elseif(isset($_GET[ref_id]))
     {
      $_SESSION[ref_id]=$_GET[ref_id];
      $ref_id=$_SESSION[ref_id];
     }
    else
     {
      $ref_id=$_SESSION[ref_id];
     }  
 
 
  
  $sql="SELECT `company`,`product`,`product_id`,unit,sum(qty)as qty,avg(freeqty) as bundle,avg(rate) as rate FROM `tbl_sales_temp`
        where user='$_SESSION[userName]' group by `product_id`";
 $users = mysql_query($sql);
 $total_stock = mysql_num_rows($users);    
 
 if ($total_stock>0)
    {
 ?> 
 <tr><td colspan="5"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trsubhead"><td colspan="7">Product In Sales Card.</td></tr> 
 <tr bgcolor="#FFCCAA">           
       <td>Category</td>
       <td>Product</td>
       <td>Sales Qty</td>
       <td>Bundle</td>
       <td>Gross Rate</td>
       <td bgcolor="#FFEE09" align="center">Sales Total</td>        
       <td bgcolor="#FF00CA" align="center">Action</td> 
 </tr>     
  <?
   while($value=mysql_fetch_array($users))
       {
  ?>
      <tr>
          <td><?=$value[company];?></td>
          <td><?=$value[product];?></td>
          
          <td align="right"><?=$value[qty];?> <?=$value[unit];?> </td>
          <td align="center"><?=number_format($value[bundle],0);?></td> 
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right" bgcolor="#FFEE09"><?=number_format($value[qty]*$value[rate],2);?></td>           
          <td align="center"><a href="indelete.php?id=<?=$value[product_id]?>&ref_id=<?=$ref_id?>&mode=tmpdosale"><img src="images/inactive.png" height="15px" width="15px"></a></td>
       </tr>


  <? 
    $totalqty=$totalqty+$value[qty];
    $totalbundle=$totalbundle+$value[bundle];
    $totalvalue=$totalvalue+($value[qty]*$value[rate]);
    $grossvalue=$grossvalue+($value[qty]*($value[rate]+$value[df]+$value[load]))+$value[others]+$value[adjamount];
      }
      echo "<tr id='trsubhead'><td colspan='2' align='center'>Total </td>
                              <td colspan='1' align='right'> ".number_format($totalqty,0)."</td>
                              <td colspan='1' align='center'> ".number_format($totalbundle,0)."</td>
                              <td colspan='1' align='right'> ".number_format($totalvalue/$totalqty,2)."</td>
                              <td colspan='1' align='right'> ".number_format($totalvalue,2)."</td><td>&nbsp;</td>
                             
             </tr>";
             
                   
      echo "</table></td></tr>";
    }
    
  
 ?> 
  <form name="order" method="post" action="process_sec.php">
   <tr><td colspan="5" align="center"  id="trhead"><b>DO Details : <?php echo $ref_id;?></b></td></tr>
   <?
  
           $user_query = "SELECT tbl_receive.id, `tbl_receive`.donumber,qty,rate,
                         tbl_receive.product as p_id,tbl_product.name as pname,tbl_product.unit,tbl_product_category.name as cat_name
                         FROM `tbl_receive`
                         join tbl_product on `tbl_receive`.product=tbl_product.id
                         join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                         where tbl_receive.donumber='$ref_id'                       
                         order by tbl_receive.product asc";
           $users = mysql_query($user_query);
           $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $count=0;
       echo "<tr align='center' id='trsubhead'><td>Product Name</td><td>Qty</td><td>Rate</td><td>Value</td><td bgcolor='#FFEECC'>Sale Rate</td> </tr>";
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
      <tr>
          <td><?=$value[cat_name];?>:<?=$value[pname];?></td>  
          <td align="center"><?=number_format($value[qty],2);?>&nbsp;&nbsp;<?=$value[unit];?>  </td>
          <td align="center"><?=number_format($value[rate],2);?></td>
          <td align="center"><?=number_format($value[rate]*$value[qty],2);?></td>    
          <td bgcolor="#FFEECC" align="center"><input name="sale_rate[<?=$value[id];?>]" type="text" value="<?=$value[rate];?>" size="6" /></td>          
      </tr> 
      
      
      <input name="product[<?=$value[id];?>]" type="hidden" value="<?=$value[p_id];?>" />
      <input name="qty[<?=$value[id];?>]" type="hidden" value="<?=$value[qty];?>" />
      <input name="work[]" type="hidden" value="<?=$value['id'];?>" />        
<?
      $totalqty=$totalqty+$value[qty];
      $totalamount=$totalamount+($value[qty]*$value[rate]);
      }// Do While loop
      if($count>1)
      {
       echo "<tr id='trhead'><td colspan='1'> Total:</td>";
       echo "<td colspan='1'>".number_format($totalqty,2)."</td>";
       echo "<td colspan='1'>".number_format($totalamount/$totalqty,2)."</td>";
       echo "<td colspan='1'>".number_format($totalamount,2)."</td><td>&nbsp;</td></tr>";
      }
      
      if($total_stock>0)
      {
       echo "<tr id='trhead'><td colspan='2'>Stock Sales: ".number_format($totalvalue,2)."</td>";
       echo "<td colspan='2'>DO Sales: ".number_format($totalamount,2)."</td>";
       echo "<td colspan='1'>Total: <b>".number_format($totalvalue+$totalamount,2)."</b></td></tr>";
      }  
      
       // Start Sales Part.
       
      // For Invoice number
      $user_query="SELECT max(autoinvoice)+1 as invoice FROM `tbl_sales` where `invoice` not like 'c%'";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newinvoice=$row_sql[invoice];
      ?>
      <form name="dosales" method="post" action ="process_sec.php"> 
         <tr id="trsubhead"> <td colspan="5" align="center">Customer Information:</td></tr>
         <tr bgcolor="#FFFFCC" align="center">
           <td colspan="2" align="center"> 
           Date :<input type="Text" id="demo11"  maxlength="15" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
        </td>
        <td>Invoice:<input type="text" name="invoice" value="<?=$newinvoice;?>" size="6" /> </td>  
        <td colspan="2">
         Customer: 
          <?
            if($_SESSION[userType]=='A')
            {
             $query_sql = "SELECT id,name,address,climit,type,status,area  FROM tbl_customer  where status=0 order by name";
            }
            else
            {
              $query_sql = "SELECT id,name,address,climit,type,status,area  FROM tbl_customer  where status=0 order by name";
            }
             
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  style="width: 250px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> >
                <?php echo $row_sql['name']?> :: <?php echo $row_sql['area'];?> :: <?php echo $row_sql['address']?>::
                <!--<?if($row_sql[status]==0){echo "Active";}else{echo "Inactive";}?>  --> 
             </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
          <input type="hidden" name="tran_type" value="2" />
          <input type="hidden" name="stock_sales" value="<?=$total_stock;?>" />
          <input type="hidden" name="donumber" value="<?php echo $ref_id;?>" />
          <input type="hidden" name="totalqty" value="<?=$totalqty;?>" />
          
       </td>
        </tr>
        <tr bgcolor="#FFFFCC" align="center">
          <td>DF Cost:<input type="text" name="dfcost" value="0"  size="6" /> </td>
          
          <td>Load Cost:<input type="text" name="locost" value="0"  size="6" /></td>
          <td colspan="3">Remarks <input type="text" name="remarks" size="50" /></td></tr>
        <tr id="trsubhead">
           <td colspan="2">
            <A HREF=javascript:void(0) onclick=window.open('pop_up_sales.php','Accounts','width=960,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Add Stock Product">
              <!-- <img src="images/edit.png" height="15px" width="15px"> -->
              <input type="button" name="pop_sales" value=" Add Stock Item  " />
            </A>
           </td>
           <td colspan="3">
             <input type="submit"  onclick="ConfirmChoice(); return false;" value=" &nbsp;&nbsp;DO Sales &nbsp;&nbsp;" name="submit" /> </td></tr>
      </form>  
    <?php  
    } // total end
 } // else end
?>
 
 
</table>
</form>

<?php
 include "footer.php";
?>
