<?php 
 include_once "includes/functions.php";
 include "session.php";
 
if($_GET['mode']=='Bank')
{
   $id=$_GET[id];
   $status=$_GET[status];
   
   if ($status==1)
   {
    $invoice=$_GET[invoice];
    $cheque=$_GET[cheque];
    $amount=$_GET[amount];
    $deposite=$_GET[code];
    $mrno=$_GET[mrno];
    $insert_query = "update tbl_dir_receive set cash=amount, cstatus='C',bdate='$_SESSION[dtcustomer]',buser='$_SESSION[userName]' where id=$id"; 
    db_query($insert_query) or die(mysql_error());
   
    
    $sql_name="select name from tbl_customer where id='$invoice'";
    $users_name = mysql_query($sql_name);
    $row_name= mysql_fetch_assoc($users_name);
    $cust_name=$row_name[name];  
    
    $remarks="Sales:Cheque Clear From :$cust_name Cheque No: $cheque.";   
    $sql="insert into tbl_bank (date,remarks,deposite,user,type,chequeid,bank,rec_ref_id) values('$_SESSION[dtcustomer]','$remarks',$amount,'$_SESSION[userName]',1,$id,'$deposite','$mrno')";
    db_query($sql) or die(mysql_error());    
   }
   else
   {
    $insert_query = "update tbl_dir_receive set cstatus='B',bdate='$_SESSION[dtcustomer]',buser='$_SESSION[userName]' where id=$id"; 
    db_query($insert_query);
   }
   header("location:bankclear.php");
 } 	


if($_GET['mode']=='CBank')
{
   $id=$_GET[id];
   $status=$_GET[status];
  
  $insert_query = "update tbl_dir_receive set cash=0, cstatus='N',bdate='',buser='$_SESSION[userName]' where id=$id"; 
  db_query($insert_query) or die(mysql_error());
  
  $sql="delete from tbl_bank where chequeid=$id";
  db_query($sql) or die(mysql_error()); 
  header("location:bankclear.php");
 } 	


if($_GET['mode']=='cash')
{
  $id=$_GET[id];
   
  $insert_query = "delete from tbl_cash where id=$id"; 
  db_query($insert_query);
   
  header("location:cash.php");
 } 	


if($_GET['mode']=='othersincome')
{
  $id=$_GET[id];
  $bank=$_GET[bank];
  if($bank=='Cash')
  { 
    $insert_query = "delete from tbl_cash where id=$id"; 
    db_query($insert_query);
  }
  else
  {
    $insert_query = "delete from tbl_bank where id=$id"; 
    db_query($insert_query);
  
  }
   
  header("location:othersincome.php");
 } 	




if($_GET['mode']=='expense')
{
  $id=$_GET[id];
   
  $insert_query = "delete from tbl_cash where id=$id"; 
  db_query($insert_query);
   
  header("location:expense.php");
 } 	


if($_GET['mode']=='truckpay')
{
  $id=$_GET[id];
   
  $sql="SELECT date,refid,withdraw,remarks FROM tbl_cash where id=$id";
  $users = mysql_query($sql);
  $row_sql= mysql_fetch_assoc($users);
  $date=$row_sql[date];
  $refid=$row_sql[refid];
  $withdraw=$row_sql[withdraw];
  $remarks=$row_sql[remarks];
  
  $insert_query = "delete from truck_main where date='$date' and tid='$refid' and income=$withdraw and remarks='$remarks' and type='Transection'"; 
  db_query($insert_query);

  $insert_query = "delete from tbl_cash where id=$id"; 
  db_query($insert_query);
     
  header("location:truckpayment.php");
 } 	



if($_GET['mode']=='banktra')
{
  $id=$_GET[id];
   
  $insert_query = "delete from tbl_bank where id=$id"; 
  db_query($insert_query);
   
  header("location:banktran.php");
 } 	


if($_GET['mode']=='incentive')
{
  $id=$_GET[id];
   
  $insert_query = "delete from tbl_incentive where id=$id"; 
  db_query($insert_query);
   
  header("location:incentive.php");
 } 	


if($_GET['mode']=='PayBank')
{
   $id=$_GET[id];
   $status=$_GET[status];
   
   $sql="SELECT * FROM tbl_com_payment where id=$id";
   $users = mysql_query($sql);
   $row_sql= mysql_fetch_assoc($users);
   $balance=$row_sql[balance];
   
   if ($status==1)
   {
    $insert_query = "update tbl_com_payment set bamount=amount, status='C',bdate='$_SESSION[dtcompany]',buser='$_SESSION[userName]' where id=$id"; 
    db_query($insert_query) or die(mysql_error());
   
    $sql_name="select name from tbl_company where id='$row_sql[companyid]'";
    $users_name = mysql_query($sql_name);
    $row_name= mysql_fetch_assoc($users_name);
    $com_name=$row_name[name];  
      
    $remarks="Purchase:Cheque Clear To:$com_name Cheque No: $row_sql[chequeno]";   
    $sql="insert into tbl_bank (date,remarks,withdraw,user,type,chequeid,bank,rec_ref_id) 
                        values('$_SESSION[dtcompany]','$remarks',$row_sql[amount],'$_SESSION[userName]',3,$id,'$row_sql[bank]','$id')";
    db_query($sql) or die(mysql_error());    
   }
   
   if ($status==0)
   {
    $insert_query = "update tbl_com_payment set status='B',bdate='$_SESSION[dtcompany]',buser='$_SESSION[userName]' where id=$id"; 
    db_query($insert_query);
   }
  
  if ($status==2)
   {
    $insert_query = "update tbl_com_payment set status='W',amount=0,wamount=$row_sql[amount], bdate='$_SESSION[dtcompany]',buser='$_SESSION[userName]' where id=$id"; 
    db_query($insert_query);
   } 
   
   header("location:paybankclear.php");
 } 	



if($_GET['mode']=='CPayBank')
{
   $id=$_GET[id];
   $status=$_GET[cstatus];
  if ($status=='W')
   {
    $insert_query = "update tbl_com_payment set bamount=0,amount=wamount, status='N',bdate='',buser='$_SESSION[userName]' where id=$id";
   }
  else
   { 
    $insert_query = "update tbl_com_payment set bamount=0, status='N',bdate='',buser='$_SESSION[userName]' where id=$id"; 
   } 
   db_query($insert_query) or die(mysql_error());
  
  $sql="delete from tbl_bank where chequeid=$id";
  db_query($sql) or die(mysql_error()); 
  header("location:paybankclear.php");
 } 	


if($_GET['mode']=='AdvPayBank')
{
   $id=$_GET[id];
   $status=$_GET[status];
   
   $sql="SELECT * FROM tbl_advance where id=$id";
   $users = mysql_query($sql);
   $row_sql= mysql_fetch_assoc($users);
   $balance=$row_sql[balance];
   
   if ($status==0)
   {
    $insert_query = "update tbl_advance set bcamount=amount,lasttdate=curdate(), status='C' where id=$id"; 
    db_query($insert_query) or die(mysql_error());
   
    $remarks="Purchase:Advance Cheque Clear Cheque No: $row_sql[chequeno]";   
    $sql="insert into tbl_bank (date,remarks,withdraw,user,type,chequeid,bank) 
                        values(curdate(),'$remarks',$row_sql[amount],'$_SESSION[userName]',4,$id,'$row_sql[bank]')";
    db_query($sql) or die(mysql_error());    
    header("location:paybankclear.php");
   }
   
   if ($status==1)
   {
    $insert_query = "update tbl_advance set bcamount=0,lasttdate=curdate(), status='W' where id=$id"; 
    db_query($insert_query);
    header("location:paybankclear.php");
   }
  
   if ($status==2)
   {
    $insert_query = "update tbl_advance set bcamount=amount,lasttdate=curdate(), status='C' where id=$id"; 
    db_query($insert_query) or die(mysql_error());
   
    $remarks="Purchase:Advance Receive Cheque No: $row_sql[chequeno]";   
    $sql="insert into tbl_bank (date,remarks,deposite,user,type,chequeid,bank) 
                        values(curdate(),'$remarks',$row_sql[amount],'$_SESSION[userName]',1,$id,'$row_sql[bank]')";
    db_query($sql) or die(mysql_error());    
    header("location:paybankclear.php");
   }
  
   
  
  if ($status==4)
   {
    $cheueno=$_GET[cheque];
    $insert_query = "update tbl_advance set bcamount=0,lasttdate='', status='N' where id=$id";  
    db_query($insert_query);
    $sql="delete from tbl_bank where chequeid=$id and type=1 and remarks='Advance Receive Cheque No: $cheueno'";
    db_query($sql);
    header("location:paybankclear.php"); 
   }
   
   
    
   
   if ($status==5)
   {
    $insert_query = "update tbl_advance set bcamount=0,lasttdate=curdate(), status='B' where id=$id"; 
    db_query($insert_query) or die(mysql_error());  
    header("location:paybankclear.php");
   }
   
  // For Advance paymane Clear. From Bank & Adv_payment Table.
  if ($status==6)
   {
    $bcamount=$_GET[amount];
    
    $insert_query = "update tbl_advance set bcamount=0,lasttdate='', status='N' where id=$id";  
    db_query($insert_query);
    $sql="delete from tbl_bank where chequeid=$id and type=4 and withdraw=$bcamount";
    db_query($sql);
    header("location:paybankclear.php"); 
   }
   
   
 } 	


if($_GET['mode']=='b2b')
{
  $id=$_GET[id];
   
  $insert_query = "delete from tbl_bank where id=$id"; 
  db_query($insert_query);
   
  header("location:banktobank.php");
 } 	



?>
