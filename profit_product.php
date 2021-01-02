<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
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
  $con2=date("Y-m-d");
  $_SESSION[con]=$con;
 } 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trsubhead">  
       <td>
         <input type="radio" name="profitwise" value="0" CHECKED> &nbsp;Category Wise
         <input type="radio" name="profitwise" value="1" <? if($_POST[profitwise]==1){echo "CHECKED";}  ?> >&nbsp;Product Wise 
       </td>
        <td align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
       
           To :<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>   
       
       <td align="center"><input type="submit"  name="submit" value="   View  " /> </td>
      </tr>            
</table>
</form>


<!-- Order Details -->

 <?
    if($_POST[profitwise]==1) 
     { 
     $user_query="Select tbl_sales.product,concat(tbl_product_category.name,' - ',tbl_product.name )as pname, tbl_sales.unit, sum(tbl_sales.qty) as qty, sum(tbl_sales.qty*(tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)) as salesvalue,
                   sum(tbl_sales.qty*(tbl_receive.rate+tbl_receive.dfcost+tbl_receive.locost)) as purcahsevalue
                   from tbl_sales
                   join tbl_receive on (tbl_sales.donumber=tbl_receive.donumber  and tbl_sales.product=tbl_receive.product)
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   where tbl_sales.date between '$con1' and '$con2'
                   group by tbl_sales.product
                   order by tbl_product.category_id,tbl_product.id";
    }
   if($_POST[profitwise]==0) 
     { 
     $user_query="Select tbl_product_category.name as pname, tbl_sales.unit, sum(tbl_sales.qty) as qty, 
                   sum(tbl_sales.qty*(tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)) as salesvalue,
                   sum(tbl_sales.qty*(tbl_receive.rate+tbl_receive.dfcost+tbl_receive.locost+view_sup_adj_amount.amount)) as purcahsevalue
                   from tbl_sales
                   join tbl_receive on (tbl_sales.donumber=tbl_receive.donumber  and tbl_sales.product=tbl_receive.product)
                   join tbl_product on tbl_sales.product=tbl_product.id
                   join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                   left join `view_sup_adj_amount` on(`view_sup_adj_amount`.`donumber` = `tbl_receive`.`donumber`)
                   where tbl_sales.date between '$con1' and '$con2'
                   group by tbl_product_category.id";    
     }  
  
  
  
  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
<table width="960px" align="center" bordercolor="#AAAA00"  bgcolor="#FFFFFF"  border="2" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr id="trhead"><td colspan="8">Category/Product Wise Profit</td></tr>
<tr id="trsubhead">
    <td align="left" colspan="8" > <b> Date :</b> <? echo $con1; ?> <? echo " To ". $con2; ?></td>
</tr> 

<tr id="trsubhead">
    <td align="center" colspan="2">Category/Product Info</td>
    <td align="center" colspan="2">Sales Info</td>
    <td align="center" colspan="1">Purchase Info</td>
    
    <td align="center" colspan="2">Profit</td>
    
    <td align="center" colspan="1">%</td>
</tr> 


<tr align="center" bgcolor="#FFEECC">
                     <td>Name</td>
                     <td>Unit</td>
                     
                     
                     <td>Qty</td>
                     <td>Value (Tk.)</td>
                          
                     <td>Value (Tk.)</td>
                     
                          
                     <td> Amount(Tk)</td>                
                     <td> Per/Unit(Tk)</td>
                     <td> % </td>
</tr>

    <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[pname];?></td>
          <td><?=$value[unit];?></td>
          
          
          <td align="right"><?=number_format($value[qty],0);?> &nbsp;</td>
          
          <td align="right" bgcolor="#FFFFFF"><?=number_format($value[salesvalue],2);?></td>
          <td align="right" bgcolor="#FFFFFF"><?=number_format($value[purcahsevalue],2);?></td>
          
          <td align="right" bgcolor="#FFFFFF"><?=number_format($value[salesvalue]-$value[purcahsevalue],2);?></td>
          <td align="right" bgcolor="#FFFFFF"><?=number_format(($value[salesvalue]-$value[purcahsevalue])/$value[qty],2);?></td>   
    
          <td align="right" bgcolor="#FFEECC"><?=number_format((($value[salesvalue]-$value[purcahsevalue])/$value[purcahsevalue])*100,2);?></td> 
          </tr>
       <?
        $sumqty=$sumqty+$value[qty];
        $sumsales=$sumsales+$value[salesvalue];
        $sumpur=$sumpur+$value[purcahsevalue];
        $sumprofit=$sumprofit+$value[salesvalue]-$value[purcahsevalue];
       }
       echo "<tr id='trsubhead' ><td colspan='2'>Total :</td>";
       echo "<td align='right'>". number_format($sumqty,0)."</td><td align='right'>". number_format($sumsales,2)." </td>
            <td align='right'>". number_format($sumpur,2)."</td>
            <td align='right'>". number_format($sumprofit,2)."</td>
            <td align='right'>". number_format($sumprofit/$sumqty,2)."</td>
            <td align='right'>". number_format(($sumprofit/$sumpur)*100,2)."</td>";
            
       
       
        
       echo "</tr></table>";
      }
     else
      {
        echo "<img src='images/inactive.png'><b> No Sales Information Found. !!</b>";
      } 
    ?>  
 
<?php
 include "footer.php";
?>
