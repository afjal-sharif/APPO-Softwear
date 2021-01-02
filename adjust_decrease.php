<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Decrease Stock Quantity ?")
if (answer !=0)
{
  window.submit();
}
}	
</script>

<?
if(isset($_POST["confimin"]))
{
      $user_query="SELECT max(autoinvoice)+1 as invoice FROM `tbl_sales` where `invoice` not like 'c%'";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newinvoice=$row_sql[invoice];
      
      $user_query="Select * from tbl_customer where status=2 ";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $customer=$row_sql[id];
      $name=$row_sql[name];
 
      
     $sql="SELECT * FROM tbl_adjustment where type=1 and status=0 and user='$_SESSION[userName]'"; 
     $users = mysql_query($sql);
     $total = mysql_num_rows($users);    
     if($total>0)
     {
      $totalvalue=0;
      while($value=mysql_fetch_array($users))
       {
        $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
            soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination) 
            value('$value[date]','$value[donumber]','$value[product]', '$newinvoice',$value[rate],$value[qty],0,
             '$_SESSION[userName]',$customer,1,'$value[unit]',0,'-',
              '-','$value[remarks]','',$newinvoice,0,'',curdate(),'-','-')"; 
        db_query($sql) or die(mysql_error());
        
        $sql="update tbl_adjustment set status=1 where id=$value[id]";
        db_query($sql) or die(mysql_error());
        $totalvalue=$totalvalue+($value[qty]*$value[rate]);
        $dt=$value[date];  
       }
      
      $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];
      
      $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,depositebank,mrno,remarks,automrno,customerid,cstatus,paytype) 
         value('$dt','$newinvoice',$totalvalue,0,'$_SESSION[userName]','Cash','$newmrnomain','Adjustment- $newinvoice','$newmrnomain',$customer,'C','Cash')";     
      db_query($sql) or die(mysql_error());  
          
       
      $remarks=" Stock Adjustment: Invoice $_POST[invoice]";
      $sql="insert into tbl_cash(date,remarks,deposite,user)values('$dt','$remarks',$totalvalue,'$_SESSION[userName]')";
      db_query($sql) or die(mysql_error());  
      $msg=" Cash Tk. $totalamount Receive Successfully";
      
      $remarks="Expense Stock Adjust: Invoice $_POST[invoice] ";
      $sql="insert into tbl_cash(date,remarks,withdraw,user,expensetype,type,refid,poorexp)values('$dt','$remarks',$totalvalue,'$_SESSION[userName]',13,1,'$newmrnomain',2)";
      db_query($sql) or die(mysql_error());     
     } 
 echo "<b> Adjustment Confirm Successfully. </b>";
}
?>



<?
 $sql="SELECT tbl_adjustment.id,tbl_product.name as pname,tbl_product.unit, tbl_product_category.name as cat_name,
              tbl_adjustment.qty,tbl_adjustment.rate,tbl_adjustment.remarks,tbl_adjustment.user 
       FROM tbl_adjustment 
       join tbl_product on tbl_product.id=tbl_adjustment.product
       join tbl_product_category on tbl_product_category.id= tbl_product.category_id
         where tbl_adjustment.status=0 and tbl_adjustment.type=1  and tbl_adjustment.user='$_SESSION[userName]'";
 $users = mysql_query($sql);
 $total = mysql_num_rows($users);    
 $total=0;
 if ($total>0)
    {
 ?> 
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Quantity Adjust Product List</td></tr> 
 <tr bgcolor="#FFCCAA">           
       <td>Category</td>
       <td>Product</td>
       <td>Adjust Qty</td>
       <td>Rate</td>
       <td>Value</td>
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
          <td><?=number_format($value[rate],2);?></td>
          <td><?=number_format($value[rate]*$value[qty],2);?></td>
          <td><?=$value[remarks];?></td>        
          <td align="center"><a href="indelete.php?id=<?=$value[id]?>&mode=inadjust&type=1"><img src="images/inactive.png" height="15px" width="15px"></a></td>
       </tr>


  <? 
    $totalqty=$totalqty+$value[qty];
    $totalvalue=$totalvalue+($value[qty]*$value[rate]);
    
    }
      echo "<tr id='trsubhead'><td colspan='2' align='center'>Total </td>
                              <td colspan='1' align='right'> ".number_format($totalqty,2)."</td>
                              <td colspan='1' align='center'> ".number_format($totalvalue/$totalqty,2)."</td>
                              <td colspan='1' align='center'> ".number_format($totalvalue,2)."</td>
                              <td>&nbsp;</td><td>&nbsp;</td>
                             
             </tr>";
             
             
      echo "<form name='abc' method='post' action=''><tr id='trsubhead'><td colspan='8'><input type='submit' name='confimin' value=' &nbsp; Confirm Decrease Quantity &nbsp;' onclick='ConfirmChoice(); return false;' /></td></tr></form>"  ;      
      echo "</table>";
    }
    
?>





<form name="abc" method="post" action="adjustment.php?todo=submitde">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">STOCK ADJUSTMENT :: <b> Quantity Decrease</b></td></tr> 
 <tr id="trsubhead">    
   <td>Category</td>
   <td>Product In Stock</td>
   <td>Quantity</td>
   <td>Remarks</td>
   <td>Action</td>
 </tr>
 <tr>
   <td colspan="1">
    
          <?
           $query_sql = "SELECT distinct catid,catname  FROM view_stock_display order by catname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="category" id="category_stock" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['catid'];?>" <?php if($_POST["category"]==$row_sql['catid']) echo "selected";?> ><?php echo $row_sql['catname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
    </td>
    <td colspan="1">
            <div id="divcategory_stock">
             <select style="width:250px" id="sub_cat" name="sub_cat">
                 <?      
                 if(isset($_POST[category]) and ($_POST[category]!=''))
                 {
                  $query_sql = "SELECT  *  FROM `view_stock_display` where catid='$_POST[category]' order by catname";
                 }
                 else
                 {
                 $query_sql = "SELECT  *  FROM `view_stock_display`  order by catname";
                 }
                 $sql = mysql_query($query_sql) or die(mysql_error());
                 echo"<option value='-1'></option>";
		               
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs[product];?>" <? if($_POST[sub_cat]==$rs[product]) {echo "SELECTED";}?>><?=$rs['catname'];?>::<?=$rs['pname'];?>::Stock <?=$rs['qty']?> <?=$rs['unit'];?> ::Rate <?=number_format($rs['grate'],2);?></option>
                 <?    
		             }
                ?>
             </select>
            </div>
     </td>
     
     <td><input type="text" size="8" name="quantity" value="0"  /> </td>
     <td><input type="text" size="30" name="remarks" value="" /></td>
     
     <td> 
        <input type="submit" name="salessave" value= "  Add To Adjust  ">
   </td>
 </tr>  
 </form>
</table>
<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
