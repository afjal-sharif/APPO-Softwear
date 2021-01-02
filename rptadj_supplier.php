<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Receive From Customer";
 include "session.php";  
 include "header.php";
?>
<form name="autopay" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="4">Supplier Adjustment Report</td></tr>
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
         Supplier: 
            <?
           $query_sql = "SELECT id,name,address  FROM tbl_company  where status<>2 order by name";
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
        
        <td> Type : 
          <select name="adj_type" style="width:110px">
            <option value=""></option>
            <option value="tbl_receive.adjamount>0" <? if($_POST[adj_type]=="tbl_receive.adjamount>0") {echo "Selected";}?>> Value Increase </option>
            <option value="tbl_receive.adjamount<0" <? if($_POST[adj_type]=="tbl_receive.adjamount<0") {echo "Selected";}?>> Value Decrease </option>
          </select>
     
         <td colspan="1" align="center"><input type="submit"  name="submit" value="   View  " /> </td> </tr>
    </table>
  </form>
  <br>  
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 <!--<tr id="trsubhead"><td colspan="5">&nbsp;</td></tr>-->
 <tr id="trhead"><td colspan="5">Adjutment On Supplier Account</td></tr> 

     <tr bgcolor="#FFCCAA">   
       <td>Supplier</td>
       <td>Date</td> 
       
       <!--<td>Type</td>-->
     
       <td>Remarks</td>
       <td>Amount</td>
       <td>User</td>  
      </tr>     

  
    <?
      if(isset($_POST[submit]))
      {
       $con=" tbl_receive.date between '$_POST[demo11]' and '$_POST[demo12]'";
       if($_POST[company_name]!='')
       {
       $con=$con. " and tbl_order.company='$_POST[company_name]'";
       }
       if($_POST[adj_type]!='')
       {
       $con=$con. " and $_POST[adj_type]";
       }
       
       $user_query="select  tbl_company.name,tbl_receive.date,tbl_receive.remarks,tbl_receive.adjamount,tbl_receive.user from tbl_receive
                   join tbl_order on tbl_order.donumber=tbl_receive.donumber
                   join tbl_company on tbl_company.id=tbl_order.company
                   where (tbl_receive.adjamount<>0) and $con order by tbl_receive.date desc";
      }
      else
      {
      $user_query="select  tbl_company.name,tbl_receive.date,tbl_receive.remarks,tbl_receive.adjamount,tbl_receive.user from tbl_receive
                   join tbl_order on tbl_order.donumber=tbl_receive.donumber
                   join tbl_company on tbl_company.id=tbl_order.company
                   where tbl_receive.adjamount<>0  order by tbl_receive.date desc  limit 0,10";
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
          <td><b><?=$value[name];?></b></td>
          <!--<td>Purchase Adjust</td>-->
          <td><?=$value[date];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[adjamount],2);?></td>
          <td><?=$value[user];?></td>
       </tr>
       <?
       $totalamount=$totalamount+$value[adjamount];
      }
      ?>
       <tr><td colspan="5" id="trsubhead"> Total Amount : <?=number_format($totalamount,2); ?></td></tr>
      <?
     }// Submit form  
    ?>  
  </tr>
 </table>

<?php
 include "footer.php";
?>
