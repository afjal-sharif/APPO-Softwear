<?php
 session_start();
 include "includes/functions.php";
 $mnuid="414";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Recieve From Customer &  Payments to Supplier ?")
if (answer !=0)
{
window.submit();
}
}	


function PayMethod()
{
 var mtype=eval(document.autoad.paymethod.value);
 if(mtype==2)
  {
  document.autoad.bank.disabled=false; 
  document.autoad.branch.disabled=false; 
  }
 else
  {
  document.autoad.bank.disabled=true; 
  document.autoad.branch.disabled=true;  
  } 
}
</script> 
<?

if(isset($_POST["submit"]))
 {
  $paytype= $_POST[paymethod];
  $company=$_POST[company];
  $amount= $_POST[amount];
  $customer=$_POST[cid];
  if (empty($_POST[mrno]) or empty($_POST[amount]) or empty($_POST[company]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   { 
     
     $customer=$_REQUEST[cid];
      
      if (is_numeric($_POST[mrno]))
        {
        $automr=$_POST[mrno];
        }
      else
        {
        $automr=0;
        }  
       
       if($_POST[paymethod]==1)
       {
         // For Cash Receive
         $remarks="C2S-Cash[$customer]>>[$company].$_POST[remarks]";
         $deposite="C2S-Cash";
         $paytype="Cash C2S";
       }
       else
       {
        // For Bank deposite.
        $remarks="C2S-On Line Bank [$customer]>>[$company].$_POST[remarks]";
        $deposite="C2S-On Line Bank Cash";
        $paytype="Online-Bank C2S";
       }
      
        $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,depositebank,mrno,remarks,automrno,customerid,paycompany,paytype) 
         value('$_POST[demo11]','-',$amount,0,'$_SESSION[userName]','$deposite','$_POST[mrno]','$remarks',$automr,$customer,$company,'$paytype')";     
        db_query($sql) or die(mysql_error());  
      
        $sql="insert into tbl_cash(date,remarks,deposite,user)values('$_POST[demo11]','$remarks',$amount,'$_SESSION[userName]')";
        db_query($sql) or die(mysql_error());  
      
        echo "<img src='images/active.png' height='15px' width='15px'><b>Payment Receive Successfully.</b>";  
        
        
        $sql="insert into tbl_com_payment (paydate,donumber,amount,chequeno,cheqdate,bank,user,remarks,status,bamount,companyid) 
        value('$_POST[demo11]','-',$amount,'Cash','$_POST[demo11]','$deposite','$_SESSION[userName]','$remarks','C',$amount,$company)"; 
        db_query($sql) or die(mysql_error()); 
       
  
        $sql="insert into tbl_cash (date,remarks,withdraw,user,type) values('$_POST[demo11]','$remarks',$amount,'$_SESSION[userName]',9)";
        db_query($sql) or die(mysql_error());
        
        echo "<img src='images/active.png' height='15px' width='15px'><b>Payment To Supplier Successfully.</b>";     
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
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <form name="autoad" method="post" action="">
 <tr id="trhead"><td colspan="6">Payment Receive from Cutomer & Payment To Supplier</td></tr>
 <tr id="trsubhead">
             <td colspan="6" align="left">
             
            From Customer : 
            <?
           $query_sql = "SELECT id,name,climit,address  FROM tbl_customer where status<>2  order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="cid" style="width:300px">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["cid"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
            </td>
 </tr>

    
     <tr bgcolor="#FFCCAA">  
         <td colspan="3" align="center"> 
           Date :<input type="Text" id="demo11" READONLY maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>  
        </td>
        <td colspan="1" align="left">Receive Type :
          <select name="paymethod" style="width: 150px;" onchange="PayMethod()">
            <!--<option value="4" <? if($_POST['paymethod']==4) {echo "SELECTED";}?>>Internal Adjust</option>-->
            <option value="1" <? if($_POST['paymethod']==1) {echo "SELECTED";}?>>Cash Receive</option>
            <option value="2" <? if($_POST['paymethod']==2) {echo "SELECTED";}?>>Cash Deposite Bank</option>
          </select>
        </td>
        <td colspan="1" align="left">MR No :<input type="text" name="mrno" value="<?=$newmrno;?>" size= "15"   /> </td>
      </tr>  
     <tr>
      <td>Bank Name</td>
      <td>Branch</td>
      <td>Amount</td>
      <td colspan="2">Remarks</td>
     </tr> 
    <tr bgcolor="#CCAABB">  
        <td><input type="text" name="bank" size="20"  DISABLED /> </td>
        <td><input type="text" name="branch" size="20" DISABLED /> </td>
        
        
        
        <td><input type="text" name="amount" value=0 size="12" /> </td>
        <td colspan="2"><input type="text" name="remarks" size="80" /></td>
    </tr>
    <tr bgcolor="#CCAABB">  
         <td colspan="5" align="center">Pay Supplier :
                <?
           $query_sql = "SELECT id,name,address  FROM tbl_company where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="company"  style="width: 350px;">
           <option value=""></option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> : <?php echo $row_sql['address']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>    
        </td>
        
    </tr>


        
         <tr id="trsubhead"><td colspan="5" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Receive  & Payment " /> </td> </tr>
    </form>
    </table>

<?php
 include "footer.php";
?>
