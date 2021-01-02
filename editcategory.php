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
    $sql="update tbl_product_category set name='$_POST[name]',g_name='$_POST[g_name]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true; 
    ?>
     <script type="text/javascript"> 
         opener.location.reload(); 
         window.close(); 
      </script>     
   
  <?  
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  *  FROM `tbl_product_category` where `tbl_product_category`.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b>Edit Product Category Form</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Category Name:</td>
         <td><input type="text"  name="name" size="55"  value="<?=$value['name'];?>"  /></td>
      </tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">   
        <td>Group Name:</td>
         <td>
       <select name="g_name" style="width: 180px;">
          
            <?
           $query_sql = "SELECT distinct g_name  FROM `tbl_product_category`  order by g_name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['g_name'];?>" <?php if($value['g_name']==$row_sql['g_name']) echo "selected";?> ><?php echo $row_sql['g_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
            
       </select>
     </td>
   
      
      
      </tr>
      
      <input type="hidden" name="id" value=<?=$value[id];?>>
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
