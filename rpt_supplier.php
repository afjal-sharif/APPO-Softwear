<?php
 session_start();
 $msgmenu="Company";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>


<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="2">View Existing Supplier List</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td colspan="1"> Name: <input type="text"  name="name"  size="30"  value="<? if($_POST[view]){ echo $_POST[name];}  ?>" />&nbsp;&nbsp;
         <input type="submit" name="view" value= "  View  "> 
       </td> 
  </tr>
 </table>
</form>


<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Existing Company Name</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Name</td>
       <td>Address</td>
       <td>Contact person</td> 
       <td>Mobile</td>
       <td>T & T </td>
       <td>E-Mail</td>
       <!--
       <td>Company Credit Days</td>
       <td>Customer Credit Days</td>
       -->
       <td>Edit</td>
  </tr>     
    <?
      if(isset($_POST["view"]))
      {
        $con='';
        if($_POST[name]!='')
         {
          $con=" name like '%$_POST[name]%'";
         }
        $user_query="select * from tbl_company where status=0 and $con order by name";   
      }else
      {  
      $user_query="select * from tbl_company where status=0 order by name"; 
      }
       //$user_query="SELECT * FROM `tbl_company` order by id desc limit 0,2";
       $users = mysql_query($user_query);
       //$var1=mysql_result($users,0,0);
       //echo $var1;
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       
       <tr>
          <td  align="center"><b><?=$value[name];?></b></td>
          <td><?=$value[address];?></td>
          <td><?=$value[person];?></td>
          <td><?=$value[mobile];?></td>
          <td><?=$value[tnt];?></td>
          <td><?=$value[email];?></td> 
          <!--
          <td><?=$value[creditday];?></td>  
          <td><?=$value[custday];?></td>
          -->  
          <td align="center"><A HREF=javascript:void(0) onclick=window.open('editcompany.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Company Info">
          <img src="images/edit.png" height="15px" weight="15px" ></a></td>  
       </tr>
       <?
       }
      }
    ?>  
 </table>
<?php
 include "footer.php";
?>

