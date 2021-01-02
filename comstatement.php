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
    $con="where (`dt` between '$con1' and '$con2') and company=$_POST[company]";
   }
  else
   {
    $con="where (`dt` between '$con1' and '$con2')";
   }  
 }
else
 {
  $con1=date("Y-m-d");
  $con2=date("Y-m-d");
  $con="where (`dt` between '$con1' and '$con2')";
 } 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trhead">  
        <td align="left"> 
           Transection Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
            
           To <input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>
        
        
          <td>Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company  where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company" style="width:250px">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>

             
       <td><input type="submit"  name="submit" value="   View  " /> </td>
     </tr>
     <tr>
       <td align="center" colspan="2"><b> Date : <? echo date('d-M-Y', strtotime($con1)); ?></b> To <b>  <? echo date('d-M-Y', strtotime($con2)); ?></b> </td>
       <td>Company: <b><? echo $_POST[company]; ?></b></td> 
     </tr>
     
</table>
</form>

<?
     $totalamount=0;   
     if(($_POST[company]!=='') and (isset($_POST["submit"])))
      {
       $sql="SELECT sum(svalue) as `order`, sum(pvalue) as payments  from view_com_stat_base 
             where  company=$_POST[company] and view_com_stat_base.dt<'$con1'";
       $users = mysql_query($sql);
       $row_sql= mysql_fetch_assoc($users);
       $prebal=$row_sql[order]-$row_sql[payments];
       $_SESSION[prebal]=$prebal;
       $_SESSION[con2]=$con2;
       $_SESSION[custid]=$_POST[company];
       $totalamount=$prebal;
      }

?>


<!-- Order Details -->

 <?
      if($_POST[company]!='')
      {
      $user_query="select * from view_com_stat_base $con
                   order by `dt` asc,porder asc";
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);  
      $_SESSION[printsql]=$user_query; 
      $_SESSION[dt]=$con2; 
      }
      else
      {
       $total=0;
      }
      if ($total>0)
      {
      $bal=0;
      $debit=0;
      $credit=0;
      $total=$totalamount;
      
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="10">Company Statement Of Accounts</td></tr>


 <?
 if($_POST[company]!=='')
  {
   echo "<tr id='trsubhead'><td colspan='5' align='left'> Company Previous Balance :</td><td colspan='5' align='right'>". number_format($prebal,0)."</td></tr>";
  }
 ?>
    



<tr bgcolor="#FFCCAA" align="center">
    <td>Date</td>
    <td>Type</td>
    <td>Ref.No</td>
    <td>Media</td>
    <td>Remarks</td>  
    <td>Rec.Qty</td>
    <td>Amount Payment</td>   
    <td>Credit</td>
    <td>Debit</td>
    <td>Balance</td>
</tr>          
 
 <?
      while($value=mysql_fetch_array($users))
       {
        if($value[porder]==1)
         {
        ?>
         <tr align="center">
            <td><?=$value[dt];?></td>
            <td><?=$value[ttype];?></td>
            <td>
              <a href="pur_view.php?id=<?=$value[refno];?>" target="_blank" title="View Details">
               <?=$value[refno];?>
              </a>
            </td>
            <td><?=$value[media];?></td>
            <td><?=$value[remarks];?></td>
            <td><?=$value[qty];?></td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($value[svalue],2);?></td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($value[svalue]+$totalamount,2);?></td>
         </tr>
        <? 
         $totalcredit=$totalcredit+$value[svalue];
         }
        if($value[porder]==2)
         {
        ?>
         <tr align="center" bgcolor="#FFFFCC">
            <td><?=$value[dt];?></td>
            <td><?=$value[ttype];?></td>
            <td><?=$value[refno];?></td>
            <td><?=$value[media];?></td>
            <td><?=$value[remarks];?></td>
            <td>&nbsp;</td>
            <td><?=number_format($value[rec],2);?></td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($value[pvalue],2);?></td>
            <td align="right"><?=number_format($totalamount-$value[pvalue],2);?></td>
         </tr>
        <? 
         $totaldebit=$totaldebit+$value[pvalue];
         } 
         $totalamount=$totalamount+$value[svalue]-$value[pvalue];     
       }
       
      echo "<tr bgcolor='#FFCC09'><td colspan='7' align='center'><b>Balance As Of Date: ". date('d-M-Y', strtotime($con2))  ." </b></td>
        <td align='right'>".number_format($totalcredit,2) ."</td><td align='right'>".number_format($totaldebit,2)."</td>
        <td colspan='1' align='right'><b>".number_format($totalamount,2)."</b> </td> </tr>";
    echo "<tr><td colspan='12' align='center' bgcolor='#FFCCEE'><a href='printcomstat.php' target='_blank' title='Print Statement'><b>Print</b></a></td></tr>";

   echo "</table>";
    }
  ?>  

 
 
<?php
 include "footer.php";
?>
