<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Company Balance";
 include "session.php";  
 include "header.php";
 $con1=date("Y-m-d");
?>

<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

 <tr>
    <td>Company: 
            <?
           $query_sql = "SELECT id,name  FROM tbl_company order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company" style="width:200px">
             <option value="">All</option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       Balance Upto :<input type="Text" id="demo11" maxlength="12" size="12" value="<?=isset($_POST["demo11"])?$_POST["demo11"]: $con1?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
   </td>
   <!--<td> Summary <input type="checkbox" name="cosum" <?if($_POST[cosum]==on){echo "CHECKED";}?> /></td>-->
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
 
</table>
</form>




<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Display Credit Amount.</td></tr> 
   <tr id="trhead">    
       <td>Company Name</td> 
       <td>Purchase Value</td>
       <td>Total Payment</td>
       <td>Payment At Bank</td>
       <td>Balance</td>
      </tr>     
  
    <?
     if(isset($_POST["view"])) 
     {
      $con="where dt<='$_POST[demo11]'";
      if($_POST[company]!=='')
       {
        $con=$con. " and view_com_stat_base.company='$_POST[company]'";
       }
      
             
       $user_query="select tbl_company.name,view_com_stat_base.company, sum(rec) as totalrec,sum(svalue) as salesvalue,sum(pvalue) as payment 
                          from view_com_stat_base
                          join tbl_company on view_com_stat_base.company=tbl_company.id
                          $con
                          group by view_com_stat_base.company
                          order by name asc";
          
      
     }
     else
     {
       
       $user_query="select tbl_company.name,view_com_stat_base.company, sum(rec) as totalrec,sum(svalue) as salesvalue,sum(pvalue) as payment 
                          from view_com_stat_base
                          join tbl_company on view_com_stat_base.company=tbl_company.id
                          group by view_com_stat_base.company
                          order by name asc
                          ";
                     
    }  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       $totalamount=0;
       while($value=mysql_fetch_array($users))
       {
       $bal=$value[salesvalue]-$value[totalrec];
        if($bal<0){$bg="bgcolor='#AABBCC'";} else {$bg="bgcolor='#FFFFFF'";}
       ?>
       <tr <? echo $bg;?>>
          
          <td><?=$value[name];?></td>
          <td align="right"><?=number_format($value[salesvalue],2);?>&nbsp;</td>
          <td align="right"><?=number_format($value[totalrec],2);?>&nbsp;</td>
          <td align="right"><?=number_format($value[totalrec]-$value[payment],2);?>&nbsp;</td>
          <td align="right"><?=number_format($bal,2);?>&nbsp;</td>       
       </tr>
       <?
        $totalamount=$totalamount+$bal;
       }
      }
    ?>  
  
  <tr id="trsubhead"><td colspan="2"> Total Amount :</td><td colspan="3" align="right"><b><?=number_format($totalamount,2);?></b></td></tr>
 </table>

<?php
 include "footer.php";
?>
