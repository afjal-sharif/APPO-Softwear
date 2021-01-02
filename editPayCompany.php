<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  
  <link href="skin.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    $sql="update tbl_dir_receive set date='$_POST[date]',mrno='$_POST[mrno]',remarks='$_POST[remarks]',
          invoice='$_POST[invoice]',paycompany=$_POST[paycompany] where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="select tbl_dir_receive.id,tbl_dir_receive.mrno, tbl_dir_receive.invoice,tbl_dir_receive.date,
                   tbl_dir_receive.hcash,tbl_dir_receive.cash,tbl_dir_receive.chequeno,tbl_dir_receive.bank,tbl_dir_receive.amount,
                   tbl_dir_receive.cstatus,tbl_dir_receive.cheqdate,tbl_dir_receive.remarks,
                   tbl_customer.name as customer,tbl_company.name as paycompany,tbl_dir_receive.customerid as pid,tbl_dir_receive.paycompany as payid
                   from tbl_dir_receive
                   join tbl_customer on tbl_dir_receive.customerid=tbl_customer.id
                   left join tbl_company on tbl_company.id= tbl_dir_receive.paycompany               
                   where tbl_dir_receive.id=$id
               ";
   
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#F090FF"><b> Cash Payment Receive Edit....</b></td></tr>
      
      
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Date :</td>
         <td><input type="text"  name="date" size="50"  value="<?=$value['date'];?>"></td>
      </tr>
      
      <tr bgcolor="#cccccc" align="center" id="trsubhead">    
         <td width=25%>Customer Name:</td>
         <td><input type="text"  name="name" size="50" READONLY  value="<?=$value['customer'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
     
     <tr  align="center"> 
       <td>MR No.</td>
       <td><input type="text"  name="mrno" size="50"  value="<?=$value['mrno'];?>"></td>
      </tr>

     <tr  align="center"> 
       <td>Remarks</td>
       <td><input type="text"  name="remarks" size="50"  value="<?=$value['remarks'];?>"></td>
      </tr>

    
      <tr  align="center"> 
       <td>Invoice No</td>
       <td><input type="text"  name="invoice" size="15" maxlength="13" value="<?=$value['invoice'];?>"></td>
      </tr>
    <!--
     <tr  align="center"> 
       <td>Cash Amount</td>
       <td><input type="text"  name="cashamount" READONLY size="15" value="<?=$value['hcash'];?>"></td>
      </tr>
     -->
      <tr  align="center"> 
        <td>Pay Company</td>
        <td>
        
         <?
           $query_sql = "SELECT distinct tbl_company.id,tbl_company.name  FROM tbl_company
                         join tbl_order on tbl_company.id=tbl_order.company
                         join tbl_sales on tbl_sales.donumber=tbl_order.donumber
                         where tbl_sales.customerid=$value[pid]
                         order by tbl_company.name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="paycompany"  style="width: 300px;">
           <option value=""></option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['id'];?>" <?php if($value[payid]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?> </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>    

        </td>
       </tr>

      </table>
 
 
    <table width="80%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submit" value="  Update  "></td>
       </tr> 
     </table>
    </form>
   <?}
   else
    {
      if($flag==true)
       {
        echo " <b>Update Successfully $msg</b>.<br><br><br><br>";
       ?>
         <A HREF=javascript:void(0) onclick=window.close() title="Edit"><b>Click Here To Close </b></a>
       <? 
        
       }
    }
   
   ?>   
</body>
</html>
