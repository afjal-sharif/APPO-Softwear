<?php
 session_start();
 $mnuid=201;
 include "includes/functions.php";
 include "session.php";  
 @checkmenuaccess($mnuid);
 include "header.php";
?>

<script language="javascript">

function validate_pro(thisform)
{
 
with (thisform)
  {
   if (validate_required(demo11,"Error On Date Field!")==false){demo11.focus();return false;}
   if (validate_required(donumber,"Error On Reference Field!")==false){donumber.focus();return false;}
   if (validate_required(company,"Error On Company Field!")==false){company.focus();return false;}  
  }  
}

function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {alert(alerttxt);return false;}
  }
}



function ConfirmChoice()
{
answer = confirm("Are You Sure To Place Order ?")
if (answer !=0)
{
window.submit();
}
}	
</script>




<?
      $user_query="Select (max(autodoid)+1)as donumber from tbl_order   
                          where  ((donumber not like 'C%' and donumber not like 'O%'))";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $newdonumber=$row_sql[donumber];
?>



<form name="myForm" method="post" action="process.php" enctype="multipart/form-data" onsubmit="return validate_pro(this)">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="2" height="40px">New Purchase, Place Order</td></tr>  
 
 <tr align="center">
      <td colspan="1">
           Date :<input type="Text" id="demo11" maxlength="15" size="15" value="<?=isset($_POST["demo11"])?$_POST["demo11"]:$_SESSION[dtcompany]?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
      </td>
      
      <td colspan="1">
        DO Number:<input type="text" name="donumber" value="<?=$newdonumber;?>" size="8" />
      </td>
 </tr>
   
 <tr align="center">
        <td colspan="1">
         Supplier: 
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
              <select name="company"  style="width: 250px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($cat==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
  
          <input type="hidden" name="data_type" value="order" />
          <input type="hidden" name="sp" value="Office" />
       </td>
       <td>
         Order Qty: <input type="text" name="qty" size="12"  value="0" />
       </td>
     
       </tr>
       
       <!--
       <tr>
          <td colspan="1">
             Delivery Fair (Total):<input type="text" name ="dfcost"  value="0" size="20"  />
              Cash Expense <input type="checkbox" name="dfcash"  CHECKED onchange="PayMethod()" />
          </td>
          <td colspan="1">UnLoad & Others Cost( Total):<input type="text"  name ="locost" value="0" size="20"  />
            Cash Expense <input type="checkbox" name="locash" CHECKED  onchange="PayMethod()" />
          </td>
       </tr> 
       -->
       
       
     <tr align="center">
          <td colspan="1">Truck No :<input type="text" name ="truckno" size="20"  /></td>
          <td colspan="1">Remarks :<input type="text" name ="remarks" size="60"  /></td>
     </tr> 
        
     <tr id="trsubhead"><td colspan="2" align="center" height="40px">
       <input type="submit"  name="submit" onclick="ConfirmChoice(); return false;" value="   Save & Add Item " /> </td> 
     </tr>
</table>
</form>


<?php
 include "footer.php";
?>
