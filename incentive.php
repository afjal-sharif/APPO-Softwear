<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add Incentive ?")
if (answer !=0)
{
window.submit();
}
}	



function PayMethod()
{
  // alert("javed"); 
 if(document.myForm.cashreceive.checked)
  {
  answer = confirm("Are You Sure To Cash Receive this Incentive Amount?")
  if(answer!=0)
   {
   var orderqty=document.myForm.deposite.value;
   document.myForm.cashamount.disabled=false; 
   document.myForm.store.disabled=false; 
   document.myForm.cashamount.value=orderqty;
   document.myForm.cashexpense.checked=false;
   document.myForm.cashexpense.disabled=true; 
   }
   else
   {
   document.myForm.cashreceive.checked=false;
   document.myForm.cashexpense.disabled=false;
   } 
  }
 else
  {
   document.myForm.cashexpense.disabled=false;
   document.myForm.cashamount.disabled=true; 
   document.myForm.store.disabled=true; 
  } 
}



function PayMethodExp()
{
  // alert("javed"); 
 if(document.myForm.cashexpense.checked)
  {
  answer = confirm("Are You Sure To Expense This Amount From Cash ?")
  if(answer!=0)
   {
   var orderqty=document.myForm.deposite.value;
   document.myForm.cashexpamount.disabled=false;  
   document.myForm.cashexpamount.value=orderqty;
   document.myForm.cashreceive.checked=false;
   document.myForm.cashreceive.disabled=true; 

   }
   else
   {
   document.myForm.cashexpense.checked=false;
   document.myForm.cashreceive.disabled=false;
   } 
  }
 else
  {
   document.myForm.cashexpamount.disabled=true;
   document.myForm.cashreceive.disabled=false;  
  } 
}

</script> 



<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[remarks]) or !Is_Numeric($_POST[deposite]) or !Is_Numeric($_POST[company]) ) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
   $deposite=$_POST[deposite];
   $company=$_POST[company];
   $mgs=""; 
    
   if($_POST[cashreceive]==on)
   {
   $withdraw=$_POST[cashamount];
   $type=1;
   if($_POST[store]=='Cash')
     {
       $remarks=" $_POST[ttype] Cash Receive ".$_POST[remarks];
       $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
             value('$_POST[demo12]','$remarks',$withdraw,0,$withdraw,'$_SESSION[userName]')"; 
       db_query($sql) or die(mysql_error());
       $msg=" & Cash Receive .";
     }
   else
     {
       $remarks="$_POST[ttype] Cheque Receive ".$_POST[remarks];
       $sql="insert into tbl_bank (date,remarks,deposite,withdraw,balance,user,bank,type) 
                 value('$_POST[demo12]','$remarks',$withdraw,0,$withdraw,'$_SESSION[userName]','$_POST[store]',4)";  
      db_query($sql) or die(mysql_error());
      $msg=" & Cheque Receive .";
     }  
   
   }
   else
   {
   $withdraw=0;
   $type=1;
   }   
   $sql="insert into tbl_incentive (date,ttype,companyid,remarks,deposite,withdraw,user,type,inmonth,inyear) 
         value('$_POST[demo12]','$_POST[ttype]',$company,'$_POST[remarks]',$deposite,$withdraw,'$_SESSION[userName]',$type,'$_POST[inmonth]','$_POST[inyear]')"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Incentive Receive Successfully. $msg</b>";
   
   // ----------Cash Expense Section ----------------
   if($_POST[cashexpense]==on)
   {
       
       $withdraw=$_POST[cashexpamount];
       
       $remarks="$_POST[ttype] Cash Withdraw ".$_POST[remarks];
       $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user) 
             value('$_POST[demo12]','$remarks',0,$withdraw,$withdraw*(-1),'$_SESSION[userName]')"; 
       db_query($sql) or die(mysql_error());     
       echo "<br><b><img src='images/active.png' height='15px' width='15px'>Cash Withdraw Successfully for $_POST[ttype]</b>";
   }
   // ----------- end Cash Expense Section-------------
   } // Error chech If
 }// Submit If
?>


<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_incentive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
?>





<form name="myForm" method="post" action="">
<table width="960" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6"><b>Current Incentive Balance : Tk. <?=number_format($balance,2);?> </b></td></tr>
 <tr id="trhead"><td colspan="6">Incentive Receive Form</td></tr>  
 <tr id="trsubhead"><td> Date</td><td>Type</td><td> Company</td><td> Remarks </td><td>Incentive Period</td><td> Receive Amount</td></tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           <input type="Text" id="demo12" READONLY maxlength="12" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dtcompany]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <!--<img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>   -->  
        </td>
        
        <td>
         <!--
          <select name="ttype" style="width: 110px;">
             <option value="Sales Incentive" <?php if($_POST["ttype"]=='Sales Incentive') echo "selected";?>>Sales Incentive</option>
             <option value="Monthly Incentive" <?php if($_POST["ttype"]=='Monthly Incentive') echo "selected";?>>Monthly Incentive</option>
             <option value="Yearly Incentive" <?php if($_POST["ttype"]=='Yearly Incentive') echo "selected";?>>Yearly Incentive</option>
             <option value="Hidden Incentive" <?php if($_POST["ttype"]=='Hidden Incentive') echo "selected";?>>Hidden Incentive</option>
        
             <option value="Comission" <?php if($_POST["ttype"]=='Comission') echo "selected";?>>Comission</option>
             <option value="Eng. Meet" <?php if($_POST["ttype"]=='Eng. Meet') echo "selected";?>>Eng. Meet</option>
             <option value="SR Salary" <?php if($_POST["ttype"]=='SR Salary') echo "selected";?>>SR Salary</option>
             <option value="Others" <?php if($_POST["ttype"]=='Others') echo "selected";?>>Others</option>
          </select>
          -->
          
           <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=6 order by area_name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="ttype" style="width: 110px;">
             
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["ttype"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
          
        </td>
        <td>
          
          <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="company" style="width: 200px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
 
 
       <td align="center"><input type="text"  name="remarks" value="" size="50" /></td>
       <td>
          <select name="inmonth">
            <option value="01" <? if(date("m")=='01') {echo "SELECTED";} ?>>Jan</option>
            <option value="02" <? if(date("m")=='02') {echo "SELECTED";} ?>>Feb</option>
            <option value="03" <? if(date("m")=='03') {echo "SELECTED";} ?>>Mar</option>
            <option value="04" <? if(date("m")=='04') {echo "SELECTED";} ?>>Apr</option>
            <option value="05" <? if(date("m")=='05') {echo "SELECTED";} ?>>May</option>
            <option value="06" <? if(date("m")=='06') {echo "SELECTED";} ?>>Jun</option>
            <option value="07" <? if(date("m")=='07') {echo "SELECTED";} ?>>July</option>
            <option value="08" <? if(date("m")=='08') {echo "SELECTED";} ?>>Aug</option>
            <option value="09" <? if(date("m")=='09') {echo "SELECTED";} ?>>Sep</option>
            <option value="10" <? if(date("m")=='10') {echo "SELECTED";} ?>>Oct</option>
            <option value="11" <? if(date("m")=='11') {echo "SELECTED";} ?>>Nov</option>
            <option value="12" <? if(date("m")=='12') {echo "SELECTED";} ?>>Dec</option>
          </select>

          <select name="inyear">
            <option value="2012" <? if(date("Y")=='2012') {echo "SELECTED";} ?>>2012</option>
            <option value="2013" <? if(date("Y")=='2013') {echo "SELECTED";} ?>>2013</option>
            <option value="2014" <? if(date("Y")=='2014') {echo "SELECTED";} ?>>2014</option>
            <option value="2015" <? if(date("Y")=='2015') {echo "SELECTED";} ?>>2015</option>
          </select>
       </td>
       
       
       <td align="center"> <input type="text"  name="deposite"  size="10"  value="0"  /> </td>
       
     </tr>    
     <tr>
       <td colspan="3">Cash Receive :(Check if Cash Receive) <input type="checkbox" name="cashreceive"  onchange="PayMethod()" /> </td>
       <td>
          <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>Deposite:
           <select name="store"  style="width: 180px;" DISABLED>
           <option value="Cash" <?php if($_POST["store"]=='Cash') echo "selected";?>>Cash</option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["store"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
            
          </select>       
       </td>
       <td colspan="2"> Amount :<input type="text" name="cashamount" size="5" value="0" DISABLED /> </td>
     </tr>

    <!--
     <tr>
       <td colspan="3">Cash Expense :(Check if Cash Expense) <input type="checkbox" name="cashexpense"  onchange="PayMethodExp()" /> </td>
       <td colspan="3"> Expense Amount :<input type="text" name="cashexpamount" size="5" value="0" DISABLED /> </td>
     </tr>
    -->
     
     <tr id="trsubhead"><td colspan="6" align="center"><input type="submit" onclick="ConfirmChoice(); return false;" name="submit" value="   Receive  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Last 10 Transection</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Date</td>
       <td>Type</td>
       <td>Company</td>
       <td>Remarks</td>
       <td>Period</td>
       <td>Receive</td> 
       <td>Adjust</td>
       <td>User</td>    
      </tr>     
    <?
      $user_query="Select tbl_incentive.id,ttype,date_format(tbl_incentive.date,'%d-%m-%Y') as dt,name,inmonth,inyear,remarks,deposite,withdraw,tbl_incentive.user,type 
                   from tbl_incentive  join tbl_company on tbl_incentive.companyid=tbl_company.id
                   order by tbl_incentive.id desc limit 0,10";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr>
          <td><?=$value[dt];?></td>
          <td><?=$value[ttype];?></td>
          <td><?=$value[name];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[inmonth];?>/<?=$value[inyear];?></td>
          <td><?=number_format($value[deposite],2);?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          
          <td><?=$value[user];?></td>  
       <!--
          <td align="center"><b>
          
           <? if($value[type]==1)
            {
           ?>
             <a href="clearbank.php?id=<?=$value[id];?>&mode=incentive" onClick="return (confirm('Are you sure to delete data? YOU MAY LOSE DATA!!!')); return false;" title="Delete">X</a></b>
           <?
            }
           ?>
           
          </td>
       -->   
                
       </tr>
       <?
       }
      }
    ?>  
  </tr>

 </table>

<?php
 include "footer.php";
?>
