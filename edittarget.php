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
    $sql="update tbl_sp_target set volume='$_POST[volume]',outlet='$_POST[outlet]',stick='$_POST[stick]',placement='$_POST[placement]'
             where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  *  FROM `tbl_sp_target` where id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> SP Target Update.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=35%>SP ID:</td>
         <td><?=$value['sp'];?></td>
      </tr>
 
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=35%>Year</td>
         <td><?=$value['year'];?></td>
      </tr>
  
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=35%>Month</td>
         <td><?=$value['month'];?></td>
      </tr>
     
      <tr  align="center"> 
       <td>New Outlet</td>
       <td><input type="text"  name="outlet" size="8"  value="<?=$value['outlet'];?>"></td>
      </tr>

       <tr  align="center"> 
        <td>Volume</td>
        <td><input type="text"  name="volume" size="8"  value="<?=$value['volume'];?>"></td>
      </tr>
      
      <tr  align="center"> 
       <td>Strick Rate (%)</td>
       <td><input type="text"  name="stick" size="8"  value="<?=$value['stick'];?>"></td>
      </tr>
      
     <tr  align="center"> 
       <td>Placement</td>
       <td><input type="text"  name="placement" size="8"  value="<?=$value['placement'];?>"></td>
      </tr>

         
  <input type="hidden" name="id" value=<?=$value[id];?>>
    
    <tr align="center">
        <td id="trhead" colspan="2"><input type="submit" name="submit" value="  Update  "></td>
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
