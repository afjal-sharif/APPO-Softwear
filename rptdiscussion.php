<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>





<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Discussion Entry With Customer Or Company for Alam</td></tr>  
    <tr bgcolor="#FFCCAA"> 
       <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,address,mobile  FROM tbl_customer where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="customer" style="width: 220px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?>::<?php echo $row_sql['address']?>::<?php echo $row_sql['mobile']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td> 
       <td>
         Company: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="company" style="width: 200px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td>Alarm Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
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
     
     <td colspan="1" align="center"><input type="submit" name="submit"  value="View" /> </td> </tr>
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
       <td>Customer</td>
       <td>Company</td>
       <td>Discussion</td>
       <td>Alarm Date</td>
       <td>Status</td>
       <td>Action</td>
      </tr>     
  <tr>
    <?
     $concustomer=" where tbl_discussion.type=0";
     $concompany=" where tbl_discussion.type=1";
    
     if($_POST[status]!='')
      {
       $concustomer=$concustomer." and acknow=$_POST[status]";
       $concompany=$concompany." and acknow=$_POST[status]";
      }
      
      if($_POST[demo11]!='')
      {
       $concustomer=$concustomer." and alarmdate='$_POST[demo11]'";
       $concompany=$concompany." and alarmdate='$_POST[demo11]'";
      }
      
     
     
     if($_POST[customer]!='')
       {
       $concustomer=$concustomer."  and tbl_discussion.customer=$_POST[customer]";
       $user_query_customer="select tbl_discussion.id, tbl_customer.name as customer,'' as company,tbl_customer.address,discussion,alarmdate,acknow
                    from tbl_discussion 
                    join tbl_customer on tbl_customer.id=tbl_discussion.customer $concustomer order by tbl_discussion.id desc"; 
       $users_customer = mysql_query($user_query_customer);
       $total_customer = mysql_num_rows($users_customer);    
       $total_company=0;
       }
       else
       {
       $user_query_customer="select tbl_discussion.id, tbl_customer.name as customer,'' as company,tbl_customer.address,discussion,alarmdate,acknow
                    from tbl_discussion 
                    join tbl_customer on tbl_customer.id=tbl_discussion.customer $concustomer order by tbl_discussion.id desc"; 
       $users_customer = mysql_query($user_query_customer);
       $total_customer = mysql_num_rows($users_customer); 
       }
       
     if($_POST[company]!='')
       {
       $concompany=$concompany." and tbl_discussion.company=$_POST[company]";
       $user_query_company="select tbl_discussion.id,  tbl_company.name as company,'' as customer,tbl_company.address,discussion,alarmdate,acknow
                    from tbl_discussion 
                    join tbl_company on tbl_company.id=tbl_discussion.company  $concompany order by tbl_discussion.id desc"; 
       $users_company = mysql_query($user_query_company);
       $total_company = mysql_num_rows($users_company);    
       
       $total_customer=0;
       }
       else
       {
       $user_query_company="select tbl_discussion.id, tbl_company.name as company,'' as customer,tbl_company.address,discussion,alarmdate,acknow
                    from tbl_discussion 
                    join tbl_company on tbl_company.id=tbl_discussion.company  $concompany order by tbl_discussion.id desc"; 
       $users_company = mysql_query($user_query_company);
       $total_company = mysql_num_rows($users_company);  
       
       }
    

      
       //echo"<br>";
     
      
      
      if ($total_customer>0)
      {
       while($value=mysql_fetch_array($users_customer))
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
  </tr>
 </table>
<?
}
?>

<?php
 include "footer.php";
?>

