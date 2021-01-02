<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Receive From Customer";
 include "session.php";  
 include "header.php";
?>

<form name="autoad" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;"> 
 <tr id="trhead"><td colspan="4">View Security Info From Customer & Supplier</td></tr>
 <tr id="trsubhead">
       <td>Type:
         <select  name="type" style="width: 150px;">
             <option value="">All</option>
             <option value="0" <?php if($_POST['type']=='0') echo "selected";?> ><?php echo "Pay to Supplier"; ?></option>
             <option value="1" <?php if($_POST['type']=='1') echo "selected";?> ><?php echo "Receive From Customer"; ?></option>
         </select>    
        </td>    
        <td colspan="1">Security Type:
          <select name="pay_type" style="width: 150px;">
            <option value="">All</option>
            <option value="Security Cheque" <? if($_POST['pay_type']=='Security Cheque') {echo "SELECTED";}?>>Security Cheque</option>
            <option value="Bank Gurrantee" <? if($_POST['pay_type']=='Bank Gurrantee') {echo "SELECTED";}?>>Bank Gurrantee</option>
            <option value="Credit Limit" <? if($_POST['pay_type']=='Credit Limit') {echo "SELECTED";}?>>Credit Limit</option>                    
          </select>
        </td>
        <td><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;"  value="   View Security " /></td></tr>
    </table>
</form>


<br>
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">    
 
 <tr id="trhead"><td colspan="9">Security Amount</td></tr> 

     <tr id="trsubhead">    
       <td>Type</td>
       <td>Sup/Cust</td>
       
       <td>Receive Type</td> 
       <td>Amount</td>
       <td>Bank</td>
       <td>Branch</td>
       <td>Exp Date</td>
       <td><b>Remarks</b></td>
       <td><b>Status</b></td>
      </tr>     

  
    <?
      if(isset($_POST[submit]))
       {
        $con="";
        
        if($_POST[type]!=''){$con=" e.type='$_POST[type]'";}
        if($_POST[pay_type]!=''){$con=" e.sec_type='$_POST[pay_type]'";}
        if($con!=''){ $con="where $con";}
        $user_query="
                   select e.id,e.name,e.address,e.sec_type,e.amount,e.bank,e.branch,e.type,e.remarks from(  
                   select tbl_security.id,name,address,sec_type,amount,bank,expdate,branch,tbl_security.type,tbl_security.remarks
                   from tbl_security
                   join tbl_customer on tbl_security.ref_id=tbl_customer.id
                   where tbl_security.type=1
                   
                   union all
                   select tbl_security.id,name,address,sec_type,amount,bank,expdate,branch,tbl_security.type,tbl_security.remarks
                   from tbl_security
                   join tbl_company on tbl_security.ref_id=tbl_company.id
                   where tbl_security.type=0
                   ) as e 
                   $con
                   order by e.id desc
                   ";      
       }
       else
       {
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
      }
       
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
      <tr>
          <td><b>
            <?php  echo ($value[type]==0)? "Pay To Supplier":"Receive From Customer"; ?></b>
             </b>
          </td>
          <td><b><?=$value[name];?></b></td>
          
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
 

<?
 include "footer.php";
?>
