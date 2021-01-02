<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
?>

<?
$concust="";

if(isset($_POST["submit"]))
 {
  $con1=$_POST[demo11];
  $con2=$_POST[demo12];
  
    
  
  $diff = abs(strtotime($con2) - strtotime($con1));
  $days = floor($diff/ (60*60*24));



  //$days=30;
  
  $_SESSION[con]=$con;
  $concust="where tbl_customer.status=0";
  
  if($_POST[customersp]!='')
   {
    $concust=$concust." and tbl_customer.sp='$_POST[customersp]'";
   }  
  if($_POST[company]!='')
   {
    $concust=$concust." and tbl_customer.com_id='$_POST[company]'";
   } 
   
   
 }
else
 {
  $con1=date("Y-m-d");
  $con2=date("Y-m-d");
  $_SESSION[con]=$con;
  $days=1;
 } 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trsubhead">
        <td colspan="1">DATE</td>
        <td>COMPANY</td>
        <td>AREA</td>
        <td>&nbsp;</td>
     </tr>
     <tr id="trsubhead">  
        <td align="center"> 
           <input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
       
           To :<input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>   
        <td>   
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 180px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($cat==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>

        <td align="center"> 
         <?
           $query_sql = "SELECT id,shortname  FROM tbl_sp order by shortname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="customersp" style="width: 180px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customersp"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
    
       <td align="center"><input type="submit"  name="submit" value="   View  " /> </td>
      </tr>            
</table>
</form>


<!-- Order Details -->

 <?
      $user_query="Select name,tbl_customer.address as adrs,tbl_customer.mobile,cid,sum(poutstn) as poutvalue, sum(outstn) as outvalue,sum(sales) as salesvalue from 
                        (
                            SELECT `custid` as cid,sum(`salesvalue`-`cash`-`bank`) as poutstn,0 as outstn,0 as sales FROM `view_cust_stat_base`
                            where `dt`<'$con1'
                            group by `custid`
                            Union All
                            SELECT `custid` as cid,0 as poutstn, sum(`cash`+`bank`) as outstn,sum(`salesvalue`) as sales FROM `view_cust_stat_base`
                            where `dt` between '$con1' and '$con2'
                            group by `custid`
                        ) as e
                        join tbl_customer on e.cid=tbl_customer.id
                        $concust
                        group by cid
                        order by tbl_customer.name";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
 ?>
<table width="960px" align="center" bordercolor="#AAAA00"  bgcolor="#FFFFFF"  border="2" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr id="trhead"><td colspan="8">DSO Report</td></tr>
<tr id="trsubhead">
    <td align="Center" colspan="8" > <b> Date :</b> <? echo $con1; ?> <? echo "& ". $con2; ?></td>
</tr> 

<tr id="trsubhead">
    <td align="center" colspan="1">SL No</td>
    <td align="center" colspan="1">Retailer Name</td>
	<td align="center" colspan="1">Address</td>
    <td align="center" colspan="1">Previous Oustanding</td>
    <td align="center" colspan="1">Sales</td>
    <td align="center" colspan="1">Receive</td>
    <td align="center" colspan="1">Total Oustanding</td>
    <td align="center" colspan="1">DSO</td>
</tr> 


    <?
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
        $tout=$value[poutvalue]+$value[salesvalue]-$value[outvalue];
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td align="Left"><?=$value[name];?></td>		 
		  <td align="Left"><?=$value[adrs];?></td>
          <td align="right"><?=number_format($value[poutvalue],2);?></td>
          <td align="right"><?=number_format($value[salesvalue],2);?></td>
          <td align="right"><?=number_format($value[outvalue],2);?></td>
          <td align="right"><?=number_format($tout,2);?></td>
          <?
           if($value[salesvalue]>0)
           {
            $perdaysales=$value[salesvalue]/$days;
            $dso=number_format($tout/$perdaysales,0);
           }
           else
           {
            $dso='';
           }
          ?>        
          <td><?=$dso?></td>
       </tr>
       <?
        $sumpout=$sumpout+$value[poutvalue];
        $sumsale=$sumsale+$value[salesvalue];
        $sumout=$sumout+$value[outvalue];
        if($days==0){$days=1;}
        if($sumsale==0){$sumsale=1;}
       }
       echo "<tr id='trsubhead' ><td colspan='3'>Total :</td>";
       echo "<td align='right'>". number_format($sumpout,2)."</td>"; 
       echo "<td align='right'>". number_format($sumsale,2)."</td><td align='right'>". number_format($sumout,2)."</td>
             <td align='right'>". number_format($sumpout+$sumsale-$sumout,2)."</td>
             <td align='right'>". number_format(($sumpout+$sumsale-$sumout)/($sumsale/$days),0)."</td>";
       echo "</tr></table>";
      }
    ?>  
 
<?php
 include "footer.php";
?>