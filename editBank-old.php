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
    $sql="update tbl_bank_name set bankname='$_POST[name]',branch='$_POST[branch]',accountcode='$_POST[accountcode]',
          contactperson='$_POST[contactperson]',mobile='$_POST[mobile]',blimit=$_POST[blimit] where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
    
    if($_POST[orgincode]==$_POST[accountcode])
     {
      
     }
    else
     {
      $sql="update tbl_bank set bank='$_POST[accountcode]'  where bank='$_POST[orgincode]'";
      db_query($sql) or die (mysql_error());
      
      $sql="update tbl_com_payment set bank='$_POST[accountcode]'  where bank='$_POST[orgincode]'";
      db_query($sql) or die (mysql_error());
      
      $sql="update `tbl_dir_receive` set depositebank='$_POST[accountcode]'  where depositebank='$_POST[orgincode]'";
      db_query($sql) or die (mysql_error());
     }  
    
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  *  FROM `tbl_bank_name` where tbl_bank_name.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b>Bank Name Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=15%>Bank Name:</td>
         <td><input type="text"  name="name" size="50"  value="<?=$value['bankname'];?>"></td>
      </tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=15%>Branch Name:</td>
         <td><input type="text"  name="branch" size="50"  value="<?=$value['branch'];?>"></td>
      </tr>   
      <input type="hidden" name="id" value=<?=$value[id];?>>
    </tr>
     <tr  align="center"> 
       <td>A/C:</td>
       <td>
         <input type="text"  name="accountcode" size="50"  value="<?=$value['accountcode'];?>">
         <input type="hidden"  name="orgincode" value="<?=$value['accountcode'];?>">
         </td>
      </tr>

     <tr  align="center"> 
       <td>Limit</td>
       <td><input type="text"  name="blimit" size="10" value="<?=$value['blimit'];?>"></td>
      </tr>

    
      <tr  align="center"> 
       <td>Mobile</td>
       <td><input type="text"  name="mobile" size="15" maxlength="13" value="<?=$value['mobile'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>Contact Person</td>
       <td><input type="text"  name="contactperson" size="15" value="<?=$value['contactperson'];?>"></td>
      </tr>

      </table>
 
 
    <table width="80%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submit" value="  Update  "></td>
       </tr> 
     </table>
    </form>
    
    <script>
       makePhoneticEditor('bangla'); //pass the textarea Id
    </script>

    
    
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
