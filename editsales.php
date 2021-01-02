<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>

<head>
  <title><?=$global['site_name']?></title>
  
  <script src="./js/code_regen.js"></script>  
  <link href="skin.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    $sql="update tbl_sales set qty=$_POST[qty],rate=$_POST[rate],df=$_POST[df],truckno ='$_POST[truckno]',
     remarks='$_POST[remarks]',loadcost=$_POST[lcost],otherscost=$_POST[ocost], bdestination='$_POST[bangla_text]' where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;   
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="select tbl_sales.id, tbl_sales.date,tbl_sales.donumber,tbl_sales.df,tbl_sales.loadcost,tbl_sales.otherscost,tbl_sales.truckno,
                   tbl_sales.invoice,tbl_sales.rate,tbl_sales.qty,tbl_sales.unit,tbl_sales.remarks,bdestination,
                   tbl_customer.name as customer,tbl_product.name as product
                   from tbl_sales
                   join tbl_order on tbl_sales.donumber=tbl_order.donumber
                   join tbl_customer on tbl_sales.customerid=tbl_customer.id
                   join tbl_product on tbl_order.product=tbl_product.id
                   where tbl_sales.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="center" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FF90CC"><b> Sales Information Edit Form.</b></td></tr>
      
      <tr bgcolor="#FFcc09" align="center" id="trsubhead">    
         <td width=25%>Customer :</td>
         <td><b><?=$value['customer'];?></b></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
    <tr  align="center"> 
       <td>Product:</td>
          <td><?=$value[product];?></td>
    </tr>
  
    
     <tr  align="center"> 
       <td>Qty : </td>
       <td><input type="text"  name="qty" size="10"  value="<?=$value['qty'];?>">&nbsp;<?=$value[unit];?></td>
      </tr>

     <tr  align="center"> 
       <td>Rate :</td>
       <td><input type="text"  name="rate" size="10" value="<?=$value['rate'];?>">&nbsp;/<?=$value[unit];?></td>
      </tr>

    
      <tr  align="center"> 
       <td>DF</td>
       <td><input type="text"  name="df" size="10" maxlength="10" value="<?=$value['df'];?>">&nbsp;/<?=$value[unit];?></td>
      </tr>
    
     <tr  align="center"> 
       <td>Load Cost</td>
       <td><input type="text"  name="lcost" size="10" value="<?=$value['loadcost'];?>">&nbsp;/<?=$value[unit];?></td>
      </tr>

      <tr  align="center"> 
        <td>Others Cost(Total)</td>
        <td><input type="text"  name="ocost" size="10" value="<?=$value['otherscost'];?>"></td>
       </tr>
      <tr  align="center"> 
        <td>Truck No:</td>
        <td>
          <?
           $query_sql = "SELECT  name  FROM truck_name order by name asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
        <select name="truckno" style="width: 180px;">          
          <option value=""></option>
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['name'];?>" <?php if($value['truckno']==$row_sql['name']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>
          
          </td>
       </tr>

     <tr  align="center"> 
        <td>Remarks</td>
        <td><input type="text"  name="remarks" size="50" value="<?=$value['remarks'];?>"></td>
       </tr>
       
     <tr> 
     
       <td colspan="1" align="center">
          &#2465;&#2503;&#2488;&#2463;&#2495;&#2472;&#2503;&#2488;&#2494;&#2472;
       </td>
       <td> 
        <textarea name="bangla_text" id="bangla" cols="30" rows="1" onfocus="" style="font-family:vrinda; font-size: 20px; width: 450px; height: 30px;" >
          <?=$value[bdestination];?>
        </textarea>
       </td>
     </tr>

       
      </table>
 
 
    <table width="80%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="center" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submit" value="  Update  "></td>
       </tr> 
     </table>
    </form>
    
    
<script>
  makePhoneticEditor('bangla'); //pass the textarea Id
</script>

    
   <?}
   else
    {
      if($flag==true)
       {
        echo "<b style='color:#FF099F'>&nbsp;&nbsp;&nbsp;&nbsp; Update Successfully $msg</b>.<br><br><br><br>";
       ?>
         <A HREF=javascript:void(0) onclick=window.close() title="Edit"><b style="color:#0000FF">&nbsp;&nbsp;&nbsp;&nbsp;Click Here To Close.</b></a>
       <? 
        
       }
    }
   
   ?>   
</body>
</html>
