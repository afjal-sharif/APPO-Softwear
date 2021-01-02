<?php
 session_start();
 $msgmenu="Company";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[name])) 
   {
    echo " Error !! Pls give input properly";
   }
  else
   {
   $sql="insert into tbl_product_category (g_name,name,user) value( '$_POST[g_name]','$_POST[name]','$_SESSION[userName]')"; 
   db_query($sql) or die(mysql_error());
    echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Category <b>$_POST[name]</b> Name  insert successfully</b>";
   } // Error chech If
 }// Submit If
?>
<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">New Product Category Entry Form</td></tr>  
    
    
    <tr bgcolor="#FFCCAA">    
       <td> Category Name: <input type="text" size="50"  name="name" /> </td>
       
      <td> Group:
       <select name="g_name" style="width: 150px;">
          
            <?
           $query_sql = "SELECT distinct g_name  FROM `tbl_product_category`  order by g_name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['g_name'];?>" <?php if($_POST["g_name"]==$row_sql['g_name']) echo "selected";?> ><?php echo $row_sql['g_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
            
       </select>
   </td>
     </tr>    
     <tr id="trsubhead"><td colspan="8" align="center"><input type="submit" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>

<br>
<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">Display Existing Category Name</td></tr> 

   <tr align="center" bgcolor="#F3F3F3">     
       <td>Group Name</td>
       <td>Category Name</td>
       <td>User</td>
       <td>Edit</td>
      </tr>     
    <?
      $user_query="select * from tbl_product_category order by name";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       
       <tr align="center">
          <td><?=$value[g_name];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[user];?></td>
          
          <td align="center">
           &nbsp;
           
           <A HREF=javascript:void(0) onclick=window.open('editcategory.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Company Info">
           <img src="images/edit.png" height="15px" weight="15px" ></a>
          
          </td>  
       </tr>
       <?
       }
      }
    ?>  
  </tr>
 </table>



<?php
 include "footer.php";
?>

