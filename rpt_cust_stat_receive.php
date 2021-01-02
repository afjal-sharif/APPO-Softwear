<?php
 session_start();
 $mnuid=418;
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 @checkmenuaccess($mnuid);
?>

<?
if(isset($_POST["view"]))
 {
  $con='';
  
  $con="where (tbl_statment_send.pdate between '$_POST[demo11]' and '$_POST[demo12]')";
  
   if ($_POST[customer]!='')
   {
    $con=$con." and tbl_statment_send.cid=$_POST[customer]";
   }
    
   if ($_POST[type]!='')
   {
    $con=$con." and tbl_statment_send.status=$_POST[type]";
   } 
    
     $user_query="select  tbl_statment_send.*,name from tbl_statment_send
                   join tbl_customer on tbl_statment_send.cid=tbl_customer.id
                   $con                 
                   order by tbl_statment_send.id desc";


 }
else
 {
    $user_query="select  tbl_statment_send.*,name from tbl_statment_send
                   join tbl_customer on tbl_statment_send.cid=tbl_customer.id
                   order by tbl_statment_send.id desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="5" align="center"  id="trsubhead"><b>Customer Statement Send Database</b></td></tr>
 <tr align="center">
   <td>Print Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>
         Customer: 
          <?
           $query_sql = "SELECT  distinct cid,name,address
                           FROM tbl_statment_send
                           join tbl_customer on tbl_statment_send.cid=tbl_customer.id
                           order by  name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  style="width: 250px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['cid'];?>" <?php if($_POST["customer"]==$row_sql['cid']) echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['address']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>  
       <td>Type:
          <select name="type" style="width: 100px;">
            <option value="">All</option>
            <option value="0" <?php if($_POST[type]=='0') echo "selected";?>>Not Receive Customer Feedback</option>
            <option value="1" <?php if($_POST[type]=='1') echo "selected";?>>Receive Customer Feedback</option>
            <option value="2" <?php if($_POST[type]=='2') echo "selected";?>>Cancel</option>
          </select>
       </td>   
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Customer Statement Send Database</td></tr> 

   <tr bgcolor="#FFFFCC" align="center">    
       <td>Send Date</td>
       <td>Customer</td>
       <td>Statement Date</td>
       <td>Receive Date</td>
       <td>Remarks</td>
       <td>Status</td>
       <td>Action</td>
    </tr>     
    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
      $cashamount=0;
      $chequeamount=0;
      $discountamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center">
          <td><?=$value[pdate];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[fdate];?> - <?=$value[edate];?> </td>
          <td>
              <? if($value[receive_date]=='0000-00-00')
                  {echo "";}
                 else
                  {echo $value[receive_date];}
              ?>
          </td>
          <td><?=$value[remarks];?></td>
          <td>
              <? if($value[status]=='0')
                  {echo "-";}
                 elseif($value[status]=='1')
                  {echo "<img src='images/active.png' height='15px' width='15px'>";}
                 else
                  {echo "Cancel";}  
              ?>
          </td>      
          <td align="center">
            <?
             if($_SESSION[userType]=='A')
             {
              ?>
               <!--
               <a href="indelete.php?id=<?=$value[id];?>&status=<?=$value[status];?>&mode=customer" title=" Click Here to change status"><img src="images/inactive.png" height="15px" width="15px"> </a>
                &nbsp; | &nbsp; 
                --><A HREF=javascript:void(0) onclick=window.open('editcust_send.php?smsId=<?=$value[id];?>','Accounts','width=600,height=500,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Customer Info"><img src="images/edit.png" height="15px" width="15px"></a>
              <?
             }?>
         </td>
        </tr>
       <?
       }
      }
    ?>  
 </table>


<?php
 include "footer.php";
?>
