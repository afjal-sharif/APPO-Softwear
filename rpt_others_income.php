<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Others Income";
 include "session.php";  
 include "header.php";
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">Others Income Report.</td></tr>  
 <tr bgcolor="#CCAABB">  
  
  <td>From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>
          <?
           $query_sql = "SELECT id,name  FROM tbl_income_head order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="income_head" style="width: 220px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST[income_head]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          
          </select>
         </td> 
        <td><input type="submit" name="view" value= "  View  "> </td>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display </td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Income Head</td>
       <td>Remarks</td>
       <td>Deposite To</td>
       <td>Amount</td>
       <td>User</td>
  </tr>     
  <?

    if(isset($_POST["view"]))
     {
      $con="where e.type=5 and e.date between '$_POST[demo11]' and '$_POST[demo12]'";
      if($_POST[income_head]!='')
      {
       $con=$con ." and e.income_id=$_POST[income_head]";
      }
      $user_query="select e.id,e.date,e.stype,e.remarks,e.type,e.income_id,e.deposite,e.name,e.user from (
                         Select tbl_cash.id,'Cash' as stype,tbl_cash.type,tbl_cash.income_id,tbl_cash.date,tbl_cash.remarks,deposite,tbl_cash.user,name 
                         from tbl_cash join tbl_income_head on tbl_cash.income_id=tbl_income_head.id where type=5
                          union all Select tbl_bank.id,bank as stype,tbl_bank.type,tbl_bank.income_id, tbl_bank.date,tbl_bank.remarks,deposite,tbl_bank.user,name 
                          from tbl_bank join tbl_income_head on tbl_bank.income_id=tbl_income_head.id where type=5 ) 
                          as e
                          $con
                          order by e.date";
     
     }
    else
     {     
      $user_query="select e.id,e.date,e.stype,e.remarks,e.deposite,e.name,e.user from (
                         Select tbl_cash.id,'Cash' as stype,tbl_cash.date,tbl_cash.remarks,deposite,tbl_cash.user,name 
                         from tbl_cash join tbl_income_head on tbl_cash.income_id=tbl_income_head.id where type=5
                          union all Select tbl_bank.id,bank as stype,tbl_bank.date,tbl_bank.remarks,deposite,tbl_bank.user,name 
                          from tbl_bank join tbl_income_head on tbl_bank.income_id=tbl_income_head.id where type=5 ) 
                          as e
                          order by e.date limit 0,10";
      }
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[stype];?></td>
          <td><?=number_format($value[deposite],2);?></td>
          <td><?=$value[user];?></td>        
       </tr>
       <?
       $totalamount=$totalamount+$value[deposite];
       }
       echo "<tr id='trhead'><td colspan='6'>Total Amount : <b>".number_format($totalamount,2)."</b></td></tr>";
      }
    ?>  
  </tr>

 </table>

<?php
 include "footer.php";
?>
