<?php
 session_start();
 $msgmenu="Product Setup";
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
  ?>
<script language="javascript">
function ConfirmChoice()
{
answer = confirm("Are You Sure To Add New Product ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?
if(isset($_POST["submit"]))
 {
  if (empty($_POST[company]) or empty($_POST[product]) ) 
   {
    echo " Error !! Pls give input properly";
   }
  else
   {
   $factor=1;
   if($_POST[punit]!==$_POST[unit])
    {
      if(($_POST[punit]=='MT') and $_POST[unit]=='Bag')
       {$factor=20; }
      
      if(($_POST[punit]=='MT') and $_POST[unit]=='Kg')
       {$factor=1000; } 
      
      if(($_POST[punit]=='Bag') and $_POST[unit]=='MT')
       {$factor=0.05; } 
      
      if(($_POST[punit]=='Bag') and $_POST[unit]=='Kg')
       {$factor=50; }
       
      if(($_POST[punit]=='Kg') and $_POST[unit]=='MT')
       {$factor=0.001; } 
      
      if(($_POST[punit]=='Kg') and $_POST[unit]=='Bag')
       {$factor=0.02; }

       
       
    }
   
     
   
   $sql="insert into tbl_product (companyid,category_id,name,punit,unit,user,factor) value('$_POST[company]','$_POST[main_category]','$_POST[product]','$_POST[punit]','$_POST[punit]','$_SESSION[userName]',$factor)"; 
   db_query($sql) or die(mysql_error());
   echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Product Name insert successfully</b>";
   } // Error chech If
 }// Submit If
?>


<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="4">New Product Entry Form</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td>
         <input type="hidden" name="company" value="1" />
         Category: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_product_category order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select  id="main_category" name="main_category" style="width: 150px;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["category"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td> Product Name: <input type="text"  name="product" /> </td>
       <!--<td> Commission: <input type="text"  name="commission"  size="4" /> </td>-->

        <td>Unit Of Measure :
          <select name="punit" style="width:70px">
             <option value="Kg">Kg</option>
             <option value="Bag">Bag</option>        
         </select>
       </td>      
     </tr>    
     <tr id="trsubhead"><td colspan="3" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value="   Save  " /> </td> </tr>
</table>
</form>
    <div id="div_product">     
    </div>

<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>

