<?php
 session_start();
 include "includes/functions.php";
 include "session.php";
 $datePicker=true; 
 include "header.php";
 $flag=false;
 
 
 ?>
<!--  Meeting Info Details Here -->

<script src="./js/code_regen.js"></script> 

<script language="JavaScript">
function total()
{
var total_base=eval(document.myForm.total_base.value);
var dfcost=eval(document.myForm.dfcost.value);
var locost=eval(document.myForm.locost.value);
document.myForm.totalcost.value=total_base+dfcost+locost;
cname();
}
</script>


<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Sales Goods ?")
if (answer !=0)
{
window.submit();
}
}	

function cname()
{
var cname=document.myForm.customer.value;
var t_cost=eval(document.myForm.totalcost.value);  
if (cname==1)
 {
  document.myForm.recust.disabled=false;
  document.myForm.cash.value=t_cost;
 }
else
 {
 document.myForm.recust.disabled=true;
 document.myForm.cash.value=0;
 document.myForm.cash.value=t_cost;
 }

}	



function PayMethod()
{  
 if(document.myForm.dfcash.checked)
  {
  answer = confirm("Are You Sure To Receive Cash ?")
  if(answer!=0)
   {
    var t_cost=eval(document.myForm.totalcost.value);
    
    document.myForm.dfcash.checked=true;
    
    document.myForm.cash.disabled=false;
    document.myForm.discount.disabled=false;
    document.myForm.paytype.disabled=false;
    document.myForm.payremarks.disabled=false;
    //document.myForm.cash.value='';
    document.myForm.cash.value=t_cost;
    document.myForm.cash.focus(); 
   }
   else
   {
    document.myForm.cash.value='0';
    document.myForm.dfcash.checked=false; 
    document.myForm.cash.disabled=true;
    document.myForm.discount.disabled=true;
    document.myForm.paytype.disabled=true;
    document.myForm.payremarks.disabled=true;
   } 
  }
 else
  {
    document.myForm.cash.value='0';
    document.myForm.dfcash.checked=false; 
    document.myForm.cash.disabled=true;
    document.myForm.discount.disabled=true;
    document.myForm.paytype.disabled=true;
    document.myForm.payremarks.disabled=true;
  } 
}



</script> 


<?
$value=round($_GET[value],2);

if(isset($_POST["submit"]))
 {
  if (empty($_POST[demo11]) or empty($_POST[customer]) or empty($_POST[invoice])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
     
      if(empty($_POST[demo12]) or $_POST[demo12]=='')
      {$coldate='';} else {$coldate=$_POST[demo12];}
   
   
       if($_POST[cday]>0)
       {
       $creditday=$_POST[cday];
       $coldate=date('Y-m-d', strtotime("+$creditday days"));
       }
      else
       {
       $coldate=$coldate;
       } 

     
      $sql_sp="Select sp from tbl_customer where tbl_customer.id='$_POST[customer]'";
      $users_sp = mysql_query($sql_sp);
      $row_sp= mysql_fetch_assoc($users_sp);
      $spname=$row_sp[sp];  
      
   
     $goods_value=$_POST[total_base];
         
     $df=$_POST[dfcost];
     $lo=$_POST[locost];
     
     $sqltmp="select * from tbl_sales_temp where user='$_SESSION[userName]'";
     $userstmp = mysql_query($sqltmp);
     while($value=mysql_fetch_array($userstmp))
     { 
      $remarks=$value[remarks].$_POST[remarks]; 
      $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
            soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination,scid) 
            value('$_POST[demo11]','$value[donumber]','$value[product_id]', '$_POST[invoice]',$value[rate],$value[qty],$value[freeqty],
             '$_SESSION[userName]',$_POST[customer],1,'$value[unit]',$df/$value[qty],'$_POST[truck]',
              '-','$_POST[remarks]','$_POST[recust]','$_POST[invoice]',$lo/$value[qty],'$spname','$_POST[demo11]','$_POST[destination]','-','$_POST[sub_cat]')"; 
      db_query($sql) or die(mysql_error());
      
      $sql="insert into tbl_stock (stockdt,donumber,product,stock,user)values('$_POST[demo11]','$value[donumber]','$value[product_id]',$value[qty]*(-1),'$_SESSION[userName]')";
      db_query($sql) or die(mysql_error());
      
      
     $totalamount=$totalamount+($value[qty]*($value[rate]+$df+$lo));
     $totalcost=$totalcost+($value[qty]*($df+$lo));
     $df=0;
     $lo=0;
     }
     $_SESSION[totalamount]=$totalamount;


    // For Carring Receive.
    if($_POST[carring]>0)
    {
                  $amount=$_POST[carring];
                  $user_mr="Select (max(automrno)+1)as mrno from tbl_dir_receive";
                  $users_mr = mysql_query($user_mr);
                  $row_sql= mysql_fetch_assoc($users_mr);
                  $newmrnomain=$row_sql[mrno];
                  if (is_numeric($newmrnomain)){$automr=$newmrnomain;}else{$automr=1;}                  
                                    
                  $remarks="Carring Receive.Invoice :$_POST[invoice]";
                  $sql="insert into tbl_dir_receive (date,mrno,invoice,hcash,discount,user,remarks,customerid,cstatus,paytype,automrno) 
                     value('$_SESSION[dtcustomer]','C:$automr','$_POST[invoice]',$amount,0,'$_SESSION[userName]','$remarks','$_POST[customer]','C','Cash','$automr')";     
                  db_query($sql) or die(mysql_error()); 
                                 
                  $remarks="Carring Receive Cash from $_POST[customer].Invoice:$_POST[invoice]";
                  $sql="insert into tbl_cash(date,remarks,deposite,user)values('$_SESSION[dtcustomer]','$remarks',$amount,'$_SESSION[userName]')";
                  db_query($sql) or die(mysql_error());  
              
                  $remarks="Carring Expense for $_POST[customer].Invoice:$_POST[invoice]";
                  $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type,expensetype,poorexp) 
                      value('$_SESSION[dtcustomer]','$remarks',0,$amount,$amount,'$_SESSION[userName]',1,'$global[exp_carring]',2)"; 
                  db_query($sql) or die(mysql_error());
                  
    
    
    
    
    }
    // End Carring

  // For Cash Receive
  
    if($_POST[dfcash]==on)
    {
      if($_POST[cash]<>0)
      {
      
      $amount=$_POST[cash];
      $discount=$_POST[discount];
      
      $sql="select name from tbl_customer where id=$_POST[customer]";
      $users = mysql_query($sql);
      $row_sql= mysql_fetch_assoc($users);
      $name=$row_sql[name];
      
      $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];

            
      if($_POST[paytype]=='CASH')
      {
      $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,depositebank,mrno,remarks,automrno,customerid,cstatus,paytype) 
         value('$_POST[demo11]','$_POST[invoice]',$amount,$discount,'$_SESSION[userName]','Cash','$newmrnomain','$remarks $_POST[recust]','$newmrnomain',$_POST[customer],'C','Cash')";     
      db_query($sql) or die(mysql_error());  
          
       
      $remarks="Cash from $name $_POST[recust] $remarks $_POST[invoice] MR:$newmrnomain";
      $sql="insert into tbl_cash(date,remarks,deposite,user,refid)values('$_POST[demo11]','$remarks',$amount,'$_SESSION[userName]','$newmrnomain')";
      db_query($sql) or die(mysql_error());  
      $msg=" Cash Tk. $_POST[cash] Receive Successfully";
      }
      else
      {
       $sql="insert into tbl_dir_receive (date,invoice,cash,amount,discount,user,depositebank,mrno,remarks,chequeno,automrno,customerid,cstatus,paytype) 
         value('$_POST[demo11]','$_POST[invoice]',$amount,$amount,$discount,'$_SESSION[userName]','$_POST[paytype]','$newmrnomain','$remarks $_POST[recust]','$_POST[payremarks]','$newmrnomain',$_POST[customer],'C','Bank')";     
       db_query($sql) or die(mysql_error());  
      
       
      $remarks="Sales Bank from $name $_POST[payremarks] Invoice $_POST[invoice] MR:$newmrnomain";
      $sql="insert into tbl_bank(date,remarks,deposite,user,rec_ref_id,type,bank)values('$_POST[demo11]','$remarks',$amount,'$_SESSION[userName]','$newmrnomain',1,'$_POST[paytype]')";
      db_query($sql) or die(mysql_error());  
      $msg=" Bank Receive Tk. $_POST[cash] Successfully";
      }
      
      if($_POST[discount]<>0)
        {
         $remarks="Sales Cash Discount Recieve from $name $_POST[recust] Invoice $_POST[invoice]";
         $sql="insert into tbl_cash(date,remarks,deposite,user,type,refid)values('$_POST[demo11]','$remarks',$_POST[discount],'$_SESSION[userName]',2,'$newmrnomain')";
         db_query($sql) or die(mysql_error());  
      
         $remarks="Expense Sales Discount For  $name $_POST[recust] Invoice $_POST[invoice]";
         $sql="insert into tbl_cash(date,remarks,withdraw,user,expensetype,type,refid,poorexp)values('$_POST[demo11]','$remarks',$_POST[discount],'$_SESSION[userName]',11,1,'$newmrnomain',2)";
         db_query($sql) or die(mysql_error());  
        }    
      }
    }  
     
  // For Cash Receive   
     
     
     echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Goods Sales successfully. $msg</b>";
     $sql="delete  from tbl_sales_temp where user='$_SESSION[userName]'";
     db_query($sql) or die(mysql_error());
     $_SESSION[invoice]=$_POST[invoice];
     $flag=true;
    }  
   } // Error chech If
 // Submit If
?>

<?
      $user_query="SELECT max(autoinvoice)+1 as invoice FROM `tbl_sales` where `invoice` not like 'c%'";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newinvoice=$row_sql[invoice];
?>

<?
if($flag==false)
 {
?>

<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Sales Customer Entry Form</td></tr>  
 
 <tr bgcolor="#CCAABB">  
         <td colspan="1" align="left"> 
           Date :<input type="Text" id="demo11"  maxlength="15" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcustomer]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
        </td>
        <td>Invoice:<input type="text" name="invoice" value="<?=$newinvoice;?>" size="6" /> </td>  
        <td colspan="1">
         Customer: 
          <?
           $query_sql = "SELECT id,name,address,climit,type,status,area  FROM tbl_customer  where status=0 order by name"; 
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="customer"  onchange="cname()" style="width: 250px;" id="customer_sec">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["customer"]==$row_sql['id']) echo "selected";?> >
                <?php echo $row_sql['name']?> :: <?php echo $row_sql['area'];?> :: <?php echo $row_sql['address']?>::
                <!--<?if($row_sql[status]==0){echo "Active";}else{echo "Inactive";}?>  --> 
             </option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>

        
     </tr> 
     <tr>
     <td colspan="2">Cash Customer Name :<input type="text" name="recust" disabled size="50"  /></td>
     <td>
        <div id="div_secondary_cust">Sec.Cust:
             <select style="width:250px" id="sub_cat" name="sub_cat">
                 <option value=""></option>
             </select>
            </div>
     </td> 
    </tr>
     
     <tr>       
        <td colspan="2">DF Cost:<input type="text" name="dfcost" value="0" onchange="total()" size="8" />
          Load Cost:<input type="text" name="locost" value="0" onchange="total()" size="8" />
          Total:<input type="text" name="totalcost"  READONLY value="<?=$value;?>" size="8" />
          <input type="hidden" name="total_base" value="<?=$value;?>" size="8" />
       </td>
       
       <td align="center" colspan="1">
          Vechical:<input type="text" size="10"  name="truck"  />
          <b>Carring Receive:</b> <input type="text" size="5"  name="carring"  value="0"  />
       </td>
       
        
       
     </tr>
     <tr>   
         <td colspan="2" align="center">
             Destination: <input type="text" size="40"   name="destination"  />
         </td>        
         <td align="center" colspan="1">
             Remarks:<input type="text" size="20"   name="remarks"  />
         </td>
         
     </tr>     
     <tr>
        <td bgcolor="#FFee09" colspan="3">
           Receive Money: <input type="checkbox" name="dfcash"  onchange="PayMethod()" /> &nbsp;
           <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name  order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="paytype"  style="width: 180px;" DISABLED>
               <option value="CASH" <?php if($_POST[paytype]=='CASH') echo "SELECTED";?>>CASH - RECEIVE</option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["paytype"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
          
          
          Amount:<input type="text" name="cash" DISABLED value="0" size="8" />
           &nbsp;Discount:<input type="text" DISABLED name="discount" value="0" size="8" />
           
           &nbsp;Remarks:<input type="text" DISABLED name="payremarks" size="20" />
        </td>
     </tr>
     
     
     <tr id="trsubhead"><td colspan="4" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   &nbsp; &nbsp;Save &nbsp; &nbsp;  " /> </td> </tr>
</table>
</form>

<!-- Display Invoice data -->
 
<?
 $sql="SELECT `company`,`product`,`product_id`,unit,sum(qty)as qty,avg(freeqty) as bundle,avg(rate) as rate FROM `tbl_sales_temp`
        where user='$_SESSION[userName]' group by `product_id`,rate";
 $users = mysql_query($sql);
 $total = mysql_num_rows($users);    
 
 if ($total>0)
    {
 ?> 
  
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="9">Current Sales Product.</td></tr> 
 <tr bgcolor="#FFCCAA">    
       
       <td>Category</td>
       <td>Product</td>       
       <td>Sales Qty</td>
       <td>Bundle</td>
       <td>Rate</td>
       <td align="center">Gross Total</td>
       <td bgcolor="#FF00CA" align="center">Action</td> 
 </tr>     
  <?
   while($value=mysql_fetch_array($users))
       {
  ?>
      <tr>
          <td><?=$value[company];?></td>
          <td><?=$value[product];?></td>
          
           <td align="right"><?=number_format($value[qty],2);?> <?=$value[unit];?> </td>
          <td align="center"><?=number_format($value[bundle],0);?></td> 
          <td align="right"><?=number_format($value[rate],2);?></td>
          <td align="right" bgcolor="#FFEE09"><?=number_format($value[qty]*$value[rate],2);?></td>           
          <td align="center"><a href="indelete.php?id=<?=$value[product_id]?>&mode=tmpsale"><img src="images/inactive.png" height="15px" width="15px"></a></td>
       </tr>


  <? 
    $totalqty=$totalqty+$value[qty];
    $totalbundle=$totalbundle+$value[bundle];
    $totalvalue=$totalvalue+($value[qty]*$value[rate]);
      }
    echo "<tr id='trsubhead'><td colspan='2' align='center'>Total </td>
                              <td colspan='1' align='right'> ".number_format($totalqty,2)."</td>
                              <td colspan='1' align='center'> ".number_format($totalbundle,0)."</td>
                              <td colspan='1' align='right'> ".number_format($totalvalue/$totalqty,2)."</td>
                              <td colspan='1' align='right'> ".number_format($totalvalue,2)."</td><td>&nbsp;</td>
                  </tr>";
 ?>   
    <?
   
   echo "</table>";
   }
  
 } 
  
  if($flag==true)
   {
    ?>
    <br><br>
    <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

   <!--
    <tr><td id="trsubhead">
    <a href="salpayment.php?invoice=<?=urlencode($_SESSION[invoice])?>&value=<?=$_SESSION[totalamount]?>" target="_blank">Receive Payment</a>
    </td></tr>

   <tr><td id="trsubhead">
    <a href="challan.php?invoice=<?=urlencode($_SESSION[invoice])?>&view=Print" target="_blank" ><b>Click Here To Print Challan</b></a>
    </td></tr>
  -->
  
    <tr><td id="trsubhead">
    <a href="invoice.php?id=<?=urlencode($_SESSION[invoice])?>&view=Print" target="_blank" ><b>Click Here To Print Incoice</b></a>
    </td></tr>
  
      </table>
   <?
   }
   ?>
   
<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
