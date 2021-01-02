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
  
  $con="where (view_invoice_profit.date between '$con1'  and '$con2')";
  if($_POST[customer]!='')
  {
   $con=$con. " and customerid='$_POST[customer]'";
  }
  
 }
else
 {
  $con1=date("Y-m-d");
  $con2=date("Y-m-d");
  $con="where (view_invoice_profit.date between '$con1'  and '$con2')";
 } 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trsubhead">  
      
        <td align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
       
           To :<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        
        </td>
         <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,mobile,type  FROM tbl_customer order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  style="width: 200px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['mobile']?> : <?php echo $row_sql['type']?>   </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td align="left">
        &nbsp;&nbsp;
       <input type="submit"  name="submit" value="   View  " /> </td>
      </tr>            
</table>
</form>

<!-- Order Details -->

 <?
   //if(isset($_POST[submit])) 
   //  { 
      $user_query="Select date,cname,invoice,catname,unit, sum(qty) as qty, sum(qty*sal_rate) as sal_value,sum(qty*rate) as pur_value
                   from view_invoice_profit
                   $con
                   group by invoice
                   order by date,invoice
                   ";    
       
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
    // }
    // else
    // {
    // $total=0;
    // }
      if ($total>0)
      {
 ?>
<table width="960px" align="center" bordercolor="#AAAA00"  bgcolor="#FFFFFF"  border="2" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr id="trhead"><td colspan="8">Invoice Wise Profit</td></tr>
<tr id="trsubhead">
    <td align="left" colspan="8" > <b> Date :</b> <? echo $con1; ?> <? echo " To ". $con2; ?></td>
</tr> 

<tr id="trsubhead">
    <td align="center" colspan="3">Basic Info</td>
    
    <td align="center" colspan="2">Sales Info</td>
    <td align="center" colspan="1">Purchase Info</td>
    
    <td align="center" colspan="2">Profit</td>
</tr> 


<tr align="center" bgcolor="#FFEECC">
                     <td>Date</td>
                     <td>Invoice</td>
                     <td>Customer</td>
                     <!--
                     <td>Category</td>
                     <td>Unit</td>
                     -->
                     <td>Qty</td>
                     <td>Value (Tk.)</td>
                          
                     <td>Value (Tk.)</td>
                                              
                     <td> Profit(Tk)</td>                
                     <td> % </td>
</tr>

    <?
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td>
           <a href="profit_rpt_invoice.php?id=<?=$value[invoice];?>" target="_blank">
             <b><?=$value[invoice];?></b>
           </a>  
          </td>
          <td><?=$value[cname];?></td>
          <!--
          <td><?=$value[catname];?></td>
          <td><?=$value[unit];?></td>
          -->
          <td align="right"><?=number_format($value[qty],2);?> &nbsp;</td>
          <td align="right" bgcolor="#FFFFFF"><?=number_format($value[sal_value],2);?></td>
          <td align="right" bgcolor="#FFFFFF"><?=number_format($value[pur_value],2);?></td>
          
          <td align="right" bgcolor="#FFFFFF"><?=number_format($value[sal_value]-$value[pur_value],2);?></td>
          <td align="right" bgcolor="#FFEECC"><?=number_format((($value[sal_value]-$value[pur_value])/$value[pur_value])*100,2);?></td> 
          </tr>
       <?
        $sumqty=$sumqty+$value[qty];
        $sumsales=$sumsales+$value[sal_value];
        $sumpur=$sumpur+$value[pur_value];
        $sumprofit=$sumprofit+$value[sal_value]-$value[pur_value];
       }
       echo "<tr id='trsubhead' ><td colspan='3'>Total :</td>";
       echo "<td align='right'>". number_format($sumqty,0)."</td><td align='right'>". number_format($sumsales,2)." </td>
            <td align='right'>". number_format($sumpur,2)."</td>
            <td align='right'>". number_format($sumprofit,2)."</td>
            
            <td align='right'>". number_format(($sumprofit/$sumpur)*100,2)."</td>";
            
       
       
        
       echo "</tr></table>";
      }
     else
      {
        echo "<img src='images/inactive.png'><b> Please Select Date !!</b>";
      } 
    ?>  
 
<?php
 include "footer.php";
?>
