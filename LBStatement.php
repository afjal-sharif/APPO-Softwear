<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[remarks]) or empty($_POST[demo11]) or empty($_POST[demo12]))  
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'> Error !! Pls give input properly";
   }
  else
   {
   
   
      
   
   $msgremarks=$_POST[remarks];  
   if($msgremarks!=='')
    {
      
      $user_query="Select sum(assets-liab) as balance from tbl_assets_liab where remarks='$msgremarks' and date<'$_POST[demo11]'";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
     
      $sql="SELECT * FROM tbl_assets_liab where remarks='$msgremarks' and `date` between '$_POST[demo11]'  and '$_POST[demo12]' ";
      $users = mysql_query($sql) or die(mysql_error());
      //$row_total = mysql_fetch_assoc($sql);
      $total = mysql_num_rows($users); 
      
      $balamount=$balance;
    }
   else
    {
    
    $total=0;
    $balance=0;
    $sql="";
    }       
   } // Error chech If
 }// Submit If
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="4">Select Parameter</td></tr>  
 
 
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
            To
           <input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
        </td>

       <td align="center">
          <?
           $query_sql = "SELECT distinct `name` as remarks FROM `tbl_lb_database` order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           //$totalRows_sql = mysql_num_rows($sql);
         ?>
           Person :<select name="remarks"  style="width: 280px;">
           
         <?
             do {  
         ?> 
            <option value="<?php echo $row_sql['remarks'];?>" <?php if($_POST["remarks"]==$row_sql['remarks']) echo "selected";?> ><?php echo $row_sql['remarks']?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
     
      <td colspan="1" align="left"><input type="submit" name="submit" value="  View " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6" align="left">Lending & Borrwing  :  <b><? echo $msgremarks;?></b> </td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Remarks</td>
       <td align="right">Lending/Payment</td>
       <td align="right">Borrowing/Receive</td> 
       <td align="right">Balance.</td>
       <td align="right">User</td>           
   </tr>     

  
  <tr id="trsubhead">
       <td colspan="2"><b>Previous Balance :</td>
       <td colspan="3"> Tk. <?=number_format($balance,2);?> </b></td> 
       <td>&nbsp;</td>
  </tr>
  
    <?
      
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $balamount=$balamount+($value[assets]-$value[liab]);
       ?>
       <tr>
          <td><?=$value[date];?></td>
          <td><?=$value[cash_bank];?>:<?=$value[remarks1];?></td>
          <td align="right"><?=number_format($value[assets],2);?></td>
          <td align="right"><?=number_format($value[liab],2);?></td>
          <td align="right"><?=number_format($balamount,2);?></td>
          <td align="right"><?=$value[user];?></td>  
             
       </tr>
       <?
       
       }
       ?>
      <tr id="trsubhead">
       <td colspan="2"><b>Balance :</td>
       <td colspan="3"> Tk. <?=number_format($balamount,2);?> </b></td> 
       <td>&nbsp;</td>
  </tr>
       
       <?
      }
      elseif($msgremarks!='')
      {
      ?>
       <tr><td colspan="6"><b>No Data Found Between This Time Frame</b></td></tr>
      <?
      }
      else
      {
       echo"<tr><td colspan='6'><b>No Person Name Select.</b></td></tr>";
      }
    ?>  
  </tr>

 </table>

<?php
 include "footer.php";
?>
