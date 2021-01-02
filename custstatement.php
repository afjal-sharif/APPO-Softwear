<?php
 session_start();
 $datePicker=true;
 include "includes/functions.php";
 include "session.php";
 include "header.php";
 $_SESSION[$prebal]=0;
?>

<SCRIPT language=JavaScript>
function reload(form)
{
var val=form.mill.options[form.mill.options.selectedIndex].value;
self.location='custstatement.php?mill=' + val ;
}


function ConfirmChoice()
{
answer = confirm("Are You Sure To Submit Statement to Customer ?")
if (answer !=0)
{
 window.submit();
}
}	

</script>


<?

if(isset($_POST["submitstat"]))
 {
  
  $sql="insert into tbl_statment_send(pdate,fdate,edate,cid,amount,user)values('$_SESSION[dtcustomer]','$_POST[fdate]','$_POST[edate]','$_POST[cid]','$_POST[balamount]','$_SESSION[userName]')";
  db_query($sql);
  echo "<img src='images/active.png'> &nbsp;<b>Send Statement For Customer Confirmation</b>";
 }


if(isset($_POST["submit"]))
 {
  $con1=$_POST[demo11];
  $con2=$_POST[demo12];
  
  if($_POST[company]!=='')
   {
    $con="where (`dt` between '$con1' and '$con2') and custid=$_POST[company]";
   }
  else
   {
    $con="where (`dt` between '$con1' and '$con2')";
   }  
 }
else
 {
  $con1=date("Y-m-d");
  $con2=date("Y-m-d");
  $con="where (`dt` between '$con1' and '$con2')";
 } 
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr id="trhead">  
        <td align="left"> 
           Date :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
            
           To <input type="Text" id="demo12" maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>     
        </td>
        
        
          <td>Customer: 
            <?
           $query_sql = "SELECT id,name,address,mobile,sp  FROM tbl_customer where status<>2 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company" style="width: 360px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> :: <?php echo $row_sql['address']?>::<?php echo $row_sql['sp']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td><input type="submit"  name="submit" value="   View  " /> </td>
     </tr>
     <tr>
       <td align="center" colspan="2"> <b> Date : <? echo date('d-M-Y', strtotime($con1)); ?></b> To <b>  <? echo date('d-M-Y', strtotime($con2)); ?></b>  </td>
       <td>Customer ID : <b><? echo $_POST[company]; ?></b></td> 
     </tr>
     
</table>
</form>
<br>

<!-- Order Details -->

 <?
        
     if(($_POST[company]!=='') and (isset($_POST["submit"])))
      {
       $sql="SELECT  sum(salesvalue) as sales,sum(cash+bank) as payment  from view_cust_stat_base where  custid=$_POST[company] and view_cust_stat_base.dt<'$con1'";
       $users = mysql_query($sql);
       $row_sql= mysql_fetch_assoc($users);
       $prebal=$row_sql[sales]-$row_sql[payment];
       $_SESSION[prebal]=$prebal;
       $_SESSION[custid]=$_POST[company];
       
      }
 ?>
 
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
<tr id="trhead"><td colspan="11">Statement Of Accounts - Customer</td></tr>

 <?
 if($_POST[company]!=='')
  {
   echo "<tr id='trsubhead'><td colspan='5' align='left'> Customer Previous Balance :</td><td colspan='6' align='right'>". number_format($prebal,2)."</td></tr>";
  }
 ?>
    
     
     
 <?    
      if(($_POST[company]!=='') and (isset($_POST["submit"])))
      {
	
      $user_query="SELECT  *                 
                   from view_cust_stat_base  $con  order by view_cust_stat_base.`dt` asc,porder asc";
      $users = mysql_query($user_query);
      $_SESSION[printsql]=$user_query;
      $_SESSION[dt]=$con2;
      $total = mysql_num_rows($users);    
      }
      else
      {
       $total=0;
      }
      
      if ($total>0)
      {
      $bal=0;
      $debit=0;
      $credit=0;
      $total=$prebal;
      $totalqty=0;
      
 ?>
    

<tr bgcolor="#FFCCAA" align="center">
    <td>Date</td>
    <td>Type</td>
    <td>Ref. No</td>    
	<td>Qty</td>
	<td>Rate</td>
    <td>Cash</td>
    <td>Bank</td>
    <td>Remarks</td>
    <td>Debit</td>
    <td>Credit</td>
    <td>Balance</td>
</tr>          
 <?
      while($value=mysql_fetch_array($users))
       {
            $date=date_create($value[dt]);
            if($value[porder]==1)
               {                
                   echo "<tr align='center'>"; 
                   echo "<td>".date_format($date,'d-M-y')."</td>";
                   echo "<td>Sales</td>";                    
                   echo "<td><a href=invoice.php?id=$value[refno] target='_blank'>".$value[refno]."</a></td>";
                   echo "<td align='right'>".$value[qty]."</td>";
				   echo "<td align='right'>".number_format ($value[salesvalue]/$value[qty],2)."</td>";					
                   echo "<td>&nbsp;</td>";
                   echo "<td>&nbsp;</td>";
                   echo "<td>".$value[remarks]."</td>";
                   $credit=0;
                   
                   echo "<td align='right'>". number_format($value[salesvalue],2)."</td>";
                   echo "<td>&nbsp;</td>";    
              
                  $totaldebt=$totaldebt+$value[salesvalue];
                  $totalcredit=$totalcredit+$credit;
                  $debit=$value[salesvalue];
                  
                  $bal=($debit-$credit);
                  $total=$total+$bal;
                  echo "<td align='right'>".number_format($total,2)."</td>";
                  echo "</tr>";                      
               }

             if($value[porder]==2)
               {
                 echo "<tr align='center' bgcolor='#FFFFCC'>"; 
                 echo "<td>".date_format($date,'d-M-y')."</td>";
                 echo "<td>Payment</td>";
                 echo "<td><a href=mrprint.php?id=$value[refno] target='_blank'>".$value[refno]."</a></td>";
                 echo "<td>&nbsp;</td>";
				 echo "<td>&nbsp;</td>";
                 echo "<td align='right'>". number_format($value[cash],2)."</td>";
                 echo "<td align='right'>". number_format($value[athand],2)."</td>";
                 
                 
                 if($value[status]=='B')
                   {
                    $status="Bounce";
                   }
                 elseif($value[status]=='C')
                  {
                   $status="Clear";
                  }
                 else
                  {
                   $status="New";
                  }   
                  echo "<td>".$value[cheqno].' &nbsp;'. $status.'&nbsp;'.$value[remarks]."</td>";
                 
                                    $debit=0;
                  $credit=$value[cash]+$value[bank]; 
                  $totalcredit=$totalcredit+$credit;
                  echo "<td>&nbsp;</td>";
                  echo "<td align='right'>".number_format($credit,2)."</td>";
                 
                  
                  
                  $bal=($debit-$credit);
                  $total=$total+$bal; 
                  $totalqty=$totalqty+$value[quantity];
                  echo "<td align='right'>".number_format($total,2)."</td>";
                  
                  echo "</tr>"; 
                 }                
               
           ?>
       
  <?
       }
       
       echo "<tr bgcolor='#FFCC09'><td colspan='5' align='center'><b>Balance As Of Date: ". date('d-M-Y', strtotime($con2))  ."</b></td>";
                                   echo"<td colspan='2'></td><td colspan='1'>&nbsp;</td>";
                      echo "<td align='right'>".number_format($totaldebt,2) ."</td><td align='right'>".number_format($totalcredit,2)."</td><td colspan='1' align='right'><b>".number_format($total,2)."</b> </td> </tr>";
       echo "<tr><td colspan='12' align='center' bgcolor='#FFCCEE'><a href='printcustst.php' target='_blank' title='Print Statement'><b>Print</b></a></td></tr>";
      ?>
     
     <form name="sendstat" action="" method="post" target="_blank">
        <tr align="center">
           <td colspan="12">
             <input type="hidden" name="cid" value="<?=$_POST[company];?>">
             <input type="hidden" name="fdate" value="<?=$con1;?>">
             <input type="hidden" name="edate" value="<?=$con2;?>">
             <input type="hidden" name="balamount" value="<?=$total;?>">
             
             <input type="submit" onclick="ConfirmChoice(); return false;" name="submitstat" value="  Send To Customer for Confirmation  " />
           </td>
        </tr>
     </form>  
    <?

      
   
    }
  ?>  
</table> 
 
<?php
 include "footer.php";
?>
