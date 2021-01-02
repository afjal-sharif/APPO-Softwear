<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $msg="";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Data In Database ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 


<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[company]) or empty($_POST[cityList]) or empty($_POST[total])) 
   {
    echo " Error !! Pls give input properly";
   }
  else
   {
  
  $product=$_POST[cityList];
  $sql="select * from tbl_product where id=$_POST[cityList]";
  $users_skills = mysql_query($sql); 
  $value=mysql_fetch_array($users_skills);
  $punit= $value['punit'];
  $sunit= $value['unit'];
  $factor=$value['factor'];
  $company=$_POST[company];
  
  $purchasecom=$value[companyid];
  
  
   $sql="insert into tbl_open_bal (companyid,productid,qty,amount,type) 
        value($_POST[company],$_POST[cityList],$_POST[qty],$_POST[total],$_POST[type])"; 
    db_query($sql) or die(mysql_error());
  
   // For Opening Stock  
   if($_POST[type]==1)
    {
      $rate=$_POST[total];
      $total=$rate*$_POST[qty];
      
      $sql="insert into tbl_order (dtDate,donumber,company,product,qty,rate,user,punit,factor) 
        value('$_SESSION[dttransection]','SOB-$company-$product',$_POST[company],$_POST[cityList],$_POST[qty],$rate,'$_SESSION[userName]','$punit',$factor)"; 
      db_query($sql) or die(mysql_error());
 
      $sql="insert into tbl_receive (date,donumber,product,qty,rate,user,remarks) 
        value('$_SESSION[dttransection]','SOB-$company-$product','$_POST[cityList]',$_POST[qty], $rate,'$_SESSION[userName]','Opening Balance')"; 
      db_query($sql) or die(mysql_error());
    
    
      $remarks="Cash Payment To $company For Open Bal.DO No:SOB-$company-$product";   
      $sql="insert into tbl_com_payment (paydate,donumber,amount,bamount,chequeno,user,remarks,status,companyid,bank) 
        value('$_SESSION[dttransection]','SOB-$company-$product',$total,$total,'OCP','$_SESSION[userName]','$remarks','C',$company,'Cash')"; 
      db_query($sql) or die(mysql_error());
      
      $remarks="Cash Payment To $company for Opening Balance DO No:SOB-$company-$product";   
      $sql="insert into tbl_cash (date,remarks,withdraw,user,type) values('$_SESSION[dttransection]','$remarks',$total,'$_SESSION[userName]',9)";
      db_query($sql) or die(mysql_error());
      echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Opening Stock Place successfully</b>";
     
    }
  
   } // Error chech If
 }// Submit If
?>


<!-- Opening Stock Balance Input Form -->

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td align="left" ><img src="images/1.jpg"></td><td colspan="5">Opening Stock</td></tr> 
    <tr bgcolor="#FFCCAA">  
        <!--
        <td>
         Company: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company" onchange="htmlData('prod.php', 'ch='+this.value)" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       -->
       
       
       <td colspan="3">
          <input type="hidden" name="company"  value="1" />
             <?      
                 $query_sql = "SELECT  tbl_product_category.name as catname,tbl_product.id as product,tbl_product.name as pname, tbl_product.unit 
                              FROM  tbl_product
                              join tbl_product_category on tbl_product.category_id=tbl_product_category.id
                               order by tbl_product_category.name";
                 
                 $sql = mysql_query($query_sql) or die(mysql_error());	               
		             ?>
		             Product:
		             <select name="cityList" style="width: 250px;">
		             <?
                  while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['product'];?>" <? if($_POST[cityList]==$rs[product]) {echo "SELECTED";}?>><?=$rs['catname'];?>::<?=$rs['pname'];?>::<?=$rs['unit'];?></option>
                 <?    
		             }
                ?>
             </select>
       </td>  
       
       <input type="hidden"  name="type"  size="12" value="1"    />
       <td> Qty (Unit) <input type="text"  name="qty"  size="12"    /> </td>     
       <td>Rate: <input type="text" size="10"  name="total" /> </td>
     </tr>    
     <tr id="trsubhead"><td colspan="6" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>




<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td align="center" colspan="5">Opening Stock</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Compnay</td>
       <td>Product</td>
       <td>Quantity</td>
       <td>Rate/Unit</td>
       <td>Total Value</td>      
      </tr>     

    <?
     $user_query="select tbl_open_bal.id, tbl_open_bal.qty,tbl_open_bal.amount,tbl_company.name as company,punit,tbl_product.name as product from tbl_open_bal
                   join tbl_company on tbl_open_bal.companyid=tbl_company.id
                   join tbl_product on tbl_open_bal.productid=tbl_product.id
                   where type=1
                   order by tbl_open_bal.id";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[company];?></td>
          <td><?=$value[product];?></td>        
          <td align="right"><?=$value[qty];?> <?=$value[punit];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>
          <td align="right"><?=number_format($value[amount]*$value[qty],2);?></td>
       </tr>
       <?
       $sumtotal=$sumtotal+($value[amount]*$value[qty]);
       }
      }
    ?>  
 <tr id="trsubhead"><td colspan="5" align="right"><b>Total : <?=number_format($sumtotal,2);?></b> </td></tr>
 </table>
<?php
 include "footer.php";
?>
