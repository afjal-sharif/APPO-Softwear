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
    $sql="update tbl_customer set codeno='$_POST[code]',name='$_POST[name]',type='$_POST[type]',btype='$_POST[btype]',address='$_POST[address]',owner='$_POST[owner]',
        area='$_POST[area]',mobile='$_POST[mobile]',tnt='$_POST[tnt]',climit=$_POST[limit],com_id='$_POST[company]',
        cdays=$_POST[cdays],status='$_POST[status]',remarks='$_POST[remarks]', customerbangla='$_POST[bangla_text]',sp='$_POST[sp]',tin='$_POST[tin]',trade_lic='$_POST[trade]' where id=$id";
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
   $user_query="SELECT  *  FROM `tbl_customer` where tbl_customer.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> Customer Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td>Code No:</td>
         <td><input type="text"  name="code" size="50"  value="<?=$value['codeno'];?>"></td>
      </tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=15%>Customer Name:</td>
         <td><input type="text"  name="name" size="50"  value="<?=$value['name'];?>"></td>
      </tr>
      
      <tr align="center">    
         <td>Owner Name:</td>
         <td><input type="text"  name="owner" size="50"  value="<?=$value['owner'];?>"></td>
      </tr>
      
      
      <input type="hidden" name="id" value=<?=$value[id];?>>
   <tr  align="center"> 
       <td>Type:</td>
       <td>
          <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=2 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="type" style="width: 100px;">          
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($value[type]==$row_sql[area_name]) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
         &nbsp;&nbsp;&nbsp;
         <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=4 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="btype" style="width: 100px;">          
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($value[btype]==$row_sql[area_name]) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
       </td>

    </tr>
    
     <tr  align="center"> 
       <td>Address</td>
       <td><input type="text"  name="address" size="50"  value="<?=$value['address'];?>"></td>
      </tr>

     <tr  align="center"> 
       <td>Area</td>
       <td><input type="text"  name="area" size="50" value="<?=$value['area'];?>"></td>
      </tr>

    
      <tr  align="center"> 
       <td>Mobile:<input type="text"  name="mobile" size="10" maxlength="13" value="<?=$value['mobile'];?>"></td>
       
       <td>T & T:<input type="text"  name="tnt" size="10" value="<?=$value['tnt'];?>"></td>
      </tr>


     <tr  align="center"> 
       <td>TIN:
         <input type="text"  name="tin" size="8" value="<?=$value['tin'];?>">
      </td>
      
      
       <td>Trade Lic:
         <input type="text"  name="trade" size="8" value="<?=$value['trade_lic'];?>"></td>
      </tr>



      <tr  align="center"> 
        <td>Credit Limit:
        <input type="text"  name="limit" size="5" value="<?=$value['climit'];?>"></td>
       </td>
      
        <td>Credit Days:<input type="text"  name="cdays" size="3" maxlength="4" value="<?=$value['cdays'];?>"></td>
       </tr>

     <tr  align="center"> 
        <td>Remarks</td>
        <td><input type="text"  name="remarks" size="50"  value="<?=$value['remarks'];?>"></td>
       </tr>

    <tr align="center">
            <td>SP Name</td>
              <td>
          <?
           
           $query_sql = "SELECT  id,shortname,type  FROM tbl_sp order by id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
        <select name="sp" style="width: 180px;">          
          <option value=""></option>
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value['sp']==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['shortname']?> :: <?php echo $row_sql['type']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>
          
          </td>

   </tr>
   <tr align="center">
     <td>COMPANY</td>
     <td>   
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 250px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($value[com_id]==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
 
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
