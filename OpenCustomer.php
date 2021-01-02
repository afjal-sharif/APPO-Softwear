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
  
  //$company=1;
  
  $purchasecom=$value[companyid];
  
  $purchasecom=1;
  
   $sql="insert into tbl_open_bal (companyid,productid,qty,amount,type) 
        value($_POST[company],$_POST[cityList],1,$_POST[total],$_POST[type])"; 
   db_query($sql) or die(mysql_error());
  
  
  
  // For Customer Receive.
  if($_POST[type]==2)
    {
      $rate=$_POST[total];
      $sql="insert into tbl_order (dtDate,donumber,company,product,qty,rate,user,punit,factor) 
        value('$_SESSION[dttransection]','COB-$company-$product',$purchasecom,$_POST[cityList],1,$rate,'$_SESSION[userName]','$punit',$factor)"; 
      db_query($sql) or die(mysql_error());
      //echo "order";
      $sql="insert into tbl_receive (date,donumber,product,qty,rate,user,remarks) 
        value('$_SESSION[dttransection]','COB-$company-$product','$_POST[cityList]',1,$rate,'$_SESSION[userName]','Customer Opening Balance')"; 
      db_query($sql) or die(mysql_error());
      
     // echo "rec";
      
      $remarks="Cash Payment To $_POST[company] DO No :COB-$company-$product";   
      $sql="insert into tbl_cash (date,remarks,withdraw,user,type) values('$_SESSION[dttransection]','$remarks',$_POST[total],'$_SESSION[userName]',9)";
      db_query($sql) or die(mysql_error());
      
     // echo "cash";
      
      $remarks="COB Cash Payment To $_POST[company] DO No :COB-$company-$product";   
      
      $sql="insert into tbl_com_payment (paydate,donumber,amount,bamount,chequeno,bank,user,remarks,status,companyid) 
        value('$_SESSION[dttransection]','COB-$company-$product',$_POST[total],$_POST[total],'COB','Cash','$_SESSION[userName]','$remarks','C',$purchasecom)"; 
      db_query($sql) or die(mysql_error());
     // echo "payment";
      
      $rate=$_POST[total]/$factor;
      $sql="insert into tbl_sales (date,donumber,invoice,product,rate,qty,user,customerid,factor,unit,truckno,remarks,sp) 
        value('$_SESSION[dttransection]','COB-$company-$product','COB-$company-$product',$_POST[cityList],$rate,$factor,'$_SESSION[userName]',$_POST[company],$factor,
                       '$sunit','COB','Opening Balance','$_POST[sp]')"; 
      db_query($sql) or die(mysql_error());
      
     // echo "sales";
      echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Customer Opening Balance Place successfully</b>";
    }

    } // Error chech If
 }// Submit If
?>


<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td align="left"  colspan="4"><img src="images/2.jpg">  Customer Opening Balance</td></tr> 
    <tr bgcolor="#FFCCAA">  
        
        <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,type  FROM tbl_customer where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
              
          ?>
              <select name="company"  style="width: 250px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name'] ?>:<?php echo $row_sql['type'] ?>   </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td>Product:
       
         <select name="cityList" style="width:300px">     
         <?
         $sql="Select tbl_product.id,tbl_company.name as cname,tbl_product.name as pname,tbl_product.unit from tbl_product
                join tbl_company on tbl_product.companyid=tbl_company.id
                ";

          $sql = mysql_query($sql) or die(mysql_error());
          $row_sql = mysql_fetch_assoc($sql);

             do {  
         ?>
            <option value="<?php echo $row_sql['id'];?>"><?php echo $row_sql['pname'] ." - ".$row_sql['unit'] ;?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
       </td>  
       <input type="hidden"  name="type"  size="12" value="2"    /> 
       <input type="hidden"  name="qty"  size="12" value="1"    />  
       <td>
                 <?
           $query_sql = "SELECT  shortname  FROM tbl_sp order by shortname desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         SP:
         <select name="sp" style="width: 100px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['shortname'];?>" <?php if($_POST["sp"]==$row_sql['shortname']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>
       </td>
       
       
       <td>Credit Amount: <input type="text" size="15"  name="total" /> </td>
     </tr>    
     <tr id="trsubhead"><td colspan="4" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td align="center" colspan="3">Customer Opening Balance</td></tr> 
   <tr bgcolor="#FFCCAA">    
       <td>Customer</td>
       <td>Product</td>     
       <td>Credit Amount</td>   
      </tr>     
  
   <?
     $user_query="select tbl_open_bal.id, tbl_open_bal.qty,tbl_open_bal.amount,tbl_customer.name as company,unit,tbl_product.name as product from tbl_open_bal
                   join tbl_customer on tbl_open_bal.companyid=tbl_customer.id
                   join tbl_product on tbl_open_bal.productid=tbl_product.id
                   where tbl_open_bal.type=2
                   order by tbl_open_bal.id desc";
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
          <td align="right"><?=number_format($value[amount],2);?></td>
       </tr>
       <?
        $sumtotal=$sumtotal+$value[amount];
       }
      }
    ?>  
  
  <tr id="trsubhead"><td colspan="3" align="right"><b>Total : <?=number_format($sumtotal,2);?></b> </td></tr>
 </table>

<?php
 include "footer.php";
?>
