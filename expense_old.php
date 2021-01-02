<?php
 session_start();
 $mnuid=631;
 include "includes/functions.php";
 $msgmenu="Expense";
 include "session.php";  
 include "header.php";
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add expense ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 




<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[type]) or !Is_Numeric($_POST[withdraw])) 
   {
    echo "<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
   }
  else
   {
   $deposite=0;
   $withdraw=$_POST[withdraw];
   $balance=$deposite-$withdraw;
   
      $sql="Select * from tbl_expense_cat where id='$_POST[type]'";
      $users_sql = mysql_query($sql);
      $row_sql_adj= mysql_fetch_assoc($users_sql);
      $headname=$row_sql_adj[type]; 
       
  
      $remarks="Expense- $headname ".$_POST[remarks];
      $sql="insert into tbl_cash (date,remarks,deposite,withdraw,balance,user,type,expensetype,poorexp) 
        value('$_POST[demo12]','$remarks',0,$withdraw,$balance,'$_SESSION[userName]',1,$_POST[type],2)"; 
      db_query($sql) or die(mysql_error());
      echo "<img src='images/active.png' height='15px' width='15px'><b> Success !! Cash Expense Insert Successfully</b>";
      $exptype="CASH";
  
      
   } // Error chech If
 }// Submit If
?>


<?
      $user_query="Select sum(deposite-withdraw) as balance from tbl_cash";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $balance=$row_sql[balance];
?>





<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4" align="left"><b>Current Cash Balance : Tk. <?=number_format($balance,2);?> </b></td></tr>

 <tr id="trhead"><td colspan="4">Expense Entry Form</td></tr>  
 
 <tr id="trsubhead"><td> Date</td><td> Category</td><td> Expense Head </td><td>Withdraw </td> </tr>
    <tr bgcolor="#CCAABB">  
        <td colspan="1" align="left"> 
           <input type="Text" id="demo12"  maxlength="12" size="12" value="<?=isset($_POST["demo12"])?$_POST["demo12"]:$_SESSION[dttransection]?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a> 
        </td>
              
       
       <td>Expense Head:
          
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
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["category"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          
                     
            
            <!--
            <option value="0" <?if($_POST[type]=='0') echo "SeLECTED";?>>Administrative</option>
            <option value="1" <?if($_POST[type]=='1') echo "SeLECTED";?>>Selling & Distribution</option>
            <option value="3" <?if($_POST[type]=='3') echo "SeLECTED";?>>Financial</option>
            <option value="4" <?if($_POST[type]=='4') echo "SeLECTED";?>>Factory Overhead</option>
            <option value="2" <?if($_POST[type]=='2') echo "SeLECTED";?>>Pre-Paid Expense</option>
            -->
            
          </select>
      </td>
       <td align="center">
            <div id="divexpense">
             <select name="type"   id ="type" style="width:220px">
                <?      
                $query_sql = "SELECT  id,type  FROM `tbl_expense_cat`  where expensetype=0 order by type";
                $sql = mysql_query($query_sql) or die(mysql_error());
                ?> 
                
		               <option value=""></option>
		            <?   
		              while ($rs = mysql_fetch_assoc($sql)) 
                  { 		
			           ?>   
                     <option value="<?=$rs['id'];?>"><?=$rs['type'];?></option>
                 <?    
		             }
		       ?>
             </select>
            </div>
       </td>
       <td align="center"> <input type="text"  name="withdraw"  size="15"  value="0"  /> </td>
  </tr>
  <tr>
  
       <td align="center" colspan="5">Remarks:<input type="text" name="remarks" value="" size="90" /></td>
       
     </tr>    
     <tr id="trsubhead"><td colspan="5" align="center"><input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save  " /> </td> </tr>
</table>
</form>



<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="7">Display Last 10 Transection</td></tr> 

   <tr id="trsubhead">    
       <td>Date</td>
       
       <td>Category</td>
       <td>Expense Head</td>
       <td>Remarks</td>
       <td>Amount</td>
       <td>User</td>
       
      </tr>     
  <tr>
    <?

       $user_query="Select tbl_cash.id,date,remarks,tbl_expense_cat.type,withdraw,tbl_cash.user,'cash' as efrom,tbl_expense_cat.expensetype from tbl_cash left 
                   join tbl_expense_cat on tbl_cash.expensetype=tbl_expense_cat.id 
                   where tbl_cash.type=1 order by tbl_cash.id desc limit 0,10";
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[date];?></td>
          
          <td colspan="1"  align="left">
         <? if($value['expensetype']=='0') 
             {
              echo "Administrative";
             }
            elseif($value['expensetype']=='1')
             {
              echo "Selling & Distribution";
             } 
           elseif($value['expensetype']=='2')
             {
              echo "Pre-Paid Expense";
             } 
           elseif($value['expensetype']=='3')
             {
               echo "Financial";
             } 
           else
             {
               echo "Factory Overhead";
             }   
         ;?></td>
          <td><?=$value[type];?></td>
          <td><?=$value[remarks];?></td>
          <td align="right"><?=number_format($value[withdraw],2);?></td>
          
          <td><?=$value[user];?></td>  
            
       </tr>
       <?
       }
      }
    ?>  
  </tr>

 </table>
<script type="text/javascript" src="sp.js"></script>
<?
 include "footer.php";
?>
