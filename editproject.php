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
    $sql="update tbl_project set name='$_POST[name]',address='$_POST[address]',mobile='$_POST[mobile]',status='$_POST[status]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  *  FROM `tbl_project` where tbl_project.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> Project Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=15%>Project Name:</td>
         <td><input type="text"  name="name" size="50"  value="<?=$value['name'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
    
     <tr  align="center"> 
       <td>Address</td>
       <td><input type="text"  name="address" size="50"  value="<?=$value['address'];?>"></td>
      </tr>

    
      <tr  align="center"> 
       <td>Mobile</td>
       <td><input type="text"  name="mobile" size="15" maxlength="13" value="<?=$value['mobile'];?>"></td>
      </tr>
    
  
  
      <tr  align="center"> 
        <td>Status</td>
        <td>
          <select name="status"  style="width: 100px;">
              <option value="0" <? if($value[status]==0) echo "SELECTED"; ?>>Active</option>
            <option value="1" <? if($value[status]==1) echo "SELECTED"; ?>>Inactive</option>
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
