<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 $rec=$_GET[rec];
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  <!--<link href="style.css" rel="stylesheet" type="text/css" />-->
  <link href="skin.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    
    if(empty($rec))
     {
      $sql="update tbl_order  set donumber=$_POST[donumber],product=$_POST[product],qty=$_POST[qty],rate=$_POST[rate],comission=$_POST[comission] where id=$id";
      db_query($sql) or die (mysql_error());
      $flag=true;
     }
     else
     {
       if($_POST[qty]>=$rec)
        {
        $sql="update tbl_order  set donumber=$_POST[donumber],product=$_POST[product],qty=$_POST[qty],rate=$_POST[rate],comission=$_POST[comission] where id=$id";
        db_query($sql) or die (mysql_error());
        $flag=true;
        }
       else
        {
         echo "Error ! Qty Must Be Greater Than Receive Qty.";
        } 
      
     }  
    //echo "Update Successfully.";
   }
 ?>


 <? 
   $id=$_GET[smsId];
   
   $user_query="Select tbl_order.id,donumber,company,product,qty,rate,comission,name from tbl_order
                join tbl_company on tbl_order.company=tbl_company.id
                where tbl_order.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b>Order Edit Form.</b></td></tr>
      <tr align="center" id="trsubhead">    
       <td width=15%>DO Number</td>
       <td width=15% align="center"><input type="text"  size="10" name="donumber" value="<?=$value['donumber'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
      <tr  align="center"> 
       <td>Company</td>
       <td><input type="text"  name="company" value="<?=$value['name'];?>" readonly></td>
      </tr>
      <tr  align="center"> 
        <td>Product</td>
        
        <td>     
         <?
          $query_sql = "SELECT id,name  FROM tbl_product where companyid=$value[company] order by id";
          $sql = mysql_query($query_sql) or die(mysql_error());
          $row_sql = mysql_fetch_assoc($sql);
          
        ?>
          <select name="product" style="width: 130px;">
        <?
          do {  
        ?>
          <option value="<?php echo $row_sql['id'];?>" <?php if($value[product]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
        <?
          } while ($row_sql = mysql_fetch_assoc($sql));
        ?>
         </select>
        </td>
       </tr>
      <tr  align="center"> 
        <td>Quantity (MT)</td>
        <td><input type="text"  name="qty" value="<?=$value['qty'];?>"></td>
       </tr>
 
      <tr  align="center"> 
        <td>Rate/ Per MT</td>
        <td><input type="text"  name="rate" value="<?=$value['rate'];?>"></td>
       </tr>
 
      <tr  align="center"> 
        <td>Comission(Per Bag)</td>
        <td><input type="text"  name="comission" size="6" maxsize="6" value="<?=$value['comission'];?>"></td>
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
        echo " <b>Update Successfully. || Please Click Referesh Button on Your Browser.</b><br>";
       ?>
         <A HREF=javascript:void(0) onclick=window.close() title="Close"><b><br>Close </b></a>
       <? 
        
       }
    }
   
   ?>   
</body>
</html>
