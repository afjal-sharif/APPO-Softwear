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
    $sql="update tbl_receive set truckno='$_POST[truckno]',remarks='$_POST[remarks]',gpnumber='$_POST[gpnumber]',qty=$_POST[qty] where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   } 
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="select tbl_order.id, tbl_order.dateandtime,tbl_order.donumber,
                   tbl_order.rate,tbl_order.qty,tbl_order.paydate,tbl_order.deliveryfair,
                   tbl_order.remarks,tbl_order.sp,tbl_order.company as company,tbl_order.product as product
                   from tbl_order
                   where tbl_order.id=$id              
                   order by tbl_order.id desc";
   
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#F090FF"><b> Goods Order Edit Form.</b></td></tr>

     <tr  align="center"> 
       <td>DO Number</td>
       <td><input type="text"  name="area" size="50" READONLY value="<?=$value['donumber'];?>"></td>
      </tr>

      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Company Name:</td>
         <td>
         
          <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company"  style="width: 260px;">
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value['company']==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>

         
         </td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
     
     <tr  align="center"> 
       <td>Product</td>
       <td>
           <?
           $query_sql = "SELECT id,name   FROM tbl_product where companyid=$value[company] order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="product" style="width:200px">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value['product']==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>

       </td>
      </tr>


      <tr  align="center"> 
        <td>Qty ( <?=$value[unit];?> )</td>
        <td><input type="text"  name="qty" size="15" value="<?=$value['qty'];?>"></td>
       </tr>

    
      <tr  align="center"> 
       <td>Rate</td>
       <td><input type="text"  name="rate" size="15" maxlength="13" value="<?=$value['rate'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>Remarks</td>
       <td><input type="text"  name="remarks" size="40" value="<?=$value['remarks'];?>"></td>
      </tr>

      <tr  align="center"> 
        <td>SP </td>
     
       <td align="center">
          <?
           $query_sql = "SELECT  shortname  FROM tbl_sp order by id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 100px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['shortname'];?>" <?php if($value['sp']==$row_sql['shortname']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
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
