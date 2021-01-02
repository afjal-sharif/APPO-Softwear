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
answer = confirm("Are You Sure To Recieve Payments ?")
if (answer !=0)
{
window.submit();
}
}


function Total()
{
qty=eval(document.autoad.paymethod.value);


if (qty>1)
{
 document.autoad.cash.disabled=false; 
}
else
{ 
 document.autoad.cash.disabled=true; 
}
}

	
</script> 



<?
if(isset($_POST["submit"]))
 {   
  if (empty($_POST[mrno]) or empty($_POST[amount]) or !(is_numeric($_POST[amount])) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   { 
     if($_POST[paymethod]==3) // Increase Sales Amount
      {
       $amount=$_POST[amount];
       $deposite=$_POST[amount];
       $withdraw=0;
       $remarks="Add Sales Amount (Add Amount) ". $_POST[remarks];
 
        
      $sqlinvoice="Select ifnull((max(id)+1),1) as newinvoice from tbl_sales";
      $users = mysql_query($sqlinvoice);
      $row_sql= mysql_fetch_assoc($users);
      $newinvoice=$row_sql[newinvoice];
      
      $sql="insert into tbl_sales (date,donumber,invoice,rate,qty,comission,user,customerid,factor,unit,df,truckno,soid,remarks,customername,autoinvoice,loadcost,otherscost,coldate,freeqty,sp,adjamount) 
        value('$_POST[demo11]','$newinvoice-$_POST[cust]','$newinvoice-$_POST[cust]',0,0,0,
             '$_SESSION[userName]',$_POST[cust],1,'',0,'Adjust','','$remarks','',0,0,0,'',0,'-',$_POST[amount])"; 
      db_query($sql) or die(mysql_error());
     
      $msg ="Add Credit Amount Successfully.";  
     
     if($_POST[cash]==on)
      {
       $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,mrno,remarks,automrno,customerid,paytype) 
             value('$_POST[demo11]','$newinvoice',$amount,0,'$_SESSION[userName]','$automr','$remarks','$automr',$_POST[cust],'Add Sales Adjust Receive')";      
       db_query($sql) or die(mysql_error());           
 
 
       $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
             value('$_POST[demo11]','$remarks',$amount,0,$amount,'$_SESSION[userName]')";
       db_query($sql) or die (mysql_error());     
       $msg =$msg. " & Cash Receive Successfully.";  
      }
                 
      }
    elseif($_POST[paymethod]==2) // Sales Discount
      {
       $amount=$_POST[amount];
       $withdraw=$_POST[amount];
       $deposite=0;
       $remarks="Discount Sales Amount (Less Credit Amount)". $_POST[remarks].$_POST[cust];
       //$sql="insert into tbl_advance (customername,customer,amount,bcamount,status,type,ttype,user,mrno,remarks,automrno) 
       //  value('$_POST[cust]',$_POST[cust],$amount,$amount,'C',1,1,'$_SESSION[userName]','$_POST[mrno]','$remarks',$automr)";     
   
  
       $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,mrno,remarks,automrno,customerid,paytype) 
             value('$_POST[demo11]','0',$amount,0,'$_SESSION[userName]','$automr','$remarks','$automr',$_POST[cust],'Sales Discount')";     
       db_query($sql) or die(mysql_error());
       
        $sql="insert into tbl_cash(date,remarks,deposite,user)values('$_POST[demo11]','$remarks',$amount,'$_SESSION[userName]')";
        db_query($sql) or die (mysql_error());
       
       $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type,expensetype,poorexp,refid) 
             value('$_POST[demo11]','$remarks',0,$amount,$amount*(-1),'$_SESSION[userName]',1,11,2,'$automr')";
       db_query($sql) or die (mysql_error());             
       $msg ="Sales Discount Successfully." ;
      }  
     elseif($_POST[paymethod]==1) // Cash Withdraw
      {
       $amount=$_POST[amount];
       $withdraw=$_POST[amount];
       $deposite=0;
       $remarks=" Direct Cash Withdraw: ". $_POST[remarks].$_POST[cust];

       //$sql="insert into tbl_advance (customername,customer,amount,bcamount,status,type,ttype,user,mrno,remarks,automrno) 
       //      value('$_POST[cust]',$_POST[cust],$amount*(-1),$amount*(-1),'C',1,3,'$_SESSION[userName]','$_POST[mrno]','$remarks',$automr)";     
 
       $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,mrno,remarks,automrno,customerid,paytype) 
             value('$_POST[demo11]','0',$amount*(-1),0,'$_SESSION[userName]','$automr','$remarks','$automr',$_POST[cust],'Cash Withdraw')";     
       db_query($sql) or die(mysql_error()); 
       $msg =" Loan Given Successfully. " ;
        
       
          $remarks="Direct Cash Withdraw By $_POST[cust]MR NO :$_POST[mrno]";
          $sql="insert into tbl_cash(date,withdraw,deposite,remarks,refid,user,type)
                values('$_POST[demo11]',$amount,0,'$remarks','$automr','$_SESSION[userName]',2)";
          db_query($sql) or die (mysql_error());
          $msgcash=" Cash Transection Sucessfully Completed.";           
      }  
     echo "<img src='images/active.png' height='15px' width='15px'><b>$msg  $msgcash</b>"; 
     $_SESSION[newflag]=false;  
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
<form name="autoad" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="9">Dircet Transection On Customer Account</td></tr>
 <tr id="trsubhead">
    <td colspan="1" align="center">
            Customer : 
            <?
           //$query_sql = "SELECT id,name,climit,address  FROM tbl_customer where type='Retailer' order by name";
           $query_sql = "SELECT id,name,climit,address  FROM tbl_customer  where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="cust" style="width:300px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["cust"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
     </td>
     <td colspan="1" align="center">Transection Type :
          <select name="paymethod" style="width: 300px;" onchange="Total()">
            <option value="3" <? if($_POST['paymethod']==3) {echo "SELECTED";}?>>Add Sales Amount ( Increase Credit Amount)</option>
            <option value="2" <? if($_POST['paymethod']==2) {echo "SELECTED";}?>>Sales Discount ( Decrease Credit Amount)</option>
            <option value="1" <? if($_POST['paymethod']==1) {echo "SELECTED";}?>>Cash Withdraw ( Increase Credit Balance)</option>
          </select>
     </td>  
 </tr>    
    
 <tr bgcolor="#FFCCAA">
      <td colspan="1" align="center"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
      </td>
      <td colspan="1">Amount : <input type="text" name="amount" size="10" /></td>
      <input type="hidden" name="mrno" value="<?=$newmrno;?>" size= "12"   /> 
 </tr>
 <tr align="center">     
      <td colspan="2">Remarks : <input type="text" name="remarks" size="40" /></td>
      <!--<td colspan="1">Cash Link (Deposite/Withdraw) ( if yes click): <input type="checkbox" name="cash"  /></td> -->
 </tr>
 <tr id="trsubhead"><td colspan="2" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Adjust  " /> </td> </tr>
 </table>
 </form>
<?php
 include "footer.php";
?>
