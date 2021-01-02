<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
 

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">SP Status Report</td></tr>  
  
    <tr bgcolor="#FFEE09" align="center">    
       <td> Year :
          <select name="year" style="width: 120px;">
           <option value="2012" <?php if($_POST["year"]=='2012') echo "selected";?>>2012</option>
           <option value="2013" <?php if($_POST["year"]=='2013') echo "selected";?>>2013</option>
           <option value="2014" <?php if($_POST["year"]=='2014') echo "selected";?>>2014</option>
           <option value="2015" <?php if($_POST["year"]=='2015') echo "selected";?>>2015</option>
           <option value="2016" <?php if($_POST["year"]=='2016') echo "selected";?>>2016</option>
           <option value="2017" <?php if($_POST["year"]=='2017') echo "selected";?>>2017</option>
          </select>
       </td>
       
       <td> Month :
          <select name="month" style="width: 120px;">
            <option value=""></option>
           <option value="1" <?php if($_POST["month"]=='1') echo "selected";?>>Jan</option>
           <option value="2" <?php if($_POST["month"]=='2') echo "selected";?>>Feb</option>
           <option value="3" <?php if($_POST["month"]=='3') echo "selected";?>>Mar</option>
           <option value="4" <?php if($_POST["month"]=='4') echo "selected";?>>Apr</option>
           <option value="5" <?php if($_POST["month"]=='5') echo "selected";?>>May</option>
           <option value="6" <?php if($_POST["month"]=='6') echo "selected";?>>June</option>
           <option value="7" <?php if($_POST["month"]=='7') echo "selected";?>>July</option>
           <option value="8" <?php if($_POST["month"]=='8') echo "selected";?>>Aug</option>
           <option value="9" <?php if($_POST["month"]=='9') echo "selected";?>>Sep</option>
           <option value="10" <?php if($_POST["month"]=='10') echo "selected";?>>Oct</option>
           <option value="11" <?php if($_POST["month"]=='11') echo "selected";?>>Nov</option>
           <option value="12" <?php if($_POST["month"]=='12') echo "selected";?>>Dec</option>
          </select>
       </td>
       
       <td colspan="1" align="center"><input type="submit" name="submit"  value="&nbsp;&nbsp;&nbsp;View  " /> </td>  
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
   if($_POST[month]!='')
   {
    $con=$con. " and month='$_POST[month]'";
    $monthdiv=1;
    
    $connew=$con;
    $connewnot="where year<=$_POST[year] and month<$_POST[month]";
    
   }
   
   if($_POST[sp]!='')
   {
    $con=$con. " and sp='$_POST[sp]'";
   }
   
   
    $user_query="select tbl_sp.shortname,p.sp, sum(p.totalcust) as totalcust, sum(p.viwst) as stick,
                     sum(p.viwpal) as placement,sum(p.viwqty) as volume,sum(p.viwsal) as salval,sum(p.newout) as nout, 
                     sum(p.tnewout) as tnew,sum(p.tstick) as tst, sum(p.tpalce) as tpal,sum(p.tvolume) as tvol 
                     from
                  (  
                   Select sp,0 as totalcust,count(view_cust_vol_st_place.custid) as viwst,sum(view_cust_vol_st_place.placement) as viwpal, 
                   sum(view_cust_vol_st_place.qty) as viwqty,sum(view_cust_vol_st_place.salval) as viwsal,0 as newout, 
                   0 as tnewout,0 as tstick, 0 as tpalce,0 as tvolume     
                          FROM view_cust_vol_st_place
                   join tbl_customer on tbl_customer.id=view_cust_vol_st_place.custid
                   $con
                   group by  sp
                   union all 
                   select sp, count(id) as totalcust,0 as viwst,0 as viwpal,0 as viwqty,0 as viwsal,0 as newout,
                   0 as tnewout,0 as tstick, 0 as tpalce,0 as tvolume 
                   
                          FROM tbl_customer group by sp
                   union all
                   SELECT sp,0 as totalcust,0 as viwst,0 as viwpal,0 as viwqty,0 as viwsal,count(distinct custid) as newout, 
                   0 as tnewout,0 as tstick, 0 as tpalce,0 as tvolume
                          FROM `view_cust_vol_st_place`
                          join tbl_customer on tbl_customer.id=view_cust_vol_st_place.custid
                          $connew and
                          custid not in (select custid from `view_cust_vol_st_place` $connewnot)
                          group by sp
                   union all
                   SELECT sp,0 as totalcust,0 as viwst,0 as viwpal,0 as viwqty,0 as viwsal,0 as newout,
                          SUM(outlet) as tnewout , SUM(stick) as tstick ,SUM(placement) as tpalce ,SUM(volume) as tvolume  
                          FROM tbl_sp_target $connew 
                          group by sp
                  ) as p

                  join tbl_sp on tbl_sp.id=p.sp
                   group by tbl_sp.id
                    ";   
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);    
      if ($total>0)
      {
    ?>
    <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
     <tr id="trsubhead">
         <td>SP Name</td>
         <td>Total Outlet</td>
         <td colspan="2">New Outlet</td>
         <td colspan="2">Strik Rate (%)</td>
         <td colspan="2">Placement</td>
         <td colspan="3">Sales Value</td>
         <!--<td>Sales Value</td> -->
     </tr>
   
    <tr id="trhead">
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>Target</td>
         <td>Actual</td>
         <td>Target</td>
         <td>Actual</td>
         <td>Target</td>
         <td>Actual</td>
         
         <td>Target</td>
         <td>Actual</td>
         
         <td>%</td>
     </tr>
   
   
    <?
       while($value=mysql_fetch_array($users))
       {
     ?>   
       <tr align="center">
         <td><?=$value[shortname];?></td>
         <td><?=$value[totalcust];?></td>
         <td><?=$value[tnew]/$monthdiv;?></td>
         <td><?=$value[nout]/$monthdiv;?></td>
         <td><?=$value[tst]/$monthdiv;?></td>
         <td><?=number_format((($value[stick]*100)/$value[totalcust])/$monthdiv,0);?></td>
         <td><?=$value[tpal]/$monthdiv;?></td>
         <td><?=$value[placement]/$monthdiv;?></td>
         <td align="right"><?= number_format($value[tvol]/$monthdiv,0);?></td>
         <!--<td><?=number_format($value[volume]/$monthdiv,0);?></td>-->
         <td align="right"><?=number_format($value[salval]/$monthdiv,0);?></td>
         <td>
            <?
              if(($value[tvol]/$monthdiv)>0)
              {
               echo number_format( (($value[salval]/$monthdiv)*100)/($value[tvol]/$monthdiv) ,2)."%";
              }
              else
              {
              echo "-";
              }
            ?>
         
         </td>
         
       </tr>
     <?          
       $gct=$gct+$value[totalcust];
       $nout=$nout+$value[nout];
       $stick=$stick+$value[stick];
       $palcement=$palcement+$value[placement];
       $volume=$volume+$value[volume];
       $salval=$salval+$value[salval];
       
       $tnew=$tnew+$value[tnew];
       $tst=$tst+$value[tst];
       $tpal=$tpal+$value[tpal];
       $tvol=$tvol+$value[tvol];
       
       
       }
      echo "<tr id='trhead'><td>Total</td><td>$gct</td><td>$tnew</td><td>$nout</td>
                            <td>$tst %</td>
                            <td>".number_format((($stick*100)/$gct),0)." %</td>
                            <td>$tpal</td>
                            <td>$palcement</td>
                            <td>".number_format($tvol,0)."</td>
                            <td>".number_format($salval,0)."</td>";
      if($tvol>0)
      {
      echo "<td>".number_format( ($salval*100)/($tvol) ,2)."%</td>";
      }
      else
      {
       echo "<td>-</td>";
      }
                             
      echo "</tr>"; 
       
      echo "</table>";
      }
      else
      {
       echo "<b>No Data Found.</b>";
      }    
 
 }// Submit If
?>


 

<?php
 include "footer.php";
?>

