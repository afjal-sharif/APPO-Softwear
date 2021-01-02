<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Receive From Customer";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Save This Transection ?")
if (answer !=0)
{
window.submit();
}
}

	
</script> 



<?
if(isset($_POST["submit"]))
 {   
  
  if ( empty($_POST[amount]) or empty($_POST[donumber]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {  
      
     if($_POST[paymethod]==3)
      {
       
       $amount=$_POST[amount];
       $deposite=$_POST[amount];
       $withdraw=0;
       
      $sql="Select adjamount from tbl_receive where donumber='$_POST[donumber]' and adjamount<>0 and product=0";
      $users = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users);
      $adjamount=$row_sql_adj[adjamount];
      if($adjamount<>0)
        {
         $sql="update tbl_receive set adjamount=adjamount+$amount where donumber='$_POST[donumber]' and product=0 and adjamount<>0";
         db_query($sql) or die(mysql_error());
         $msg ="Purchase Value Increase Successfully with DO:$_POST[donumber]";
        }
        else
        {
          $remarks="PV Inc.". $_POST[remarks];
          $sql="insert into tbl_receive (date,donumber,product,qty,user,dfcost,remarks,freeqty,adjamount) 
            value('$_POST[demo11]','$_POST[donumber]','0',0,
                 '$_SESSION[userName]',0,'$remarks',0,$amount)"; 
          db_query($sql) or die(mysql_error());
          $msg ="Purchase Value Increase Successfully with DO:$_POST[donumber]";  
       }
      }
      
     
    elseif($_POST[paymethod]==2)
      {
       $amount=$_POST[amount];
       $withdraw=$_POST[amount];
       $custid=$_POST[customer];
       $deposite=0;
      $sql="Select adjamount from tbl_receive where donumber='$_POST[donumber]' and adjamount<>0 and product=0";
      $users = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users);
      $adjamount=$row_sql_adj[adjamount];
      if($adjamount<>0)
        {
         $sql="update tbl_receive set adjamount=adjamount-$amount where donumber='$_POST[donumber]' and product=0 and adjamount<>0";
         db_query($sql) or die(mysql_error());
         $msg ="Purchase Value Discount Successfully with DO:$_POST[donumber]";
        }
        else
        {              
          $remarks="PV Dec.". $_POST[remarks];
          $sql="insert into tbl_receive (date,donumber,product,qty,user,dfcost,remarks,freeqty,adjamount) 
            value('$_POST[demo11]','$_POST[donumber]','0',0,
                 '$_SESSION[userName]',0,'$remarks',0,$amount*(-1))"; 
          db_query($sql) or die(mysql_error());
          
          $msg ="Purchase Value Discount Successfully with DO:$_POST[donumber]";
       }   
      }  
     echo "<img src='images/active.png' height='15px' width='15px'><b>$msg  $msgcash</b>";   
   } // Error chech If   
 }// Submit If
?>


<?
      $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];
      $newmrno=$newmrnomain;
?>


<form name="autopay" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 
 <tr id="trhead"><td colspan="4">Dircet Transection On Supplier </td></tr>
 <tr id="trsubhead">
    <td colspan="2">
    
            Supplier: 
            <?
           //$query_sql = "SELECT id,name,climit,address  FROM tbl_customer where type='Retailer' order by name";
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
      <td colspan="2" align="center">
            <div id="div_do_number">
            Ref No: 
            <?
           //$query_sql = "SELECT id,name,climit,address  FROM tbl_customer where type='Retailer' order by name";
           $query_sql = "SELECT `dtDate`,`donumber`,`company`,tbl_company.name FROM `tbl_order` 
                          join tbl_company on tbl_company.id=tbl_order.company 
                          where tbl_company.status<>2 
                          order by dtDate desc,donumber desc,name limit 0,30";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="donumber" style="width:250px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['donumber'];?>" <?php if($_POST["donumber"]==$row_sql['donumber']) echo "selected";?> ><?php echo $row_sql['donumber']; ?>::<?php echo $row_sql['name'];?>::<?php echo $row_sql['dtDate']; ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
          </div>
        </td>
  </tr>
 <tr bgcolor="#FFEECC" align="center">  
        <td colspan="2"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="08" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>     
         <input type="hidden" name="mrno" value="<?=$newmrno;?>" size= "12"   />
        <td colspan="2">Type :
          <select name="paymethod" style="width: 250px;" onchange="PayMethod1()">
            <option value="3" <? if($_POST['paymethod']==3) {echo "SELECTED";}?>>Add Purcahse Value ( Increase Credit Amount)</option>
            <option value="2" <? if($_POST['paymethod']==2) {echo "SELECTED";}?>>Purcahse Discount ( Decrease Credit Amount)</option>
          </select>
        </td>
        
      </tr>  
      <tr bgcolor="#FFEECC" align="center">  
       <td colspan="2">Remarks : <input type="text" name="remarks" size="40" /></td>
       <td colspan="2">Amount : <input type="text" name="amount" size="10" /></td>
      </tr>
      <tr id="trsubhead"><td colspan="9" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Adjust  " /> </td> </tr>
    </table>
  </form>
  <br>  
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 <tr id="trsubhead"><td colspan="6">&nbsp;</td></tr>
 <tr id="trhead"><td colspan="6">Others Direct Transection On Supplier</td></tr> 
     <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Supplier</td>
       <td>Ref. No</td>
       <td>Remarks</td>
       <td>Amount</td>
       <td>User</td>  
      </tr>     

  
    <?
      if(isset($_POST[submit]))
      {
       $user_query="select  tbl_company.name,tbl_receive.donumber,tbl_receive.date,tbl_receive.remarks,tbl_receive.adjamount,tbl_receive.user from tbl_receive
                   join tbl_order on tbl_order.donumber=tbl_receive.donumber
                   join tbl_company on tbl_company.id=tbl_order.company
                   where (tbl_receive.adjamount<>0) and (tbl_order.company='$_POST[company_name]' or tbl_receive.donumber='$_POST[donumber]') 
                   order by tbl_receive.date desc  limit 0,10";
      }
      else
      {
      $user_query="select  tbl_company.name,tbl_receive.donumber,tbl_receive.date,tbl_receive.remarks,tbl_receive.adjamount,tbl_receive.user from tbl_receive
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
          <td><?=$value[date];?></td>
          <td><b><?=$value[name];?></b></td>
          <td><?=$value[donumber];?></td>
          
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[adjamount],2);?></td>
          <td><?=$value[user];?></td>
       </tr>
       <?
      }

     }// Submit form  
    ?>  
 </table>
<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
