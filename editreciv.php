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
    $sql="update tbl_receive set truckno='$_POST[truckno]',remarks='$_POST[remarks]',gpnumber='$_POST[gpnumber]',qty=$_POST[qty],truckno='$_POST[truckno]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="select tbl_receive.id, tbl_receive.date,tbl_receive.donumber,tbl_product.punit as unit,
                   tbl_receive.gpnumber,tbl_order.rate,tbl_receive.qty,tbl_receive.truckno,tbl_receive.df,
                   tbl_receive.otherscost,tbl_receive.remarks,
                   tbl_company.name as company,tbl_product.name as product
                   from tbl_receive
                   join tbl_order on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   where tbl_receive.id=$id              
                   order by tbl_receive.id desc";
   
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#F090FF"><b> Goods Receive Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Company Name:</td>
         <td><input type="text"  name="name" size="50" READONLY  value="<?=$value['company'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
     
     <tr  align="center"> 
       <td>Product</td>
       <td><input type="text"  name="address" size="50"  READONLY value="<?=$value['product'];?>"></td>
      </tr>

     <tr  align="center"> 
       <td>DO Number</td>
       <td><input type="text"  name="area" size="50" READONLY value="<?=$value['donumber'];?>"></td>
      </tr>

    
      <tr  align="center"> 
       <td>Truck No</td>
       <td><input type="text"  name="truckno" size="15" maxlength="13" value="<?=$value['truckno'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>GP Number</td>
       <td><input type="text"  name="gpnumber" size="15" value="<?=$value['gpnumber'];?>"></td>
      </tr>

      <tr  align="center"> 
        <td>Qty ( <?=$value[unit];?> )</td>
        <td><input type="text"  name="qty" size="15" value="<?=$value['qty'];?>"></td>
       </tr>

     <tr  align="center"> 
        <td>Remarks</td>
        <td><input type="text"  name="remarks" size="50" maxlength="15" value="<?=$value['remarks'];?>"></td>
       </tr>
       
       <tr align="center">
          <td>Truck No: </td>
          <td>
            <?
           $query_sql = "SELECT id,name,owner  FROM truck_name order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="truckno" style="width:180px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['name'];?>" <?php if($value["truckno"]==$row_sql['name']) echo "selected";?> ><?php echo $row_sql['name']?> ::<?php echo $row_sql['owner']?> </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>
       </tr>
       
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
