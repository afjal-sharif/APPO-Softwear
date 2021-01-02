<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Incentive Payable";
 include "session.php";
 include "header.php";
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr><td colspan="5" id="trsubhead">Incnetive Payment</td></tr>
 <tr align="center">
     <td>YEAR</td>
     <td>BATCH</td>
     <td>CUSTOMER</td>
     <td>COMPANY</td>
     <td>&nbsp;</td>
 </tr>
 <tr align="center">
       <td>         
          <select name="year" style="width: 80px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value="" <?php if($_POST["year"]=='') echo "selected";?>>ALL</option>
             <option value="2016" <?php if($_POST["year"]=='2016') echo "selected";?>>2016</option>
             <option value="2017" <?php if($_POST["year"]=='2017') echo "selected";?>>2017</option>
             <option value="2018" <?php if($_POST["year"]=='2018') echo "selected";?>>2018</option>
             <option value="2019" <?php if($_POST["year"]=='2019') echo "selected";?>>2019</option>
             <option value="2020" <?php if($_POST["year"]=='2020') echo "selected";?>>2020</option>
          </select>
       </td>   
       <td>
          <?
           $query_sql = "SELECT distinct batch  FROM tbl_incentive_pay order by batch";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="batch" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['batch'];?>" <?php if($_POST["batch"]==$row_sql['batch']) echo "selected";?> ><?php echo $row_sql['batch']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
     </td>


     <td>
            <?
           $query_sql = "SELECT id,name,address,mobile  FROM tbl_customer  order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer" style="width: 220px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> :: <?php echo $row_sql['address']?>::<?php echo $row_sql['mobile']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
   </td>

   <td>
     <select name="company" style="width: 160px; height: 28px; border-width:1px;border-color:#FF0000;">   
         <option value="">All</option>  
           <?
         $sql="Select id,name from tbl_company where status<>2";

          $sql = mysql_query($sql) or die(mysql_error());
          $row_sql = mysql_fetch_assoc($sql);

             do {  
         ?>
            <option value="<?php echo $row_sql['id'];?>"><?php echo $row_sql['name'] ;?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
  
   </td>

  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>

   <?
    if(isset($_POST["view"]))
     {
  
     $con="where tbl_incentive_pay.type<>5";
  
      if ($_POST[batch]!='')
       {
        $con=$con." and tbl_incentive_pay.batch='$_POST[batch]'";
       }
      if ($_POST[customer]!='')
       {
         $con=$con. " and tbl_incentive_pay.customerid=$_POST[customer]";
       }    
      if ($_POST[company]!='')
       {
         $con=$con. " and tbl_incentive_pay.company=$_POST[company]";
       }
      if ($_POST[year]!='')
       {
         $con=$con. " and substr(tbl_incentive_pay.batch,4)='$_POST[year]'";
       } 
       
  
      $user_query="Select  tbl_incentive_pay.id,tbl_incentive_pay.batch,date_format(tbl_incentive_pay.indate,'%d-%M-%Y') as indate,
                   tbl_incentive_pay.type,date_format(tbl_incentive_pay.date,'%d-%M-%Y') as date,
                   tbl_customer.name as custname,withdraw,tbl_company.name as cname,tbl_incentive_pay.customerid,tbl_incentive_pay.remarks,
                   tbl_incentive_pay.rate,tbl_incentive_pay.qty,tbl_incentive_pay.pay,tbl_incentive_pay.adjust,tbl_incentive_pay.pay from tbl_incentive_pay
                   join tbl_customer on tbl_customer.id=tbl_incentive_pay.customerid                   
                   left join tbl_company on tbl_company.id=tbl_incentive_pay.company
                   $con
                   order by tbl_customer.name";                
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);
      
      $_SESSION[print_incentive_pay]=$user_query;
          
      if ($total>0)
      {
      $bal=0;
      $qty=0;
      $totalbal=0;
      
 ?>
    
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead">
    <td colspan="10"> Incentive Details.</td>
    <td align="center" colspan="2">
          <A HREF=javascript:void(0) onclick=window.open('print_incentive.php','POPUP','width=1000,height=800,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Print"><img src="images/print.png" width="35px" height="35px" ></a>
    </td>
</tr>
<tr bgcolor="#FFCCAA">
    <td align="center">SL</td>
    <td align="center">Batch</td>
    <td align="center">Incentive Date</td>
    <td align="center">Customer Name</td>
    <td align="center">Company</td>
    
    <td align="center">Qty</td>
    <td align="center">Rate</td>   
    <td align="center">Sales Incentive</td>
    <td align="center">Others</td>
    <td align="center">Withdraw</td>
    <td align="center" id="trsubhead">Balcnce</td>
    <td align="center" id="trsubhead">&nbsp;</td>
</tr>          
 <?
      $count=0;
      while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr>
          <td align="center"><?=$count;?></td>
          <td align="center"><?=$value[batch];?></td>
          <td align="center">
             <?
              //echo $value[indate];
              if($value[indate]=='')
                {
                  echo $value[date];
                  
                }
              else
                {
                 echo $value[indate];
                 
                }   
             ?>
               
          
          </td>
          <td align="center"><?=$value[custname];?></td>
          <td align="center"><?=$value[cname];?><?=$value[remarks];?></td>
          
          
          <td align="right"><?=$value[qty];?></td>
          <td align="center"><?=number_format($value[rate],2);?></td>
          <td align="right"><?=number_format($value[pay],2);?></td>
          <td align="right"><?=number_format($value[adjust],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          <td id="trsubhead" align="right"><?=number_format($value[pay]+$value[adjust]-$value[withdraw],2);?></td>
          <td align="center">
          <?if($value[type]!=='2'){?>
          <A HREF=javascript:void(0) onclick=window.open('editincentive.php?smsId=<?=$value[id];?>&type=<?=$value[type];?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Incentive Amount">
          <img src="images/edit.png" height="15px" weight="15px" ></a>
          <?}?>
          </td>
  
      <?         
        $incustname=$value[custname];
        $totalbal=$totalbal+$value[pay]+$value[adjust]-$value[withdraw]; 
        }      
      ?>
       </tr>
       <tr id="trsubhead" align="center">
          <td colspan="4">Total </td>
          <td>&nbsp;</td>
          <td align="right"></td>
          <td>&nbsp;</td>
          <td colspan="3" align="right"><?=number_format($totalbal,2);?></td>
          <td>&nbsp;</td>
       </tr>
       <?
        if(($_POST[batch]=='') and ($_POST[company]=='') and ($_POST[product]=='') and ($_POST[customer]!==''))
        {
         ?>
         <tr><td colspan="11" id="trsubhead">
          
          <A HREF=javascript:void(0) onclick=window.open('inwith.php?bal=<?=$totalbal?>&smsId=<?=$_POST[customer]?>&custname=<?=urlencode($incustname)?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Withdraw Incentive Amount">
          Click Here To  Cash Incentive Withdraw</a>
         </td></tr>
         <?
        if($totalbal>0)
         {?>
         <tr><td colspan="12" id="trsubhead">
          <A HREF=javascript:void(0) onclick=window.open('inadjust.php?bal=<?=$totalbal?>&smsId=<?=$_POST[customer]?>&custname=<?=urlencode($incustname)?>','Accounts','width=600,height=400,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Adjust With Oustanding Amount">
           Adjust With Outsanding </a>
          </td</tr>
         <? 
         }
        
        }
       
       
       ?>
       
       
    </table>
  <?  
    }
    }
  ?>   
<?php
 include "footer.php";
?>
