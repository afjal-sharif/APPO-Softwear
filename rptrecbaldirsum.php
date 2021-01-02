<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $_SESSION[print_cb_sql]='';
 $con1=date("Y-m-d");
?>



 <table width="960px" align="center" bordercolor="#Ff0000" bgcolor="#FFEB9C"  border="2" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr > 
     
       <form name="order" method="post" action="">
        <td>   
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 250px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($cat==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       
        <td colspan="1">
         Customer: 
          <?
           $query_sql = "SELECT  *  FROM tbl_customer order by type asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="customer" style="width: 200px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST['customer']==$row_sql['id']) echo "selected";?>><?php echo $row_sql['name']?>:-:<?php echo $row_sql['address']?> </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
         </td> 
          
          <td>   
            Balance Upto :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]: $con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
         </td>
         
         <td rowspan="2" align="center">
            <input type="submit"  name="view" value="   View  " />       
         </td>
         </tr> 
       
         <tr align="center"> 
                   
          <td>
         
         
         <select name="type" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">         
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['type'];?>" <?php if($_POST[type]==$row_sql[type]) echo "selected";?> ><?php echo $row_sql['type']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>
         
         &nbsp; &nbsp;
         
         <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=4 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="btype" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">          
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["btype"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
           
       </td>   
       <td>SP:        
          <?
           $query_sql = "SELECT id as sp,shortname  FROM tbl_sp  order by shortname asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">       
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['sp'];?>" <?php if($_POST["sp"]==$row_sql['sp']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select> 


        &nbsp;&nbsp;

        <select name="order_by" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">       
             <option value="order by name,sum(salesvalue-cash-bank) desc">Name Wise</option>   
             <option value="order by sum(salesvalue-cash-bank) desc,name asc">Balance Wise</option>                            
         </select>


   
       </td>      
       
     </form>
     
     
          <td align="center">
           <form name="excel_export" method="post" action="printrebalsum.php">
             <INPUT TYPE="image" SRC="images/excel.png" HEIGHT="30" WIDTH="30" BORDER="0" ALT="Excle Export">
           </form>
         </td>
   </tr>
 </table>




<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Customer Total Balance </td></tr> 

   <tr id="trsubhead"> 
       <td> SL</td>   
       <td>Customer</td>
       <td>Address</td>
       <!--<td>Sales Value</td>-->
       
       <td>Type</td>
         
       <td>Last Sales Date</td>
       <!--<td>Receive Amount</td>-->
       <td>Last Pay.Rec Date</td>
       <td>Focus On</td>
       <!--<td>At Bank</td> -->
       <td>Credit</td>
    </tr>     
    <?
    if(isset($_POST["view"]) )
     {
      $con="where dt<='$_POST[demo11]'";
      
      if($_POST[company]!=='')
       {
        $con=$con. " and tbl_customer.com_id='$_POST[company]'";
       }
      
      if($_POST[customer]!=='')
       {
        $con=$con. " and view_cust_stat_base.custid='$_POST[customer]'";
       }
      if($_POST[type]!=='')
       {
        $con=$con. " and tbl_customer.type='$_POST[type]'";
       }
       
       if($_POST[btype]!=='')
       {
        $con=$con. " and tbl_customer.btype='$_POST[btype]'";
       }
   
       if($_POST[sp]!=='')
       {
        $con=$con. " and tbl_customer.sp='$_POST[sp]'";
       }
     
      
      
       $user_query="SELECT  view_cust_stat_base.custid,name, mobile,address,sum(salesvalue) as sales,sum(cash) as cash,sum(bank) as bank, sum(athand) as athand,
                           max(view_cust_last_tdate.sales)as saldate,max(view_cust_last_tdate.payment) as paydate,
                           datediff(sales,payment) as datedf,tbl_customer.type,tbl_customer.btype
                  from view_cust_stat_base    
                   join tbl_customer on tbl_customer.id=view_cust_stat_base.custid
                   join view_cust_last_tdate on view_cust_last_tdate.custid=view_cust_stat_base.custid
                   $con
                   group by tbl_customer.id,name
                   having (sum(salesvalue-cash-bank) >5) or (sum(salesvalue-cash-bank) <-5)                  
                   $_POST[order_by]";
      
      
     }
    else
     {
       $user_query="SELECT  view_cust_stat_base.custid,name, mobile,address,sum(salesvalue) as sales,sum(cash) as cash,sum(bank) as bank, sum(athand) as athand,
                  max(view_cust_last_tdate.sales)as saldate,max(view_cust_last_tdate.payment) as paydate,
                  datediff(sales,payment) as datedf,tbl_customer.type,tbl_customer.btype
                  from view_cust_stat_base    
                   join tbl_customer on tbl_customer.id=view_cust_stat_base.custid
                   join view_cust_last_tdate on view_cust_last_tdate.custid=view_cust_stat_base.custid
                   group by tbl_customer.id,name
                   having (sum(salesvalue-cash-bank) >5) or (sum(salesvalue-cash-bank) <-5) 
                   $_POST[order_by]";    
     }
    
      $_SESSION[print_cb_sql]=$user_query;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       $count=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       $bal=$value[sales]-($value[cash]+$value[bank]);
       ?>
       <tr align="center">
          
           <td><?=$count;?></td>
          <td><?=$value[name];?></td>
          
          <td><?=$value[address];?></td>
          <td><?=$value[type];?>&nbsp;<?=$value[btype];?></td>
          
          
          <td><?=$value[saldate];?></td>
          
          <td><?=$value[paydate];?></td>
          <!--<td><?=$value[datedf];?></td>-->
          
            <?php
              if($value[datedf]>0 and  $bal>0) 
               {
               echo "<td align='center' bgcolor='#FFEB9C'><b>P</b></td>";
                
               }
              else
               {
                echo "<td align='center'>S</td>";
               } 
            ?>
          <!--<td align="right"><?=number_format($value[athand]-$value[bank],2);?></td> -->
          <td align="right"><b><?=number_format($bal,2);?></b></td>         
       </tr>
       <?
       $totalsales=$totalsales+$value[sales];
       $totalpayment=$totalpayment+$value[cash]+$value[bank];
       $totalucpayment=$totalucpayment+$value[athand]-$value[bank];
       $totalamount=$totalamount+$bal;
       }
       } 
      
    ?>  
  
  <?
   if(isset($_POST["view"]) and ($_POST[customer]!==""))
    {
  ?>
  <tr id="trsubhead">
   <!--<td colspan="1"><a href="printrebal.php" target="_blank" title="Print Statement">Print</a></td>-->
   <td colspan="3"> Total Amount :</td><td colspan="4" align="right"><b><?=number_format($totalamount,2);?></b></td></tr>
    <?
    }
    else
    {
    ?>
  
  <tr id="trsubhead">
                     <td colspan="4"> Total Amount :</td>
                     <!--td colspan="2" align="right"><?=number_format($totalsales,2);?></td>
                     <td colspan="2" align="right"><?=number_format($totalpayment,2);?></td>
                     <td colspan="1" align="right"><?=number_format($totalucpayment,2);?></td>-->
                     <td colspan="4" align="right"><?=number_format($totalamount,2);?></td></tr>  
    
    <?
    }
    ?>
 </table>



<?php
 include "footer.php";
?>
