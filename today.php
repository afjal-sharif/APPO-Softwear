<?php
 ob_start("ob_gzhandler"); 
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
   }
  else
   {
    //$con1=date("Y-m-d");
    $con1=$_SESSION[dttransection];
   }  
  
  //$con_display=date("Y-m-d");
  
 
  $_SESSION[con]=$con1; 
  $_SESSION[t_excel_con]=$con1; 
?>
<!--
<form name="excel_export" method="post" action="excel.php">
  <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
    <td align="right"><input type="submit"  name="submit" value="   Export Excel  " /> </td>
    <td align="right">
      <INPUT TYPE="image" SRC="images/excel.png" HEIGHT="30" WIDTH="30" BORDER="0" ALT="Submit Form">    
    </td>
  </table>
</form>
-->
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trsubhead">  
         <td align="center" colspan="1"> 
           <form name="myForm" method="post" action="">
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
         <!--
         </td>   
         <td align="center">
         -->
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="submit"  name="submit" value="   View  " />
         </form> 
        </td>
        
        <td align="center">
          <A HREF=javascript:void(0) onclick=window.open('printtoday.php','POPUP','width=1000,height=800,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><img src="images/print.png" width="35px" height="35px" ></a>
        </td>
       <td align="center">
         <form name="excel_export" method="post" action="excel.php">
           <INPUT TYPE="image" SRC="images/excel.png" HEIGHT="30" WIDTH="30" BORDER="0" ALT="Submit Form">
         </form>
       </td> 
     </tr>
     
    
     <tr id="trhead">
      <td colspan="3">
        <b> Day Details Transection : 
         <?php  
         $date = date_create($con1); 
         echo  date_format($date, 'd-M-Y')." </b>" ;?>
      </td>
     </tr>
</table>


 
 <!-- Receive Details -->

 <?
         $con="where tbl_order.dtDate='$con1'";
         $user_query="select tbl_order.dtDate as date,tbl_order.donumber,tbl_order.remarks,tbl_order.qty as orderqty,
                   tbl_order.truckno,sum(tbl_receive.qty) as qty, 
                   sum((tbl_receive.rate +tbl_receive.dfcost+tbl_receive.locost) * tbl_receive.qty) as goodsvalue,tbl_company.name as company, sum(((tbl_receive.rate +tbl_receive.dfcost+tbl_receive.locost) * tbl_receive.qty) / tbl_receive.qty) as Srate	
                   from tbl_order
                   join tbl_company on tbl_order.company=tbl_company.id
                   left join tbl_receive on tbl_receive.donumber=tbl_order.donumber
                   $con
                   group by tbl_order.donumber                
                   order by tbl_order.id desc";
      $users = mysql_query($user_query);
      
      $total = mysql_num_rows($users);    
      $_SESSION[sqlorder]=$user_query;
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">

 <tr id="trhead"><td colspan="10"><b>Receive Goods Details.</b></td></tr> 
 <tr align="center" bgcolor="#F3F3F3">   
       <td>SL No</td> 
       <td>Date</td>
       <td>Company</td>
       <td>Ref.No</td>
       <td>Truck No</td>
       <td>Remarks</td>
       <td>Order Qty</td>
       <td>Receive Qty</td>
	<td>Rate</td>
       <td>Total Cost</td>
    </tr>     

    <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[company];?></td>
          <td align="center">
             <a href="pur_view.php?id=<?=$value[donumber];?>" target="_blank" title="View Details">
               <?=$value[donumber];?>
             </a>
          </td>
          <td><?=$value[truckno];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=$value[orderqty];?></td>
          <td align="right"><?=$value[qty];?></td>
	<td align="right"><?=number_format($value[goodsvalue]/$value[qty],2);?></td>
         <td align="right"><?=number_format($value[goodsvalue]+$value[dfcost]+$value[locost],2);?></td> 
       </tr>
       <?
       
       
       $totalamount=$totalamount+$value[goodsvalue];
       $totalqty=$totalqty+$value[qty];
       
       $totallorder=$totallorder+$value[orderqty];
       }
      
    ?>  
  </tr>
   <tr id="trsubhead">
                      <td colspan="6" align="center">Total Amount :</td>
                     <td align="right"><?=number_format($totallorder,2);?></td>
                      <td align="right"><?=number_format($totalqty,2);?></td>
                      
                      <td colspan="2" align="right"><?=number_format($totalamount+$totaldfcost+$totallocost,2);?></td>
  </tr>
       <?
       
       echo "</table>";
      }
    ?>  

 

<!-- Sales Details --> 


 <?
    $totalamount=0;
    $totalqty=0;
    $con="where tbl_sales.date='$con1'";
    $user_query="select tbl_sales.date,tbl_sales.invoice,sum((tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty) as value,sum(tbl_sales.qty) as qty,
                   tbl_customer.name as customer,customername,sum(tbl_sales.rate*tbl_sales.qty)/sum(tbl_sales.qty) as rate
                   from tbl_sales
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   $con
                   group by tbl_sales.invoice, tbl_sales.customerid
                   order by tbl_sales.id desc,invoice";
      $users = mysql_query($user_query);
      $_SESSION[sqlreceive]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7"><b>Sales Goods Details.</b></td></tr> 
    <tr align="center" bgcolor="#F3F3F3">
       <td>SL No</td>
       <td>Date</td>
       <td>Customer</td>
       <td>Invoice</td>
       <td>Qty</td>
	   <td>Rate</td>
       <td>Total Value</td>
   </tr>     
    <?
       $count=0;
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
        ?>
       <tr  align="center">
          <td><?=$count?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[customer];?>&nbsp;<?=$value[customername];?> </td>
          <td>
           <a href="invoice.php?id=<?=$value[invoice];?>" target="_blank" title="View Details">
              <?=$value[invoice];?>
           </a>
          </td>
          
          <td align="right"><?=number_format($value[qty],2);?></td>
		  <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[value],2);?></td>
       </tr>
       <?
       $totalqty=$totalqty+$value[qty];
       $totalamount=$totalamount+$value[value];
       }
      
    ?>  
        <tr id="trsubhead"><td colspan="3"> Total Amount</td>
		<td colspan="1" align="right"></td>
         <td colspan="1" align="right"><?=number_format($totalqty,2);?> <?=$unit;?></td>
         <td colspan="2" align="right"><?=number_format($totalamount,2);?></td></tr>
     </table>
     <? 
      }
    ?>  

 <!-- Product Category Wise Purchase & Sales Details --> 

 <?
    $totalamount=0;
    $totalqty=0;
    $con_sal="where tbl_sales.date='$con1'";
    $con_pur="where tbl_receive.date='$con1'";
    $user_query="select p.date, p.g_name,sum(p.pur_qty) as pqty,sum(p.pur_value) as pvalue,
                 sum(p.sales_qty) as sqty,sum(p.sales_value)as svalue
                 from(
                      
                      select tbl_sales.date,g_name,sum((tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty) as sales_value,sum(tbl_sales.qty) as sales_qty, 0 as pur_value,0 as pur_qty
                      from tbl_sales 
                      join tbl_product on tbl_product.id=tbl_sales.product
                      join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                      $con_sal
                      group by g_name
                      union all
                      select tbl_receive.date,g_name, 0 as sales_value,0 as sales_qty,  
                                         sum((tbl_receive.rate +tbl_receive.dfcost+tbl_receive.locost) * tbl_receive.qty) as pur_value,sum(tbl_receive.qty) as pur_qty
                                         from tbl_receive 
                      join tbl_product on tbl_receive.product=tbl_product.id
                      join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                      $con_pur
                      group by g_name
                      ) as p 
                 group by p.date,p.g_name
                 ";
      $users = mysql_query($user_query);
      $_SESSION[sqlcategory]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7"><b>Product Group Wise Purchase & Sales</b></td></tr> 
 <tr align="center" bgcolor="#F3F3F3">
       <td>SL No</td>
       <td>Date</td>
       <td>Group Name</td>
       <td colspan="1">Pur. Qty</td>
       <td colspan="1">Pur. Value</td>
       <td colspan="1"> Sales Qty</td>
       <td colspan="1"> Sales Value</td>       
 </tr>     
    <?
       $count=0;
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
        ?>
       <tr  align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[g_name];?></td>
                  
          <td align="right"><?=number_format($value[pqty],2);?></td>
          <td align="right"><?=number_format($value[pvalue],2);?></td>
          
          <td align="right"><?=number_format($value[sqty],2);?></td>
          <td align="right"><?=number_format($value[svalue],2);?></td>
          
       </tr>
       <?
       $ptotalamount=$ptotalamount+$value[pvalue];
       $stotalamount=$stotalamount+$value[svalue];
       }
      
    ?>  
        <tr id="trsubhead"><td colspan="3"> Total Amount</td>
          <td colspan="2" align="right"><?=number_format($ptotalamount,2);?></td>
          <td colspan="2" align="right"><?=number_format($stotalamount,2);?></td>
        </tr>
     </table>
     <? 
      }
    ?>  


 <!-- Product Category Wise Item Receive -->
 <!-- Product Category Wise Purchase & Sales Details --> 

 <?
    $totalamount=0;
    $totalqty=0;
    $con_sal="where tbl_sales.date='$con1'";
    $con_pur="where tbl_receive.date='$con1'";
    $user_query="select p.date, p.name,sum(p.pur_qty) as pqty,sum(p.pur_value) as pvalue,
                 sum(p.sales_qty) as sqty,sum(p.sales_value)as svalue
                 from(
                      
                      select tbl_sales.date,tbl_product_category.g_name,tbl_product_category.name,sum((tbl_sales.rate+tbl_sales.df+tbl_sales.loadcost)*tbl_sales.qty) as sales_value,
                      sum(tbl_sales.qty) as sales_qty, 0 as pur_value,0 as pur_qty
                      from tbl_sales 
                      join tbl_product on tbl_product.id=tbl_sales.product
                      join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                      $con_sal
                      group by name
                      union all
                      select tbl_receive.date,tbl_product_category.g_name,tbl_product_category.name, 0 as sales_value,0 as sales_qty,  
                                         sum((tbl_receive.rate +tbl_receive.dfcost+tbl_receive.locost) * tbl_receive.qty) as pur_value,sum(tbl_receive.qty) as pur_qty
                                         from tbl_receive 
                      join tbl_product on tbl_receive.product=tbl_product.id
                      join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                      $con_pur
                      group by tbl_product_category.name
                      ) as p 
                 group by p.date,p.name
                 order by p.g_name
                 ";
      $users = mysql_query($user_query);
      $_SESSION[sql_pro_category]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7"><b>Product Category Wise Purchase & Sales</b></td></tr> 
 <tr align="center" bgcolor="#F3F3F3">
       <td>SL No</td>
       <td>Date</td>
       <td>Category Name</td>
       <td colspan="1">Pur. Qty</td>
       <td colspan="1">Pur. Value</td>
       <td colspan="1"> Sales Qty</td>
       <td colspan="1"> Sales Value</td>       
 </tr>     
    <?
       $count=0;
       $totalamount=0;
       $ptotalamount=0;
       $stotalamount=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
        ?>
       <tr  align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[name];?></td>
                  
          <td align="right"><?=number_format($value[pqty],2);?></td>
          <td align="right"><?=number_format($value[pvalue],2);?></td>
          
          <td align="right"><?=number_format($value[sqty],2);?></td>
          <td align="right"><?=number_format($value[svalue],2);?></td>
          
       </tr>
       <?
       $ptotalamount=$ptotalamount+$value[pvalue];
       $stotalamount=$stotalamount+$value[svalue];
       }
      
    ?>  
        <tr id="trsubhead"><td colspan="3"> Total Amount</td>
          <td colspan="2" align="right"><?=number_format($ptotalamount,2);?></td>
          <td colspan="2" align="right"><?=number_format($stotalamount,2);?></td>
        </tr>
     </table>
     <? 
      }
    ?>  

 
 
 
 
 
 
 
 
<!-- Payment Details --> 

 <?
 $con="";
 $con2="";
      $con="where tbl_com_payment.paydate='$con1'";
      $user_query="select paydate,tbl_company.name,chequeno,bank,amount,cheqdate,bamount,remarks,tbl_com_payment.status from tbl_com_payment 
                   join tbl_company on tbl_company.id=tbl_com_payment.companyid
                   $con
                   order by tbl_com_payment.id";
      $users = mysql_query($user_query);
      $_SESSION[sqlpayment]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="10"><b>Payment To Supplier</b></td></tr>
 <tr align="center" bgcolor="#F3F3F3">     
       <td>S No</td>
       <td>Date</td>
       <td>Company</td>
       <td>Cheque No</td>
       <td>Cash/Bank</td>
       <td>Cheque Date</td>
       <td>Remarks</td>
       <td>Amount</td>
       <td>Status</td>
       <td>BC Amount</td>   
</tr> 

      <?
      $count=0;
      $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr  align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[paydate]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[chequeno];?></td>
          <td align="center"><?=$value[bank];?></td>
          <td align="right">
           <? 
           if(($value[bank]=='Cash') or ($value[bank]=='Incentive Adjustment'))
           {
           echo "&nbsp;";
           }
           else
           {
            echo $value[cheqdate];
           }
           ?>
          </td>
          <td align="right"><?=$value[remarks];?></td>   
          <td align="right"><?=number_format($value[amount],2);?></td>
           <td align="center"><?=$value[status];?></td>
          <td align="right"><?=number_format($value[bamount],2);?></td>  
          
            
       </tr>
       <?
       $totalbcamount=$totalbcamount+$value[bamount];
       $totalamount=$totalamount+$value[amount];
       }
      echo "<tr id='trsubhead'><td colspan='6'>Total Payment :</td><td colspan='2' align='right'>".number_format($totalamount,2)."</td>";
                                                           echo "<td colspan='2' align='right'>".number_format($totalbcamount,2)."</td>";
                                                           
       echo "</tr>"; 
       echo "</table>";
      }
    ?>  

 
 

<!-- Payment Receive Details --> 

 <?
      $con="where tbl_dir_receive.date='$con1'";
      $user_query="select customerid,tbl_customer.name,type,tbl_dir_receive.date, tbl_customer.address,tbl_customer.mobile,tbl_dir_receive.invoice,
                   paytype,hcash,amount,bank,chequeno,tbl_customer.status,tbl_dir_receive.mrno,tbl_dir_receive.remarks,
                   tbl_company.name as cname
                   from tbl_dir_receive
                   join tbl_customer on tbl_customer.id=tbl_dir_receive.customerid
                   left join tbl_company on tbl_dir_receive.paycompany=tbl_company.id
                   $con order by tbl_dir_receive.id desc";
      $users = mysql_query($user_query);
      $_SESSION[sqlpreceive]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="11"><b>Payment Receive From Customer</b></td></tr>
 <tr align="center" bgcolor="#F3F3F3">
<td>SL No</td>
<td>Date</td><td>Customer</td><td>Invoice/MR</td><td>Cash</td><td>Cheque No</td><td>Bank</td><td>Amount</td><td>Cheque Date</td><td>Status</td><td>User</td></tr>          
      <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr  align="center">
          <td><?=$count;?></td>
          <td><?
           $date=date_create($value[date]);
           echo date_format($date,'d-M-y');
          ?></td>
          <td><?=$value[name];?> &nbsp; &nbsp;  <?=$value[remarks];?></td>
          <td><?=$value[invoice];?>/<?=$value[mrno];?></td>
          <td align="right"><?=number_format($value[hcash],2);?></td>
          <td><?=$value[chequeno];?></td>
          <td><?=$value[bank];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>
          <td><?=$value[cheqdate];?></td>
          <td>
          <?
           
            if($value[cstatus]=='C')
             {
              echo "Clear";
             }
            elseif($value[cstatus]=='B')
             {
             echo "Bounce";
             } 
           else
             {
             echo "New";
             }           
          ?>
          
          </td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $totalcash=$totalcash+$value[hcash];
       $totalch=$totalch+$value[amount];
       }
      echo "<tr id='trsubhead'><td colspan='3'>Total :</td><td colspan='2' align='right'>".number_format($totalcash,2)."</td><td colspan='3' align='right'>".number_format($totalch,2)."</td><td colspan='4' align='center'>=".number_format($totalcash+$totalch,2)."</td></tr>";
      echo "</table>";
      }
    ?>  

 
 
 
<!-- Bank Transection Details --> 

 <?
      $con="where tbl_bank.date='$con1'";
      $user_query="SELECT * from tbl_bank $con ";
      $users = mysql_query($user_query);
      $_SESSION[sqlbank]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $deptotal=0;
       $withtotal=0;
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="5"><b>Bank Transection</b></td>
<!--<td><A HREF=javascript:void(0) onclick=window.open('printtodayCB.php','Holcim','width=700,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><b>Print</b></a> </td>-->
</tr>
 <tr align="center" bgcolor="#F3F3F3">
  <td>SL No</td>
  <td>Description</td><td>Deposite</td><td>Withdraw</td><td>User</td></tr>          
      <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr>
          <td align="center"><?=$count;?></td>
          <td><?=$value[bank];?>:<?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $deptotal=$deptotal+$value[deposite];
       $withtotal=$withtotal+$value[withdraw];
       }
       echo "<tr id=trsubhead><td colspan='2'>Total</td><td align='right'>". number_format($deptotal,2)."</td><td align='right'>". number_format($withtotal,2)." </td><td>= ". number_format($deptotal-$withtotal,2)."</td></tr>";
       echo "</table>";
      }
    ?>  
 


<!-- Cash Transection Details --> 

 <?
      $con="where tbl_cash.date<'$con1'";
      $sql="select sum(deposite-withdraw) as balance from tbl_cash $con";
      $users_skills = mysql_query($sql); 
      $value=mysql_fetch_array($users_skills);
      $opencash=$value[balance];
       
      $_SESSION[opencash]=$opencash; 
      
      $con="where tbl_cash.date='$con1' ";
      $user_query="SELECT * from tbl_cash $con and (deposite<>0 or withdraw<>0) ";
      $users = mysql_query($user_query);
      $_SESSION[sqlcash]=$user_query;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $deptotal=0;
       $withtotal=0;
 ?>
    
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="5"><b>Cash Transection</b></td>
<!--<td><A HREF=javascript:void(0) onclick=window.open('printtodayCB.php','Holcim','width=700,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><b>Print</b></a> </td>-->
</tr>
 <tr align="center" bgcolor="#F3F3F3">
   <td>SL No</td>
   <td>Description</td><td>Deposite</td><td>Withdraw</td><td>User</td></tr>          
 <tr align="center" bgcolor="#F3F3F3">
    <td colspan="2">Openning Cash Balance :</td>
                   <td colspan="1" align="right"> <?=number_format($opencash,2);?></td>
                   <td colspan="1">&nbsp;</td>
                   <td colspan="1">&nbsp;</td>
</tr>


      <?
       $count=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr>
          <td align="center"><?=$count;?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>         
       </tr>
       <?
       $deptotal=$deptotal+$value[deposite];
       $withtotal=$withtotal+$value[withdraw];
       }
       echo "<tr><td colspan='2'>Total : </td><td align='right'>". number_format($deptotal,2)."</td><td align='right'>". number_format($withtotal,2)." </td><td>= ". number_format($deptotal-$withtotal,2)."</td></tr>";
       echo "<tr id='trsubhead'><td colspan='2'>Closing Balance:($con1) </td><td align='right'>". number_format($deptotal-$withtotal+$opencash,2)."</td><td colspan='2'>&nbsp;</td></tr>";
       echo "</table>";
      }
    ?>  
 
<?php
 include "footer.php";
?>
