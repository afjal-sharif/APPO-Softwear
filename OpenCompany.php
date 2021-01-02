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
  $purchasecom=2;
  
   $sql="insert into tbl_open_bal (companyid,productid,qty,amount,type) 
        value($_POST[company],$_POST[cityList],$_POST[qty],$_POST[total],$_POST[type])"; 
   db_query($sql) or die(mysql_error());
  
  
  // For Company Payment
  if($_POST[type]==3)
    {
      $rate=$_POST[total];
      
      $sql="insert into tbl_order (dtDate,donumber,company,product,qty,rate,user,punit,factor) 
        value('$_SESSION[dttransection]','COBC-$company-$product',$company,$_POST[cityList],1,$rate,'$_SESSION[userName]','$punit',$factor)"; 
      db_query($sql) or die(mysql_error());
 
      $sql="insert into tbl_receive (date,donumber,product,qty,rate,user,remarks) 
        value('$_SESSION[dttransection]','COBC-$company-$product',1,1,$rate,'$_SESSION[userName]','Compnay Opening Balance')"; 
      db_query($sql) or die(mysql_error());
      
        
      //$remarks="COB Cash Payment To $_POST[company] DO No :COB-$company-$product";   
      //$sql="insert into tbl_com_payment (paydate,donumber,amount,bamount,chequeno,user,remarks,status) 
      //  value(curdate(),'COB-$company-$product',$_POST[total],$_POST[total],'COB','$_SESSION[userName]','$remarks','C')"; 
     // db_query($sql) or die(mysql_error());
      
      $rate=$_POST[total]/$factor;
      $sql="insert into tbl_sales (date,donumber,invoice,product,rate,qty,user,customerid,factor,unit,truckno,remarks) 
        value('$_SESSION[dttransection]','COBC-$company-$product','COBC-$company-$product',$_POST[cityList],$rate,$factor,'$_SESSION[userName]',$purchasecom,$factor,
                       '$sunit','COBC','Opening Balance')"; 
      db_query($sql) or die(mysql_error());
      
      $remarks="COBC Cash Receive From $_POST[company] DO No :COBC-$company-$product";   
      $sql="insert into tbl_dir_receive (date,mrno,invoice,hcash,user,bank,branch,chequeno,amount,cheqdate,depositebank,remarks,customerid) 
        value('$_SESSION[dttransection]','COBC-$company-$product','COBC-$company-$product',$_POST[total],'$_SESSION[userName]',
        '','','',0,'','','$remarks',$purchasecom)";     
      db_query($sql) or die(mysql_error());

      $remarks="Cash Receive From $_POST[company] DO No :COBC-$company-$product";   
      $sql="insert into tbl_cash (date,remarks,deposite,user,type) values('$_SESSION[dttransection]','$remarks',$_POST[total],'$_SESSION[userName]',9)";
      db_query($sql) or die(mysql_error()); 
      echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Company Opening Balance Place successfully</b>";
    }
   } // Error chech If
 }// Submit If
?>



<form name="myForm" method="post" action="">
<table width="955px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td align="left" colspan="3"><img src="images/3.jpg"> Company Opening Balance</td></tr> 
    <tr bgcolor="#FFCCAA">  
        
        <td>
         Company: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_company  where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company"  style="width: 150px;">
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
       
       <td id="txtResult" colspan="1">Product:
        <select name="cityList" style="width:250px">     
         <?
          $sql="Select tbl_product.id, tbl_company.name as cname,tbl_product.name as pname from tbl_product
                join tbl_company on tbl_product.companyid=tbl_company.id
                ";
          $sql = mysql_query($sql) or die(mysql_error());
          $row_sql = mysql_fetch_assoc($sql);

             do {  
         ?>
            <option value="<?php echo $row_sql['id'];?>"><?php echo $row_sql['pname'];?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
     </td>  
       
       <input type="hidden"  name="type"  size="12" value="3"    />
       <input type="hidden"  name="qty"  size="12" value="1"    />      
       <td>Credit Amount: <input type="text" size="10"  name="total" /> </td>
     </tr>    
    <tr id="trsubhead"><td colspan="3" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>


<br><br>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td align="center" colspan="3">Company Opening Balance</td></tr> 
   <tr bgcolor="#FFCCAA">    
       <td>Company</td>
       <td>Product</td>     
       <td>Credit Amount</td>   
      </tr>     
  
   <?
     $user_query="select tbl_open_bal.id, tbl_open_bal.qty,tbl_open_bal.amount,tbl_company.name as company,unit,tbl_product.name as product from tbl_open_bal
                   join tbl_company on tbl_open_bal.companyid=tbl_company.id
                   join tbl_product on tbl_open_bal.productid=tbl_product.id
                   where tbl_open_bal.type=3
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
