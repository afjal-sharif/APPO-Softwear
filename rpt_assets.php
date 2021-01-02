<?php
 session_start();
 $mnuid="507";
 include "includes/functions.php";
 include "session.php";  
 //@checkmenuaccess($mnuid);
 include "header.php";
?>




<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Fixed Assets List</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Assets</td>
       <td>Remarks</td>
       <td>Finance From</td>
       <td>Life Time</td>
       <td>Amount</td> 
       <td>User</td>
  </tr>     
    <?
      $user_query="Select * from tbl_assets_liab where type=4 order by id desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr align="center">
          <td><?=$value[date];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[remarks1];?></td>
          <td><?=$value[financeby];?></td>
          <td><?=$value[lifetime];?></td>
          <td align="right"><?=number_format($value[assets],2);?></td>
          <td><?=$value[user];?></td>           
       </tr>
       <?
        $totalamount=$totalamount+$value[assets];
       }
       echo "<tr id='trhead'><td colspan='7'>Total Amount: <b>".number_format($totalamount,2)."</b></td> </tr>";
      }
    ?>  

 </table>

<?php
 include "footer.php";
?>
