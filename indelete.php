<?php 
 include_once "includes/functions.php";
 include "session.php";
 
//echo $_GET['mode'];
//echo $_GET['id'];
if($_GET['mode']=='dirpaymeny')
 {
   $invoice=$_GET[invoice];
   $amount=$_GET[amount];
   $update_query = "delete from tbl_dir_receive  WHERE id=$_GET[id]"; 
   db_query($update_query);
   $remarks="Cash Receive From Invoice :$invoice";  
   $sql="delete from tbl_cash where remarks='$remarks' and deposite=$amount";
   db_query($sql);

   header("location: salpayment.php?invoice=$invoice");   
 } 	

if($_GET['mode']=='Bank')
{
   $id=$_GET[id];
   $status=$_GET[status];
   
   if ($status==1)
   {
    $insert_query = "update tbl_dir_receive set cash=amount, cstatus='C',bdate=curdate(),buser='$_SESSION[userNmae]' where id=$id"; 
    db_query($insert_query);
   }
   else
   {
    $insert_query = "update tbl_dir_receive set cstatus='C',bdate=curdate(),buser='$_SESSION[userName]' where id=$id"; 
    db_query($insert_query);
   }
   header("location:bankclear.php");
 }

 
 if($_GET['mode']=='customer')
 {
   $id=$_GET[id];
   $status=$_GET[status];
   if($status==0)
   {
    $sta=1;
   }
   else
   {
   $sta=0;
   }
   
   $update_query = "update tbl_customer set status=$sta where id=$id"; 
   db_query($update_query);
   header("location: customer.php");   
 } 	

if($_GET['mode']=='customerinactive')
 {
   $id=$_GET[id];
   $status=$_GET[status];
   if($status==0)
   {
    $sta=1;
   }
   else
   {
   $sta=0;
   }
   
   $update_query = "update tbl_customer set status=$sta where id=$id"; 
   db_query($update_query);
   header("location: rptCloseCustomer.php");   
 } 	


 if($_GET['mode']=='truck')
 {
   $id=$_GET[id];
   $status=$_GET[status];
   if($status==0)
   {
    $sta=1;
   }
   else
   {
   $sta=0;
   }
   
   $update_query = "update truck_name set status=$sta where id=$id"; 
   db_query($update_query);
   header("location: addtruck.php");   
 } 	




if($_GET['mode']=='sp')
 {
   $id=$_GET[id];
   $status=$_GET[status];
   if($status==0)
   {
    $sta=1;
   }
   else
   {
   $sta=0;
   }
   
   $update_query = "update tbl_sp set status=$sta where id=$id"; 
   db_query($update_query);
   header("location: sp.php");   
 } 	


 
 if($_GET['mode']=='pur_order')
 {
   
   $id=$_GET[id];
   $donumber=$_GET[donumber];
   $update_query = "delete  from  tbl_order where id=$id"; 
   db_query($update_query);
   
   $update_query = "delete  from  tbl_receive where donumber=$donumber"; 
   db_query($update_query);
      
   header("location: order.php");   
 } 	


 if($_GET['mode']=='order')
 {
   $id=$_GET[id];
   $donumber=$_GET[donumber];
   
   $query_sql="select * from tbl_sales where donumber='$donumber'";
   $sql = mysql_query($query_sql) or die(mysql_error());
   $row_sql = mysql_fetch_assoc($sql);
   $totalRows_sql = mysql_num_rows($sql);    
   if($totalRows_sql<=0)       
   {
    $update_query = "delete  from  tbl_receive where id=$id"; 
    db_query($update_query);
   }
   header("location: pur_item.php?id=$donumber");   
 } 	


 if($_GET['mode']=='exp_delete')
 {
   $id=$_GET[id];
   $type=$_GET[source];
   $data=$_GET[data];
   if($type==1)
    {
     $sql="insert into tbl_delete_log(type,ref_id,sup_cust,remarks,user)value(3,$id,1,'$data','$_SESSION[userName]')";
     db_query($sql);
     $update_query = "delete  from  tbl_cash where id=$id"; 
     db_query($update_query);
    }
   else
    {
     
     $sql="insert into tbl_delete_log(type,ref_id,sup_cust,remarks,user)value(3,$id,2,'$data','$_SESSION[userName]')";
     db_query($sql);
     $update_query = "delete  from  tbl_bank where id=$id"; 
     db_query($update_query);
    }  
   header("location: edit_order.php?id=expense");   
 } 	




if($_GET['mode']=='sales')
 {
 $id=$_GET[id];

 $sql="select * from tbl_sales where id=$id";
 $users_skills = mysql_query($sql); 
 $value=mysql_fetch_array($users_skills);


 $strrem="Cash Withdraw for Goods Sales. Invoice $value[invoice] Customer $value[customerid]"; 
 $withdraw=$value[qty]*($value[df]+$value[loadcost])+$value[otherscost];
 $sql_cash="delete from tbl_cash where remarks='$strrem' and withdraw=$withdraw and type=2";
 db_query($sql_cash);


 $update_query = "delete  from  tbl_sales where id=$id"; 
 db_query($update_query);
 header("location: salesbal.php");   
 } 	

// Sales Confirmation Status
if($_GET['mode']=='salescon')
 {
 $id=$_GET[id];
 $status=$_GET[status]; 
 if ($status==0)
  {
   $status=1;
  }
 else
  {
   $status=0;
  } 
/*
 $sql="select * from tbl_sales where id=$id";
 $users_skills = mysql_query($sql); 
 $value=mysql_fetch_array($users_skills);

 $strrem="Cash Withdraw for Goods Sales. Invoice $value[invoice] Customer $value[customerid]"; 
 $withdraw=$value[qty]*($value[df]+$value[loadcost])+$value[otherscost];
 $sql_cash="delete from tbl_cash where remarks='$strrem' and withdraw=$withdraw and type=2";
 db_query($sql_cash);
*/
 
 $update_query = "update tbl_sales set status=$status where id=$id"; 
 db_query($update_query);
 header("location: salesconfirm.php");   
 } 	

// Sales Confirmation Status
if($_GET['mode']=='salesconup')
 {
 $id=$_GET[id];
 $status=$_GET[status]; 
 if ($status==0)
  {
   $update_query = "update tbl_sales set status=1 where id=$id"; 
   db_query($update_query);
   header("location: salesconfirm.php");  
  }
 else
  {
   $update_query = "delete from tbl_sales where id=$id"; 
   db_query($update_query);
   header("location: salesconfirm.php");  
  
  } 
    
 } 	




if($_GET['mode']=='receive')
 {
 $id=$_GET[id]; 
 $sql="select * from tbl_receive where id=$id";
 $users_skills = mysql_query($sql); 
 $value=mysql_fetch_array($users_skills);
 
 $dosales=$value[dosales];
 $gpnumber=$value[gpnumber];
 
 $dosales=$value[dosales];
 
 $strrem="Cost for goods receive DO:$value[donumber] GP:$value[gpnumber] Truck: $value[truckno],$value[remarks]"; 
 
 $withdraw=$value[qty]*($value[df]+$value[otherscost]);
   
 $sql_cash="delete from tbl_cash where remarks='$strrem' and withdraw=$withdraw and type=8";
 db_query($sql_cash);
 if($dosales==1)
  {
   $sql_sales="delete from tbl_sales where donumber='$value[donumber]' and refid=$value[gpnumber]";
   db_query($sql_sales);
  }
  
   
 $update_query = "delete  from  tbl_receive where id=$id"; 
 db_query($update_query);    

 if($dosales==1)
  {
   $sql="select * from tbl_sales where refid=$gpnumber";
   $users_skills = mysql_query($sql); 
   $value=mysql_fetch_array($users_skills);
   $amount=$value[qty]*$value[df];
   $invoice=$value[invoice];
   
   $sql="delete from tbl_sales where refid=$gpnumber";
   db_query($sql) or die(mysql_error());
   
   $sql="insert into tbl_cash(date,remarks,deposite,type,user)values(curdate(),'DO Sales DF Adjust Cash Amount. Invoice : $invoice',$amount,2,'$_SESSION[userName]')";
   db_query($sql) or die(mysql_error());
  }

 header("location: receivebal.php");   
 } 	
 
 
 
 
if($_GET['mode']=='product')
 {
   $id=$_GET[id];
   
   $sql="select product from tbl_receive where product=$id";
   $users_skills = mysql_query($sql); 
   $value=mysql_fetch_array($users_skills);
   $product=$value[product];
   
   if(($product==0) or isnull($product))
   {
    $update_query = "delete  from  tbl_product where id=$id"; 
    db_query($update_query);
   }
   header("location: product.php");   
 } 	
 
if($_GET['mode']=='pcomdel')
 {
   $id=$_GET[id];
   $cheque=$_GET[chequeno];
   $remarks=$_GET[remarks];
   $update_query = "delete from tbl_com_payment  WHERE id=$_GET[id]"; 
   db_query($update_query) or die(mysql_error());
   if ($cheque=='Cash Payment')
    {  
      $sql="delete from tbl_cash where remarks='$remarks' and type=5";
      db_query($sql);
    }
   header("location: paybalcom.php");   
 } 	
 


if($_GET['mode']=='advpayadjust')
 {
   $id=$_GET[id];
   
   $select_query = "Select *  from tbl_advance  WHERE id=$id"; 
   $users = mysql_query($select_query);
   $row_sql= mysql_fetch_assoc($users);
   
   $customer=$row_sql[customer];
   $amount=$row_sql[bcamount]-$row_sql[adjustamount];
   $bdate=$row_sql[lasttdate];
   
   $rembal=$amount;  
   //$bank=$row_sql[rbank];
   //$brabch=$row_sql[rbranch];
   $bank=$row_sql[bank];
   $mrno=$row_sql[mrno];
   $chequeno=$row_sql[chequeno];
   $chequedate=$row_sql[demo12];
   $remarks=$row_sql[remarks]. " Advance Payment Adjustemnt";
     
 
 
 
      $user_query="SELECT * FROM autopaybal where cid=$customer order by id";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);
      $bal=0;
      $adjamount=0;
      if ($total>0)
      {
       $flag=true;
       while($value=mysql_fetch_array($users) and ($flag==true))
       {
        $bal=$value[dotamount]-$value[dopaymnet];
        if($rembal<=$bal)
         {
         $flag=false;
         $amount=$rembal;
         $rembal=0;
         $company=$value[company];
         $adjamount=$adjamount+$amount;
         }
        else
         {
         $flag=true;
         $amount=$bal;
         $rembal=$rembal-$bal;
         $company=$value[company];
         $adjamount=$adjamount+$amount;
         }
        $sql="insert into tbl_com_payment (paydate,donumber,amount,chequeno,cheqdate,bank,user,remarks,bamount,bdate,status) 
        value(curdate(),'$value[donumber]',$amount,'$chequeno','$chequedate','$bank','$_SESSION[userName]','$remarks',$amount,'$bdate','C')"; 
        db_query($sql) or die(mysql_error());  
       ?>
      <?
      }
      
      $sql="update tbl_advance set adjustamount=adjustamount+$adjamount, lasttdate=curdate() where id=$id";
      db_query($sql) or die(mysql_error());
      // If Rem Bal has then auto matic go to Advance Paymanes.
      $msg="Payment Adjust Successfully.";
      }
      else
      {
      $msg="No DO found for adjust.";
      }
  // header("location: advancepaymentadjust.php");
  echo "Payment Adjust Successfully.";
  echo "<a href='rptpaybalcom.php'>Click Here To Go Main Page.</a>";   
   
 } 	
 
 



if($_GET['mode']=='advrecadjust')
 {
   $id=$_GET[id];
   
   $select_query = "Select *  from tbl_advance  WHERE id=$id"; 
   $users = mysql_query($select_query);
   $row_sql= mysql_fetch_assoc($users);
   
   $customer=$row_sql[customer];
   $custid=$row_sql[customer];
   $amount=$row_sql[bcamount]-$row_sql[adjustamount];
   $bdate=$row_sql[lasttdate];
   
   $rembal=$amount;  
   $rbank=$row_sql[rbank];
   $rbrabch=$row_sql[rbranch];
   $bank=$row_sql[bank];
   $mrno=$row_sql[mrno];
   $chequeno=$row_sql[chequeno];
   $chequedate=$row_sql[demo12];
   $remarks=$row_sql[remarks]. " Advance Receive Adjustemnt";
     
 
 
 
      $user_query="select customerid,name,type,address,mobile,dircustomerinvoice.invoice,salevalue,viw_rec_amount.amount as payment  from dircustomerinvoice
                   join tbl_customer on tbl_customer.id=dircustomerinvoice.customerid
                   left join viw_rec_amount on dircustomerinvoice.invoice=viw_rec_amount.invoice
                   where (salevalue>viw_rec_amount.amount or isnull(viw_rec_amount.amount)) and dircustomerinvoice.customerid=$customer";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);
      $bal=0;
      $adjamount=0;
   if ($total>0)
      {
       $flag=true;
       while($value=mysql_fetch_array($users) and ($flag==true))
       {
        $bal=$value[salevalue]-$value[payment];
        $custid=$value[customerid];
        if($rembal<=$bal)
         {
         $flag=false;
         $amount=$rembal;
         $rembal=0;
         $customer=$value[name];
         $adjamount=$adjamount+$amount;
         }
        else
         {
         $flag=true;
         $amount=$bal;
         $rembal=$rembal-$bal;
         $customer=$value[name];
         $adjamount=$adjamount+$amount;
         }
        
        if($chequeno!='')
        {
         $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,bank,branch,chequeno,amount,
         cheqdate,depositebank,mrno,remarks,cstatus,cash,customerid) 
         value(curdate(),'$value[invoice]',0,0,'$_SESSION[userName]',
        '$rbank','$rbranch','$chequeno',$amount,'$chequedate','$bank','$mrno','$remarks','C',$amount,$custid)";     
        }
        else
        {
        $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,bank,branch,chequeno,amount,
         cheqdate,depositebank,mrno,remarks,customerid) 
         value(curdate(),'$value[invoice]',$amount,0,'$_SESSION[userName]',
        '$rbank','$rbranch','$chequeno',0,'$chequedate','$bank','$mrno','$remarks',$custid)";
        }
        
        db_query($sql) or die(mysql_error());  
       ?>
      <?
      }
      // If Rem Bal has then auto matic go to Advance Paymanes.
      $sql="update tbl_advance set adjustamount=adjustamount+$adjamount, lasttdate=curdate() where id=$id";
      db_query($sql) or die(mysql_error());
      // If Rem Bal has then auto matic go to Advance Paymanes.
      $msg="Payment Adjust Successfully.";
      }
      else
      {
      $msg="No Invoice found for adjust.";
      }
  //header("location:advancerecmentadjust.php");
  echo "Payment Adjust Successfully.";
  echo "<a href='rptrecbaldir.php'>Click Here To Go Main Page.</a>";   
 }
 
 
 
 
 
 if($_GET['mode']=='tmpsale')
 {
   $id=$_GET[id];
   $update_query = "delete  from  tbl_sales_temp where product_id=$id"; 
   db_query($update_query);
   header("location: salesbalmul.php");   
 } 	

 if($_GET['mode']=='tmpdosale')
 {
   $id=$_GET[id];
   $ref_id=$_GET[ref_id];
   $update_query = "delete  from  tbl_sales_temp where product_id=$id"; 
   db_query($update_query);
   header("location:invoiceprint.php?id=dosalesview&ref_id=$ref_id");   
 } 	

if($_GET['mode']=='tmpdo_pop_sale')
 {
   $id=$_GET[id];
   $update_query = "delete  from  tbl_sales_temp where product_id=$id"; 
   db_query($update_query);
   header("location: pop_up_sales.php");   
 } 	


 
 if($_GET['mode']=='advdelete')
 {
   $id=$_GET[id];
   $sql="select * from tbl_advance where id=$id";
   $users_skills = mysql_query($sql); 
   $value=mysql_fetch_array($users_skills);
 
   $strrem="Error Receive Adjust entry from advance receive customer :$value[customer]"; 
 
   $withdraw=($value[bcamount]-$value[adjustamount]);

 
   if($value[adjustamount]>0)
    {
      $sql="update tbl_advance set bcamount=$value[adjustamount], amount=$value[adjustamount] where id=$id";
      db_query($sql);
    }
   else
    {
     $sql="delete from tbl_advance where id=$id";
     db_query($sql);
    }
   if($value[paytype]==2)
    {
     $sql_bank="insert into tbl_bank(date,remarks,withdraw,user,type,bank)values(curdate(),'$strrem',$withdraw,'$_SESSION[userName]',2,'$value[bank]')";
     db_query($sql_bank);  
    }
   if($value[paytype]==3)
    {
     $sql_cash="insert into tbl_cash(date,remarks,withdraw,user,type,refid,poorexp)values(curdate(),'$strrem',$withdraw,'$_SESSION[userName]',4,$id,1)";
     db_query($sql_cash);      
    }
    header("location: editadvancerecment.php");   
 }

 if($_GET['mode']=='advpaydelete')
 {
   $id=$_GET[id];
   $sql="select * from tbl_advance where id=$id";
   $users_skills = mysql_query($sql); 
   $value=mysql_fetch_array($users_skills);
 
   $strrem="Error Adjust entry from advance payment to company :$value[customer]"; 
 
   $withdraw=($value[bcamount]-$value[adjustamount]);

 
   if($value[adjustamount]>0)
    {
      $sql="update tbl_advance set bcamount=$value[adjustamount], amount=$value[adjustamount] where id=$id";
      db_query($sql);
    }
   else
    {
     $sql="delete from tbl_advance where id=$id";
     db_query($sql);
    }
   if($value[paytype]==1)
    {
     $sql_bank="insert into tbl_bank(date,remarks,deposite,user,type,bank)values(curdate(),'$strrem',$withdraw,'$_SESSION[userName]',2,'$value[bank]')";
     db_query($sql_bank);  
    }
    header("location: editadvancerecment.php");   
 }


// Truck Daily Enrty Delete
 if($_GET['mode']=='truckdelete')
 {
   $id=$_GET[id];
   $sql="delete from truck_main where id=$id";
   db_query($sql);
   header("location: tr_income.php");   
 }
// End Truck Daily Entry.

// Truck Daily Enrty Delete
 if($_GET['mode']=='truckindelete')
 {
   $id=$_GET[id];
   $sql="delete from truck_main where id=$id";
   db_query($sql);
   header("location: tr_installment.php");   
 }
// End Truck Daily Entry.


// Truck Daily Expense Delete
 if($_GET['mode']=='truckexpdelete')
 {
   $id=$_GET[id];
   $sql="delete from truck_main where id=$id";
   db_query($sql);
   header("location: tr_expense.php");   
 }
// End Truck Expense Entry.


// Truck Daily Expense Delete
 if($_GET['mode']=='account')
 {
   $id=$_GET[id];
   $sql="delete from tbl_sc_account where id=$id";
   db_query($sql);
   header("location: rpt_account.php");   
 }
// End Truck Expense Entry.




// Truck Daily Expense Delete
 if($_GET['mode']=='target')
 {
   $id=$_GET[id];
   $sql="delete from tbl_target where id=$id";
   db_query($sql);
   header("location: target.php");   
 }
// End Truck Expense Entry.

// Truck Daily Expense Delete
 if($_GET['mode']=='inadjust')
 {
   $id=$_GET[id];
   $sql="delete from tbl_adjustment where id=$id";
   db_query($sql);
   $type=$_GET[type];
   if($type=0)
   {
     header("location: adjustment.php?todo=viewin");
   }
   else
   {
     header("location: adjustment.php?todo=viewde");
   }     
 }
// End Truck Expense Entry.

// Daily Cash Receive Item Delete
 if($_GET['mode']=='cash_receive')
 {
   $id=$_GET[id];
   $sql="delete from tbl_cash_temp where id=$id";
   db_query($sql);
   header("location: rec_cash_bulk.php?id=2");     
 }
// End Daily Cash Receive Item Delete




// Daily Sales Item Delete
 if($_GET['mode']=='sales_receive')
 {
   $id=$_GET[id];
   $sql="delete from tbl_daily_sales where id=$id";
   db_query($sql);
   header("location: rec_cement_sales.php?id=2");     
 }
// End Daily Cash Receive Item Delete


// Daily Sales Item Delete
 if($_GET['mode']=='cash_sales')
 {
   $id=$_GET[id];
   $tid=$_GET[type];
   $cust=$_GET[cust];
   $sql="delete from tbl_daily_sales where id=$id";
   db_query($sql);
   header("location: sales_cash.php?id=$tid&cust=$cust");     
 }
// End Daily Cash Receive Item Delete

 if($_GET['mode']=='cash_sales_pay')
 {
   $id=$_GET[id];
   $tid=$_GET[type];
   $cust=$_GET[cust];
   $sql="delete from tbl_daily_cash_sales where id=$id";
   db_query($sql);
   header("location: sales_cash.php?id=$tid&cust=$cust");     
 }


// Daily Order Item Delete
 if($_GET['mode']=='holcim_d_order')
 {
   $id=$_GET[id];
   $sql="delete from tbl_daily_order where id=$id";
   db_query($sql);
   header("location: holcim_order.php?id=2");     
 }
// End Daily Order Item Delete
  

  	
?>
