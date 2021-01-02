<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add New INCENTIVE ?")
if (answer !=0)
{
window.submit();
}
}	

function Confirm()
{
answer = confirm("Are You Sure To Delete this INCENTIVE ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?php
if(isset($_POST["submit"]))
 {
     
   $skill_id=$_POST[skill_id]; 
   $user=$_SESSION['userName']; 
   $rate_val=$_POST[rate_value];
   $qty=$_POST[qty];
   $remarks=$_POST[remarks];
   
   $company=$_POST[company];
   $customer=$_POST[customer];
   $year_a=$_POST[year];
   $month_a=$_POST[month];
   $addition=$_POST[add_value];
    
    
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $rate_ben= $rate_val[$id];
    $qty_ben= $qty[$id];
    
    $customer_ben= $customer[$id];
    $company_ben= $company[$id];
    $year_ben= $year_a[$id];
    $month_ben= $month_a[$id];
    $remarks_ben= $remarks[$id];
    $addition_ben=$addition[$id];
    
    
    $skill_id_result=$skill_id[$id];  
    
     if($qty_ben>0)
       { 
         $sql="insert into tbl_temp_incentive(customer,company,date_from,date_to,qty,rate,user,remarks,addition)
                                  values('$customer_ben','$company_ben','$year_ben','$month_ben','$qty_ben','$rate_ben','$_SESSION[userName]','$remarks_ben','$addition_ben')";
         db_query($sql);
       } 
   }
    echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! INCENTIVED ADDED IN CARD</b>";
    // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="900px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">RETAILER INCENTIVE</td></tr>  
   
    <tr id="trsubhead">
        <td colspan="2">DATE</td>
        
        <td>COMPANY</td>
        <td>AREA</td>
        
        <td>TYPE</td>
        <td>RATE</td>
        <td>REMARKS</td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFEE09" align="center">    
       <td>         
          <select name="year" style="width: 80px; height: 28px; border-width:1px;border-color:#FF0000;">
           <option value="2016" <?php if($_POST["year"]=='2016') echo "selected";?>>2016</option>
           <option value="2017" <?php if($_POST["year"]=='2017') echo "selected";?>>2017</option>
           <option value="2018" <?php if($_POST["year"]=='2018') echo "selected";?>>2018</option>
           <option value="2019" <?php if($_POST["year"]=='2019') echo "selected";?>>2019</option>
           <option value="2020" <?php if($_POST["year"]=='2020') echo "selected";?>>2020</option>
          </select>
          <!--
          <input type="Text" id="demo11" maxlength="10" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
         -->  
       </td>
       <!--
       <td>
           <input type="Text" id="demo12" maxlength="10" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>       
       </td>
        -->
       <td>
          <select name="month" style="width: 50px; height: 28px; border-width:1px;border-color:#FF0000;">
               <?
               for ($x=1; $x<=12; $x++)
                {
               ?>
                 <option value="<?=$x?>" <?php if($_POST["month"]=="$x") echo "selected";?>><?=$x?></option>
               <?
               }
               ?>
           </select>
      </td>
      
      <td colspan="1">
         
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 150px; height: 28px; border-width:1px;border-color:#FF0000;">
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
          <?
           $query_sql = "SELECT id,shortname as name  FROM tbl_sp order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="sp" style="width: 100px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["sp"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       
       <td colspan="1">  
          <?
           $query_sql = "SELECT distinct btype as name  FROM tbl_customer order by btype";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="type" style="width: 100px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['name'];?>" <?php if($_POST["type"]==$row_sql['name']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       
       
       
       <td>
          <input type="text" name="rate" size="4"   value="<?=$_POST[rate]?>" />      
       </td>
       <td>
          <input type="text" name="remarks" size="12"   value="Comission" />      
       </td>       
       <td colspan="1" align="center"><input type="submit" name="view"  value="   View    " /> </td>
    </tr>
   
</table>
</form>


<?php
 if(isset($_POST["sp"]))
 {
 ?>
 <form name="abc" action="" method="post">
 <table width="900px" class="hovertable" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="10">RETAILER INCENTIVE</td></tr>  
   <tr align="center" bgcolor="#FFFF99">
      <td>SL</td>
      <td>Company</td>
      <td>Customer</td>
      <td>Target</td>
      <td>Actual</td>
      <td>%</td>
      <td>Per/Bag</td>
      <td>Addition</td>
      <td>Remarks</td>
      <td>Total</td>
   </tr>
   
   <?php
    
       //$con_target="where (tbl_retailer_target.date between '$_POST[demo11]' and '$_POST[demo12]') and tbl_retailer_target.company='$_POST[company]' ";
       
       $con_target="where (tbl_retailer_target.year='$_POST[year]' and tbl_retailer_target.month='$_POST[month]') and tbl_retailer_target.company='$_POST[company]' ";
       $con_sales="where year(tbl_sales.date)='$_POST[year]' and month(tbl_sales.date)='$_POST[month]' and tbl_order.company='$_POST[company]' and tbl_sales.payincentive=0";
       
       //$con_sales="where  (tbl_sales.date between '$_POST[demo11]' and '$_POST[demo12]') and tbl_order.company='$_POST[company]' and tbl_sales.payincentive=0";
      
       $con="where tbl_customer.status=0";
      
       if($_POST[sp]!='')
       {
        $con=$con. " and tbl_customer.sp='$_POST[sp]'";
       }
      
       if($_POST[type]!='')
       {
        $con=$con. " and tbl_customer.btype='$_POST[type]'";
       } 
       
       
     $user_query="select e.customer as customer,e.company as company,
                       tbl_customer.name as cust_name,tbl_company.name as com_name,
                       sum(e.target) as target,sum(e.actual) as actual from(
    
                      select company,customer,sum(target) as target,sum(actual) as actual from tbl_retailer_target $con_target group by customer,company 
                      union all
                      SELECT tbl_order.company as company,`customerid` as customer, 
                        0 as target,sum(tbl_sales.qty) as actual FROM `tbl_sales`
                        join tbl_order on tbl_order.donumber=tbl_sales.donumber
                        $con_sales    
                        group by customerid,company
                        ) as e                        
                        join tbl_customer on tbl_customer.id=e.customer
                        join tbl_company on tbl_company.id=e.company
                        $con
                        group by e.customer,e.company";
                        
    
    /*
      $user_query="select tbl_customer.*,tbl_retailer_target.*,tbl_company.name as comname,tbl_retailer_target.id as tid from tbl_customer 
                     join tbl_retailer_target on tbl_customer.id=tbl_retailer_target.customer
                     join tbl_company on   tbl_company.id=tbl_retailer_target.company       
                 
                  and tbl_retailer_target.month='$_POST[month]' and tbl_retailer_target.company='$_POST[company]'
                   order by name,customer,year,month asc";  
                   */
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      { 
        $count=0;
        
        while($value=mysql_fetch_array($users))
         {
           $count=$count+1;
           
            echo "<tr align='center'>
                 <td>$count</td>
                 <td>$value[com_name]</td>
                 <td>$value[cust_name]</td>
                 
                 <td align='right'>".number_format($value[target],0)."</td>
                 <td align='right'>$value[actual]</td>";
                 if($value[target]>0)
                 {
                  $percentage=number_format(($value[actual]*100)/$value[target],2); 
                  echo "<td>$percentage %</td>";
                 }
                 else
                 {
                   echo "<td></td>";
                 }
             ?>
              <input name="work[]" type="hidden" value="<?=$count;?>" />
              <input name="skill_id[<?=$count;?>]" type="hidden" value="<?=$count;?>" />   
              <input name="qty[<?=$count;?>]" type="hidden" value="<?=$value[actual];?>" />
              
              <input name="customer[<?=$count;?>]" type="hidden" value="<?=$value[customer];?>" />
              <input name="company[<?=$count;?>]" type="hidden" value="<?=$value[company];?>" />
              <input name="year[<?=$count;?>]" type="hidden" value="<?=$_POST[year];?>" />
              <input name="month[<?=$count;?>]" type="hidden" value="<?=$_POST[month];?>" />   
               
               
              <td><input type="text" size="3" maxlength="3" value="<?=$_POST[rate]?>"  name="rate_value[<?=$count;?>]" /> </td>
              <td><input type="text" size="4" maxlength="5" value="0"  name="add_value[<?=$count;?>]" /> </td>
              <td><input type="text" size="15" maxlength="3" value="<?=$_POST[remarks]?>:<?=$_POST[year]?>:<?=$_POST[month]?> "  name="remarks[<?=$count;?>]" /> </td>
              <td align="right"><?=number_format($value[actual]*$_POST[rate],2)?> </td>
             <?php    
             echo"</tr>";
             $totaltarget=$totaltarget+$value[target];
             $totalactual=$totalactual+$value[actual];
             $totalincentive=$totalincentive+$value[actual]*$_POST[rate];
         }
       
       echo "<tr align='center' id='trsubhead'>
                <td colspan='3'>Total</td>
                <td colspan='1'>".number_format($totaltarget,0)."</td>
                <td colspan='1'>".number_format($totalactual,0)."</td>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                <td colspan='1'>".number_format($totalincentive,2)."</td>
             </tr>";
       ?>
        <tr id="trsubhead"><td colspan="10" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value="   ADD TO CARD  " /> </td> </tr>
       <?   
      }
   ?>
 </table>
 </form>
<?php 
 }
 // DISPLAY  TEMP DATA.
 
      $user_dispaly="select tbl_temp_incentive.*,tbl_customer.name as cust_name,tbl_company.name as com_name 
                     from tbl_temp_incentive
                     join tbl_customer on tbl_customer.id=tbl_temp_incentive.customer
                     join tbl_company on tbl_company.id=tbl_temp_incentive.company
                     ";
      $users = mysql_query($user_dispaly);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
  ?>
    <br>
       
        <table width="900px" align="center" bordercolor="#AACCBB" border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
           <tr id="trhead"><td colspan="10">INCENTIVE IN CARD</td></tr>       
           <tr bgcolor="#FFCCAA" align="center">    
               <td>SL</td>
               <td>COMPANY</td>
               <td>CUSTOMER</td>
               <td>PEROID</td>
               <td>QTY</td>
               <td>RATE</td>
               <td>ADDITION</td>
               <td>AMOUNT</td>
               <td>USER</td>  
               <td>&nbsp;</td>            
            </tr>    
   <?php    
       $count=0;
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
         <tr align="center">  
             <td><?=$count?></td>
             <td><?=$value[com_name];?></td>
             <td><?=$value[cust_name];?></td>
             <td><?=$value[date_from];?>-<?=$value[date_to];?></td>
             <td><?=number_format($value[qty],0);?></td>
             <td><?=number_format($value[rate],0);?></td>
             <td><?=number_format($value[addition],0);?></td>
             <td><?=number_format((($value[qty]*$value[rate])+$value[addition]),2);?></td>
             <td><?=$value[user];?></td>
             <td>
                  <A HREF=javascript:void(0) onclick=window.open('edit_incentive.php?smsId=<?=$value[id];?>','Accounts','width=450,height=300,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="EDIT INCENTIVE"><img src="images/edit.png" height="15px" width="15px"></a>
             </td>
         </tr>
  <?php
       
       $totalqty=$totalqty+$value[qty];
       $totaladd=$totaladd+$value[addition];
       $totalvalue=$totalvalue+$totaladd+($value[qty]*$value[rate]);
      
      
      }
      echo "<tr id='trsubhead'>
              <td colspan='4'>TOTAL</td>
              <td>".number_format($totalqty,0)."</td>
              <td>".number_format($totalvalue/$totalqty,2)."</td>
              <td>".number_format($totaladd,2)."</td>
              <td>".number_format($totalvalue,2)."</td>
              <td>&nbsp;</td><td>&nbsp;</td>
           </tr>";
      
      echo "</table>";
     } 
?>
 
 
 


  
<?php
 include "footer.php";
?>

