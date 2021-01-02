<?php
 session_start();
 $mnuid=202;
 include "includes/functions.php";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<?
 $id=$_GET[id];
 if ($id=='invoice')
  {
?>
<form name="order" method="get" action="invoice.php" target="_blank">
<tr><td colspan="4" align="center"  id="trhead"><b>Invoice Print</b></td></tr>
 <tr>
   <td align="center">Enter Invoice No:<input type="text" size="8" name="id"  value="<?=$_SESSION[invoice];?>">
       <input type="submit" name="view" value= " Print ">
   </td>
 </tr>
 <?
 }
 elseif ($id=='mr')
  {
  ?>
  <form name="order" method="get" action="mrprint.php" target="_blank">
<tr><td colspan="4" align="center"  id="trhead"><b>Money Receipt Print</b></td></tr>
 <tr>
   <td align="center">Enter Money Receipt No:<input type="text" size="8" name="id"  value="<?=$_SESSION[mrno];?>">
       <input type="submit" name="view" value= " Print ">
   </td>
 </tr>
  
  <?
  }elseif ($id=='challan') 
  {
 ?> 
   <form name="order" method="get" action="challan.php" target="_blank">
<tr><td colspan="4" align="center"  id="trhead"><b>Challan Print</b></td></tr>
 <tr>
   <td align="center">Enter Invoice No:<input type="text" size="8" name="invoice"  value="<?=$_SESSION[invoice];?>">
       <input type="submit" name="view" value= " Print ">
   </td>
 </tr>
  <?
  }elseif ($id=='pur_receive') 
  {
 ?> 
   <form name="order" method="post" action="pur_item.php">
<tr><td colspan="4" align="center"  id="trhead"><b>Receive Purcahse Item</b></td></tr>
 <tr>
   <td align="center">Purchase Ref No:<input type="text" size="8" name="id"  value="<?=$_SESSION[refid];?>">
                                      <input type="hidden" name="view_type" value="1" />  
       <input type="submit" name="view" value= " Receive Item ">
   </td>
 </tr>
 <?
 }
 ?>
 
 
</table>
</form>

<?php
 include "footer.php";
?>
