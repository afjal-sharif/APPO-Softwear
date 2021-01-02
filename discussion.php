<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Discussion for Alam ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if ((empty($_POST[discussion]) or empty($_POST[demo11])) or (empty($_POST[customer]) and empty($_POST[company]))) 
   {
    echo " <b>Error !! Pls give input properly</b>";
   }
  else
   {
  
      if($_POST[customer]!='')
        {
         $type=0;
         $customer=$_POST[customer];
         $company="0";
         $_SESSION[id]=$customer;
        }
      else
        {
         $type=1;
         $customer="0";
         $company=$_POST[company]; 
         $_SESSION[id]=$company;
                
        }  
        $_SESSION[dtype]=$type;
      
   $sql="insert into tbl_discussion (customer,company,discussion,alarmdate,user,type)
         value($customer,$company,'$_POST[discussion]','$_POST[demo11]','$_SESSION[userName]',$type)"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Discussion insert successfully</b>";
   } // Error chech If
 }// Submit If
?>






<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="3">Discussion Entry With Customer Or Company for Alam</td></tr>  
    <tr bgcolor="#FFCCAA"> 
       <td>
         Customer: 
          <?
           $query_sql = "SELECT id,name,address,mobile  FROM tbl_customer where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="customer" style="width: 250px;">
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
           <select name="company" style="width: 220px;">
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
     </tr>    
     <tr>
       <td colspan="3">
         <textarea name="discussion" rows="10" cols="130"><?echo $_POST[discussion];?></textarea>
       </td>
     </tr>
     
     <tr id="trsubhead"><td colspan="3" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value="   Save  " /> </td> </tr>
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
      </tr>     
  <tr>
    <?
      if($_SESSION[dtype]==0)
       {
        $user_query="select  tbl_customer.name as customer,'' as company,tbl_customer.address,discussion,alarmdate 
                    from tbl_discussion 
                    join tbl_customer on tbl_customer.id=tbl_discussion.customer  and comtype=0 order by tbl_discussion.id desc"; 
       }
      else
       {
        $user_query="select  tbl_company.name as company,'' as customer,tbl_company.address,discussion,alarmdate 
                    from tbl_discussion 
                    join tbl_company on tbl_company.id=tbl_discussion.company and comtype=0 order by tbl_discussion.id desc"; 
       } 
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>     
       <tr>
          <td><?=$value[customer];?></td>
          <td><?=$value[company];?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[alarmdate];?></td>    
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

