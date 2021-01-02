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
    $sql="update tbl_sc_account set ref_id='$_POST[ref_id]',bank='$_POST[bank]',branch='$_POST[branch]',account='$_POST[account]',remarks='$_POST[remarks]' where id=$id";
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
   //$user_query="SELECT  *  FROM `tbl_company` where tbl_company.id=$id";
    $user_query=" select tbl_sc_account.id,tbl_sc_account.ref_id,name,address,account,bank,branch,tbl_sc_account.type,tbl_sc_account.remarks
                   from tbl_sc_account
                   join tbl_company on tbl_sc_account.ref_id=tbl_company.id
                   where tbl_sc_account.id='$id'";  
                  
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="90%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> Supplier Account Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=35%>Supplier:</td>
         <td>
           <?
           $query_sql = "SELECT id,name,address  FROM tbl_company  where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="ref_id"   id ="ref_id" style="width:350px">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value["ref_id"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>   
         </td>
      </tr>
       
       
      <input type="hidden" name="id" value=<?=$value[id];?>>
    
     <tr  align="center"> 
       <td>Bank </td>
       <td><input type="text"  name="bank" size="50"  value="<?=$value['bank'];?>"></td>
     </tr>
     
     <tr  align="center"> 
       <td>Branch</td>
       <td><input type="text"  name="branch" size="50"  value="<?=$value['branch'];?>"></td>
     </tr>
     
     <tr  align="center"> 
       <td>Account</td>
       <td><input type="text"  name="account" size="50"  value="<?=$value['account'];?>"></td>
     </tr>
     
     <tr  align="center"> 
       <td>Remarks</td>
       <td><input type="text"  name="remarks" size="50"  value="<?=$value['remarks'];?>"></td>
     </tr>


    </table>
 
    <table width="90%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
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
