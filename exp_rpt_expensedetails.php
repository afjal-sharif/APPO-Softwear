<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>



<form name="order" method="post" action="">
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
<tr><td colspan="6" align="center"  id="trhead"><b>Expense Details Report</b></td></tr>
 <tr>
   <td>Date: <input type="Text" id="demo11" maxlength="10" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:date('Y-m-d')?>" name="demo11";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>
   <td>To: 
       <input type="Text" id="demo12" maxlength="15" size="10" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:date('Y-m-d')?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
   </td>

      
         <td>     
         <?
           $query_sql = "SELECT id,bankname,accountcode  FROM tbl_bank_name order by bankname";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="bank"  style="width: 150px;">
               <option value=""></option>
               <option value="Cash" <?php if($_POST[bank]=='CASH') echo "SELECTED";?>>CASH - EXPENSE</option>
         <?
             do {  
         ?>
            <option value="<?php echo $row_sql['accountcode'];?>" <?php if($_POST["bank"]==$row_sql['accountcode']) echo "selected";?> ><?php echo $row_sql['bankname']?> : <?php echo $row_sql['accountcode']?>  </option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>
        </td> 
    


      <td>
          <?
           $query_sql = "SELECT id,name  FROM tbl_expense_main order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select id="expense" name="expense" style="width: 220px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["expense"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>


       <td align="center">
            <div id="divexpense">
             
                <?      
                if($_POST[expense]!='')
                 {
                  $query_sql = "SELECT  id,type  FROM `tbl_expense_cat`  where expensetype='$_POST[expense]' order by type";
                 }
                else
                 { 
                  $query_sql = "SELECT  id,type  FROM `tbl_expense_cat`  where expensetype=0 order by type";
                 }
                $sql = mysql_query($query_sql) or die(mysql_error());
                ?> 
             <select name="type"   id ="type" style="width:150px">   
		               <option value=""></option>
		            <?   
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['id'];?>" <?if($rs['id']==$_POST[type]) echo "Selected";?>><?=$rs['type'];?></option>
                 <?    
		             }
		       ?>
             </select>
            </div>
       </td>
   <td><input type="submit" name="view" value= "  View  "> </td>
 </tr>
</table>
</form>

<br>

<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <!--
 <tr id="trhead"><td colspan="6" align="left">Total <? if($_POST[bank]=='CASH') {echo "Cash";}else { echo "Bank";} ?> Expense :  Tk. <?=number_format($balance,2);?> </td></tr>
 --> 

 <tr id="trhead"><td colspan="7">Display Expense Transection.</td></tr> 

   <tr id="trsubhead">    
       <td>Date</td>
       <td>Source</td>
       <td>Category</td>
       <td>Exp.Head</td>
       <td>Remarks</td>
       <td>Cash</td>
       <td>Bank</td> 
            
      </tr>     
    <?
      if(isset($_POST["view"]))
      {
       $conexp='';
       $conbank='';
       
       if ($_POST[expense]!='')
        {
          $conexp=$conexp." and view_expense_details.expensetype=$_POST[expense]";
        }
       
       if ($_POST[type]!='')
        {
          $conexp=$conexp." and view_expense_details.id='$_POST[type]'";
        }
       if ($_POST[bank]!='')
        {
          $conexp=$conexp." and view_expense_details.efrom='$_POST[bank]'";
        }
       
       
       
         $user_query="Select * from view_expense_details 
                       where (date between '$_POST[demo11]' and '$_POST[demo12]') 
                       $conexp
                       order by view_expense_details.date desc,view_expense_details.id desc";
       
          
      }
      else
      {   
      $user_query="Select * from view_expense_details order by date desc limit 0,10";
      }
      $totaldepo=0;
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        
       ?>
       <tr align="center">
          <td><?=$value[date];?></td>
          <td><?=$value[efrom];?></td>
          <td><?=$value[headname];?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[cash],2);?></td>
          <td align="right"><?=number_format($value[bank],2);?></a></td>
       </tr>
       <?
       $totalcash=$totalcash+$value[cash];
       $totalbank=$totalbank+$value[bank];
       }
      }
    ?>  
  </tr>
 <tr id="trhead">
     <td colspan="3" align="center"><b>Total :</b></td>
     <td colspan="2" align="center"><b><?=number_format($totalcash+$totalbank,2)?></b></td>
     <td colspan="1" align="right"><b><?=number_format($totalcash,2)?></b></td>
     <td colspan="1" align="right"><b><?=number_format($totalbank,2)?></b></td>
     
  </tr>
 </table>
<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>
