<?php
 session_start();
 $msgmenu="Expense Head";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add expense category ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[name])) 
   {
    echo " <img src='images/inactive.png' height='15px' width='15px'><b>Error !! Pls give input properly</b>";
   }
  else
   {
   $sql="insert into tbl_expense_cat (type,details,user,expensetype) value('$_POST[name]','$_POST[details]','$_SESSION[userName]','$_POST[category]')"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'>  Success !! Expense Category Insert Successfully</b>";
   } // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3">Add Expense & Cost Head</td></tr>  
    <tr bgcolor="#FFCCAA">    
      <td>Expense Head:
          
          <?
           $query_sql = "SELECT id,name  FROM tbl_expense_main order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="category" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["category"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          
                     
            
            <!--
            <option value="0" <?if($_POST[type]=='0') echo "SeLECTED";?>>Administrative</option>
            <option value="1" <?if($_POST[type]=='1') echo "SeLECTED";?>>Selling & Distribution</option>
            <option value="3" <?if($_POST[type]=='3') echo "SeLECTED";?>>Financial</option>
            <option value="4" <?if($_POST[type]=='4') echo "SeLECTED";?>>Factory Overhead</option>
            <option value="2" <?if($_POST[type]=='2') echo "SeLECTED";?>>Pre-Paid Expense</option>
            -->
            
          </select>
      </td>
      <td> Expense Sub Head: <input type="text" size="30" name="name" /> </td>
      <td> Details (If any):<input type="text"  name="details" value="-" size="30" /> </td>
             
  </tr>
  <tr id="trsubhead"><td colspan="3" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit"  value="   Save  " /> </td> </tr>
</table>
</form>



<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Display Existing Expense List</td><td><a href="addexpense.php">Refresh</a</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>ID</td>
       <td>Expense Head</td>
       <td>Name</td>
       <td>Details</td>
       <td>User</td>
       <?if($_SESSION[userType]=='A')
        {
         echo "<td align='center'>Action</td>";
        }
       ?>
      </tr>     
    <?
      $user_query="select tbl_expense_cat.id,tbl_expense_main.name hname,
                   tbl_expense_cat.type as sname,details,tbl_expense_cat.user  
                   from tbl_expense_cat 
                   join tbl_expense_main on tbl_expense_main.id=tbl_expense_cat.expensetype
                   order by tbl_expense_cat.id desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
        <td><?=$value[id];?></td>
          <td colspan="1"><?=$value[hname];?></td>
          <td><?=$value[sname];?></td>
          <td><?=$value[details];?></td>
          <td><?=$value[user];?></td>
          <td align="center"> 
          <?  
            if($_SESSION[userType]=='A')
             {
              ?>
               <!--<a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=customer" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a>-->
               <A HREF=javascript:void(0) onclick=window.open('editexpense.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Expense Info"><img src="images/edit.png" height="15px" width="15px"></a>
              <?
             }
          ?></td>
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

