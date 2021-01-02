<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
?>

<?
if(isset($_POST["submit"]))
 {
  $con1=$_POST[demo11];
  $con2=$_POST[demo12];
  
  
  if($_POST[company]!=='')
   {
    $con="where (tbl_incentive_gift.`date` between '$con1' and '$con2') and companyid=$_POST[company]";
   }
  else
   {
    $con="where (tbl_incentive_gift.`date` between '$con1' and '$con2')";
   } 
  
  if($_POST[status]!='')
   {
    $con=$con. " and tbl_incentive_gift.status=$_POST[status]";
   } 
 }
else
 {
  $con1=date("Y-m-d");
  $con2=date("Y-m-d");
  $con="where (tbl_incentive_gift.`date` between '$con1' and '$con2')";
 } 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr bgcolor="#CCAABB" id='trsubhead'>  
        <td align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
            
           To <input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>
         
        <td>Company: 
            <?
           $query_sql = "SELECT distinct tbl_incentive_gift.companyid,tbl_company.name  FROM tbl_incentive_gift
                                join tbl_company on tbl_company.id=tbl_incentive_gift.companyid
                          order by tbl_company.name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company" style="width:200px">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['companyid'];?>" <?php if($_POST["company"]==$row_sql['companyid']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
      </td>
      
       <td>
           Status:
          <select name="status" style="width: 80px;">
             <option value="">All</option>
             <option value="0" <?php if($_POST["status"]=='0') echo "selected";?>>At Hand</option>
             <option value="1" <?php if($_POST["status"]=='1') echo "selected";?>>Disposed</option>
             <option value="2" <?php if($_POST["status"]=='2') echo "selected";?>>Used</option>           
          </select>
       </td>      
       <td><input type="submit"  name="submit" value="   View  " /> </td>
     </tr>
     <tr>
       <td align="center">  Date :<b> <? echo $con1; ?></b> To <b>  <? echo $con2; ?></b>  </td>
       
       <td colspan="3">Company ID : <b><? echo $_POST[company]; ?></b></td> 
     </tr>
     
</table>
</form>


<!-- Order Details -->

 <?
     $user_query="Select tbl_incentive_gift.id,date_format(tbl_incentive_gift.date,'%d-%m-%Y') as dt,name,gift_name,
                   remarks,value,tbl_incentive_gift.user,tbl_incentive_gift.status,dis_value,dis_remarks,dis_date 
                   from tbl_incentive_gift  join tbl_company on tbl_incentive_gift.companyid=tbl_company.id
                   $con
                   order by tbl_incentive_gift.id desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
      $bal=0;
      $debit=0;
      $credit=0;
      $totalbal=0;
      
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="8">Incentive Details.</td></tr>
<tr bgcolor="#FFCCAA">
    <td align="center">Date</td>
    <td align="center">Company</td>    
    <td align="center">Gift Name</td>
    <td align="center">Remarks</td>
    <td align="center">Market Value</td>
    <td align="center">Status</td>
    <td align="center">Disposal Value</td>
    <td align="center">Action</td>
</tr>          
 <?
      while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td align="center"><?=$value[dt];?></td>
          <td align="center"><?=$value[name];?></td>
          <td align="center"><?=$value[gift_name];?></td>
          <td align="center"><?=$value[remarks];?>: <?=$value[dis_date];?> <?=$value[dis_remarks];?></td>
          <td align="right"><?=number_format($value[value],2);?></td>
          <td align="center">
           <?
            if($value[status]==0)
             {
              echo "At Hand";
             }
            elseif($value[status]==1)
             {
             echo "Disposed";
             } 
            else
             {
             echo "Used";
             }  
           ?>
          </td>
          <td align="right"><?=number_format($value[dis_value],2);?></td>
          <td align="center">
              <A HREF=javascript:void(0) onclick=window.open('edit_gift.php?smsId=<?=$value[id];?>','Accounts','width=650,height=500,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Customer Info"><img src="images/edit.png" height="15px" width="15px"></a>
         </td>
      <? 
               
        $debit=$debit+$value[value];
        $credit=$credit+$value[dis_value]; 
        }      
      ?>
       </tr>
       <tr id="trsubhead" align="center">
          <td colspan="2">Total </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=number_format($debit,2);?></td>
          <td colspan="2" align="right"><?=number_format($credit,2);?></td>
          <td>&nbsp;</td>
       </tr>
    
  <?       
   echo "</table>";
    }
  ?>  

 
 
<?php
 include "footer.php";
?>
