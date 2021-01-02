<?php
 session_start();
 $mnuid=0;
 include "includes/functions.php";
 include "session.php";  
 
 include "header.php";
?>
<?PHP
 $sql="delete from tbl_age_analysis";
 db_query($sql) or die(mysql_error());
 
 $sql="ALTER TABLE `tbl_age_analysis`  AUTO_INCREMENT =1";
 db_query($sql) or die(mysql_error());

 $user_query="SELECT `dt` , `custid` , sum( round( `salesvalue` , 0 ) ) AS sales, sum( round( cash + bank ) ) AS payment
              FROM `view_cust_stat_base` 
              GROUP BY `dt` , `custid` 
              HAVING sum( round( `salesvalue` , 0 ) ) - sum( round( cash + bank ) ) < -1
               OR sum( round( `salesvalue` , 0 ) ) - sum( round( cash + bank ) ) >1
              ORDER BY `custid` , `dt` , `porder` "; // Engineer
 
 
 $users = mysql_query($user_query);
 $total = mysql_num_rows($users);    
 if($total>0)
 {
    while($value=mysql_fetch_array($users))
    {
        $uinsert_query = "INSERT INTO tbl_age_analysis(dt,cid,sales,payment) 
        VALUES ('$value[dt]','$value[custid]','$value[sales]','$value[payment]')";
        db_query($uinsert_query) or die(mysql_error());
        $count=$count+1;
    }
    //echo "<b>Total: ".$count." Record.";
    //echo "<br><b>Please Wait... Calculating Age...</b>";
    $balance=0;
    
    //echo "<br>";
    //echo "<br>";
    
    $sql_cid="select distinct cid from tbl_age_analysis order by cid";
    $users_cid = mysql_query($sql_cid);
    while($value_cid=mysql_fetch_array($users_cid))
    {
          $count=0;   
    
     //echo "<br><b>Processing Customer ID :".$value_cid[cid]."</b>";
    
          $user_sales="select * from tbl_age_analysis where cid=$value_cid[cid] and sales<>0 order by dt,sales desc";
          $users_sales = mysql_query($user_sales);
          while($value_sales=mysql_fetch_array($users_sales))
          {
            //echo $count=$count+1;
            //echo "<br>";
           
            
            $sales_value=$value_sales[sales];
            $balance=$sales_value;
            //echo "<br>";
            $user_payment="select * from tbl_age_analysis where cid=$value_cid[cid] and payment<>0 order by dt,payment desc";
            $user_payment = mysql_query($user_payment);
              
               while($value_payment=mysql_fetch_array($user_payment))
                { 
                 $pay_count=0;
                 $payment_value=$value_payment[payment];
                 //echo "<br>";
                 //echo $pay_count=$pay_count+1;
                  
                 if($payment_value>=$balance)
                  {
                               
                   $sql="update tbl_age_analysis set sales=0 where id=$value_sales[id]";
                   db_query($sql) or die(mysql_error());
                   //echo "<br>";
                   
                   $break_sales=1;
                   
                   $sql="update tbl_age_analysis set payment=(payment-$balance) where id=$value_payment[id]";
                   db_query($sql) or die(mysql_error());
                   //echo "<br>";
                   //echo "<br>Payment  Break</br>";
                   break;
                  }
                 else
                  {
                   $break_sales=1;
                   $sql="update tbl_age_analysis set payment=0 where id=$value_payment[id]";
                   db_query($sql) or die(mysql_error());
                   //echo "<br> ";
                   
                                   
                   $sql="update tbl_age_analysis set sales=(sales-$payment_value) where id=$value_sales[id]";
                   db_query($sql) or die(mysql_error());
                   $balance=$balance-$payment_value;  
                   //echo "<br>";
                   
                  }
                 if($break_sales==0)
                  {
                   break;
                  }   
                }// payment loop
                //echo " Payment Finish";
            // Payment total record count     
          }// Sales While Loop 
      }// customer loop.    
      
      //echo "<br><b><img src='images/active.png' height='30px' width='30px'> Process Complete.</b>";
      
 }// total record count 
 ?>
 
 
 
 
 <table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trhead">  
         <td colspan="5"><b>Age Wise Analysis Report</b></td>
     </tr>
     <form name="age" action="" method="post">
     <tr>
       <td colspan="5" align="center"> 
          Age Days : <input type="text" size="4" name="inactiveday" maxsize='3' value="<?=isset($_POST["inactiveday"])?$_POST["inactiveday"]:0 ?>"  />
          &nbsp;&nbsp;&nbsp;<input type="submit" name="view" value= "  View  "> 
       </td>
     </tr>
     </form>
     <tr id="trsubhead">
       <td>Sl No</td>
       <td>Customer</td>  
       <td>Sales Date</td>
       <td>Amount</td>
       <td>Age</td>
     </tr>
    <?
    if(isset($_POST["view"]))
      {
       $user_query="Select cid,name,address,mobile,dt,sales,DATEDIFF(now(),dt) as age from tbl_age_analysis
                 join tbl_customer on tbl_customer.id=tbl_age_analysis.cid 
                 where sales>0 and DATEDIFF(now(),dt)>=$_POST[inactiveday] order by cid,DATEDIFF(now(),dt) desc";
      }
    else
      {  
       $user_query="Select cid,name,address,mobile,dt,sales,DATEDIFF(now(),dt) as age from tbl_age_analysis
                 join tbl_customer on tbl_customer.id=tbl_age_analysis.cid 
                 where sales>0 order by cid,DATEDIFF(now(),dt) desc";
      }
    $users = mysql_query($user_query);
    $total = mysql_num_rows($users);    
    if ($total>0)
      {
        while($value=mysql_fetch_array($users))
         {
         if($value[age]>=30)
          {
           $bgcolor="#FF0000"; 
          }
         else
          {
          $bgcolor="#FFFFFF";
          }
         if($cust_id==$value[cid])
         {
          echo "<tr>";
          echo "<td>&nbsp;</td><td>&nbsp;</td>";
          echo "<td align=center>$value[dt]</td>";
          echo "<td align=right>". number_format($value[sales],2)."</td>";
          echo "<td align='center' bgcolor='$bgcolor'>$value[age]</td>"; 
          echo "</tr>";
         }
         else
         {
         $count=$count+1;
     ?>
      <tr align="center" bgcolor="#FFCCAA">
        <td><b><?=$count;?></b></td>
        <td colspan="4" align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?=$value[name];?></b>, &nbsp;&nbsp;<?=$value[address];?>,<?=$value[mobile];?></td>
      </tr>
      <tr align="center">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$value[dt];?></td>
        <td align="right"><?=number_format($value[sales],2);?></td>
        <td bgcolor=<? echo $bgcolor;?>><?=$value[age];?></td>
      </tr>
     <?
      }
       $cust_id=$value[cid];
       $totalsales=$totalsales+$value[sales];
      }
      ?>
      <tr id="trsubhead"> 
        <td colspan="3">Total Value: </td>
        <td colspan="2"><?=number_format($totalsales,2);?></td>
      </tr>
      <?
      }
     ?>
</table> 

<?php
 include "footer.php";
?>
