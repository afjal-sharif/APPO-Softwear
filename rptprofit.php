<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Profit Withdraw Statements";
 include "session.php";  
 include "header.php";
$con='';
?>



<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="4" align="center"  id="trsubhead"><b>Profit Withdraw Report</b></td></tr>
 <tr>
   <td align="right">From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>

<br>
 <?
 
 if(isset($_POST["view"]))
  {
  $con=" where date between '$_POST[demo11]' and '$_POST[demo12]'";
  }
 else
  {
  $con=" where date between curdate() and curdate()";
  } 
 
 
  $sql="select * from tbl_profit $con order by id desc";
  $users = mysql_query($sql);
  $total = mysql_num_rows($users);    
  if ($total>0)
      {
 ?>
   <table width="80%"  border="1" cellspacing="1"  cellpadding="5" align="center" style="border-collapse:collapse;">
    <tr id="trhead">
       <td>Date</td>
       
       <td>Remarks</td>
       <td>Withdraw Amount</td>
       <td>User</td>
    </tr>
   <?
      $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr align="center">
          <td><?=$value[date]?> </td>
          
          <td><?=$value[remarks]?> </td>
          <td align="right"><?=number_format($value[amount],0);?> </td>
          <td><?=$value[user]?> </td>
       </tr>
       <?
        $totalamount=$totalamount+$value[amount];
       }
       ?>
       <tr>
         <td colspan="4"  id="trsubhead" align="right"> Total Amount: &nbsp; <? echo number_format($totalamount,0);?> Tk.</td>
       </tr> 
   </table>
   <?
   }
   ?>


<?php
 include "footer.php";
?>
