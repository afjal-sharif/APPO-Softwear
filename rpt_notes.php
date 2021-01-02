<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>





<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">View Notes</td></tr>  
    <tr bgcolor="#FFCCAA"> 
       <td>Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
       </td> 
       <td> To<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
       </td> 
        
      <td> 
          Status
         <select name="status"  style="width: 100px;">
              <option value="">All</option>
              <option value="0" <? if($_POST[status]=='0') echo "SELECTED"; ?>>Pending</option>
              <option value="1" <? if($_POST[status]=='1') echo "SELECTED"; ?>>Done</option>             
          </select> 
      </td>
     
     <td colspan="1" align="center"><input type="submit" name="submit"  value="   View   " /> </td> </tr>
</table>
</form>
<br>
<?
if(isset($_POST["submit"]))
 {
?>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Display Existing Discussion</td></tr> 

   <tr bgcolor="#FFCCAA">
       <td>SL No</td>
       <td>Date</td>
       <td>Discussion</td>
       <td>User</td>
       <td>Status</td>
       <td>Action</td>
      </tr>     
  
  
    <?
     
     $con=" where (`date` between '$_POST[demo11]' and '$_POST[demo12]'  and comtype=1 ) ";
    
     if($_POST[status]!='')
      {
       $con=$con." and acknow=$_POST[status]";
      }
       
       $user_query_customer="select *  from tbl_discussion 
                    $con order by tbl_discussion.date desc"; 
       $users_customer = mysql_query($user_query_customer);
       $total_customer = mysql_num_rows($users_customer);    
      if ($total_customer>0)
      {
       $count=1;
       while($value=mysql_fetch_array($users_customer))
       {
       ?>     
       <tr>
          <td><?=$count;?></td>
          <td><?=$value[date];?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[user];?></td>  
          <? if($value[acknow]==0)
                   {
                    echo "<td>Pending</td>";
                    echo "<td>";
                    ?>
                    <A HREF=javascript:void(0) onclick=window.open('editDiscussion.php?smsId=<?=$value[id];?>','Accounts','width=800,height=450,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit WO Requset Info">
                         <img src="images/edit.png" size="20px" width="20px" title="Edit Request"></a></td>
                   <? 
                   }
                 else
                   {echo "<td bgcolor='#ffee09'>Done</td><td>&nbsp;</td>";}
                   
              ;?>
                 
       </tr>
       <?
       $count=$count+1;
       }
      }
      
     
      if ($total_company>0)
      {
       while($value=mysql_fetch_array($users_company))
       {
       ?>     
       <tr>
          <td><?=$value[customer];?></td>
          <td><?=$value[company];?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[alarmdate];?></td>    
          <? if($value[acknow]==0)
                   {
                    echo "<td>Pending</td>";
                    echo "<td>";
                    ?>
                    <A HREF=javascript:void(0) onclick=window.open('editDiscussion.php?smsId=<?=$value[id];?>','Accounts','width=800,height=450,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit WO Requset Info">
                         <img src="images/edit.png" size="20px" width="20px" title="Edit Request"></a></td>
                   <? 
                   }
                 else
                   {echo "<td bgcolor='#ffee09'>Done</td><td>&nbsp;</td>";}
                   
              ;?>
       </tr>
       <?
       }
      }
      
      
      
    ?>  

 </table>
<?
}
?>

<?php
 include "footer.php";
?>

