<?php
 session_start();
 $msgmenu="Balance Sheet Activity";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<form name="typeform" method="post" action="">
  <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
    <tr align="center" id="trhead">
      <td>Person Type: 
        <?
           $query_sql = "SELECT distinct `tbl_lb_database`.type FROM `tbl_assets_liab` 
                         left join tbl_lb_database on remarks=tbl_lb_database.name 
                         WHERE tbl_assets_liab.`type`<>3 or tbl_assets_liab.`type`<>4  group by `remarks` having sum(`assets`-`liab`)<>0";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="remarks"  style="width: 280px;">
           <option value=""></option>
         <?
             do {  
         ?> 
             <option value="<?php echo $row_sql['type'];?>" <?php if($_POST["remarks"]==$row_sql['type']) echo "selected";?> ><?php echo $row_sql['type']?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
          &nbsp;&nbsp;&nbsp;
        <input type="submit"  name="submit" value="   View  " />
     
    </tr>
  </table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Lending & Borrowing Transaection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Sl No</td>     
       <td>Person</td>
       <td>Type</td>
       <td>Address</td>
       <td>Payment</td>
       <td>Receive</td> 
       <td>Balance</td>
      </tr>     
  
    <?
      if(isset($_POST[submit]))
      {
       $con="";
       if($_POST[remarks]!='') { $con=" and tbl_lb_database.type='$_POST[remarks]'";}
       
       $user_query="SELECT  name,address,mobile,tbl_lb_database.type,sum(`assets`) as assets,sum(`liab`) as lib,`remarks` FROM `tbl_assets_liab`
                  left join tbl_lb_database on tbl_assets_liab.remarks=tbl_lb_database.name
                  where tbl_assets_liab.type in (1,2) $con
                  group by `remarks`
                  having sum(`assets`-`liab`)<>0";
      }
      else
      {
      $user_query="SELECT  name,address,mobile,tbl_lb_database.type,sum(`assets`) as assets,sum(`liab`) as lib,`remarks` FROM `tbl_assets_liab`
                  left join tbl_lb_database on tbl_assets_liab.remarks=tbl_lb_database.name
                  where tbl_assets_liab.type in (1,2)
                  group by `remarks`
                  having sum(`assets`-`liab`)<>0";
      }
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr>
          <td><?=$count;?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[address];?>,<?=$value[mobile];?></td>
          <td align="right"><?=number_format($value[assets],2);?></td>
          <td align="right"><?=number_format($value[lib],2);?></td>
          <td align="right"><?=number_format($value[assets]-$value[lib],2);?></td>
          <!--<td><?=$value[user];?></td> 
          <td align="center">
            <A HREF=javascript:void(0) onclick=window.open('editbalance.php?smsId=<?=$value[id];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Balancesheet Info">
          <img src="images/edit.png" height="15px" weight="15px" ></a>
          </td>        
              -->
       </tr>
       <?
       $totalass=$totalass+$value[assets];
       $totallib=$totallib+$value[lib];
       }
       ?>
       <tr id="trsubhead">
          <td colspan="4">Total</td>
          <td align="right"><?=number_format($totalass,2);?></td>
          <td align="right"><?=number_format($totallib,2);?></td>
          <td align="right"><?=number_format($totalass-$totallib,2);?></td>
          <!--<td>&nbsp;</td> -->
       </tr>
       
       
       <?
      }
    ?>  
  

 </table>

<?php
 include "footer.php";
?>
