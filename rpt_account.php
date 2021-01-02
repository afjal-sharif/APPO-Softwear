<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Receive From Customer";
 include "session.php";  
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Delete Account?")
if (answer !=0)
{
window.submit();
}
}	
</script>


<form name="autoad" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;"> 
 <tr id="trhead"><td colspan="3"> View Account Information From Customer & Supplier</td></tr>
 <tr id="trsubhead">
       <!--
       <td>Type:
         <select  id="sec_type" name="sec_type" style="width: 150px;">
             <option value="0" <?php if($_POST['sec_type']==0) echo "selected";?> ><?php echo " Supplier Account "; ?></option>
             <option value="1" <?php if($_POST['sec_type']==1) echo "selected";?> ><?php echo " Customer Account "; ?></option>
         </select>    
        </td>
        -->    
        <td colspan="1" align="center">
          <div id="div_sec_info">
         Supplier: 
          <?
           //$query_sql = "SELECT id,name,address  FROM tbl_company  where status=0 order by name";
           $query_sql="select distinct tbl_sc_account.ref_id as id,name,address from tbl_sc_account
                       join tbl_company on tbl_sc_account.ref_id=tbl_company.id
                       order by name desc ";
           
           
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="ref_id"   id ="ref_id" style="width:350px">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["ref_id"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
        </div>      
        <td><input type="submit"  name="submit"   value=" View Account " /> </td> </tr>
    
    </table>
</form>

<br>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 
 <tr id="trsubhead"><td colspan="6"><? echo ($_POST[sec_type]==0)? "Supplier":"Customer";  ?> Account No </td></tr> 

     <tr id="trhead">    
       <td>Supplier</td>     
       <td>Bank</td>
       <td>Branch</td>
       <td>Acc No</td>
       <td>Remarks</td>
       <td>Action</td>
     </tr>     
    <?
      if(isset($_POST[submit]))
       {
        $con="";
        
        
        if($_POST[ref_id]!=''){$con=" ref_id='$_POST[ref_id]'";}
        if($con!=''){ $con="where $con";}
        $user_query=" select tbl_sc_account.id,tbl_sc_account.ref_id,name,address,account,bank,branch,tbl_sc_account.type,tbl_sc_account.remarks
                   from tbl_sc_account
                   join tbl_company on tbl_sc_account.ref_id=tbl_company.id
                   $con
                   order by ref_id,id desc ";      
       }
       else
       {
         $user_query="select tbl_sc_account.id,name,address,account,bank,branch,tbl_sc_account.type,tbl_sc_account.remarks
                   from tbl_sc_account
                   join tbl_company on tbl_sc_account.ref_id=tbl_company.id
                   where tbl_sc_account.type=0 order by ref_id,id  desc limit 0,10";
      }
       
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
      <tr>
          <td><b><?=$value[name];?></b></td>  
          <td align="center"><?=$value[bank];?></td>
          <td align="center"><?=$value[branch];?></td>
          <td align="center"><?=$value[account];?></td> 
          <td align="center"><?=$value[remarks];?></td>  
          <td align=center>
             <A HREF=javascript:void(0) onclick=window.open('edit_sup_account.php?smsId=<?=$value[id];?>','Accounts','width=680,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Account Info"><img src="images/edit.png" height="15px" width="15px"></a>
             &nbsp;&nbsp;|&nbsp;&nbsp; 
             <a href="indelete.php?id=<?=$value[id];?>&mode=account" onclick="ConfirmChoice(); return false;"><img src="images/inactive.png" height="15px" width="15px"></a>
          </td>              
      </tr>
       <?
       
       }
      }
     // Submit form  
    ?>  
</table>

<?
 include "footer.php";
?>
