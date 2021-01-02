<?php
 session_start();
 $mnuid="452";
 include "includes/functions.php";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="3">Probition Expensse Report</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td>Expense Probition Head</td> <td>&nbsp;</td></tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           <input type="Text" id="demo11" maxlength="12" size="8" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
           
           &nbsp;&nbsp;&nbsp;
           <input type="Text" id="demo12" maxlength="12" size="8" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>

       <td align="center">
         <?   
           $query_sql = "SELECT  distinct remarks FROM tbl_account_coa 
                               where tbl_account_coa.type=2 and tbl_account_coa.exp_pro=1 order by remarks";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="pay_head"  style="width: 320px;">
           <option value=""></option> 
         <?
             do {  
         ?> 
            <option value="<?php echo $row_sql['remarks'];?> <? if($_POST[pay_head]=="$row_sql[remarks]"){ echo " SELECTED";} ?> "><?php echo $row_sql['remarks']?></option>
            
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
        
         ?>
          </select>        
       </td>
       
       <td>
        <input type="submit"  name="submit" value="  View  " /> </td> </tr>
</table>
</form>

 <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Expense Probition Report</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Acc Code</td>      
       <td>Expense Head</td>
       <td>Source</td>
       <td>Probition</td>
       <td>Payment</td> 
       <td>User</td>
  </tr>     
    <?
      if(isset($_POST["submit"]))
      {
       $con="where tbl_account_coa.date between '$_POST[demo11]' and '$_POST[demo12]'";
       if($_POST[finance_from]!='')
       {
        $con=$con. " and remarks ='$_POST[pay_head]'";
       }
       
       $user_query="Select head_name,tbl_account_coa.date,remarks,deposite ,withdraw,tbl_account_coa.user,exp_source from tbl_account_coa
                    join tbl_coa on ref_id=tbl_coa.id
                    $con order by date desc";
      }
      else
      { 
      $user_query="Select head_name,tbl_account_coa.date,remarks,deposite,withdraw,tbl_account_coa.user,exp_source from tbl_account_coa 
                  join tbl_coa on ref_id=tbl_coa.id
                  where exp_pro=1 order by tbl_account_coa.date desc limit 0,10";
      }
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr align="center">
          <td><?=$value[date];?></td>
          <td><?=$value[head_name];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[exp_source];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td><?=$value[user];?></td>           
       </tr>
       <?
        $totaldeposite=$totaldeposite+$value[deposite];
        $totalwithdraw=$totalwithdraw+$value[withdraw];
       }
       ?>
      <tr id="trsubhead">  
        <td colspan="4"> Total</td>
        <td align="right"><?=number_format($totaldeposite,2);?></td>
        <td align="right"><?=number_format($totalwithdraw,2);?></td>
        <td align="right"><?=number_format($totaldeposite-$totalwithdraw,2);?></td>
      </tr> 
       <?
      }
    ?>  
 </table>
 



<?php
 include "footer.php";
?>
