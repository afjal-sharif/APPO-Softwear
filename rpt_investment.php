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

 <tr id="trhead"><td colspan="4">Others Investment Report</td></tr>  

 <tr id="trsubhead"><td> Date Between</td><td>Finance From</td><td>Deposite To</td> <td>&nbsp;</td></tr>
 <tr bgcolor="#CCAABB" align="center">
    <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="8" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
           &nbsp;&nbsp;&nbsp;     
           <input type="Text" id="demo12" maxlength="12" size="8" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
        </td>
     <td>
        <select name="finance_from"  style="width: 200px;">    
          <option value=""></option>
          <option value="O-:OE" <? if($_POST[finance_from]=='O-:OE'){ echo "SELECTED";} ?>>Owners Equity</option>
         <?
           $query_sql = "SELECT id,head_name from tbl_coa where liabalities=1 order by id desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
             do {
          ?>      
            <option value="L-:<?php echo $row_sql['id'];?>::<?php echo $row_sql['head_name'];?>"  <? if($_POST[finance_from]=="L-:$row_sql[id]::$row_sql[head_name]"){ echo "SELECTED";} ?>  ><?php echo $row_sql['head_name']?></option>     
          <?
                 } while ($row_sql = mysql_fetch_assoc($sql));    
         ?>
          </select>
       </td>     
       <td>
          <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name where isDPS=1  order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="deposite_to"  style="width: 250px;">
            <option value=""></option>
            <option value="C-:CASH" <? if($_POST[deposite_to]=='C-:CASH'){ echo "SELECTED";} ?>>Cash</option> 
         <?
             do {  
         ?> 
            <option value="B-:<?php echo $row_sql['accountcode'];?>" <? if($_POST[deposite_to]=="B-:$row_sql[accountcode]"){ echo "SELECTED";} ?> > <?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
            
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
          
       </td>
       <td><input type="submit"  name="submit" value="   View   " /></td> 
     </tr>    
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Investment Report</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>Date</td>
       <td>Finance From</td>
       <td>Deposite To</td>
       <td>Remarks</td>
       <td>Amount</td> 
       <td>User</td>
  </tr>     
    <?
      if(isset($_POST["submit"]))
      {
       $con="where tbl_investment.date between '$_POST[demo11]' and '$_POST[demo12]'";
       if($_POST[finance_from]!='')
       {
        $con=$con. " and source ='$_POST[finance_from]'";
       }
       if($_POST[deposite_to]!='')
       {
        $con=$con. " and destination ='$_POST[deposite_to]'";
       }
       $user_query="Select * from tbl_investment $con order by date desc";
      }
      else
      { 
      $user_query="Select * from tbl_investment order by id desc limit 0,10";
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
          <td><?=$value[source];?></td>
          <td><?=$value[destination];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[deposite],2);?></td>
          <td><?=$value[user];?></td>           
       </tr>
       <?
        $totaldeposite=$totaldeposite+$value[deposite];
       }
       ?>
      <tr id="trsubhead">  
        <td colspan="4"> Total</td>
        <td align="right"><?=number_format($totaldeposite,2);?></td>
        <td align="right">&nbsp;</td>
      </tr> 
       <?
      }
    ?>   


 </table>
<?php
 include "footer.php";
?>
