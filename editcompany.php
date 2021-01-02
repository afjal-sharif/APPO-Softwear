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
    $sql="update tbl_company set name='$_POST[name]',address='$_POST[address]',person='$_POST[person]',mobile='$_POST[mobile]',tnt='$_POST[tnt]',email='$_POST[email]',creditday=$_POST[creditday],custday=$_POST[custday] where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  *  FROM `tbl_company` where tbl_company.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> Company Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Company Name:</td>
         <td><input type="text"  name="name" size="50"  value="<?=$value['name'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
    
     <tr  align="center"> 
       <td>Address</td>
       <td><input type="text"  name="address" size="50"  value="<?=$value['address'];?>"></td>
      </tr>

     <tr  align="center"> 
       <td>Contact Person</td>
       <td><input type="text"  name="person" size="50" value="<?=$value['person'];?>"></td>
      </tr>

    
      <tr  align="center"> 
       <td>Mobile</td>
       <td><input type="text"  name="mobile" size="15" maxlength="13" value="<?=$value['mobile'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>T & T</td>
       <td><input type="text"  name="tnt" size="15" value="<?=$value['tnt'];?>"></td>
      </tr>

    <tr  align="center"> 
       <td>E- Mail</td>
       <td><input type="text"  name="email" size="30" value="<?=$value['email'];?>"></td>
      </tr>
    <tr  align="center"> 
       <td>Company Credit Days</td>
       <td><input type="text"  name="creditday" size="6" value="<?=$value['creditday'];?>"></td>
      </tr>
    <tr  align="center"> 
       <td>Customer Credit Days</td>
       <td><input type="text"  name="custday" size="6" value="<?=$value['custday'];?>"></td>
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
