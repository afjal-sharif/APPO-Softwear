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
   
   $emp_1=$_POST[1];
   $emp_2=$_POST[2];
   $emp_3=$_POST[3];
   $emp_4=$_POST[4];
   $emp_5=$_POST[5];
   $emp_6=$_POST[6];
   $emp_7=$_POST[7];
   $emp_8=$_POST[8];
   $emp_9=$_POST[9];
   $emp_10=$_POST[10];
   $emp_11=$_POST[11];
   $emp_12=$_POST[12];
   
   $year=$_POST[year];
   $month=$_POST[month];
   $company=$_POST[company];
   
   $skill_id=$_POST[skill_id];
  
  
   $user=$_SESSION['userName']; 
  
    
  foreach ($_REQUEST['work'] as $id)
   {
    //echo $id;
    $emp_ben_1= $emp_1[$id];
    $emp_ben_2= $emp_2[$id];
    $emp_ben_3= $emp_3[$id];
    $emp_ben_4= $emp_4[$id];
    $emp_ben_5= $emp_5[$id];
    $emp_ben_6= $emp_6[$id];
    $emp_ben_7= $emp_7[$id];
    $emp_ben_8= $emp_8[$id];
    $emp_ben_9= $emp_9[$id];
    $emp_ben_10= $emp_10[$id];
    $emp_ben_11= $emp_11[$id];
    $emp_ben_12= $emp_12[$id];
    
    
     $skill_id_result=$skill_id[$id];  
     
     // Delete previous target if aveaable
     
     $sql="delete from tbl_retailer_target where customer='$skill_id_result' and year='$year' and month='$month' and company='$company'";
     db_query($sql);
          
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,1,$emp_ben_1,'$company', '$_SESSION[userName]','$year-01-01')"; 
     db_query($sql);
     
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,2,$emp_ben_2,'$company','$_SESSION[userName]','$year-02-01')"; 
     db_query($sql);
     
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,3,$emp_ben_3,'$company','$_SESSION[userName]','$year-03-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_resuytlt,$year,4,$emp_ben_4,'$company','$_SESSION[userName]','$year-04-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,5,$emp_ben_5,'$company','$_SESSION[userName]','$year-05-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,6,$emp_ben_6,'$company','$_SESSION[userName]','$year-06-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,7,$emp_ben_7,'$company','$_SESSION[userName]','$year-07-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,8,$emp_ben_8,'$company','$_SESSION[userName]','$year-08-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,9,$emp_ben_9,'$company','$_SESSION[userName]','$year-09-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,10,$emp_ben_10,'$company','$_SESSION[userName]','$year-10-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,11,$emp_ben_11,'$company','$_SESSION[userName]','$year-11-01')"; 
     db_query($sql);
    
     $sql="insert into tbl_retailer_target (customer,year,month,target,company,user,date) 
          value($skill_id_result,$year,12,$emp_ben_12,'$company','$_SESSION[userName]','$year-12-01')"; 
     db_query($sql);
   }
    echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Target insert successfully</b>";
    // Error chech If
 }// Submit If
?>

<form name="newcompany" method="post" action="">
<table width="900px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Retailer Target Entry Form</td></tr>  
  
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
          <select name="company"  style="width: 160px; height: 28px; border-width:1px;border-color:#FF0000;">
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

      <td colspan="1">TYPE: 
          <?
           $query_sql = "SELECT distinct btype as name  FROM tbl_customer order by btype";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="type" style="width: 100px; height: 28px; border-width:1px;border-color:#FF0000;">
             <option value=""></option>
          <?
             do {  
          ?>
             <option value="<?php echo $row_sql['name'];?>" <?php if($_POST["type"]==$row_sql['name']) echo "selected";?> ><?php echo $row_sql['name']?></option>
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
 if(isset($_POST["view"])) 
  {
     $con="where tbl_customer.status<>2";
     if($_POST[sp]!='')
     {
      $con=$con." and tbl_customer.sp='$_POST[sp]'";
     }
     if($_POST[type]!='')
     {
      $con=$con." and tbl_customer.btype='$_POST[type]'";
     }
     
     
      $user_query="select tbl_customer.*,shortname as spname from tbl_customer 
                     join tbl_sp on tbl_customer.sp=tbl_sp.id
                     $con           
                     order by name asc";  
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       
 ?> 
<form name="newcompany" method="post" action="">
<table width="900px" class="hovertable" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="14">New Target Entry Form</td></tr>  
    <tr align="center">
       <td>SL</td>
       <td>Customer</td>
       <td>Jan</td>
       <td>Feb</td>
       <td>Mar</td>
       <td>Apr</td>
       <td>May</td>
       <td>Jun</td>
       <td>Jul</td>
       <td>Aug</td>
       <td>Sep</td>
       <td>Oct</td>
       <td>Nov</td>
       <td>Dec</td>
    </tr>
    <?php
      while($value=mysql_fetch_array($users))
       {
       $count=$count+1;
    ?>
    
    <tr bgcolor="#FFCCAA" align="center">    
       <td><?=$count?></td>
       <td><?=$value[name]?>:: <?=$value[id]?>:: <?=$value[btype]?></td>
       
       <input name="year" type="hidden" value="<?=$_POST[year];?>" />
       <input name="month" type="hidden" value="<?=$_POST[month];?>" />
       <input name="company" type="hidden" value="<?=$_POST[company];?>" />
       <input name="sp" type="hidden" value="<?=$_POST[sp];?>" />
       
       <input name="work[]" type="hidden" value="<?=$value['id'];?>" />
       <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" /> 
       
       <td><input type="text" size="3" value="0"  name="1[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="2[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="3[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="4[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="5[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="6[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="7[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="8[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="9[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="10[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="11[<?=$value[id];?>]" /> </td>
       <td><input type="text" size="3" value="0" name="12[<?=$value[id];?>]" /> </td>
     </tr>   
     <?php
      }// end while loop.
     ?>
      
     <tr id="trsubhead"><td colspan="14" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value="   Save  " /> </td> </tr>
</table>
</form>
<?php
   } // end total
 }// end view
 


 if(isset($_POST["sp"]))
 {
 ?>
 <table width="900px" class="hovertable" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="6">Customer Target</td></tr>  
   <tr align="center" bgcolor="#FFFF99">
      <td>SL</td>
      <td>Company</td>
      <td>Customer</td>
      <td>Year</td>
      <td>Month</td>
      <td>Target</td>
   </tr>
   
   <?php
    
      $user_query="select tbl_customer.*,tbl_retailer_target.*,tbl_company.name as comname from tbl_customer 
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
                 <td align='right'>$value[target]</td></tr>";
         $totaltarget=$totaltarget+$value[target];
         }
       
       echo "<tr align='center' id='trsubhead'>
                <td colspan='4'>Total</td>
                <td colspan='2'>".number_format($totaltarget,0)."</td>
             </tr>";
          
      }
   ?>
 </table>
<?php 
 }
?>
  
<?php
 include "footer.php";
?>

