<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Balance Sheet";
 include "session.php";  
 include "header.php";
 $totalcedit=0;
 $totaldebit=0;
?>

<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Save This Balance Sheet ?")
if (answer !=0)
{
window.submit();
}
}	
</script>


<form name="myForm" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border="2" cellspacing="1" cellpadding="5" style="border-collapse:collapse;">
     <tr align="left" id="trsubhead">  
         <td>
          Select Date:
           <?
            $query_sql="select distinct `date` from tbl_bs order by date desc";
            $sql = mysql_query($query_sql) or die(mysql_error());
            $row_sql = mysql_fetch_assoc($sql);   
           ?>
           <select name="date" style="width: 150px;">
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['date'];?>" <?php if($_POST["date"]==$row_sql['date']) echo "selected";?> ><?php echo $row_sql['date']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
         <input type="submit"  name="submit"  value=" View " /></td>
     </tr>
</table>
</form>


<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4"><?=$global['site_name']?> Balance Sheet</td>
 
 </tr> 
   <tr bgcolor="#FFCCAA" id="trhead">    
       <td>Head</td>
       <td>Description</td>
       <td>Assets</td> 
       <td>Liabilities & OE</td>   
   </tr>
   <?
     if(isset($_POST["submit"]))
     {
      $user_query="select * from tbl_bs where `date`='$_POST[date]' order by id asc";
     }
     else
     {
      $user_query="select * from tbl_bs where `date`=curdate() order by id asc";
     } 
      
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
          if($value[head]=='')
          {
           echo "<tr id='trsubhead'>";
          }
        else
          {
            echo "<tr>";
          }
         
       ?>
       
          <td align="left"><?=$value[head];?></td>
          <td><?=$value[description];?></td>
          <td align="right"><?=number_format($value[assets],2);?></td>
          <td align="right"><?=number_format($value[liab],2);?></td>  
       </tr>
       <?
       }
      }
    ?> 
 </table>
<?php
 include "footer.php";
?>
