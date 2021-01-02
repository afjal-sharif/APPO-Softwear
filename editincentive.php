<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  
  <link href="skin.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    $type=$_GET[type];
    
    if($type==0)
    {    
    $sql="update tbl_incentive_pay set qty=$_POST[qty],rate=$_POST[rate],pay=$_POST[pay],adjust=$_POST[adjust],user='$_SESSION[userName]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;
    }
    elseif($type==1)
    {
     $preamount=$_POST[prewithamount];
     $amount=$_POST[withdraw];
     $bal=$amount-$preamount;

    $sql="update tbl_incentive_pay set withdraw=$_POST[withdraw],user='$_SESSION[userName]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;
   
    $remarks="Incnetive Cash Withdraw Edit Adjustment ID: $id Customer: $_POST[custname]";
    $sql="insert into tbl_cash (date,remarks,deposite,withdraw,user) 
        value(curdate(),'$remarks',0,$bal,'$_SESSION[userName]')"; 
     db_query($sql) or die(mysql_error());
 
    
    } 
    elseif($type==2)
    {
    
    }// type 2 end.
      
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $type=$_GET[type];
   $user_query="Select  tbl_incentive_pay.id,tbl_customer.name as custname,tbl_company.name as cname,tbl_product.name as pname,tbl_incentive_pay.withdraw,
                   tbl_incentive_pay.rate,tbl_incentive_pay.qty,tbl_incentive_pay.pay,tbl_incentive_pay.adjust,tbl_incentive_pay.pay,tbl_incentive_pay.productid from tbl_incentive_pay
                   join tbl_customer on tbl_customer.id=tbl_incentive_pay.customerid 
                   left join tbl_product on tbl_product.id=tbl_incentive_pay.productid
                   left join tbl_company on tbl_company.id=tbl_incentive_pay.company 
                   where tbl_incentive_pay.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FFEEC9"><b> Incentive Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Customer Name:</td>
         <td><input type="text"  name="custname" size="50"  value="<?=$value['custname'];?>" READONLY ></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
      <input type="hidden" name="prewithamount" value=<?=$value[withdraw];?>>
    
     <?
      if($type==0)
       {
     ?>
     <tr  align="center"> 
       <td>From Company</td>
       <td><input type="text"  name="cname" size="50"  value="<?=$value['cname'];?>" READONLY></td>
      </tr>

     <tr  align="center"> 
       <td>Product Name</td>
       <td><input type="text"  name="pname" size="50" value="<?=$value['pname'];?>" READONLY></td>
      </tr>

    
      <tr  align="center"> 
       <td>Qty</td>
       <td><input type="text"  name="qty" size="15" maxlength="13" value="<?=$value['qty'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>Rate</td>
       <td><input type="text"  name="rate" size="15" value="<?=$value['rate'];?>"></td>
      </tr>

      <tr  align="center"> 
       <td>Payments</td>
       <td><input type="text"  name="pay" size="15" value="<?=$value['pay'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>Others</td>
       <td><input type="text"  name="adjust" size="15" value="<?=$value['adjust'];?>"></td>
      </tr>
     
     <?
      }
     elseif($type==1)
      {
      ?>
     <tr  align="center"> 
       <td>Withdraw</td>
       <td><input type="text"  name="withdraw" size="15" value="<?=$value['withdraw'];?>"></td>
      </tr>
      
      
      <?
      }
      elseif($type==2)
      {
      ?>
     <tr  align="center"> 
       <td>Withdraw</td>
       <input type="hidden" name="invoiceno" value=<?=$value[productid];?>>
       <td><input type="text"  name="withdraw" size="15" value="<?=$value['withdraw'];?>"></td>
      </tr>
  
      <?
      }
        
     ?>
     


      </table>
 
 
    <table width="80%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submit" value="  Update  "></td>
       </tr> 
     </table>
    </form>
   <?}
   else
    {
      if($flag==true)
       {
        echo " <b>Update Successfully $msg</b>.<br><br><br><br>";
       ?>
         <A HREF=javascript:void(0) onclick=window.close() title="Edit"><b>Click Here To Close </b></a>
       <? 
        
       }
    }
   
   ?>   
</body>
</html>
