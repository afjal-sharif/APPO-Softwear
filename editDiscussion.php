<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  
  <script src="./js/code_regen.js"></script> 
  <link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submitupdate"]))
   {
    $id=$_POST[id];
    $sql="update tbl_discussion set alarmdate='$_POST[alarmdate]',discussion='$_POST[discussion]',acknow=$_POST[status] where id=$id";
    db_query($sql) or die (mysql_error());
    $msg="Update Successfully";
    $flag=true;   
    ?>
     <script type="text/javascript"> 
         opener.location.reload(); 
         window.close(); 
      </script>     
   
  <?
     
   }
   
 if(isset($_POST["submitdelete"]))
   {
    $id=$_POST[id];
    $sql="delete from  tbl_discussion where id=$id";
    db_query($sql) or die (mysql_error());
    $msg="Request Delete Successfully";
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
   $user_query="Select * from   tbl_discussion  where tbl_discussion.id=$id"; 
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="100%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b>Update Discussion</b></td></tr>
      
      <tr bgcolor="#cccccc" align="left">    
         <td width=15%>Alarm Date</td>
         <td><input type="text"  name="alarmdate" size="50"  value="<?=$value['alarmdate'];?>"></td>
      </tr>
 
     
      <input type="hidden" name="id" value=<?=$value[id];?>>

  
    
     <tr  align="left"> 
       <td>Discussion</td>
       <td> <textarea name="discussion" rows="10" cols="80"><?echo $value[discussion];?></textarea></td>
      </tr>
    <tr>
     <td> 
          Status
     </td>
     <td>     
         <select name="status"  style="width: 100px;">
              <option value="0" <? if($value[acknow]=='0') echo "SELECTED"; ?>>Pending</option>
              <option value="1" <? if($value[acknow]=='1') echo "SELECTED"; ?>>Done</option>             
          </select> 
      </td>
    </tr>
   
      </table>
 
 
    <table width="100%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submitupdate" value="Update"></td>
        <td id="trhead"><input type="submit" name="submitdelete" onClick="return (confirm('Are you sure to Delete WO Request!!!')); return false;" value="Delete"></td>
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
        echo " <b>$msg</b>.<br><br><br><br>";
       ?>
         <A HREF=javascript:void(0) onclick=window.close() title="Edit"><b>Click Here To Close </b></a>
       <? 
        
       }
    }
   
   ?>   
</body>
</html>
