<?php
 session_start();
 include "includes/functions.php";
 $mnuid="412";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Recieve Payments ?")
if (answer !=0)
{
window.submit();
}
}	

function ConfirmChoiceChk()
{
answer = confirm("Are You Sure To Recieve Check Clear?")
if (answer !=0)
{
window.submit();
}
}	


function PayMethod()
{
 var mtype=eval(document.autoad.paymethod.value);
 if(mtype==1)
  {
  document.autoad.bank.disabled=false; 
  document.autoad.branch.disabled=false; 
  document.autoad.chequeno.disabled=false;  
  document.autoad.demo12.disabled=false;
  document.autoad.chequeno.value="";
  document.autoad.chkreceive.disabled=false;
  document.autoad.depositebank.disabled=false;
  }
 else if(mtype==4)
  {
  document.autoad.bank.disabled=true; 
  document.autoad.branch.disabled=true; 
  document.autoad.chequeno.disabled=false;  
  document.autoad.demo12.disabled=true; 
  document.autoad.chequeno.value="TT/DD";
  document.autoad.chkreceive.disabled=true;
  document.autoad.depositebank.disabled=false;
  }
 else if(mtype==5)
  {
  document.autoad.bank.disabled=true; 
  document.autoad.branch.disabled=true; 
  document.autoad.chequeno.disabled=false;  
  document.autoad.demo12.disabled=true; 
  document.autoad.chequeno.value="On Line";
  document.autoad.chkreceive.disabled=true;
  document.autoad.depositebank.disabled=false;
  } 
 else
  {
  document.autoad.depositebank.disabled=true;
  document.autoad.bank.disabled=true; 
  document.autoad.branch.disabled=true; 
  document.autoad.chequeno.disabled=true;  
  document.autoad.demo12.disabled=true;
  document.autoad.chkreceive.disabled=true;
  }  
}
</script> 




<?

if(isset($_POST["submit"]) and $_SESSION[newflag]==true)
 {
  
  $msg="";
  // cheque method.
 if($_POST[paymethod]==1)
  {  
   
  if (empty($_POST[demo11]) or empty($_POST[bank]) or empty($_POST[mrno]) or empty($_POST[amount]) or empty($_POST[chequeno])or empty($_POST[demo12]) or empty($_POST[mrno]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   { 
      $rembal=$_POST[amount];  
      $bank=$_POST[bank];
      $branch=$_POST[branch];
      $customerid=$_REQUEST[cid];
      $chequeno=$_POST[chequeno];
      $chequedate=$_POST[demo12];
      $remarks=$_POST[remarks];
      $dbank=$_POST[depositebank];
      $_SESSION[mrno]=$_POST[mrno];  
      $discount=$_POST[discount];
          
      $customer=$_REQUEST[cid];
      
      
      
      if($_POST[chkreceive]==on)
       { 
       $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,bank,branch,chequeno,amount,
         cheqdate,depositebank,mrno,remarks,automrno,customerid,paytype,cstatus,cash) 
         value('$_POST[demo11]','$_POST[invoice]',0,$discount,'$_SESSION[userName]',
        '$bank','$branch','$chequeno',$rembal,'$chequedate','$_POST[depositebank]','$_POST[mrno]','$remarks',$_POST[mrno],$customerid,'Cheque','C',$rembal)";     
       db_query($sql) or die(mysql_error());

       $sql="select name from tbl_customer where id=$customerid";
       $users = mysql_query($sql);
       $row_sql= mysql_fetch_assoc($users);
       $name=$row_sql[name];
     
       $remarks="Sales:Cheque Clear from $name ($customerid) $remarks";
       $sql="insert into tbl_bank(date,remarks,deposite,user,type,bank,rec_ref_id)
                 values('$_POST[demo11]','$remarks',$rembal,'$_SESSION[userName]',1,'$_POST[depositebank]','$_POST[mrno]')";
       db_query($sql) or die(mysql_error());  
       $msg= " & Bank Clear Successfully.";
       }
      else
       {  
       $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,bank,branch,chequeno,amount,
         cheqdate,depositebank,mrno,remarks,automrno,customerid,paytype) 
         value('$_POST[demo11]','$_POST[invoice]',0,$discount,'$_SESSION[userName]',
        '$bank','$branch','$chequeno',$rembal,'$chequedate','$_POST[depositebank]','$_POST[mrno]','$remarks',$_POST[mrno],$customerid,'Cheque')";     
       db_query($sql) or die(mysql_error());
       }
        
    echo "<img src='images/active.png' height='15px' width='15px'><b>Payment Adjust Successfully. $msg</b>";
   $_SESSION[newflag]=false;
   } // Error chech If
  }// for Cheque insert
    
 // For Cash payment
 if($_POST[paymethod]==2)
  {  
   
  if (empty($_POST[mrno]) or empty($_POST[amount])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   { 
      $rembal=$_POST[amount]; 
      $amount=$_POST[amount]; 
      $customerid=$_REQUEST[cid];
      $remarks=$_POST[remarks];
      $dbank=$_POST[depositebank];
      $discount=$_POST[discount];
      
      $customer=$_REQUEST[cid];


      
      if (is_numeric($_POST[mrno]))
        {
        $automr=$_POST[mrno];
        }
      else
        {
        $automr=0;
        }  
       
      
      
      $_SESSION[mrno]=$_POST[mrno];  
      $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,depositebank,mrno,remarks,automrno,customerid,cstatus,paytype) 
         value('$_POST[demo11]','$_POST[invoice]',$amount,$discount,'$_SESSION[userName]','$_POST[depositebank]','$_POST[mrno]','$remarks',$automr,$customerid,'C','Cash')";     
      db_query($sql) or die(mysql_error());  
      
      // If Rem Bal has then auto matic go to Advance Paymanes.
     
    $sql="select name from tbl_customer where id=$customer";
    $users = mysql_query($sql);
    $row_sql= mysql_fetch_assoc($users);
    $name=$row_sql[name];
     
   
    $remarks="Sales:Cash from $name ($customer) $remarks";
    $sql="insert into tbl_cash(date,remarks,deposite,user,refid)values('$_POST[demo11]','$remarks',$amount,'$_SESSION[userName]','$_POST[mrno]')";
    db_query($sql) or die(mysql_error());  
    
    echo "<img src='images/active.png' height='15px' width='15px'><b>Customer Payment Cash Receive Successfully. $msg</b>"; 
    $_SESSION[newflag]=false;
   } // Error chech If
  }// for Cash insert


// Incentive Adjustment.
 // For Cash payment
 if($_POST[paymethod]==3)
  {  
   
  if (empty($_POST[mrno]) or empty($_POST[amount])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   { 
     
     $sql="select sum(pay+adjust)-sum(withdraw) as balance from tbl_incentive_pay where customerid=$_POST[cid]";
     $users = mysql_query($sql);
     $row_sql= mysql_fetch_assoc($users);
     $inbalance=$row_sql[balance];
     if($inbalance>0)
     {
     
     if($inbalance>$_POST[amount])
      {
       $rembal=$_POST[amount]; 
       $totalrecamount=$_POST[amount]; 
      }
     else
      {
       $rembal=$inbalance; 
       $totalrecamount=$inbalance; 
      }    
      $customerid=$_REQUEST[cid];
      $remarks="Incentive Adj.".$_POST[remarks];
      $dbank=$_POST[depositebank];
      
      $customer=$_REQUEST[cid];


      
      if (is_numeric($_POST[mrno]))
        {
        $automr=$_POST[mrno];
        }
      else
        {
        $automr=0;
        }  
       
          
        $_SESSION[mrno]=$_POST[mrno];  
        $discount=$_POST[discount];
        
        $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,depositebank,mrno,remarks,automrno,customerid,paytype) 
         value('$_POST[demo11]','$_POST[invoice]',$totalrecamount,$discount,'$_SESSION[userName]','$_POST[depositebank]','$_POST[mrno]','$remarks',$automr,$customerid,'Incentive Adj.')";     
        db_query($sql) or die(mysql_error());  
        
        $remarks="Sales:Incnetive Adjust. MrNo:$_POST[mrno]";
        $sql="insert into tbl_incentive_pay(batch,indate,customerid,withdraw,productid,remarks,user,type)
                values('Adjust','$_POST[demo11]',$_POST[cid],$totalrecamount,'$_POST[invoice]','$remarks','$_SESSION[userName]',2)";
        db_query($sql) or die (mysql_error());  
        echo "<img src='images/active.png' height='15px' width='15px'><b>Customer Incentive Adjust Successfully. $msg</b>"; 
        $_SESSION[newflag]=false;  
     }
     else
     {
      echo "<img src='images/inactive.png' height='15px' width='15px'><b> Sorry !! Customer Have no Incentive Amount</b>";
     }
   
   } // Error chech If
   
  }// for Incenive Adjustments

  
 // paymethod 4,5
 
  if(($_POST[paymethod]==4) or ($_POST[paymethod]==5)) 
  {  
   
  if (empty($_POST[demo11]) or empty($_POST[depositebank]) or empty($_POST[amount]) or empty($_POST[mrno]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pay 4 Pls give input properly</b>";
   }
  else
   { 
    
      $amount=$_POST[amount];  
      $bank=$_POST[bank];
      $branch=$_POST[branch];
      $customerid=$_REQUEST[cid];
      $chequeno=$_POST[chequeno];
      $chequedate=$_POST[demo12];
      $remarks=$_POST[remarks];
      $dbank=$_POST[depositebank];
      $_SESSION[mrno]=$_POST[mrno];  
      $discount=$_POST[discount];
      
      $customer=$_REQUEST[cid];

     
      
        if($_POST[paymethod]==4)
         {
         $remarks="TT/DD. Clear MR :$_POST[mrno] Cheque No: $chequeno";
         $paytype=" TT/DD";
         }
        else
         {
          $remarks="On Line Cash. MR :$_POST[mrno] Cheque No: $chequeno";
          $paytype="OnLine Cash";
         }    
      
        $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,bank,branch,chequeno,amount,cash,cstatus,
         cheqdate,depositebank,mrno,remarks,automrno,customerid,paytype) 
         value('$_POST[demo11]','$_POST[invoice]',0,$discount,'$_SESSION[userName]',
        '$bank','$branch','$chequeno',$amount,$amount,'C','$chequedate','$_POST[depositebank]','$_POST[mrno]','$_POST[remarks]',$_POST[mrno],$customerid,'$paytype')";     
        db_query($sql) or die(mysql_error());  
        
        
        $sql="select name from tbl_customer where id=$customer";
        $users = mysql_query($sql);
        $row_sql= mysql_fetch_assoc($users);
        $name=$row_sql[name];

        
        $remarks="Sales:TT/DD from $name ($customer) $remarks";
        $sql="insert into tbl_bank (date,remarks,deposite,user,type,bank,rec_ref_id) values('$_POST[demo11]','$remarks - $name',$amount,'$_SESSION[userName]',1,'$dbank','$_POST[mrno]')";
        db_query($sql) or die(mysql_error());
        $msg=" & Bank Clear Successfully";   
      }
    echo "<img src='images/active.png' height='15px' width='15px'><b>Payment Receive Successfully. $msg</b>";
   $_SESSION[newflag]=false;
   } // Error chech If
  
   if($_POST[discount]<>0)
    {
      $remarks="Sales:Cash Discount Recieve from $name ($customer)";
      $sql="insert into tbl_cash(date,remarks,deposite,user,type,refid)values('$_POST[demo11]','$remarks',$_POST[discount],'$_SESSION[userName]',2,'$_POST[mrno]')";
      db_query($sql) or die(mysql_error());  
      
      $remarks="Sales:Cash Discount To $name ($customer)";
      $sql="insert into tbl_cash(date,remarks,withdraw,user,expensetype,type,refid,poorexp)values('$_POST[demo11]','$remarks',$_POST[discount],'$_SESSION[userName]',100,1,'$_POST[mrno]',2)";
      db_query($sql) or die(mysql_error());  
      
    }
   
   
 }// Submit If
?>


<?
      $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];
?>

<?
      $user_query="Select (max(mrno)+1)as mrno from tbl_advance";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnoadv=$row_sql[mrno];
?>

<?
  if($newmrnomain>$newmrnoadv)
   {
   $newmrno=$newmrnomain;
   }
  else
   {
   $newmrno=$newmrnoadv;
   } 

?> 



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 
 
 <tr id="trhead"><td colspan="9">Payment Receive From Customer</td></tr>
 <tr id="trsubhead">
             <td colspan="9" align="left">
             <form name="autopay" method="post" action=""  onchange="this.submit()" action="autopaybalcust.php">
            Customer : 
            <?
           //$query_sql = "SELECT id,name,climit,address  FROM tbl_customer where type='Retailer' order by name";
           $query_sql = "SELECT id,name,climit,address,mobile  FROM tbl_customer  where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer" style="width:300px" onchange="htmlData('city.php', 'ch='+this.value)">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']." : ".$row_sql['mobile'] ?> </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
         <input type="submit" name="view" value= "  View  "> 
         </td></tr>
         <!--
         <tr colspan="9" align="left"><td>
            <div id="txtResult">Oustanding:<input name="out" size="80" /></div>        
         </td>         
        </tr>
        -->
             </form>
            
  

 
 <?
 if(isset($_POST["customer"]))
  {
   $custid=$_POST[customer];
  
  $_SESSION[newflag]=true;
  ?>
    <form name="autoad" method="post" action="">
     <tr bgcolor="#FFCCAA">  
         <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo11"  maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>    
        </td>
        <td colspan="2" align="left">Receive Type :
          <select name="paymethod" style="width: 150px;" onchange="PayMethod()">
            <option value="2" <? if($_POST['paymethod']==2) {echo "SELECTED";}?>>Cash Receive</option>
            <option value="4" <? if($_POST['paymethod']==4) {echo "SELECTED";}?>>TT / DD</option>
            <option value="5" <? if($_POST['paymethod']==5) {echo "SELECTED";}?>>On Line Cash</option>
            <option value="1" <? if($_POST['paymethod']==1) {echo "SELECTED";}?>>Cheque Receive</option>
            <option value="3" <? if($_POST['paymethod']==3) {echo "SELECTED";}?>>Incentive Adjust.</option>
          </select>
        </td>
         <td><b>Amount: </b><input type="text" name="amount" value=0 size="12" /></b> </td>
        <td> Discount: </b><input type="text" name="discount" value=0 size="5" /> </td>
        
      </tr>  
     <tr bgcolor="#CCAABB">  
         <td colspan="1" align="left">MR No :<input type="text" name="mrno" value="<?=$newmrno;?>" size= "15"   /> </td>
         <td>Invoice:<input type="text" name="invoice" size="7" /> </td>
         <td colspan="3" align="center">Deposite Bank :
           <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name where isCustomer=0 order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="depositebank"  style="width: 300px;" disabled>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["depositebank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>    
        </td>
       
        
    </tr>

 
     <tr>
      <td colspan="2">Bank Name</td>
      <td>Branch</td>
      <td>Cheque No</td>
      <td>Cheque Date</td>  
     </tr> 
    <tr bgcolor="#CCAABB">  
        <td colspan="2"><input type="text" name="bank" size="30"  DISABLED /> </td>
        <td><input type="text" name="branch" size="20" DISABLED /> </td>
        <td><input type="text" name="chequeno" size="20" DISABLED /> </td>
        <input type="hidden" name="cid" value="<?=$_POST[customer];?>">
         <td colspan="1" align="left"> 
            <input type="Text" id="demo12" maxlength="15" size="15" DISABLED value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> &nbsp;&nbsp;
           <input type="checkbox" name="chkreceive" DISABLED  onclick="ConfirmChoiceChk(); return false;" />Clear    
        </td>
        
    </tr>
    
    <tr bgcolor="#CCAABB">    
          
      <td colspan="5" align="center">Remarks: <input type="text" name="remarks" size="80" /></td>
    </tr>    
         <tr id="trsubhead"><td colspan="5" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Receive  " /> </td> </tr>
    </form>
    </table>

<?php
}
?>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 <tr id="trsubhead"><td colspan="9">&nbsp;</td></tr>
 <tr id="trhead"><td colspan="9">Today Receive Amount</td></tr> 

     <tr bgcolor="#FFCCAA">    
       <td>Customer</td>
       <td>Address</td>
       <td>MR No</td> 
       <td>Receive Type</td> 
       <td>Cash</td>
       <td>Bank</td>
       <td>Cheque No</td>
       <td>Bank Amount</td>
       <td><b>Total Amount</b></td>
      </tr>     

  
    <?
      
      if(isset($_POST["customer"]))
      {
      $user_query="select customerid,tbl_customer.name,type,tbl_customer.address,tbl_customer.mobile,tbl_dir_receive.invoice,
                   paytype,hcash,amount,bank,chequeno,tbl_customer.status,tbl_dir_receive.mrno,
                   tbl_company.name as cname
                   from tbl_dir_receive
                   join tbl_customer on tbl_customer.id=tbl_dir_receive.customerid
                   left join tbl_company on tbl_dir_receive.paycompany=tbl_company.id
                   where tbl_dir_receive.date='$_SESSION[dtcustomer]' and tbl_customer.id=$_POST[customer] order by tbl_dir_receive.id desc";
      
      }
      else
      {
       $user_query="select customerid,tbl_customer.name,type,tbl_customer.address,tbl_customer.mobile,tbl_dir_receive.invoice,
                   paytype,hcash,amount,bank,chequeno,tbl_customer.status,tbl_dir_receive.mrno,  
                   tbl_company.name as cname
                   from tbl_dir_receive
                   join tbl_customer on tbl_customer.id=tbl_dir_receive.customerid
                   left join tbl_company on tbl_dir_receive.paycompany=tbl_company.id
                   where tbl_dir_receive.date='$_SESSION[dtcustomer]' order by tbl_dir_receive.id desc";
      } 
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[dotamount]-$value[dopaymnet];
       ?>
      <tr>
          <td><b><?=$value[name];?></b></td>
          <td><?=$value[address];?></td>
          <td align="center"><?=$value[mrno];?></td>
          <td align="center"><?=$value[paytype];?></td>
          <td align="right"><?=number_format($value[hcash],2);?></td>
          <td align="center"><?=$value[bank];?></td>
          <td align="center"><?=$value[chequeno];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>  
          <td align="right"><b><?=number_format($value[hcash]+$value[amount],2);?></b></td>         
       </tr>
       <?
        $totalamount=$totalamount+$value[hcash]+$value[amount];
       }
       echo "<tr id='trsubhead'><td colspan='5'>Total :</td><td colspan='4' align='right'>". number_format($totalamount,2)."</td></tr>";
      }
      
     // Submit form  
    ?>  
  </tr>

 </table>

<?
 include "footer.php";
?>
