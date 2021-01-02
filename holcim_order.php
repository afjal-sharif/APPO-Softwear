<?php
 session_start();
 $mnuid=508;
 include "includes/functions.php";
 $msgmenu="New Customer";
 include "session.php";  
 include "header.php";
 $id=$_GET[id];
?>
<script language="javascript">
function ConfirmSales()
{
answer = confirm("Are You Sure To Delete This Order.?")
if (answer !=0)
{
 window.submit();
}
}	
</script>


<? 
 if($id==1)
 {
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Holcim Order</td></tr>  
 
    <tr bgcolor="#FFCCAA" align="center">
       <td> Ref.No</td>
       <td> Area</td>
       <td> Type</td>
       
       <td> Product</td>
       <td> Rate/Unit</td>
       <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFCCAA" align="center">
       <td>
         <?php
           $ref_no= date("d").''.date("m").''.date("Y");
           //$mon=date("m")
         ?>
          <input type="text" name="ref_no" size="10"  value="<?=$ref_no?>" />
       </td> 
       <td>
          <?
           $query_sql = "SELECT id as sp,shortname  FROM tbl_sp  order by shortname asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 100px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['sp'];?>" <?php if($_POST["sp"]==$row_sql['sp']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>    
       </td>   
       
       <td>
        
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=2 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="type" style="width: 80px; height: 28px; border-width:1px;border-color:#FF0000;">          
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["type"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
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
           <select name="company" disabled="disabled" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($row_sql['id']==2) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
          <input type="hidden" name="company" size="4" value="<?=$global[company]?>" />
       
       
       <?
           $query_sql = "SELECT id,name  FROM tbl_product where category_id=32 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="product" style="width: 100px; height: 28px; border-width:1px;border-color:#FF0000;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['id'];?>::<?php echo $row_sql['name'];?>" <?php if($_POST["product"]=="$row_sql[id]::$row_sql[name]") echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
     <td>
        <input type="text" name="rate" size="4"  value="<?=$_POST[rate]?>" />    
     </td>
      
     
     <td>
         <input type="submit" name="view" value= "  View  "> 
       </td> 
  </tr>
 </table>
</form>
<!--  Company Info Details Here -->
<form name="po" id="vendor" action="daily_order_process.php" method="post"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Customer List: <b>Daily Holcim Order</b> </td></tr> 

 <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>SAP ID</td>
       <td>Name</td>
       <td>Type</td>
       <td>Owner & Address</td>       
       <td>Order Qty (Unit)</td>
       <td>Rate/(Unit)</td>
       <td>Remarks</td>
   </tr>     
 <?
     
     $con="where tbl_customer.status=0";
     if($_POST[sp]!=''){$con=$con. " and tbl_customer.sp='$_POST[sp]'";}
     if($_POST[type]!=''){$con=$con. " and tbl_customer.type='$_POST[type]'";}
     if($_POST[btype]!=''){$con=$con. " and tbl_customer.btype='$_POST[btype]'";}
     
     
     $user_query="select tbl_customer.*,shortname as spname from tbl_customer 
                     join tbl_sp on tbl_customer.sp=tbl_sp.id         
                   $con order by name asc";  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if (($total>0))
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[codeno];?></td>
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[type];?> &nbsp; &nbsp;<?=$value[btype];?></td>
          <td><?=$value[owner];?>,<?=$value[address];?></td>
          <td align="center">
           
           <input type="text" name="cash[<?=$value[id];?>]" size="4"  value="0" />
           
           <input type="hidden" name="cname[<?=$value[id];?>]" size="4"  value="<?=$value[name]?>" />
           
           <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
           
           <input name="company" type="hidden" value="<?=$_POST[company];?>" />
           <input name="product" type="hidden" value="<?=$_POST[product];?>" />
           <input name="ref_no" type="hidden" value="<?=$_POST[ref_no];?>" />
           <input name="data_type" type="hidden" value="holcim_order" />
           
           <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" />  
          </td>
          <td>
            <input type="text" name="rate[<?=$value[id];?>]" size="4"  value="<?=$_POST[rate]?>" />
          </td>
          <td align="center">
             <input type="text" name="remarks[<?=$value[id];?>]" size="10"  value="-" />
          </td> 
       </tr>
       <?
         }
       ?>
       <tr align="center" id="trsubhead">
             <td colspan="8">
                    <input type="submit" name="submitqry"  value=" Submit ">
             </td>
        </tr>
       
       <?  
        }
       
    ?>  
 </table>
 <?
 }
 elseif($id==2)
 {
 ?> 
 <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="10">Display Order</td></tr>
   <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Ref.No</td>
       <td>SAP ID</td>
       <td>Name</td>
       
       <td>Owner & Address</td>       
       <td>Product</td>
       <td>Sales Qty</td>
       <td>Rate/Unit</td>
       <td>Remarks</td>
       <td>Delete</td>              
   </tr>     
  
 <? 
    $user_query="select tbl_daily_order.*,tbl_customer.name,tbl_customer.codeno,address,sp,tbl_product.name as pname
                  from tbl_daily_order    
                 join tbl_customer on tbl_customer.id=tbl_daily_order.cust_id 
                 join tbl_product on tbl_product.id=tbl_daily_order.product
                 where tbl_daily_order.user='$_SESSION[userName]'
                 order by name asc";
    $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $count=0;
       $totalvalue=0;
       $totalcash=0;
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
          <tr align="center">
              <td><?=$count;?></td>
              <td><?=$value[ref_no];?></td>
              <td colspan="1"  align="center"><?=$value[codeno];?></td>
              <td colspan="1"  align="center"><?=$value[name];?></td>
              <td><?=$value[sp];?>,<?=$value[address];?></td>
              <td><?=$value[company];?>::<?=$value[pname];?></td>
              <td align="right"><?=number_format($value[qty],0);?></td>
              <td align="right"><?=number_format($value[rate],0);?></td>
              <td><?=$value[remarks];?></td>
              <td>
                 <a href="indelete.php?id=<?=$value['id'];?>&mode=holcim_d_order" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
              </td>         
          </tr>
       <?
        $totalcash=$totalcash+$value[qty];
        $totalvalue=$totalvalue+$value[qty]*$value[rate];
        }
       ?>
       <tr align="center" id="trsubhead">
        <td colspan="5" align="right">Total Order &nbsp;&nbsp;&nbsp;</td>
           <td align="right" colspan="2"><?=number_format($totalcash,0);?></td>
           <td align="right" colspan="1"><?=number_format($totalvalue/$totalcash,0);?></td>
        <td colspan="2">&nbsp;</td>
       </tr>
       
      
       
       <tr align="center" id="trsubhead">
             <td colspan="10">
                  <form name="newcash" method="post" action="daily_order_process.php">
                    <input type="hidden" name="data_type" value="holcim_order_confim">
                    <input type="submit" name="submitqry"  value="Confirm Daily Order ">
                  </form>  
             </td>
        </tr>
       
     <?php 
     }
 ?>  
 </table>   
 <?
 }if($id==3)
  {
   $ref_id=$_GET[ref_id];
   echo "<b><img src='images/active.png'>Daily Order Place Successfully.</b>";
   echo "<br><br><br><br>";
   
   echo "<a href='print_order.php?id=$ref_id' target='_blank' alt='Print Order'><img src='images/report.jpg' tittle='Print Report'></a>";
   
   echo "<br><br><br><br>";
   
   echo "<a href='holcim_order.php?id=1'><b>Continue with Order</b></a>";
  }
 
 ?>

 
 
<?php
 include "footer.php";
?>

