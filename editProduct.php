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
    $sql="update tbl_product set name='$_POST[product]',category_id='$_POST[category]',punit='$_POST[unit]',unit='$_POST[unit]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   //$user_query="SELECT  *  FROM `tbl_company` where tbl_company.id=$id";
   $user_query="select tbl_product.id as id,tbl_product.category_id as cat_id, tbl_product_category.name as category,tbl_product.name as product,commission,punit,unit,factor 
                  from tbl_product  
                  join tbl_product_category on tbl_product.category_id=tbl_product_category.id 
                  where tbl_product.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="70%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> Product Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=35%>Category:</td>
         <td>
            <?
           $query_sql = "SELECT id,name  FROM tbl_product_category order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select  name="category" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value[cat_id]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
         
         </td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
    
     <tr  align="center"> 
       <td>Product</td>
       <td><input type="text"  name="product" size="50"  value="<?=$value['product'];?>"></td>
     </tr>
     <tr  align="center">
     <td>Unit:</td>
     <td>
          <select name="unit" style="width:70px">
             <option value="Kg" <?if($value[unit]=='Kg') {echo "Selected";}?> >Kg</option>
             <option value="Bag" <?if($value[unit]=='Bag') {echo "Selected";}?>>Bag</option>        
         </select>
     </td>  
     </tr>
    </table>
 
 
    <table width="70%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
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
