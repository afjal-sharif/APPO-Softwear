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

<script language="javascript">
  function ConfirmSales()
  {
    answer = confirm("Are You Sure To DELETE THIS INCENTIVE.?")
    if (answer !=0)
    {
     window.submit();
    }
  }	
</script>


<body>
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    $sql="update tbl_temp_incentive set qty='$_POST[qty]',rate='$_POST[rate]',addition='$_POST[addition]'  where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
    ?>
     <script type="text/javascript"> 
         opener.location.reload(); 
         window.close(); 
      </script>      
  <?
   }
   
   if(isset($_POST["delsubmit"]))
   {
    $id=$_POST[id];
    $sql="delete from tbl_temp_incentive where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  *  FROM `tbl_temp_incentive` where id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#F3F3F3"><b>INCENTIVE EDIT</b></td></tr>
      
     
      <input type="hidden" name="id" value=<?=$value[id];?>>

      <tr  align="center"> 
        <td>Qty</td>
        <td><input type="text"  name="qty" size="10" value="<?=$value['qty'];?>"></td>
      </tr>

      <tr  align="center"> 
        <td>Rate</td>
        <td><input type="text"  name="rate" size="10"  value="<?=$value['rate'];?>"></td>
      </tr>
      
      <tr  align="center"> 
        <td>Addition</td>
        <td><input type="text"  name="addition" size="10"  value="<?=$value['addition'];?>"></td>
      </tr>
      
    </table>

    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" onclick='ConfirmSales(); return false;' name="delsubmit" value="  DELETE  "></td>
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
