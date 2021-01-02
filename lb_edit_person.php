<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  
  <script src="./js/code_regen.js"></script> 
  <link href="skin.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    echo $sql="update tbl_lb_database set name='$_POST[name]',type='$_POST[type]',address='$_POST[address]',mobile='$_POST[mobile]',status='$_POST[status]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;
    
    $sql="update tbl_assets_liab set remarks='$_POST[name]' where person_id=$id";
    db_query($sql) or die (mysql_error());
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
   $user_query="SELECT  *  FROM `tbl_lb_database` where id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b>Person Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=15%>Name:</td>
         <td><input type="text"  name="name" size="50"  value="<?=$value['name'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
     <tr  align="center"> 
       <td>Type:</td>
       <td>
          <select name="type" style="width: 100px;">
            <option value="Personal" <?if($value[type]=='Personal') {echo "SELECTED";}?>>Personal</option>
            <option value="Employee" <?if($value[type]=='Employee') {echo "SELECTED";}?>>Employee</option>
            <option value="Customer" <?if($value[type]=='Customer') {echo "SELECTED";}?>>Customer</option>
            <option value="Company" <?if($value[type]=='Company') {echo "SELECTED";}?>>Company</option>
            <option value="Others" <?if($value[type]=='Others') {echo "SELECTED";}?>>Others</option>
          </select> 
            
       </td>

    </tr>
    
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
