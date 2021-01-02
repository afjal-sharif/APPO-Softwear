<?php
 include "includes/functions.php";
 include "session.php";  
 set_time_limit(0);
 if($_POST[data_type]=='order')
  {
    $date=$_POST[demo11];
    $donumber=$_POST[donumber];
    $company=$_POST[company];
    $sp=$_POST[sp];
    $remarks=$_POST[remarks];
    $truckno=$_POST[truckno];
    $dfcost=$_POST[dfcost];
    $locost=$_POST[locost];
    $qty=$_POST[qty];
    
    $_SESSION[refid]=$donumber;
    
    $sql="insert into tbl_order (dtDate,donumber,company,product,qty,rate,deliveryfair,locost,user,punit,factor,autodoid,paydate,remarks,truckno,sp) 
        value('$_POST[demo11]','$_POST[donumber]',$_POST[company],1,$qty,1,'$dfcost','$locost','$_SESSION[userName]','-',1,$_POST[donumber],'','$_POST[remarks]','$truckno','$_POST[sp]')"; 
    db_query($sql) or die(mysql_error()); 
    
    /*
    if($_POST[dfcash]==on)
    {
      if($dfcost>0)
       {
             $remarks="Goods Receive Carring Expense for Ref No:$donumber";
             $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type,expensetype,poorexp) 
                   value('$_POST[demo11]','$remarks',0,$dfcost,$dfcost,'$_SESSION[userName]',1,300,2)"; 
             db_query($sql) or die(mysql_error());
       }
    }
    if($_POST[locash]==on)
    {
      if($locost>0)
       {
            $remarks="Goods Receive Unload & Others Expense for Ref No:$donumber";
            $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type,expensetype,poorexp) 
                  value('$_POST[demo11]','$remarks',0,$locost,$locost,'$_SESSION[userName]',1,300,2)"; 
            db_query($sql) or die(mysql_error());
       }
    }
    */
    
    header("location: pur_item.php?id=$donumber");
  }
  
  if($_POST[data_type]=='cash_receive')
  {
      $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];
     
     
     $user_query="select tbl_cash_temp.*,name,address,sp from tbl_cash_temp    
                 join tbl_customer on tbl_customer.id=tbl_cash_temp.cust_id 
                 where tbl_cash_temp.user='$_SESSION[userName]'
                 order by name asc";
     $users = mysql_query($user_query);
     while($value=mysql_fetch_array($users))
       {
        
        $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,depositebank,mrno,remarks,automrno,customerid,cstatus,paytype) 
         value('$_SESSION[dtcustomer]','',$value[cash],0,'$_SESSION[userName]','Cash','$newmrnomain','Daily Collection','$newmrnomain',$value[cust_id],'C','Cash')";     
        db_query($sql) or die(mysql_error());  
       
        $remarks="Daily Collection:Cash from $value[name] ($value[cust_id])";
        $sql="insert into tbl_cash(date,remarks,deposite,user,refid)values('$_SESSION[dtcustomer]','$remarks',$value[cash],'$_SESSION[userName]','$newmrnomain')";
        db_query($sql) or die(mysql_error()); 
        $newmrnomain=$newmrnomain+1;
       }
        
   header("location: rec_cash_bulk.php?id=3");
  }   
  
 
 if($_POST[data_type]=='sales_receive')
  {
      $user_query="Select (max(autoinvoice)+1)as mrno from tbl_sales";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];
     
     
     $user_query="select tbl_daily_sales.*,name,address,sp from tbl_daily_sales    
                 join tbl_customer on tbl_customer.id=tbl_daily_sales.cust_id 
                 where tbl_daily_sales.user='$_SESSION[userName]'
                 order by name asc";
     $users = mysql_query($user_query);
     while($value=mysql_fetch_array($users))
       {
        
       $salesqty=$value[qty];
       $balqty=$salesqty;
       do
       {
        
       $sql="SELECT donumber,sum(qty) as sqty FROM `view_stock_details_base` where `product`='$value[product]'
              group by donumber
              having sum(qty)>0
              order by min(dt)
              limit 0,1";
       $users_do = mysql_query($sql);
       $row_sql_do= mysql_fetch_assoc($users_do);
       $donumber=$row_sql_do[donumber]; 
       $stockqty=$row_sql_do[sqty]; 
       
       if($balqty>$stockqty)
       {
        $entryqty=$stockqty;
        $balqty=$balqty-$stockqty;
       }
       else
       {
        $entryqty=$balqty;
        $balqty=0;
       }
        
        $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
            soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination) 
            value('$_SESSION[dtcustomer]','$donumber','$value[product]', '$newmrnomain',$value[rate],$entryqty,0,
             '$_SESSION[userName]',$value[cust_id],1,'Bag',$value[cost]/$value[qty],'DS:$_SESSION[dtcustomer]',
              '-','$value[remarks]','-','$newmrnomain',0,'$value[sp]','$_SESSION[dtcustomer]','$value[address]','-')"; 
       db_query($sql) or die(mysql_error());
       //echo "<br>"; 
          
       }while ($balqty>0);
        $newmrnomain=$newmrnomain+1;
       }
        
   header("location: rec_cement_sales.php?id=3");
  }   
   
 
 
 if($_POST[data_type]=='sales_cash')
  {
      $user_query="Select (max(autoinvoice)+1)as mrno from tbl_sales";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newmrnomain=$row_sql[mrno];
     
     
     $user_query="select tbl_daily_sales.*,name,address,sp from tbl_daily_sales    
                 join tbl_customer on tbl_customer.id=tbl_daily_sales.cust_id 
                 where tbl_daily_sales.user='$_SESSION[userName]'
                 order by name asc";
     $users = mysql_query($user_query);
     while($value=mysql_fetch_array($users))
       {
        
       $salesqty=$value[qty];
       $balqty=$salesqty;
       do
       {
        
       $sql="SELECT donumber,sum(qty) as sqty FROM `view_stock_details_base` where `product`='$value[product]'
              group by donumber
              having sum(qty)>.5
              order by donumber
              limit 0,1";
       $users_do = mysql_query($sql);
       $row_sql_do= mysql_fetch_assoc($users_do);
       $donumber=$row_sql_do[donumber]; 
       $stockqty=$row_sql_do[sqty]; 
       
       if($balqty>$stockqty)
       {
        $entryqty=$stockqty;
        $balqty=$balqty-$stockqty;
       }
       else
       {
        $entryqty=$balqty;
        $balqty=0;
       }
       if($donumber!='')
        { 
         $sql="insert into tbl_sales (date,donumber,product,invoice,rate,qty,bundle,user,customerid,factor,unit,df,truckno,
            soid,remarks,customername,autoinvoice,loadcost,sp,coldate,destination,bdestination) 
            value('$_SESSION[dtcustomer]','$donumber','$value[product]', '$newmrnomain',$value[rate],$entryqty,0,
             '$_SESSION[userName]',$value[cust_id],1,'Bag',$value[cost]/$value[qty],'DCS:$_SESSION[dtcustomer]',
              '-','$value[remarks]','-','$newmrnomain',0,'$value[sp]','$_SESSION[dtcustomer]','$value[address]','-')"; 
         db_query($sql) or die(mysql_error());
         $status=1;
         $totalentqty=$totalentqty+$entryqty;
         
         $sql="insert into tbl_stock (stockdt,donumber,product,stock,user)values('$_SESSION[dtcustomer]','$donumber','$value[product]',$entryqty*(-1),'$_SESSION[userName]')";
         db_query($sql) or die(mysql_error());
        }
       else
        {
         $balqty=0;
         $status=2;
        }  
       //echo "<br>";   
       }while ($balqty>0);
        //$newmrnomain=$newmrnomain+1;
        $sql="update tbl_daily_sales set status=$status,stock='$totalentqty' where product='$value[product]'";
        db_query($sql);
        $totalentqty=0;  
       }
       // Start Payment Module.
              $user_query="Select custid,depositebank,remarks,sum(cash) as cash,sum(bank) as bank,sum(discount) as discount from tbl_daily_cash_sales
              where user='$_SESSION[userName]' group by custid,depositebank,remarks
              order by custid
              ";
              
        $users = mysql_query($user_query);
        while($value=mysql_fetch_array($users))
         {
           if($value[custid]!=$custid)
           {
           $user_mr_no="Select (max(automrno)+1)as mrno from tbl_dir_receive";
           $users_mr = mysql_query($user_mr_no);
           $row_sql_mr= mysql_fetch_assoc($users_mr);
           $newmrnomain_mr=$row_sql[mrno];
           }
           
           $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,bank,branch,chequeno,amount,
           cheqdate,depositebank,mrno,remarks,automrno,customerid,paytype,cstatus,cash) 
           value('$_SESSION[dtcustomer]','$newmrnomain',$value[cash],$value[discount],'$_SESSION[userName]',
          'DCS','-','Online',$value[bank],'$_SESSION[dtcustomer]','$value[depositebank]','$newmrnomain_mr','$value[remarks]','$newmrnomain_mr',$value[custid],'OnLine Cash','C',$value[bank])";     
           db_query($sql) or die(mysql_error());
          
          
          $sql="select name from tbl_customer where id=$value[custid]";
          $users = mysql_query($sql);
          $row_sql= mysql_fetch_assoc($users);
          $name=$row_sql[name];
     
         if($value[cash]<>0)
         {
          $remarks="Sales:Cash from $name ($value[custid]) $value[remarks]";
          $sql="insert into tbl_cash(date,remarks,deposite,user,refid)values('$_SESSION[dtcustomer]','$remarks',$value[cash],'$_SESSION[userName]','$newmrnomain_mr')";
          db_query($sql) or die(mysql_error());  
         }
         if($value[bank]<>0)
         {
          $remarks="Sales:Online Cash from $name ($value[custid]) $value[remarks]";
          $sql="insert into tbl_bank (date,remarks,deposite,user,type,bank,rec_ref_id) values('$_SESSION[dtcustomer]','$remarks',$value[bank],'$_SESSION[userName]',1,'$value[depositebank]','$newmrnomain_mr')";
          db_query($sql) or die(mysql_error());  
         }
        
        if($value[discount]<>0)
        {
         $remarks="Sales:Cash Discount Recieve from $name ($value[custid])";
         $sql="insert into tbl_cash(date,remarks,deposite,user,type,refid)values('$_SESSION[dtcustomer]','$remarks',$value[discount],'$_SESSION[userName]',2,'$newmrnomain_mr')";
         db_query($sql) or die(mysql_error());  
      
         $remarks="Sales:Cash Discount To $name ($value[custid])";
         $sql="insert into tbl_cash(date,remarks,withdraw,user,expensetype,type,refid,poorexp)values('$_SESSION[dtcustomer]','$remarks',$value[discount],'$_SESSION[userName]',100,1,'$newmrnomain_mr',2)";
         db_query($sql) or die(mysql_error());  
        }   
            
         $custid=$value[custid];
         }   
              
   header("location:sales_cash.php?id=3");
  }   
  
  
  
?> 
