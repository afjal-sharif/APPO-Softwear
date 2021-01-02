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
     <td>
       <form name="order" method="post" action="">
         
          &nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;<input type="Text" id="demo11" maxlength="12" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]: $con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
           &nbsp;&nbsp;
          
          To:<input type="Text" id="demo12" maxlength="12" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]: $con1?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
           &nbsp;&nbsp;
         <!--
         
         SP: 
          <?
           $query_sql = "SELECT  distinct SP as sp from tbl_customer  order by sp";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="sp" style="width:120px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['sp'];?>" <?php if($_POST['sp']==$row_sql['sp']) echo "selected";?>><?php echo $row_sql['sp']?> </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
          
         -->  
           
          <input type="submit"  name="view" value="   View  " />   
          </form>
     </td>
     <!--
     <td align="center">
       <form name="excel_export" method="post" action="printrebalsum.php">
           <INPUT TYPE="image" SRC="images/excel.png" HEIGHT="30" WIDTH="30" BORDER="0" ALT="Excle Export">
         </form>
     </td>
     -->
   </tr>
 </table>




<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Sales Person Wise Customer Credit</td></tr> 

   <tr id="trsubhead">    
       <td>SP</td>
       <td>Previous Oustanding</td>
       <td>Sales Value</td>
       <td>Receive Amount</td>
       <td>Total Oustanding</td>
    </tr>     
    <?
    if(isset($_POST["view"]) )
     {
            
      $user_query="
                      select shortname as sp, sum(pre_out) as pre_credit,sum(sales) as saleval,sum(payment) as payval from
                      (
                      SELECT  view_cust_stat_base.custid,0 as pre_out,sum(salesvalue) as sales,sum(cash+bank) as payment
                           from view_cust_stat_base    
                           where dt between '$_POST[demo11]' and '$_POST[demo12]' 
                           group by view_cust_stat_base.custid                         
                      union all
                      SELECT  view_cust_stat_base.custid,sum(salesvalue-cash-bank) as pre_out,0 as sales,0 as payment
                           from view_cust_stat_base    
                           where dt<'$_POST[demo11]' 
                           group by view_cust_stat_base.custid                         
                      ) as p
                      join tbl_customer on p.custid=tbl_customer.id
                      left join tbl_sp on tbl_customer.sp=tbl_sp.id
                      group by shortname
                   ";
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      $_SESSION[print_sp_sql]=$user_query;   
     }
    else
     {
      /*$user_query="SELECT  view_cust_stat_base.custid,name, mobile,address,sum(salesvalue) as sales,sum(cash) as cash,sum(bank) as bank, sum(athand) as athand,
                  max(view_cust_last_tdate.sales)as saldate,max(view_cust_last_tdate.payment) as paydate,
                  datediff(sales,payment) as datedf
                  from view_cust_stat_base    
                   join tbl_customer on tbl_customer.id=view_cust_stat_base.custid
                   join view_cust_last_tdate on view_cust_last_tdate.custid=view_cust_stat_base.custid
                   group by tbl_customer.id,name
                   having (sum(salesvalue-cash-bank) >5) or (sum(salesvalue-cash-bank) <-5) 
                   order by sum(salesvalue-cash-bank) desc,name";    
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);
      */    
      $total=0;
     }
    
   
      if ($total>0)
      {
       $total_pre_credit=0;
       $totalsales=0;
       $totalpayval=0;
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[pre_credit]+($value[saleval]-$value[payval]);
       ?>
       <tr align="center">
          <td><?=$value[sp];?></td>
          <td align="right"><?=number_format($value[pre_credit],2);?></td>
          <td align="right"><?=number_format($value[saleval],2);?></td>
          <td align="right"><?=number_format($value[payval],2);?></td>
          <td align="right"><b><?=number_format($bal,2);?></b></td>         
       </tr>
       <?
       $total_pre_credit=$total_pre_credit+$value[pre_credit];
       $totalsales=$totalsales+$value[saleval];
       $totalpayval=$totalpayval+$value[payval];
       }
       echo "<tr id='trhead'><td>Total</td><td>".number_format($total_pre_credit,2)."</td>";
       echo "<td>".number_format($totalsales,2)."</td>";
       echo "<td>".number_format($totalpayval,2)."</td>";
       echo "<td>".number_format($total_pre_credit+$totalsales-$totalpayval,2)."</td></tr>";
       }
       else
       {
       echo "<tr><td colspan='5'>Please select date parameter.</td></tr>";
       } 
      
    ?>  
  </table>



<?php
 include "footer.php";
?>
