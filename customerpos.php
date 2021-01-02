<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
 $_SESSION[printadv]='';
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

 <tr id="trsubhead">
      <td align="right">From Date: <input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="15" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   
    
  
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Credit Amount Direct Customer</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Customer</td>
       <td>Type</td>
       <td>Address</td>
       <td>Mobile</td>
       <td>Sales Amount</td>
       <td>Receive Amount</td>
       <td>Credit</td>
      </tr>     
  <tr>
    <?
    if(isset($_POST["view"]))
     {
      
       $user_query="select name,address,type,mobile,sum(value) as value,sum(receive) as receive from (
                         SELECT `customerid`,sum(`salevalue`) as value, 0 as receive FROM `dircustomerinvoice` 
                         where dircustomerinvoice.`date` between '$_POST[demo11]' and '$_POST[demo12]'
                         group by `customerid`
                       union all
                         SELECT customerid,0 as value,sum(`hcash`+`cash`) as receive FROM `tbl_dir_receive`
                         where `tbl_dir_receive`.`date` between '$_POST[demo11]' and '$_POST[demo12]'
                         group by customerid 
                       ) as e
                       join tbl_customer on e.customerid=tbl_customer.id 
                       group by tbl_customer.id
                       order by name";
         
     }
    else
     {
      $user_query="select name,value,receive from (
                         SELECT `customerid`,sum(`salevalue`) as value, 0 as receive FROM `dircustomerinvoice` 
                         where dircustomerinvoice.`date` between curdate() and curdate()
                         group by `customerid`
                       union all
                         SELECT customerid,0 as value,sum(`hcash`+`cash`) as receive FROM `tbl_dir_receive`
                         where `tbl_dir_receive`.`date` between curdate() and curdate()
                         group by customerid 
                       ) as e
                       join tbl_customer on e.customerid=tbl_customer.id order by name";
    
     }
    
      $_SESSION[printsql]=$user_query;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[value]-$value[receive];
       ?>
       <tr>
         
         <?
          if ($id==$value[name])
            {
              echo "<td>&nbsp;</td>";
              echo "<td>&nbsp;</td>";
              echo "<td>&nbsp;</td>";
              echo "<td>&nbsp;</td>";
             }
           else
             {
              ?>
          <td><?=$value[name];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[address];?></td>
          <td><?=$value[mobile];?></td>
      
              <?
             }  
           ?>   
                  
          <td align="right"><?=number_format($value[value],0);?></td>
          <td align="right"><?=number_format($value[receive],0);?></td>
          <td align="right"><b><?=number_format($value[value]-$value[receive],0);?></b></td>         
       </tr>
       <?
       $totalamount=$totalamount+$bal;
       $id=$value[name];
       }
       $totaldue=$totalamount;
      }
    ?>  
  
   <tr id="trsubhead"><td colspan="4"> Total Amount :</td>
                    <td colspan="3" align="right"><b><?=number_format($totalamount,2);?></b></td>
   </tr>
   
   <tr id="trsubhead"><td colspan="8">
                      <?
                       if($totalamount<>0)
                       {
                       if($totalamount>1)
                        {echo "<b><font color='Red' size='4px'><img src='images/danger.png'> !!!! Sales Amount is More.</font></b>";}
                       else
                        {echo "<b><font color='Blue' size='4px'><img src='images/yahoo.png'> !!!! Collection Amount is More</font></b>";}
                        }  
                      ?>
                     </td>
                   
   </tr>
   
 </table>

<?php
 include "footer.php";
?>
