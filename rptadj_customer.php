<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Receive From Customer";
 include "session.php";  
 include "header.php";
?>
<form name="autopay" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="3">Customer Adjustment Report</td></tr>
 <tr id="trsubhead">
     <td colspan="1"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="08" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
            &nbsp;&nbsp;&nbsp;&nbsp;
            To <input type="Text" id="demo12" maxlength="12" size="08" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
     
     </td>     
   
     <td colspan="1">
         Customer: 
            <?
           $query_sql = "SELECT id,name,climit,address  FROM tbl_customer  where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company_name" style="width:300px" id="company_name">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company_name"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select> 
        </td>
     
         <td colspan="1" align="center"><input type="submit"  name="submit" value="   View  " /> </td> </tr>
    </table>
  </form>
  <br>  
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 <!--<tr id="trsubhead"><td colspan="5">&nbsp;</td></tr>-->
 <tr id="trhead"><td colspan="7">Adjutment On Customer Account</td></tr> 

     <tr bgcolor="#FFCCAA">   
       <td>Date</td> 
       <td>Customer</td>
       <td>Type</td>
       <td>Remarks</td>
       <td>Amount Increase</td>
       <td>Discount</td>
       <td>User</td>  
      </tr>     

  
    <?
      if(isset($_POST[submit]))
      {
       $con="Where e.date between '$_POST[demo11]' and '$_POST[demo12]'";
       if($_POST[company_name]!='')
       {
       $con=$con. " and e.cid='$_POST[company_name]'";
       }
       
         $user_query=" select name,e.date, e.type,e.remarks,e.user,e.add_amount,e.dis_amount from ( 
     
                   SELECT date,customerid as cid,'Increase Sales Value' as type, remarks as remarks,user, `adjamount` as add_amount,0 as dis_amount FROM `tbl_sales`
                              where `adjamount`<>0
                   union all
                   SELECT date,`customerid`  as cid, 'Sales Discount' as type ,`remarks`,user, 0 as add_amount,`hcash` as dis_amount FROM `tbl_dir_receive`
                              where `paytype`='Sales Discount'            
                   union all
                   SELECT date,`customerid`  as cid, 'Cash Withdraw' as type ,`remarks`,user, hcash*(-1) as add_amount,0 as dis_amount FROM `tbl_dir_receive`
                              where `paytype`='Cash Withdraw'
                   ) as e
                   join tbl_customer on e.cid=tbl_customer.id
                   $con
                   order by e.date desc limit 0,20";
      }
      else
      {
        $user_query=" select name,e.date, e.type,e.remarks,e.user,e.add_amount,e.dis_amount from ( 
     
                   SELECT date,customerid as cid,'Increase Sales Value' as type, remarks as remarks,user, `adjamount` as add_amount,0 as dis_amount FROM `tbl_sales`
                              where `adjamount`<>0
                   union all
                   SELECT date,`customerid`  as cid, 'Sales Discount' as type ,`remarks`,user, 0 as add_amount,`hcash` as dis_amount FROM `tbl_dir_receive`
                              where `paytype`='Sales Discount'            
                   union all
                   SELECT date,`customerid`  as cid, 'Cash Withdraw' as type ,`remarks`,user, hcash*(-1) as add_amount,0 as dis_amount FROM `tbl_dir_receive`
                              where `paytype`='Cash Withdraw'
                   ) as e
                   join tbl_customer on e.cid=tbl_customer.id
                   order by e.date desc limit 0,20";
      }
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[dotamount]-$value[dopaymnet];
       ?>

      <tr align="center">
          <td><?=$value[date];?></td>
          <td><b><?=$value[name];?></b></td>
          <td><?=$value[type];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[add_amount],2);?></td>
          <td align="right"><?=number_format($value[dis_amount],2);?></td>
          <td><?=$value[user];?></td>
       </tr>
       <?
       $totaladd_amount=$totaladd_amount+$value[add_amount];
       $totaldis_amount=$totaldis_amount+$value[dis_amount];
      }
      ?>
       <tr id="trsubhead"><td colspan="4" > Total Amount : </td>
           <td align="right"><?=number_format($totaladd_amount,2);?></td>
           <td align="right"><?=number_format($totaldis_amount,2);?></td>
           <td>&nbsp;</td>
       </tr>
      <?
     }// Submit form  
    ?>  
 </table>
<?php
 include "footer.php";
?>
