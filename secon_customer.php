<?php
 session_start();
 $mnuid=408;
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 ?>
<link href="test.css" rel="stylesheet" type="text/css" />
<script src="./js/code_regen.js"></script> 
<script language="JavaScript">
function ConfirmAdd()
{
answer = confirm("Are You Sure To Add Data ?")
if (answer !=0)
{
window.submit();
}
}	



function validate_pro(thisform)
{
with (thisform)
  {
  if (validate_required(name,"Error On Name Field!")==false){name.focus();return false;}
  if (validate_required(customer,"Error On Parent Customer Name Field!")==false){customer.focus();return false;}
  if (validate_required(mobile,"Error On Mobile Field!")==false){mobile.focus();return false;}  
  }
}

function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {alert(alerttxt);return false;}
  }
}
</script>


<?php
 if(isset($_POST['Submit'])) 
 {	
 	$sql="insert into tbl_secondary_customer (cid,name,address,mobile,c_type,remarks,user)
         value('$_POST[customer]', '$_POST[name]','$_POST[address]','$_POST[mobile]','$_POST[type]','$_POST[remarks]','$_SESSION[userName]')"; 
 	
  db_query($sql) or die(mysql_error());	
 	
  echo "<img src=images/active.png width=25 height=25 alt='Success'><b>Secondary Customer Information Insert Successfully!</b><br>";
 	$flag=true;
 }
 
?>
 <!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
 <form name="newad" method="post" enctype="multipart/form-data"  action="" onsubmit="return validate_pro(this)">
 
 <table align="center" width="90%" style="Border-collapse:Collapse" border="1" bgcolor="#FFFFFF" bordercolor="#EEFFCC"  cellspacing="5" cellpadding="5">
  <tr bgcolor="#FFCCEE" id="trhead" height="20px">
     <td colspan="2" align="center">New Secondary Customer Information.</td>  
  </tr>
  
  <tr>
     <td colspan="1">Parent Customer:* </td>
       <td>
          <?
           $query_sql = "SELECT id,name,climit,address,type  FROM tbl_customer  where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer" style="width:278px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']." : ".$row_sql['type'] ?> </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
     </td>
  </tr>
  <tr align="left"><td>Name of the Customer:*</td>
      <td>
       <input type="text" name="name" value="" size="40"  />
        
       </td>
  </tr>
 
 
  
  <tr align="left"><td>Address:</td>
      <td><textarea name="address" rows="3" cols="80">-</textarea></td>
  </tr>
 
  <tr align="left"><td>Type:*</td>
     <td>
       
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=2 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="type" style="width: 220px;">          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["type"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
  </tr>  
    
  
  <tr align="left"><td>Mobile:*</td>
     <td><input type="text" name="mobile" value="01" size="12"  /></td>
  </tr>  
  
  
   
  <tr align="left"><td align="left">Remarks</td>
     <td><input type="text" size="60" name="remarks"></td></tr>
     
 	
  <tr id="trsubhead"><td align="center" colspan="2"><input name="Submit" type="submit"  onclick="ConfirmAdd(); return false;"  value="Save Information"></td></tr>
 </table>	
 </form> 
 
 
  <table align="center" width="90%" style="Border-collapse:Collapse" border="1" bgcolor="#FFFFFF" bordercolor="#EEFFCC"  cellspacing="5" cellpadding="5">
    <tr id="trsubhead"><td colspan="7">Exisiting Secondary Customer List</td></tr>
    
    <?
      if(isset($_POST['Submit'])) 
       {
        $user_query="select tbl_secondary_customer.name as sname,tbl_secondary_customer.address,tbl_secondary_customer.id, 
                     tbl_secondary_customer.mobile,tbl_customer.name as pname,
                     tbl_secondary_customer.c_type as type,tbl_secondary_customer.remarks as remarks
                     from tbl_secondary_customer
                     join tbl_customer on tbl_secondary_customer.cid=tbl_customer.id  
                     where tbl_secondary_customer.cid='$_POST[customer]' order by id desc ";
       }
      else
       {
        $user_query="select tbl_secondary_customer.name as sname,tbl_secondary_customer.address,tbl_secondary_customer.id,
                     tbl_secondary_customer.mobile,tbl_customer.name as pname,
                     tbl_secondary_customer.c_type as type,tbl_secondary_customer.remarks as remarks
                     from tbl_secondary_customer
                     join tbl_customer on tbl_secondary_customer.cid=tbl_customer.id order by id desc limit 0,10"; 
       } 	
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       echo "<tr id='trhead'><td>SL No</td><td>Parent Customer</td><td>Customer Name</td><td>Type</td><td>Address</td><td>Mobile</td><td>Remarks</td></tr>";
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
        <tr align="center">
          <td><?=$count;?></td>
          <td><?=$value[pname];?></td>
          <td><?=$value[sname];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[address];?></td>
          <td><?=$value[mobile];?></td>
          <td><?=$value[remarks];?></td>
        </tr>
        
       <?
        
       }
      } 
    
    ?>
    

  </table> 
 
 <?
 
  include "footer.php";
?>
