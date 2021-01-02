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
answer = confirm("Are You Sure To Add Security Info?")
if (answer !=0)
{
window.submit();
}
}


function PayMethod()
{
 var mtype=document.autoad.paymethod.value;
 
 if(mtype=="Credit Limit")
   {
    document.autoad.bank.disabled=true; 
    document.autoad.branch.disabled=true;
    document.autoad.bank.value="-"; 
    document.autoad.branch.value="-"; 
   }
  else
   {
    document.autoad.bank.disabled=false; 
    document.autoad.branch.disabled=false;
    document.autoad.bank.value=""; 
    document.autoad.branch.value="";
   } 
}	
</script>

<form name="autoad" method="post" action="process_sec.php">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;"> 
 <tr id="trhead"><td colspan="4"> Add New Security Info From Customer & Supplier</td></tr>
 <tr id="trsubhead">
      <td>Type:
         <select  id="sec_type" name="sec_type" style="width: 150px;">
             <option value="0" <?php if($_POST['sec_type']==0) echo "selected";?> ><?php echo "Pay to Supplier"; ?></option>
             <option value="1" <?php if($_POST['sec_type']==1) echo "selected";?> ><?php echo "Receive From Customer"; ?></option>
         </select>    
        </td>    
        <td colspan="3" align="center">
          <div id="div_sec_info">
         Supplier: 
          <?
           $query_sql = "SELECT id,name,address  FROM tbl_company  where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="ref_id"   id ="ref_id" style="width:300px">
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST['ref_id']==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']." :  ".$row_sql['address']  ?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
        </div>      
     </tr>
     <tr bgcolor="#FFCCAA">  
         <td colspan="1" align="left"> 
           Date:<input type="Text" id="demo11"  maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>    
        </td>
        <td colspan="1" align="left">Security Type:
          <select name="paymethod" style="width: 150px;" onchange="PayMethod()">
            <option value="Security Cheque" <? if($_POST['paymethod']=='Security Cheque') {echo "SELECTED";}?>>Security Cheque</option>
            <option value="Bank Gurrantee" <? if($_POST['paymethod']=='Bank Gurrantee') {echo "SELECTED";}?>>Bank Gurrantee</option>
            <option value="Credit Limit" <? if($_POST['paymethod']=='Credit Limit') {echo "SELECTED";}?>>Credit Limit</option>                    
          </select>
        </td>
      
        <td><b>Amount: </b><input type="text" name="amount" value=0 size="12" /></b> 
           <input type="hidden" name="cid" value="<?=$_POST[customer];?>" />
        </td>   
        <td colspan="1" align="left"><b>Expire Date:</b>
            <input type="Text" id="demo12" maxlength="15" size="15"  value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
        </td>
        </tr>
        <tr bgcolor="#FFCCAA"> 
          <td>Bank: <input type="text" name="bank"   value="-" size="20" /> </td>
          <td>Branch: <input type="text" name="branch"  value="-" size="20" /> </td>
          <td colspan="2" align="center">Remarks: <input type="text" name="remarks" size="30" /></td>
          <input type="hidden" name="tran_type" value="0" />
       </tr>

    <tr id="trsubhead"><td colspan="9" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   Save Security " /> </td> </tr>
    
    </table>
</form>

<!--
<br>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 
 <tr id="trhead"><td colspan="10">Security Amount</td></tr> 

     <tr id="trsubhead">    
       <td>Type</td>
       <td>Sup/Cust</td>
       <td>Address</td>
       <td>Receive Type</td> 
       <td>Amount</td>
       <td>Bank</td>
       <td>Branch</td>
       <td>Exp Date</td>
       <td><b>Remarks</b></td>
       <td><b>Status</b></td>
      </tr>     

  
    <?
      
       $user_query="
       
                   select tbl_security.id,name,address,sec_type,amount,bank,expdate,branch,tbl_security.type,tbl_security.remarks
                   from tbl_security
                   join tbl_customer on tbl_security.ref_id=tbl_customer.id
                   where tbl_security.type=1
                   
                   union all
                   select tbl_security.id,name,address,sec_type,amount,bank,expdate,branch,tbl_security.type,tbl_security.remarks
                   from tbl_security
                   join tbl_company on tbl_security.ref_id=tbl_company.id
                   where tbl_security.type=0
                   
                   ";
       
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[dotamount]-$value[dopaymnet];
       ?>
      <tr>
          <td><b>
            <?php  echo ($value[type]==0)? "Given To Supplier":"Receive From Customer"; ?></b>
             </b>
          </td>
          <td><b><?=$value[name];?></b></td>
          <td><?=$value[address];?></td>
          <td align="center"><?=$value[sec_type];?></td>
          <td align="right"><?=number_format($value[amount],2);?></td>  
          <td align="center"><?=$value[bank];?></td>
          <td align="center"><?=$value[branch];?></td>
          <td align="center"><?=$value[expdate];?></td> 
          <td align="center"><?=$value[remarks];?></td>  
          <?
           if($value[expdate]<=date('Y-m-d'))
            {
             echo "<td id='trsubhead'><b>Expired</b></td>";  
            }
           else
            {
             echo "<td>&nbsp;</td>";
            } 
          ?>             
       </tr>
       <?
        $totalamount=$totalamount+$value[amount];
       }
       echo "<tr id='trsubhead'><td colspan='4'>Total :</td><td colspan='5' align='right'>". number_format($totalamount,2)."</td></tr>";
      }
      
     // Submit form  
    ?>  
  </tr>

 </table>
 
 -->
<script type="text/javascript" src="sp.js"></script>
<?
 include "footer.php";
?>
