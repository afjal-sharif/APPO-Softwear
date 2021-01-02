<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  
  <script src="./js/code_regen.js"></script> 
  <link href="skin_dhk.css" rel="stylesheet" type="text/css" />
</head>
<body>
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    echo $sql="update tbl_incentive_gift set dis_value='$_POST[dis_value]',dis_remarks='$_POST[dis_remarks]',status='$_POST[status]',dis_date='$_SESSION[dtcustomer]'
          where id=$id";
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
   $user_query="SELECT  *  FROM `tbl_incentive_gift` where id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#F3F3F3"><b> Gift Item Edit Form.</b></td></tr>
      
      <tr align="center" id="trsubhead">    
         <td width=25%>Gift Name</td>
         <td><?=$value[gift_name];?></td>
      </tr>
      
      <tr align="center" id="trsubhead">    
         <td width=15%>Remarks</td>
         <td><?=$value['remarks'];?></td>
      </tr>
      
     <tr  align="center"> 
       <td>Market Value</td>
       <td><?=$value['value'];?></td>
      </tr>


      <input type="hidden" name="id" value=<?=$value[id];?>>

      <tr  align="center"> 
        <td>Disposed Value</td>
        <td><input type="text"  name="dis_value" size="15" value="<?=$value['dis_value'];?>"></td>
     </tr>

     <tr  align="center"> 
        <td>Disposed Remarks</td>
        <td><input type="text"  name="dis_remarks" size="50"  value="<?=$value['dis_remarks'];?>"></td>
       </tr>

      <tr  align="center"> 
        <td>Status</td>
        <td>
          <select name="status"  style="width: 100px;">
            <option value="0" <? if($value[status]==0) echo "SELECTED"; ?>>At Hand</option>
            <option value="1" <? if($value[status]==1) echo "SELECTED"; ?>>Disposed</option>
            <option value="2" <? if($value[status]==2) echo "SELECTED"; ?>>Used</option>
          </select> 
        </td>
       </tr>
      </table>
 
 
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
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
