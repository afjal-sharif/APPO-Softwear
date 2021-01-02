<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
 

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Sales & Collection Report</td></tr>  
  
    <tr bgcolor="#FFEE09" align="center">    
       <td> Year :
          <select name="year" style="width: 120px;">
           <option value="2013" <?php if($_POST["year"]=='2013') echo "selected";?>>2013</option>
           <option value="2014" <?php if($_POST["year"]=='2014') echo "selected";?>>2014</option>
           <option value="2015" <?php if($_POST["year"]=='2015') echo "selected";?>>2015</option>
           <option value="2016" <?php if($_POST["year"]=='2016') echo "selected";?>>2016</option>
          </select>
       &nbsp;
       <input type="submit" name="submit"  value="&nbsp;&nbsp;&nbsp;View  " /> </td>  
    </tr>
</table>
</form>

<?
if(isset($_POST["submit"]))
 { 
   
   $monthdiv=1;
   $con="where year='$_POST[year]'";
   $connew=$con;
   $connewnot="where year<$_POST[year]";
   
    $user_query="select sum(cash+bank) as collection, sum(salesvalue) as sales from view_cust_stat_base where year(dt)<$_POST[year]";
    $users = mysql_query($user_query);
    $row_sql_adj= mysql_fetch_assoc($users);
    $collection=$row_sql_adj[collection];
    $sales=$row_sql_adj[sales];  
    $openbal=$sales-$collection;
    
   
    $user_query="select year(dt) as year,month(dt) as month,sum(cash+bank) as collection, sum(salesvalue) as sales from view_cust_stat_base 
                 where year(dt)=$_POST[year]
                 GROUP BY YEAR(dt),month(dt)
                 order by month(dt)";
       
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);    
      if ($total>0)
      {
    ?>
    <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
     <tr id="trsubhead">
         <td>Year</td>
         <td>Month</td>
         <td colspan="1">Sales Value</td>
         <td colspan="1">Collection</td>
         <td colspan="1">Balance</td>
         <td colspan="1">Cumulative Oustanding</td>
         <td> % </td>
     </tr>   
     <tr align="right">
        <td colspan='5'>Openning Balance: &nbsp;&nbsp;&nbsp;</td>
         <td align="right"><?=number_format($sales-$collection,2);?> &nbsp;</td>
         <td>&nbsp;</td>
     </tr>
    <?
       while($value=mysql_fetch_array($users))
       {
     ?>   
       <tr align="center">
         <td><?=$value[year];?></td>
         <td><?=$value[month];?></td>
         <td align="right"><?=number_format($value[sales],0);?></td>
         <td align="right"><?=number_format($value[collection],0);?></td>
         <td align="right"><?=number_format($value[sales]-$value[collection],0);?></td>
         <?
         $openbal1=$openbal;
         if($openbal1==0){$openbal1=1;}
         
         $openbal=$openbal+$value[sales]-$value[collection];
         echo "<td align='right'>".number_format($openbal,2)."&nbsp;&nbsp;</td>";
         ?>
         <td align="right">
            <? echo number_format((($openbal-$openbal1)*100)/$openbal1,2) ?> %
         &nbsp;&nbsp; </td>
       </tr>
     <?          
       $tsal=$tsal+$value[sales];
       $tcol=$tcol+$value[collection];
       //$openbal=$openbal+$value[sales]-$value[collection];
       }
      echo "<tr id='trsubhead' ><td colspan='2'>Total</td>
                            <td align='right'>".number_format($tsal,2)."</td>
                            <td align='right'>".number_format($tcol,2)." </td>
                            <td>&nbsp;</td>
                            <td align='right'>".number_format($openbal,2)."&nbsp;&nbsp;</td>
                            <td>&nbsp;</td></tr></table>";
                            
     }  
 }
?>

<?php
 include "footer.php";
?>

