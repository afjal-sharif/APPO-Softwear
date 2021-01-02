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
  $con="where (tbl_incentive.`date` between '$con1' and '$con2')";    
 }
else
 {
  $con1=date("Y-m-d");
  $con2=date("Y-m-d");
  $con="where (tbl_incentive.`date` between '$con1' and '$con2')";
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

   <!--
         <td>Type: 
            <?
           $query_sql = "SELECT distinct ttype  FROM tbl_incentive where type=1 order by ttype";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="ttype" style="width:200px">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['ttype'];?>" <?php if($_POST["ttype"]==$row_sql['ttype']) echo "selected";?> ><?php echo $row_sql['ttype']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
         </td>
         
          <td>Company: 
            <?
           $query_sql = "SELECT distinct tbl_incentive.companyid,tbl_company.name  FROM tbl_incentive
                                join tbl_company on tbl_company.id=tbl_incentive.companyid
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
 -->
             
       <td><input type="submit"  name="submit" value="   View  " /> </td>
     </tr>
     <tr>
       <td align="center" colspan="2">  Date :<b> <? echo $con1; ?></b> To <b>  <? echo $con2; ?></b>  </td>
       <!--
       <td align="center">  Type :<b> <? echo $_POST[ttype]; ?></b></td>
       <td colspan="2">Company ID : <b><? echo $_POST[company]; ?></b></td>
       --> 
     </tr>
     
</table>
</form>


<!-- Order Details -->

 <?
      $user_query="Select name,sum(deposite) as deposite,sum(withdraw) as withdraw from tbl_incentive
                   join tbl_company on tbl_incentive.companyid=tbl_company.id
                   $con 
                   group by name
                   order by name asc ";
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
<tr id="trhead"><td colspan="4">Incentive Summary.</td></tr>
<tr bgcolor="#FFCCAA">
    <td align="center">Company</td>    
    <td align="center">Receive</td>
    <td align="center">Adjusted</td>
    <td align="center">Balance</td>
</tr>          
 <?
      while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td align="center"><?=$value[name];?></td>
          
          <td align="center"><?=number_format($value[deposite],2);?></td>
          <td align="center"><?=number_format($value[withdraw],2);?></td>
          <td align="center"><?=number_format($value[deposite]-$value[withdraw],2);?></td>
      <? 
               
        $debit=$debit+$value[deposite];
        $credit=$credit+$value[withdraw];
        $bal=($debit-$credit);
        $totalbal=$bal; 
        }      
      ?>
       </tr>
       <tr id="trsubhead" align="center">
          <td colspan="1">Total </td>
          <td><?=number_format($debit,2);?></td>
          <td><?=number_format($credit,2);?></td>
          <td><?=number_format($totalbal,2);?></td>
       </tr>       
  <?
       
       
       
       
   echo "</table>";
    }
  ?>  

 
 
<?php
 include "footer.php";
?>
