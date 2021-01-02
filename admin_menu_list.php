<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 @checkaccess("admin_menu_list.php");
 include "header.php";
?>

<?
if(isset($_POST["submit"]))
 {
    $access=$_POST[whour];
    $userid=$_POST[user];
    //echo $_POST[newuser];
   
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $con= $access[$id]; 
    $uid=$userid[$id];
    if($con=='on')
    {
    $sql="insert into tbl_user_menu(userid,menuid,user)values('$uid','$id','$_SESSION[userName]')";
    db_query($sql);
    //echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! $id Access Given Successfully</b><br>";
    }
    else
    {
    $sql="delete from tbl_user_menu where userid='$uid' and menuid='$id'";
    db_query($sql);
    }
    //echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! $id Access Given Successfully</b><br>";
   }
 }
?>

<form name="order" method="post" action="">
<table width="960px"  align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">    
  <tr id="trsubhead">
       <td colspan="1">
         User Name:
          <?
           $query_sql = "SELECT id,userName,screenName,userType  FROM hbl_users  where status=1 and userName<>'admin' order by userName";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="userid"  style="width: 220px;">
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["userid"]==$row_sql['id']) echo "selected";?> <?php if($uid==$row_sql['id']) echo "selected";?> >
                <?php echo $row_sql['userName']?>::<?php echo $row_sql['screenName']?>::
             </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>   
       <input type="submit" name="viewuser" value= "  View Access  "> </td>
  </tr>
</table>
</form>
<?php
 if((isset($_POST["viewuser"])) or (isset($_POST["submit"])))
 {
   if(isset($_POST["viewuser"]))
    {
    $user=$_POST[userid];
    }
   if(isset($_POST["submit"]))
    {
    $user=$uid;
    }
  
?>
<form name="order" method="post" action="">
<table width="960px"  align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">    
  <?PHP   
     $user_query="SELECT tbl_menu_list.id as id, tbl_menu_list.main,tbl_menu_list.second,tbl_menu_list.third,tbl_menu_list.access,tbl_menu_list.type,e.menuid as menuid
                  from tbl_menu_list 
                  left join 
                   (select tbl_user_menu.menuid,tbl_user_menu.userid
                     from
                     tbl_user_menu where tbl_user_menu.userid='$user') as e
                      on tbl_menu_list.id=e.menuid
                  where tbl_menu_list.id>0 order by tbl_menu_list.id";
     $users = mysql_query($user_query);
     $total = mysql_num_rows($users);    
  ?>
  <? if($total>0) { ?>
      <tr id="trhead">
        <td colspan="7">User Access Menu</td>
      </tr>
      <tr bgcolor="#CCAABB" align="center"> 
         <td>Menu ID</td>  
         <td>Main Menu</td>
         <td>Sub Menu</td>
         <td>Sub Sub Menu</td>
         <td>Type</td>
         <td>New Access</td>
         <td bgcolor="#FFE000">Current Access</td>
       </tr>    
<?PHP
	while($value=mysql_fetch_array($users)){
   if(($value['id']%100)==0)
    {
     $bg="id='trsubhead'";
    }
   else
    {
     $bg="#FFFFFF";
    } 
  ?>
  <tr <?=$bg?>>
  <td><?=$value['id'];?>
  </td>
  <td align="center"><?=$value[main];?>&nbsp;&nbsp;</td>
  <td align="right"><b><?=$value[second];?>&nbsp;&nbsp;</b></td>
  <td align="right"><?=$value[third];?>&nbsp;&nbsp;</td>
  <td align="center"><? 
         if($value[access]==0)
         {
             if($value[type]==0){echo "View";}else{echo "Data Entry";}
         }
          ?>
        &nbsp;&nbsp;
             
  </td>
  
      <?php if($value['access']<>1)
           {
      ?>    
     <?php if($value['id']==$value[menuid])
           {
      ?>    
           <td align="center"> 
            <input name="user[<?=$value[id];?>]" type="hidden" value="<?=$_POST[userid];?>" />
            <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
            <input type="checkbox" CHECKED name="whour[<?=$value[id];?>]" />
           </td>
           <td bgcolor="#FFEACA" align="center"> 
             <img src="images/active.png" height="15px" width="15px"> 
           </td> 
      <?
           }
           else
           {
           ?>
           <td align="center"> 
            <input name="user[<?=$value[id];?>]" type="hidden" value="<?=$_POST[userid];?>" />
            <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
            <input type="checkbox" name="whour[<?=$value[id];?>]" />
           </td>
           <?
            echo "<td bgcolor='#FFEACA' >&nbsp;</td>";
           }
          }
          else
          {
          //echo $_POST[userid];
          echo "<td>&nbsp;</td>";
          echo "<td>&nbsp;</td>";
          }      
      ?>         
   
              
  </tr>

    <?
    }
    }
    ?>       
     <tr id="trsubhead"><td colspan="7" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>
<?php
 }
?>
<?php
 include "footer.php";
?>
