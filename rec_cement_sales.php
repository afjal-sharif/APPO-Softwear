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
answer = confirm("Are You Sure To Delete This Sales.?")
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
 <tr id="trhead"><td colspan="6">View Existing Customer</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td>Road:
          <?
           $query_sql = "SELECT id as sp,shortname  FROM tbl_sp  order by shortname asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 120px;">       
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
        Type:
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=2 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="type" style="width: 120px;">          
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
       Business Type:
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=4 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="btype" style="width: 100px;">          
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
       
         <td>
       Product:
       <?
           $query_sql = "SELECT id,name  FROM tbl_product where category_id=32 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="product" style="width: 100px;">          
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
         <input type="submit" name="view" value= "  View  "> 
       </td> 
  </tr>
 </table>
</form>
<!--  Company Info Details Here -->
<form name="po" id="vendor" action="daily_sales_process.php" method="post"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Customer List: <b>Daily Sales</b> </td></tr> 

 <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Name</td>
       <td>Owner & Address</td>       
       <!--<td>Type</td>-->
       
 
    <?
     if(isset($_POST["view"]))
      {
        $con='';
        if($_POST[name]!='')
         {
          $con=" name like '%$_POST[name]%'";
         }
        if($_POST[code]!='')
         {
          if($con!='')
           {
            $con=$con. " or codeno like '%$_POST[code]%'" ;
           }
          else
           {
            $con=" codeno like '%$_POST[code]%'"; 
           } 
         } 
        if($_POST[sp]!='')
         {
          if($con!='')
           {
            $con=$con. " or sp='$_POST[sp]'"; 
           }
          else
           {
            $con="sp='$_POST[sp]'"; 
           }
         }
        
        if($_POST[type]!='')
         {
          if($con!='')
           {
            $con=$con. " and tbl_customer.type='$_POST[type]'"; 
           }
          else
           {
            $con="tbl_customer.type='$_POST[type]'"; 
           }
         } 
         
        if($_POST[btype]!='')
         {
          if($con!='')
           {
            $con=$con. " and tbl_customer.btype='$_POST[btype]'"; 
           }
          else
           {
            $con="tbl_customer.btype='$_POST[btype]'"; 
           }
         } 
        
          
          
         $strpos=strpos($_POST[product],'::')+2;
         $strid=substr($_POST[product],0,$strpos-2);
         $strproduct=substr($_POST[product],$strpos);  
          
        if($con!='')
           {
            $con="Where $con and tbl_customer.status<>2";
           }
         else
           {
            $con=" where tbl_customer.status<>2";
           }  
        $user_query="select price,tbl_customer.*,shortname as spname from tbl_customer   
                     join tbl_sp on tbl_customer.sp=tbl_sp.id
                     left join 
                     (select * from view_customer_price where view_customer_price.product='$strid') as a
                      on  tbl_customer.id=a.cust_id   
         $con
         order by name asc";
         
        
         
         $sql_stick="SELECT SUM(qty) as stock  FROM  `view_stock_details_base` WHERE  `product` =$strid";
         $users_stock = mysql_query($sql_stick);
         $row_stock= mysql_fetch_assoc($users_stock);
         $product_stock=$row_stock[stock];
         
         
      }
     else
      {
        $user_query="select tbl_customer.*,shortname as spname from tbl_customer 
                     join tbl_sp on tbl_customer.sp=tbl_sp.id
                     
         where tbl_customer.status<>2 order by name asc limit 0,0";  
      $strid=0;
      $product_stock=0;
      $strproduct="Product Not Select";
      }
      
 ?>
         <td><?=$strproduct?>::<b><?= $product_stock?></b></td>   
         <td>Sales Rate</td>    
         <td>Others Cost(Total)</td>           
         <td>Remarks</td>           
   </tr>     
 <?
 
     
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if (($total>0) and ($product_stock>0))
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[owner];?>,<?=$value[address];?></td>
          <!--<td><?=$value[type];?>, <?=$value[btype];?></td>-->
          <td align="center">
           <input type="text" name="cash[<?=$value[id];?>]" size="4"  value="0" />
           <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
           <input name="product" type="hidden" value="<?=$strid;?>" />
           <input name="product_name" type="hidden" value="<?=$strproduct;?>" />
           <input name="stock" type="hidden" value="<?=$product_stock;?>" /> 
           <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" />  
          </td>
          <td align="center">
             <input type="text" name="rate[<?=$value[id];?>]" size="6"  value="<?=$value[price]?>" />
          </td>
          <td align="center">
             <input type="text" name="cost[<?=$value[id];?>]" size="4"  value="0" />
          </td>
          <td align="center">
             <input type="text" name="remarks[<?=$value[id];?>]" size="10"  value="-" />
          </td>
          
          
          
       </tr>
       <?
         }
       ?>
       <tr align="center" id="trsubhead">
             <td colspan="7">
                    <input type="submit" name="submitqry"  value=" Submit ">
             </td>
        </tr>
       
       <?  
        }
        else
        {
        echo "<tr align='center'><td colspan='7' id='trsubhead'>No Stock for Product :$strproduct </td></tr>";
        }
    ?>  
 </table>
 <?
 }
 elseif($id==2)
 {
 ?> 
 <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="9">Display Sales</td></tr>
   <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Name</td>
       <td>Owner & Address</td>       
       <td>Product</td>
       <td>Sales Qty</td>
       <td>Rate</td>
       <td>Cost [Total]</td>
       <td>Remarks</td>
       <td>Delete</td>              
 </tr>     
  
 <? 
    $user_query="select tbl_daily_sales.*,name,address,sp from tbl_daily_sales    
                 join tbl_customer on tbl_customer.id=tbl_daily_sales.cust_id 
                 where tbl_daily_sales.user='$_SESSION[userName]'
                 order by name asc";
    $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
       ?>
          <tr align="center">
          <td><?=$count;?></td>
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[sp];?>,<?=$value[address];?></td>
          <td><?=$value[product_name];?></td>
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[cost],2);?></td>
          <td><?=$value[remarks];?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=sales_receive" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
          </td>         
       </tr>
       <?
        $totalcash=$totalcash+$value[qty];
        $totalcost=$totalcost+$value[cost];
        $stock_qty=$value[stock];
         }
       ?>
       <tr align="center" id="trsubhead">
        <td colspan="2">Stock Total :&nbsp;&nbsp;&nbsp; <?=number_format($stock_qty,2);?></td>
        <td colspan="3" align="right">Total Sales: &nbsp;&nbsp;&nbsp;<?=number_format($totalcash,2);?></td>
        <td colspan="3" align="right"> Total Cost: &nbsp;&nbsp;&nbsp;<?=number_format($totalcost,2);?></td>
        <td>&nbsp;</td>
       </tr>
       
       <?
       if($stock_qty>=$totalcash)
       {
       ?>
       
       <tr align="center" id="trsubhead">
             <td colspan="9">
                  <form name="newcash" method="post" action="process.php">
                    <input type="hidden" name="data_type" value="sales_receive">
                    <input type="submit" name="submitqry"  value="Confirm Daily Sales ">
                  </form>  
             </td>
        </tr>
       
       <?  
        }
        else
        {
         echo "<tr align='center'><td colspan='8'> <b>Error !!! Sales Qty Must Be Leass than Stock Qty.</b></td></tr>";     
        }
        }
      
 ?>  
 </table>   
 <?
 }if($id==3)
  {
   echo "<b><img src='images/active.png'>Daily Sales Successfully.</b>";
   echo "<br><br>";
   echo "<a href='rec_cement_sales.php?id=1'><b>Continue with Sales</b></a>";
  }
 
 ?>

 
 
<?php
 include "footer.php";
?>

