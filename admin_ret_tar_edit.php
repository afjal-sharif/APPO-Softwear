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
answer = confirm("Are You Sure To Add New Target ?")
if (answer !=0)
{
window.submit();
}
}	

function Confirm()
{
answer = confirm("Are You Sure To Delete this Target ?")
if (answer !=0)
{
window.submit();
}
}	
</script> 

<?php
if(isset($_POST["submit"]))
 {
     
   $skill_id=$_POST[skill_id]; 
   $user=$_SESSION['userName']; 
   $target=$_POST[target];
    
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $target_ben= $target[$id];
    
    $skill_id_result=$skill_id[$id];  
     
    $sql="update tbl_retailer_target set target='$target_ben' where id='$skill_id_result'";
    db_query($sql);
   }
    echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Target Update Successfully</b>";
    // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="900px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Retailer Target Entry Form</td></tr>  
  
    <tr bgcolor="#FFEE09" align="center">    
       <td> Year :
          <select name="year" style="width: 80px; height: 28px; border-width:1px;border-color:#FF0000;">
           <option value="2016" <?php if($_POST["year"]=='2016') echo "selected";?>>2016</option>
           <option value="2017" <?php if($_POST["year"]=='2017') echo "selected";?>>2017</option>
           <option value="2018" <?php if($_POST["year"]=='2018') echo "selected";?>>2018</option>
           <option value="2019" <?php if($_POST["year"]=='2019') echo "selected";?>>2019</option>
           <option value="2020" <?php if($_POST["year"]=='2020') echo "selected";?>>2020</option>
          </select>
       </td>
       <td>
          Month: 
          <select name="month" style="width: 50px; height: 28px; border-width:1px;border-color:#FF0000;">
               <?
               for ($x=1; $x<=12; $x++)
                {
               ?>
                 <option value="<?=$x?>" <?php if($_POST["month"]=="$x") echo "selected";?>><?=$x?></option>
               <?
               }
               ?>
           </select>
      </td>
      <td colspan="1">
         Company 
          <?
           $query_sql = "SELECT id,name  FROM tbl_company where status=0 order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
          <select name="company"  style="width: 180px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($cat==$row_sql['id']) echo "SELECTED"; if($_POST["company"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>

      
      
       <td colspan="1"> Area Name:
         
          <?
           $query_sql = "SELECT id,shortname as name  FROM tbl_sp order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="sp" style="width: 120px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['id'];?>" <?php if($_POST["sp"]==$row_sql['id']) echo "selected";?> ><?php echo $row_sql['name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
          </select>
       </td>
       <td colspan="1" align="center"><input type="submit" name="view"  value="   View    " /> </td>
    </tr>
   
</table>
</form>


<?php
 if(isset($_POST["sp"]))
 {
 ?>
 <form name="abc" action="" method="post">
 <table width="900px" class="hovertable" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="7">Customer Target</td></tr>  
   <tr align="center" bgcolor="#FFFF99">
      <td>SL</td>
      <td>Company</td>
      <td>Customer</td>
      <td>Year</td>
      <td>Month</td>
      <td>Target</td>
      <td>&nbsp;</td>
   </tr>
   
   <?php
    
      $user_query="select tbl_customer.*,tbl_retailer_target.*,tbl_company.name as comname,tbl_retailer_target.id as tid from tbl_customer 
                     join tbl_retailer_target on tbl_customer.id=tbl_retailer_target.customer
                     join tbl_company on   tbl_company.id=tbl_retailer_target.company       
                  where tbl_customer.sp='$_POST[sp]' and tbl_retailer_target.year='$_POST[year]'
                  and tbl_retailer_target.month='$_POST[month]' and tbl_retailer_target.company='$_POST[company]'
                   order by name,customer,year,month asc";  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      { 
        $count=0;
        
        while($value=mysql_fetch_array($users))
         {
           $count=$count+1;
           
            echo "<tr align='center'>
                 <td>$count</td>
                 <td>$value[comname]</td>
                 <td>$value[name]</td>
                 <td>$value[year]</td>
                 <td>$value[month]</td>
                 <td align='right'>$value[target]</td>";
             ?>
              <input name="work[]" type="hidden" value="<?=$value['tid'];?>" />
              <input name="skill_id[<?=$value[tid];?>]" type="hidden" value="<?=$value['tid'];?>" />    
              <td><input type="text" size="5" value="<?=$value[target]?>"  name="target[<?=$value[tid];?>]" /> </td>
             <?php    
             echo"</tr>";
             $totaltarget=$totaltarget+$value[target];
         }
       
       echo "<tr align='center' id='trsubhead'>
                <td colspan='4'>Total</td>
                <td colspan='2'>".number_format($totaltarget,0)."</td>
                <td>&nbsp;</td>
             </tr>";
       ?>
        <tr id="trsubhead"><td colspan="14" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value="   UPDATE  " /> </td> </tr>
       <?   
      }
   ?>
 </table>
 </form>
<?php 
 }
?>
  
<?php
 include "footer.php";
?>

