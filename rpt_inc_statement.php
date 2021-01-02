<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
?>

<form name="myForm" method="post" action="">
<table width="1120px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr bgcolor="#CCAABB" id='trsubhead'>  
        <td align="center">  Year :
         <select name="inyear">
            <option value="2012" <? if(date("Y")=='2012') {echo "SELECTED";} ?>>2012</option>
            <option value="2013" <? if(date("Y")=='2013') {echo "SELECTED";} ?>>2013</option>
            <option value="2014" <? if(date("Y")=='2014') {echo "SELECTED";} ?>>2014</option>
            <option value="2015" <? if(date("Y")=='2015') {echo "SELECTED";} ?>>2015</option>
          </select>
        
      &nbsp;&nbsp;&nbsp;&nbsp;
        
        Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company" style="width:280px">
          <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;           
       <input type="submit"  name="submit" value="   View  " /> </td>
     </tr>
     <tr>
       <td align="center">Year: <b> <? echo $_POST[inyear]; ?></b>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           Group Company: <b> <? echo $_POST[group_name]; ?></b>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          Company ID : <b><? echo $_POST[company]; ?></b></td> 
     </tr>
</table>
</form>




 <?
     if(isset($_POST["submit"]))
      {
       if($_POST[group_name]=='' and $_POST[company]=='')
        {
         echo " <b>Error !! Pls Select A Company Name</b>";
        }
       else
        {
         $con=" where e.yr='$_POST[inyear]'";
         $congr="group by e.yr,convert(e.mon,UNSIGNED INTEGER)";
         if($_POST[group_name]!='')
          {
            $con=$con. " and tbl_company.group_name='$_POST[group_name]'";
            $congr=$congr.",tbl_company.group_name";
            $name="group_name";
          }
         if($_POST[company]!='')
          {
           $con=$con. " and tbl_company.id='$_POST[company]'";
           $congr=$congr.",tbl_company.id";
           $name="name"; 
          }
          
         
         $user_query="select $name as name,e.yr as yr,convert(e.mon,UNSIGNED INTEGER) as mon, sum(e.qty) as qty,sum(e.monin) as monin,sum(e.yrin) as yrin,sum(e.hiin) as hiin from (
                    SELECT `company`,year(tbl_receive.date) as yr,month(tbl_receive.date) as mon,sum(tbl_receive.qty) as qty,0 as monin,0 as yrin,0 as hiin FROM `tbl_order`
                           join tbl_receive on tbl_order.donumber =tbl_receive.donumber
                           group by company,year(tbl_receive.date),month(tbl_receive.date)
                  union all
                    SELECT `companyid` as company, `inyear` as yr ,`inmonth` as mon,0 as qty, sum(`deposite`) as monin,0 as yrin,0 as hiin FROM `tbl_incentive`
                          where `type`=1 and `ttype`='Monthly Incentive'
                          group by `companyid`,`inyear`,`inmonth`
                  union all
                    SELECT `companyid` as company, `inyear` as yr ,`inmonth` as mon,0 as qty,0 as monin, sum(`deposite`) as yrin,0 as hiin FROM `tbl_incentive`
                          where `type`=1 and `ttype`='Yearly Incentive'
                          group by `companyid`,`inyear`,`inmonth`
                 union all
                    SELECT `companyid` as company, `inyear` as yr ,`inmonth` as mon,0 as qty, 0 as monin,0 as yrin, sum(`deposite`) as hiin FROM `tbl_incentive`
                          where `type`=1 and `ttype`='Hidden Incentive'
                          group by `companyid`,`inyear`,`inmonth`
                   ) as e
                   join tbl_company on e.company=tbl_company.id
                   $con
                   $congr 
                   order by convert(mon,UNSIGNED INTEGER) desc";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      }
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
      $totalbal=0;
      
 ?>
    
<table width="1120px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="8">Incentive Statements</td></tr>
<tr bgcolor="#FFCCAA">
    <td align="center">Company Name</td>
    <td align="center">Month</td>
    <td align="center">Sales Qty</td>
    <td align="center">Monthly Incentive</td>    
    <td align="center">Yearly Incentive</td>
    <td align="center">Hidden Incentive</td>
    <td align="center" bgcolor='#FFFFCC'>Total</td>
    <td align="center" bgcolor='#FFFFCC'>Per Bag</td>
</tr>          
 <?
      while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td align="center"><?=$value[name];?></td>
          <td align="center"><?=$value[mon];?></td>
          <td align="right"><?=number_format($value[qty],0);?></td>
          <td align="right"><?=number_format($value[monin],2);?></td>
          <td align="right"><?=number_format($value[yrin],2);?></td>
          <td align="right"><?=number_format($value[hiin],2);?></td>
          <td align="right"  bgcolor='#FFFFCC'><?=number_format($value[monin]+$value[yrin]+$value[hiin],2);?></td>
        <? 
        
        $totalamount=$value[monin]+$value[yrin]+$value[hiin];       
        
        
        $totalqty=$totalqty+$value[qty];
        $debit=$debit+$totalamount;
        $totalmonin=$totalmonin+$value[monin];
        $totalyrin=$totalyrin+$value[yrin];
        $totalhiin=$totalhiin+$value[hiin];
        
        if($value[qty]>0)
        {
         echo "<td align='right'  bgcolor='#FFFFCC'>".number_format($totalamount/$totalqty,2)."</td>";
        }
        else
        {
         echo "<td  bgcolor='#FFFFCC'>&nbsp;</td>";
        }
        
        echo "</tr>"; 
        }      
      ?>
       
       <tr id="trsubhead" align="center">
          <td colspan="2">Total </td>
          <td align='right'><?=number_format($totalqty,0);?></td>
          <td align='right'><?=number_format($totalmonin,2);?></td>
          <td align='right'><?=number_format($totalyrin,2);?></td>
          <td align='right'><?=number_format($totalhiin,2);?></td>
          <td align='right'><?=number_format($debit,2);?></td>
          <td align='right'><? if ($totalqty>0)
                  {
                   echo number_format($debit/$totalqty,2);        
                  }
                 else
                  {
                   echo "&nbsp;";
                  } 
               ?>
          </td>
       </tr>    
  <?
       
       
       
       
   echo "</table>";
    }
  ?>  

 
 
<?php
 include "footer.php";
?>
