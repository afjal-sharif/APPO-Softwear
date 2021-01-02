<?php
 include "includes/functions.php";
 include "session.php";  
 
       
       $user_query="Select (max(automrno)+1)as mrno from tbl_dir_receive";
       $users = mysql_query($user_query);
       $row_sql= mysql_fetch_assoc($users);
       $newmrnomain=$row_sql[mrno];
       
       
       $user_dispaly="select tbl_temp_incentive.*,tbl_customer.name as cust_name,tbl_company.name as com_name 
                     from tbl_temp_incentive
                     join tbl_customer on tbl_customer.id=tbl_temp_incentive.customer
                     join tbl_company on tbl_company.id=tbl_temp_incentive.company
                     ";
      $users = mysql_query($user_dispaly);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {    
        while($value=mysql_fetch_array($users))
        {  
                if($comid!=$value[company])
                {
                 $product_in='';
                 $sql_product="SELECT distinct tbl_sales.product as product FROM `tbl_sales` 
                                       join tbl_order on tbl_order.donumber=tbl_sales.donumber
                                       where tbl_order.company='$value[company]' and year(tbl_sales.date)='$value[date_from]' and month(tbl_sales.date)='$value[date_to]'";
                 $users_product = mysql_query($sql_product);
                 $pcount=0;
                 while($value_product=mysql_fetch_array($users_product))
                   {
                    if($pcount==0)
                     {
                      $product_in=$value_product[product];
                     }   
                    else
                     {
                       $product_in=$product_in.','.$value_product[product];
                     } 
                   
                    $pcount=$pcount+1;
                   }                      
                }
                
                
                $pay=$value[qty]*$value[rate];
                $add=$value[addition];
                $addjust=$pay+$add;
                $sql="insert into tbl_incentive_pay(batch,customerid,company,productid,qty,rate,pay,adjust,withdraw,user,date,remarks,indate)
                       values('$value[date_from]-$value[date_to]','$value[customer]','$value[company]','0','$value[qty]','$value[rate]','$pay','$add','$addjust','$_SESSION[userName]','$_SESSION[dtcustomer]','$value[remarks]','$_SESSION[dtcustomer]')";
                db_query($sql) or die(mysql_error());
                $count=$count+1;
                
                //echo "<br>";
                
                $remarks=$value[remarks].' Date:'.$value[date_from].'-'.$value[date_to]; 
                $sql="insert into tbl_dir_receive (date,invoice,hcash,discount,user,mrno,remarks,automrno,customerid,paytype,paycompany,cstatus) 
                     value('$_SESSION[dtcustomer]','','$addjust',0,'$_SESSION[userName]','IA-$newmrnomain','$remarks','$newmrnomain','$value[customer]','Incentive','$value[company]','C')";     
                db_query($sql) or die(mysql_error());  
                
                
                
                $sql="update tbl_sales set payincentive=1,inbatch='$value[date_from]-$value[date_to]'
                             where (tbl_sales.date between '$value[date_from]' and '$value[date_to]') and customerid='$value[customer]'
                             and tbl_sales.product in ($product_in)
                                       
                             ";
                db_query($sql) or die(mysql_error());
                
                $sql="delete from tbl_temp_incentive where id='$value[id]'";
                db_query($sql);
                
                $newmrnomain=$newmrnomain+1;
            
           $comid=$value[company];
       }        
      }
   header("location: post_incentive.php?id=1");
?> 
