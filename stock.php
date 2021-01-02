<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Stock List";
 include "session.php";  
 include "header.php";
?>


<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

 <tr id="trsubhead">
    <td>Category: 
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
                 if(isset($_POST[category]))
                 {
                  $query_sql ="SELECT  tbl_product.id,tbl_product.name as pname,tbl_product_category.name as catname,punit                
                              FROM `tbl_product`
                              join tbl_product_category on tbl_product.category_id=tbl_product_category.id 
                              where category_id='$_POST[category]' order by tbl_product.name";
                 }
                 else
                 {
                 $query_sql = "SELECT  tbl_product.id,tbl_product.name as pname,tbl_product_category.name as catname,punit                
                              FROM `tbl_product`
                              join tbl_product_category on tbl_product.category_id=tbl_product_category.id  order by tbl_product.name";
                 }
                 $sql = mysql_query($query_sql) or die(mysql_error());
                 echo"<option value='-1'></option>";
		               
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['id'];?>" <? if($_POST[sub_cat]==$rs[id]) {echo "SELECTED";}?>><?=$rs['catname'];?>::<?=$rs['pname'];?>::<?=$rs['punit'];?></option>
                 <?    
		             }
                ?>
             </select>
            </div>
       </td>
  
   <td>
     Stock Upto Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
   </td>
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="9">Stock List</td></tr> 

   <tr bgcolor="#FFCCAA">    
       
       <td>Category</td>
       <td>Product</td>
       <td>Qty</td>    
       <td>Bundle</td>       
       <td>Product Price</td>
       <td>Others Cost</td>
       <td>Gross Price</td>
       <td bgcolor="#FFEECC">Product Value</td>
       <td bgcolor="#FFEECC">Total Value</td>
      </tr>     
    <?
   if(isset($_POST["view"]))
   {
    $con="where view_stock_details_base.dt<='$_POST[demo11]'";
     if ($_POST[category]!='')
      {
       $con=$con. " and view_stock_details_base.catid='$_POST[category]'";
      }
     
     
     if ($_POST[sub_cat]!='-1')
      {
       $con=$con." and view_stock_details_base.product='$_POST[sub_cat]'";
       
      }
   
     
     $user_query="select catname,pname,unit,sum(qty) as stock_qty,sum(bundle) as bundle, sum(qty*rate)/sum(qty) as rate, 
                     sum(qty*dfcost)/sum(qty) as dfcost,sum(qty*locost)/sum(qty) as locost
                     from view_stock_details_base $con group by product
                     having sum(view_stock_details_base.qty)<>0
                     order by view_stock_details_base.catname asc";
        
  
    }
   else
   {
   
      $user_query="select catname,pname,unit,sum(qty) as stock_qty,sum(bundle) as bundle, sum(qty*rate)/sum(qty) as rate, 
                  sum(qty*dfcost)/sum(qty) as dfcost,sum(qty*locost)/sum(qty) as locost 
                from view_stock_details_base  
                group by product
                having sum(view_stock_details_base.qty)<>0
                order by view_stock_details_base.catname asc";
   }
  
      $toalamount=0;
      $totalstock=0;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $runvalue=0;
       $bal=0;
       $runqty=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       
          <?
          if($value[product]==$product)
           {
           ?>
           <tr>
             <td><?=$value[catname];?></td>
             <td><?=$value[pname];?></td>    
             <td align="right"><?=$value[stock_qty];?>  &nbsp; <?=$value[unit];?> </td>
             <td align="center"><?=$value[bundle];?></td>
             <td align="right"><?=number_format($value[rate],2);?></td>
             <td align="right"><?=number_format($value[dfcost]+$value[locost],2);?></td>
             <td align="right"><?=number_format($value[rate]+$value[dfcost]+$value[locost],2);?></td>
             <td align="right"><?=number_format($value[rate]*$value[stock_qty],2);?></td>
             <td align="right" bgcolor="#FFEECC"><?=number_format($value[rate]*$value[stock_qty],2);?></td>
          </tr>  
           <?
           $runqty=$runqty+$value[stock_qty];
           $runvalue=$runvalue+($value[rate]*$value[stock_qty]);
           }
          else
           { 
        ?>
          <tr>
             <td><?=$value[catname];?></td>
             <td><?=$value[pname];?></td>       
             <td align="right"><?=$value[stock_qty];?>&nbsp;<?=$value[unit];?> </td>
             <td align="center"><?=$value[bundle];?></td>      
             <td align="right"><?=number_format($value[rate],2);?></td>
             <td align="right"><?=number_format($value[dfcost]+$value[locost],2);?></td>
             <td align="right"><?=number_format($value[rate]+$value[dfcost]+$value[locost],2);?></td>
             <td align="right"><?=number_format($value[rate]*$value[stock_qty],2);?></td>
            <td align="right" bgcolor="#FFEECC"><?=number_format($value[rate]*$value[stock_qty],2);?></td>
         </tr>
       <?
        }
       $toalpamount=$toalpamount+($value[rate]*$value[stock_qty]); 
       $toalamount=$toalamount+(($value[rate]+$value[dfcost]+$value[locost])*$value[stock_qty]);
       $totalstock=$totalstock+$value[stock_qty];
       $totalbundle=$totalbundle+$value[bundle];
       $product=$value[product];
       }
      }

      if($totalstock<=0){$totalstock=1;}
    ?>  
  </tr>
  <tr id="trsubhead">
     <td colspan="2" align="center">Total :</b></td>
     <td colspan="1" align="right"><?=number_format($totalstock,2)?></td>
     <td colspan="1" align="center"><?=number_format($totalbundle,0)?></td>
     <td colspan="1" align="right"><?=number_format($toalpamount/$totalstock,2)?></td>
     <td colspan="1" align="right"><?=number_format(($toalamount-$toalpamount)/$totalstock,2)?></td>
     <td colspan="1" align="right"><?=number_format($toalamount/$totalstock,2)?></td>
     <td colspan="1" align="right"><?=number_format($toalpamount,2)?></td>
     <td colspan="1" align="right"><?=number_format($toalamount,2)?></td>
  </tr>
 </table>
 <script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
