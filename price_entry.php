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
 if(isset($_POST["submitqry"]))
  {
   
   $emp_ben=$_POST[cash];
   $skill_id=$_POST[skill_id];
  
   $product=$_POST[product];
  
   $user=$_SESSION['userName']; 
  
    
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $emp_ben_result= $emp_ben[$id];
    $skill_id_result=$skill_id[$id];  
    
    
    if(($emp_ben_result<>'') and  ($emp_ben_result<>0)) 
     {
       $sql="update tbl_customer_price set status=1 where cust_id='$skill_id_result' and product='$product'";
       db_query($sql);
       
       $sql="insert into tbl_customer_price(cust_id,product,price,user)
               values('$skill_id_result','$product','$emp_ben_result','$user')";
       db_query($sql);
     }      
   }   
  echo "<img src='images/active.png' width='25px' height='25px'> Price Insert Successfully. "; 
 }
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
         
         <select name="sp" style="width: 100px;">       
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
         
         <select name="type" style="width: 100px;">          
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
<form name="po" id="vendor" action="" method="post"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Customer List: <b>Price Entry</b> </td></tr> 

 <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Name</td>
       <td>Owner & Address</td>       
       <td>Type</td>
       <td>Current Price</td>
   
 
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
        
        //$con=$con ."  and ( view_customer_price.product='$strid' or view_customer_price.product is null)";         
          
          
        if($con!='')
           {
            $con="Where $con and tbl_customer.status<>2 ";
           }
         else
           {
            $con=" where tbl_customer.status<>2";
           }  
        
        
         
        
        
         $user_query="select price,tbl_customer.*,shortname as spname, price from tbl_customer   
                     join tbl_sp on tbl_customer.sp=tbl_sp.id 
                     left join 
                     (select * from view_customer_price where view_customer_price.product='$strid') as a
                      on  tbl_customer.id=a.cust_id    
         $con
         order by name asc";
         
         
         /*
         $sql_stick="SELECT SUM(qty) as stock  FROM  `view_stock_details_base` WHERE  `product` =$strid";
         $users_stock = mysql_query($sql_stick);
         $row_stock= mysql_fetch_assoc($users_stock);
         $product_stock=$row_stock[stock];
         */
         
      }
     else
      {
        $user_query="select tbl_customer.*,shortname as spname from tbl_customer 
        left join tbl_sp on tbl_customer.sp=tbl_sp.id
         where tbl_customer.status<>2 order by name asc limit 0,0";  
      $strid=0;
      $product_stock=0;
      $strproduct="Product Not Select";
      }
      
 ?>
         <td><?=$strproduct?></b> New Price </td>              
   </tr>     
 <?
 
     
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
          <td><?=$value[owner];?>,<?=$value[address];?></td>
          <td><?=$value[type];?>, <?=$value[btype];?></td>
          <td><?=number_format($value[price],2);?></td>
          <td align="center">
           <input type="text" name="cash[<?=$value[id];?>]" size="4"  value="0" />
           <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
           <input name="product" type="hidden" value="<?=$strid;?>" />
                    
           <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" />  
          </td>
       </tr>
       <?
         }
       ?>
       <tr align="center" id="trsubhead">
             <td colspan="6">
                    <input type="submit" name="submitqry"  value=" Submit ">
             </td>
        </tr>
       
       <?  
        }
    ?>  
 </table>
  
<?php
 include "footer.php";
?>

