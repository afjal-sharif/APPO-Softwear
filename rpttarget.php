<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<form name="tracview" action="" method="post">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr bgcolor="#FFCCAA" align="center">
   <td> Year </td>
   <td> Month </td>
   <td> Company </td>
   <td> Area </td>
   <td> Customer </td>
   <td> &nbsp;</td>
 </tr>
 <tr align="center">
  <td>
    <? $yr= date("Y"); ?>
    <select name="year" style="width: 60px; height: 28px; border-width:1px;border-color:#FF0000;">
           <?
           for ($x=$yr; $x>=2015; $x--)
            {
           ?>
             <option value="<?=$x?>" <?php if($_POST["year"]=="$x") echo "selected";?>><?=$x?></option>
           <?
           }
           ?>
   </select>
 </td>
 <td>
     
    <select name="month" style="width: 40px; height: 28px; border-width:1px;border-color:#FF0000;">
           <option value=""></option>
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
   <td>
    
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 180px; height: 28px; border-width:1px;border-color:#FF0000;">
            
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($cat==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
   </td>
   <td>   
          <?
           $query_sql = "SELECT id,shortname as name  FROM tbl_sp order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="sp" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">
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
   <td>
        
     <?
           if(isset($_POST[sp]))
           {
            $query_sql = "SELECT tbl_customer.id,tbl_customer.codeno,tbl_customer.name,tbl_sp.shortname as spname  FROM tbl_customer
                          join  tbl_sp on  tbl_sp.id=tbl_customer.sp
                          where tbl_customer.sp='$_POST[sp]'
                          order by tbl_customer.name";
           }
           else
           {
            $query_sql = "SELECT tbl_customer.id,tbl_customer.codeno,tbl_customer.name,tbl_sp.shortname as spname  FROM tbl_customer
                          join  tbl_sp on  tbl_sp.id=tbl_customer.sp
                          order by tbl_customer.name";
           }
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?> 
          
           <select name="customer" style="width: 250px; height: 28px; border-width:1px;border-color:#FF0000;"> 
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?>:: <?php echo $row_sql['spname']?>::<?php echo $row_sql['codeno']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
   </td>
   <td>
     <input type="submit" value=" View " name="view" />
   </td>
   </tr>
   
</form>

<?
if(isset($_POST["view"]))
 {
?> 

<!--  Company Info Details Here -->
<table width="960px" align="center" class="hovertable" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="9">Display Existing Target Vs Actual.</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">
       <td>SL</td>
       <td>Year</td> 
       <td>Month</td>
       <td>Company</td>
       <td>Customer</td>
       
       <td>Target</td>
       <td>Actual</td>
       <td>Diff.(Taget-Actual)</td>
       <td>%</td>
   </tr>     
    <?
     $con="where e.year=$_POST[year]";

     if($_POST[month]!=''){$con=$con. " and e.month=$_POST[month]";}

     if($_POST[customer]!=''){$con=$con. " and e.cid=$_POST[customer]";}
     if($_POST[sp]!=''){$con=$con. " and tbl_customer.sp=$_POST[sp]";}
     if($_POST[company]!=''){$con=$con. " and e.company=$_POST[company]";}
     
     $user_query="select tbl_customer.name,tbl_company.name as comname, e.year,e.month,sum(e.target) as target,sum(e.actual) as actual
                    from
                   (
                    Select tbl_retailer_target.customer as cid ,tbl_retailer_target.year as year,
                           tbl_retailer_target.month as month,target,0 as actual,company
                         from tbl_retailer_target   
                    union all
                    SELECT tbl_sales.customerid as cid,year(`date`) as year,month(`date`) as month, 0 as target,
                            sum(tbl_sales.qty) as actual,tbl_order.company
                          FROM `tbl_sales`  
                          left join tbl_order on tbl_order.donumber=tbl_sales.donumber  
                          group by tbl_sales.customerid,tbl_order.company,year(date),month(date)
                   ) as e
                   join tbl_customer on tbl_customer.id=e.cid
                   join tbl_company on tbl_company.id=e.company
                   $con
                   group by e.cid,e.year,e.month,e.company
                   order by tbl_customer.name,e.month asc
                   ";
                   
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $count=0;
       while($value=mysql_fetch_array($users))
       {
         $count=$count+1;
       ?>
       
       <tr align="center">
          <td><?=$count;?></td>
          <td><?=$value[year];?></td>
          <td><?=$value[month];?></td>
          <td><?=$value[comname];?></td>
          <td><?=$value[name];?></td>
          
          <td align="right"><?=number_format($value[target],2);?></td>
          <td align="right"><?=number_format($value[actual],2);?></td>
          <td align="right"><?=number_format($value[target]-$value[actual],2);?></td>
          <td align="right">
             <?if($value[target]==0)
              {
                echo number_format(100,2);
              }
              else
              {
               echo number_format(($value[actual]*100)/$value[target],2);
              }
              ?>
              %
            </td>      
       </tr>
       <?
       $totaltarget=$totaltarget+$value[target];
       $totalactual=$totalactual+$value[actual];
       $totalshort=$totalshort+$value[target]-$value[actual];
       }
      }
    ?>  
  </tr>
  <tr id="trsubhead">
     <td colspan="5"> Total: </td>
     <td align="right"><?=number_format($totaltarget,2);?></td>
     <td align="right"><?=number_format($totalactual,2);?></td>
     <td align="right"><?=number_format($totalshort,2);?></td>
     <td align="right">
        <?if($totaltarget==0)
          {
             echo number_format(100,2);
          }
          else
          {
             echo number_format(($totalactual*100)/$totaltarget,2);
          }
        ?>
          %
     </td>
  </tr>
 </table>
<?
}
?>

<?php
 include "footer.php";
?>

