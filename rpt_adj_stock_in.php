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
  $join='';
  $con="where (tbl_order.dtDate between '$_POST[demo11]' and '$_POST[demo12]') and tbl_company.status=2";
  
 
  if($_POST[category]!='')
   {
    $con= $con. " and tbl_product_category.id='$_POST[category]'";  
    //$join="join tbl_product_category on tbl_product.category_id=tbl_product_category.id";
   } 
   
  if ($_POST[sub_cat]!='-1')
   {
   $con=$con." and tbl_receive.product=$_POST[sub_cat]";
   }
   
   
     $user_query="select tbl_receive.id, tbl_order.dtDate as date,tbl_order.remarks,tbl_order.status,tbl_receive.donumber,tbl_product.punit as unit,
                   tbl_receive.rate,tbl_receive.qty,tbl_order.truckno,tbl_receive.bundle,tbl_order.remarks,tbl_order.truckno,
                   tbl_company.name as company,tbl_product.name as product,tbl_receive.dfcost,tbl_receive.locost,tbl_product_category.name as catname
                   from tbl_receive
                   join tbl_order on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   join tbl_product on tbl_receive.product=tbl_product.id
                   join tbl_product_category on tbl_product_category.id=tbl_product.category_id
                   
                   $con                 
                   order by tbl_receive.id desc";


 }
else
 {
   $user_query="select tbl_receive.id, tbl_order.dtDate as date,tbl_order.remarks,tbl_order.status,tbl_receive.donumber,tbl_product.punit as unit,
                   tbl_receive.rate,tbl_receive.qty,tbl_order.truckno,tbl_receive.bundle,tbl_order.remarks,tbl_order.truckno,
                   tbl_company.name as company,tbl_product.name as product,tbl_receive.dfcost,tbl_receive.locost,tbl_product_category.name as catname
                   from tbl_receive
                   join tbl_order on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   join tbl_product on tbl_receive.product=tbl_product.id
                   join tbl_product_category on tbl_product_category.id=tbl_product.category_id
                   where tbl_company.status=2
                   order by tbl_receive.id desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Stock Increase Report</b></td></tr>
 <tr id="trhead"><td colspna="1"> Date</td><td>Category</td><td>Product</td><td>&nbsp;</td></tr>
 <tr>
   <td><input type="Text" id="demo11" maxlength="15" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   
    To: 
       <input type="Text" id="demo12" maxlength="15" size="11" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>

   <td>
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
            
             $query_sql = "SELECT tbl_product.id,tbl_product.name, tbl_product_category.name as cat_name,tbl_product.punit FROM tbl_product 
                           join tbl_product_category on tbl_product.category_id=tbl_product_category.id  
                           order by tbl_product_category.name";
                $sql = mysql_query($query_sql) or die(mysql_error());
                 echo"<option value='-1'></option>";
		               
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['id'];?>" <?if($_POST[sub_cat]==$rs[id]) {echo "SELECTED";}?>> <?=$rs['cat_name'];?>::<?=$rs['name'];?>::<?=$rs['punit'];?></option>
                 <?    
		             }
                ?>
             </select>
            </div>
       </td>
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Stock Increase Report</td></tr> 

   <tr id="trsubhead">    
       <td>Date</td>
       <td>Product</td>
       <td>Ref.No</td>
       <td>Remarks</td>
       <td>Qty</td>
       <td>Bundle</td>
       <!--
       <td>Rate</td>
       <td>DF</td>
       <td>Unload</td>
       <td>Total Taka</td>
       -->
       <td>Action</td>
    </tr>     
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);  
      $totalamount=0;  
      $totalqty=0;
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          
          <td><?=$value[catname];?> :<?=$value[product];?></td>
          <td align="center"><b>
            <a href="pur_view.php?id=<?=$value[donumber];?>" target="_blank" title="View Details">
              <?=$value[donumber];?>
            </a> 
            </b>   
          </td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=$value[qty];?> &nbsp; <?=$value[unit];?></td>
          <td><?=$value[bundle];?></td>
          <!--
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[dfcost],2);?></td>
          <td align="right"><?=number_format($value[locost],2);?></td>
          <td align="right"><?=number_format($value[qty]*($value[rate]+$value[dfcost]+$value[locost]),2);?></td>  
          -->
          <td align="center">
           <?
            if($value[status]==0)
            {
           ?>
          <A HREF=javascript:void(0) onclick=window.open('editGP.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit GP Number Info">
          <img src="images/edit.png" height="15px" weight="15px" ></a></td>
           <?} else { echo "&nbsp";}?>     
       </tr>
       <?
       
       
       $totalamount=$totalamount+($value[qty]*($value[rate]+$value[dfcost]+$value[locost]));
       $totalqty=$totalqty+$value[qty];
       $totalbundle=$totalbundle+$value[bundle];
       }
      }
    ?>  
  </tr>
 <tr id="trsubhead">
                      <td colspan="4" align="center">Total Amount :</td>
                      <td align="right"><?=number_format($totalqty,2);?></td>
                      <td align="center"><?=$totalbundle;?></b></td>
                      <td>&nbsp;</td>
  </tr>
 </table>

<!--<script type="text/javascript" src="sp.js"></script>-->
<?php
 include "footer.php";
?>
