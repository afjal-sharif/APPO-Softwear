<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
?>
<?
 $sql="delete from today_tmp";
 db_query($sql);
 
 $query_sql="select tbl_product_category.name as cat_name,tbl_product.id,tbl_product.name as name,tbl_product.unit,tbl_product.category_id from tbl_product
             join tbl_product_category on   tbl_product.category_id=tbl_product_category.id";
 $users = mysql_query($query_sql) or die(mysql_error());
 $totalRows_sql = mysql_num_rows($users);
 if($totalRows_sql>0)
 {
   while($value=mysql_fetch_array($users))
   {
   $sql="insert into today_tmp(cat_name,item,name,unit,cat_id)values('$value[cat_name]', $value[id],'$value[name]','$value[unit]','$value[category_id]')";
   db_query($sql) or die(mysql_error()); 
   }
 }
?> 




<?
if(isset($_POST["submit"]))
 {
  $con1=$_POST[demo11];
  $con2=$_POST[demo12];
    
    
  $_SESSION[con]=$con;
 }
else
 {
 
  $con1=date("Y-m-d");
  $con1=$_SESSION[dttransection];
  $con2=date("Y-m-d");
  $con2=$_SESSION[dttransection];
  $con3="";
  $_SESSION[con]=$con;
 } 
?>

<form name="myForm" method="post" action="">
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trsubhead">  
        <td align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]: $con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
       
           To :<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$con2 ?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>   
         <td> Group:
       <select name="g_name" style="width: 150px;">
          <option value=""></option>
            <?
           $query_sql = "SELECT distinct g_name  FROM `tbl_product_category`  order by g_name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['g_name'];?>" <?php if($_POST["g_name"]==$row_sql['g_name']) echo "selected";?> ><?php echo $row_sql['g_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
            <!--
            <option value="Rod" <?if($_POST[g_name]=='Rod'){ echo "Selected";}?>>Rod</option>
            <option value="CEMENT" <?if($_POST[g_name]=='CEMENT'){ echo "Selected";}?> >Cement</option>
            -->
       </select>
   </td>
        
        <td>
        Category: 
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
       
       <td align="center"><input type="submit"  name="submit" value="   View  " /> </td>
       </tr>
</table>
</form>

 
 <!-- Receive Details -->

 <? 
         
      $user_query="SELECT product,sum(qty) as qty, sum(tbl_receive.qty*(rate+dfcost+locost))/sum(qty) as rate FROM tbl_receive 
                   where date_format(tbl_receive.date,'%Y-%m-%d') between '$con1' and  '$con2' group by product";
            
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $sql="update today_tmp set `receive`=$value[qty],receive_rate='$value[rate]', status=1 where item='$value[product]'";
        db_query($sql) or die(mysql_error()); 
 
       }
      }
    ?>  

 
<!-- Sales Details --> 


 <?
      $user_query="SELECT product,sum(tbl_sales.qty*(tbl_sales.rate+df+loadcost))/sum(qty) as rate,sum(tbl_sales.qty) as qty FROM tbl_sales 
                          where date_format(tbl_sales.date,'%Y-%m-%d') between '$con1' and  '$con2' and qty<>0 group by product";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $sql="update today_tmp set `sales`=$value[qty],`sales_rate`=$value[rate] ,status=1 where item='$value[product]'";
        db_query($sql) or die(mysql_error()); 
       }
      }
    ?>  

 
 
 
 
 
<!-- Stock Transection Details --> 

  <?
     // $user_query="SELECT *  FROM `view_stock_display`";
      $user_query="SELECT product,sum(qty) as qty,sum(qty*(rate+dfcost+locost))/sum(qty) as grate  FROM `view_stock_details_base` where dt<='$con2' group by product";
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $sql="update today_tmp set `stock`=$value[qty],stock_rate='$value[grate]',  status=1 where item='$value[product]'";
       db_query($sql) or die(mysql_error());  
       }
      }
    ?>  
 



<!-- Display Transection Details --> 

 <?  
      if($_POST[category]!='')
      {
       $con= "where today_tmp.status=1 and cat_id='$_POST[category]'";
       if($_POST[g_name]!='')
         {
           $con= $con. " and tbl_product_category.g_name='$_POST[g_name]'";   
         } 
         $user_query="SELECT *,today_tmp.name as pname from today_tmp 
                   join  `tbl_product_category` on  `tbl_product_category`.id=today_tmp.cat_id 
                   $con
                  ";
      }
      else
      {
        $con="where today_tmp.status=1";
        if($_POST[g_name]!='')
         {
           $con= $con. " and tbl_product_category.g_name='$_POST[g_name]'";   
         }  
        $user_query="SELECT *,today_tmp.name as pname from today_tmp
                     join  `tbl_product_category` on  `tbl_product_category`.id=today_tmp.cat_id 
                     $con";
      }
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
   <br> 
<table width="960px" align="center" bordercolor="#AAAA00"  bgcolor="#FFFFFF"  border="2" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr id="trhead"><td colspan="7">Transection Summery</td></tr>
<tr id="trsubhead">
    <td align="left" colspan="7" > <b> Date :</b> <? echo $con1; ?> <? echo "& ". $con2; ?></td>
</tr> 

<tr id="trhead">
    <td align="center" colspan="1">Product</td>
    <td align="center" colspan="2">Purchase</td>
    <td align="center" colspan="2">Sales</td>
    <td align="center" colspan="2">Stock</td>
</tr> 


<tr align="center" id="trsubhead">
                     <td>&nbsp;</td>
                     <td>Qty</td>
                     <td>Rate</td>
                     <td>Qty</td>        
                     <td>Rate</td>
                     <td>Qty</td>
                     <td>Rate</td>
</tr>

    <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center">
          <td><?=$value[cat_name];?>:: <?=$value[pname];?> (<?=$value[unit];?>)</td>
          <td align="right"><?=number_format($value[receive],2);?></td>
          <td align="right"><?=number_format($value[receive_rate],2);?></td>
                   
          <td align="right"><?=number_format($value[sales],2);?></td>
          <td align="right"><?=number_format($value[sales_rate],2);?></td>
          
          <td align="right"><?=number_format($value[stock],2);?></td>
          <td align="right"><?=number_format($value[stock_rate],2);?></td>
                    
       </tr>
       <?
        
        $sumreceive=$sumreceive+$value[receive];
        $sumreceivevalue=$sumreceivevalue+($value[receive]*$value[receive_rate]);
        
        $sumsales=$sumsales+$value[sales];
        $sumsalesvalue=$sumsalesvalue+($value[sales]*$value[sales_rate]);
                
        $sumstock=$sumstock+$value[stock];
        $sumstockvalue=$sumstockvalue+($value[stock]*$value[stock_rate]);
        
        if($sumreceive==0){$dsumreceive=1;} else {$dsumreceive=$sumreceive;}
        if($sumsales==0){$dsumsales=1;}else {$dsumsales=$sumsales;}
        if($sumstock==0){$dsumstock=1;}else {$dsumstock=$sumstock;}
        
       }
       echo "<tr id='trsubhead'><td>Total :</td>";
       echo "<td align='right'>". number_format($sumreceive,2)." </td><td align='right'>". number_format($sumreceivevalue/$dsumreceive,2)."</td><td align='right'>". number_format($sumsales,2)."</td>"; 
       echo "<td align='right'>". number_format($sumsalesvalue/$dsumsales,2)."</td>";
       echo "<td align='right'>". number_format($sumstock,2)."</td><td align='right'>". number_format($sumstockvalue/$dsumstock,2)." </td></tr>";
        
       echo "</table>";
      }
    ?>  
 
<?php
 include "footer.php";
?>
