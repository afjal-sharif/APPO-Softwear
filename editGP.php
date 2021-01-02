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
    $sql="update tbl_receive set qty='$_POST[qty]',bundle='$_POST[bundle]',dfcost='$_POST[dfcost]',locost='$_POST[locost]' where id=$id";
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
   $user_query="SELECT  *  FROM `tbl_receive` where tbl_receive.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b>Receive Edit Form</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=50%>DO Number:</td>
         <td><input type="text"  name="donumber" size="15"  value="<?=$value['donumber'];?>" READONLY /></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
    
     <tr  align="center"> 
       <td>Qty</td>
       <td><input type="text"  name="qty" size="15"  value="<?=$value['qty'];?>"></td>
      </tr>
    
     <tr  align="center"> 
       <td>Bundle</td>
       <td><input type="text"  name="bundle" size="15"  value="<?=$value['bundle'];?>"></td>
     </tr>
     <tr  align="center"> 
       <td>DF/Unit</td>
       <td><input type="text"  name="dfcost" size="15"  value="<?=$value['dfcost'];?>"></td>
      </tr>
     <tr  align="center"> 
       <td>Unload Cost/Unit</td>
       <td><input type="text"  name="locost" size="15"  value="<?=$value['locost'];?>"></td>
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
