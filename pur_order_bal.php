<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
if(isset($_POST["view"]))
 {
  $con='';
  
  $con="where  (tbl_order.status=0 and tbl_order.qty <>0) and (tbl_order.dtDate between '$_POST[demo11]' and '$_POST[demo12]')";
  
  if ($_POST[company]!='')
   {
   $con=$con." and tbl_order.company=$_POST[company]";
   }
   
   
     $user_query="select tbl_order.dtDate as date,tbl_order.donumber,tbl_order.remarks,tbl_order.qty as oqty,
                   tbl_order.truckno,sum(tbl_receive.qty) as qty,tbl_company.name as company
                   from tbl_order
                   left join tbl_receive on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   $con
                   group by tbl_order.donumber                
                   order by tbl_receive.id desc";


 }
else
 {
   $user_query="select tbl_order.dtDate as date,tbl_order.donumber,tbl_order.remarks,tbl_order.qty as oqty,
                   tbl_order.truckno,sum(tbl_receive.qty) as qty,tbl_company.name as company
                   from tbl_order
                   left join tbl_receive on tbl_receive.donumber=tbl_order.donumber
                   join tbl_company on tbl_order.company=tbl_company.id
                   where tbl_order.status=0 and tbl_order.qty <>0
                   group by tbl_order.donumber
                   order by tbl_order.id desc limit 0,10";
   
 }
?>
<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="3" align="center"  id="trsubhead"><b>Goods Purchase Order Report</b></td></tr>
 <tr id="trhead"><td colspna="1"> Date</td><td>Company</td><td>&nbsp;</td></tr>
 <tr>
   <td><input type="Text" id="demo11" maxlength="15" size="10" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   
    To: 
       <input type="Text" id="demo12" maxlength="15" size="11" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company" style="width:180px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Receive Goods Details.</td></tr> 
 <tr id="trsubhead">    
       <td>Date</td>
       <td>Company</td>
       <td>Ref.No</td>
       <td>Truck No</td>
       <td>Remarks</td>
       <td>Order Qty</td>
       <td>Receive Qty</td>
       <td>Balance Qty</td>
    </tr>     

    <?
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);  
      $totalamount=0;  
      $totalqty=0;
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[company];?></td>
          <td align="center">
             <a href="pur_item.php?id=<?=$value[donumber];?>" title="Click To Receive Item">
               <?=$value[donumber];?>
             </a>
          </td>
          <td><?=$value[truckno];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=$value[oqty];?></td>
          <td align="right"><?=number_format($value[qty],2);?></td>
          <td align="right"><?=number_format($value[oqty]-$value[qty],2);?></td>
       </tr>
       <?
       
       
       $totalamount=$totalamount+$value[goodsvalue];
       $totaloqty=$totaloqty+$value[oqty];
       $totalqty=$totalqty+$value[qty];
       $totaldfcost=$totaldfcost+$value[dfvalue];
       $totallocost=$totallocost+$value[lovalue];
       }
      }
    ?>  
  </tr>
   <tr id="trsubhead">
                      <td colspan="5" align="center">Total Qty :</td>
                      <td align="right"><?=number_format($totaloqty,2);?></td>
                      <td align="right"><?=number_format($totalqty,2);?></td>
                      <td align="right"><?=number_format($totaloqty-$totalqty,2);?></td>
                    
  </tr>
 </table>


<?php
 include "footer.php";
?>
