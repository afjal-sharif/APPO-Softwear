<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Increase Stock Quantity ?")
if (answer !=0)
{
window.submit();
}
}	
</script>

<?
if(isset($_POST["confimin"]))
{
      $user_query="Select (max(autodoid)+1)as donumber from tbl_order ";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newdonumber=$row_sql[donumber];
      
      $user_query="Select * from tbl_company where status=2 ";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $company=$row_sql[id];
 
 
      $sql="insert into tbl_order (dtDate,donumber,company,product,qty,rate,deliveryfair,locost,user,punit,factor,autodoid,paydate,remarks,truckno,sp,status) 
        value('$_SESSION[dtcompany]','$newdonumber',$company,1,0,0,0,0,'$_SESSION[userName]','-',1,$newdonumber,'','Stock Adjustment- Increase','-','',1)"; 
      db_query($sql) or die(mysql_error()); 
      
     $sql="SELECT * FROM tbl_adjustment where type=0 and status=0 and user='$_SESSION[userName]'"; 
     $users = mysql_query($sql);
     $total = mysql_num_rows($users);    
     if($total>0)
     {
      while($value=mysql_fetch_array($users))
       {
        $sql="insert into tbl_receive(date,donumber,product,qty,bundle,rate,user,dfcost,locost) 
         value('$value[date]',$newdonumber,'$value[product]',$value[qty],0,0,'$_SESSION[userName]','0','0')"; 
        db_query($sql) or die(mysql_error());
        
        $sql="update tbl_adjustment set status=1 where id=$value[id]";
        db_query($sql) or die(mysql_error());
       }
     } 
 echo " Adjustment Confirm Successfully.";
}
?>



<?
 $sql="SELECT tbl_adjustment.id,tbl_product.name as pname,tbl_product.unit, tbl_product_category.name as cat_name,
              tbl_adjustment.qty,tbl_adjustment.remarks,tbl_adjustment.user 
       FROM tbl_adjustment 
       join tbl_product on tbl_product.id=tbl_adjustment.product
       join tbl_product_category on tbl_product_category.id= tbl_product.category_id
         where tbl_adjustment.status=0 and tbl_adjustment.type=0  and tbl_adjustment.user='$_SESSION[userName]'";
 $users = mysql_query($sql);
 $total = mysql_num_rows($users);    
$total=0; 
 if ($total>0)
    {
 ?> 
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Quantity Increase Product List</td></tr> 
 <tr bgcolor="#FFCCAA">           
       <td>Category</td>
       <td>Product</td>
       <td>Adjust Qty</td>
       <td>Remarks</td>        
       <td bgcolor="#FF00CA" align="center">Action</td> 
 </tr>     
  <?
   while($value=mysql_fetch_array($users))
       {
  ?>
      <tr>
          <td><?=$value[cat_name];?></td>
          <td><?=$value[pname];?></td>
          <td align="right"><?=$value[qty];?> <?=$value[unit];?> </td>
          <td><?=$value[remarks];?></td>        
          <td align="center"><a href="indelete.php?id=<?=$value[id]?>&mode=inadjust&type=0"><img src="images/inactive.png" height="15px" width="15px"></a></td>
       </tr>


  <? 
    $totalqty=$totalqty+$value[qty];
    $totalbundle=$totalbundle+$value[bundle];
    $totalvalue=$totalvalue+($value[qty]*$value[rate]);
    $grossvalue=$grossvalue+($value[qty]*($value[rate]+$value[df]+$value[load]))+$value[others]+$value[adjamount];
      }
      echo "<tr id='trsubhead'><td colspan='2' align='center'>Total </td>
                              <td colspan='1' align='right'> ".number_format($totalqty,0)."</td>
                              <td>&nbsp;</td><td>&nbsp;</td>
                             
             </tr>";
             
             
      echo "<form name='abc' method='post' action=''><tr id='trsubhead'><td colspan='8'><input type='submit' name='confimin' value=' &nbsp; Confirm Increase Quantity &nbsp;' onclick='ConfirmChoice(); return false;' /></td></tr></form>"  ;      
      echo "</table>";
    }
    
?>

<form name="abc" method="post" action="adjustment.php?todo=submitin">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">::  STOCK ADJUSTMENT -<b> Quantity Increase  ::</b></td></tr> 
   <tr id="trsubhead">    
       <td>Category</td>
       <td>Item</td>
       <td>Quantity</td>
       <td>Remarks</td>
       <td bgcolor="#FF00CA" align="center">Action</td> 
   </tr>     
   <tr>
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
             <select style="width:220px" id="sub_cat" name="sub_cat">
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
       
       <!--
       <td>
           <select name="type"  style="width: 100px;">
             <option value="0"> Add Stock</option>
             <option value="1"> Less Stock</option>
       </td>
       -->      
       <td><input type="text"  size="6" name="quantity"  /> </td>
       <td><input type="text" size="30" name="remarks" value="" /></td>
       <td bgcolor="#FF00CA" align="center"><input type="submit" name="submit" value="&nbsp;Save&nbsp;" /> </td>
    </tr>
 </table>
 </form>

<script type="text/javascript" src="sp.js"></script>
<?php
include "footer.php";
?>
