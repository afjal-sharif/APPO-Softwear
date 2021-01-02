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

<?
if(isset($_POST["submit"]))
 { 
  if ($_POST[sp]=='')  
   {
    echo "<b> Error !! Pls give input properly</b>";
   }
  else
   { 
    for ($i=1;$i<=12;$i++)
    {
     $vi='v'.$i;
     $si='s'.$i;
     $pi='p'.$i;
     $oi='o'.$i;
     
     $sql="insert into tbl_sp_target (year,month,sp,volume,stick,placement,outlet,user) 
          value($_POST[year],$i,$_POST[sp],$_POST[$vi],$_POST[$si],$_POST[$pi],$_POST[$oi],'$_SESSION[userName]')"; 
     db_query($sql) or die (mysql_error());
    //echo "<br>";
    }
    echo "<b><img src='images/active.png' height='15px' width='15px'> Success !! Target insert successfully</b>";
   } // Error chech If
 }// Submit If
?>


<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">SP Target Entry Form</td></tr>  
  <form name="newcompany" method="post" action="">
    <tr bgcolor="#FFEE09" align="center">    
       <td> Year :
          <select name="year" style="width: 120px;">
           <option value="2013" <?php if($_POST["year"]=='2013') echo "selected";?>>2013</option>
           <option value="2014" <?php if($_POST["year"]=='2014') echo "selected";?>>2014</option>
           <option value="2015" <?php if($_POST["year"]=='2015') echo "selected";?>>2015</option>
           <option value="2016" <?php if($_POST["year"]=='2016') echo "selected";?>>2016</option>
           <option value="2017" <?php if($_POST["year"]=='2017') echo "selected";?>>2017</option>
          </select>
       </td>
   
       <td colspan="4"> SP Name:
         
          <?
           $query_sql = "SELECT id,shortname as name  FROM tbl_sp order by name";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
           <select name="sp" style="width: 250px;" id="sp_target" onchange="forms.submit()">
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
    </tr>
  
  
   
   
  
  <tr align="center" id="trsubhead">    
       <td width="20%">Month</td>
       <td width="20%">New Outlet</td>
       <td width="20%">Volume</td>
       <td width="20%">Strik Rate(%)</td>
       <td width="20%">Placement</td>
    </tr>

    
    <tr align="center">
       <td colspan="1">Jan</td>
       <td><input type="text" size="3" value="0"  name="o1" /> </td>
       <td><input type="text" size="3" value="0"  name="v1" /> </td>
       <td><input type="text" size="3" value="0"  name="s1" /> </td>
       <td><input type="text" size="3" value="0"  name="p1" /> </td>
    </tr>
    <tr align="center">
       <td colspan="1">Feb</td>
       <td><input type="text" size="3" value="0"  name="o2" /> </td>
       <td><input type="text" size="3" value="0"  name="v2" /> </td>
       <td><input type="text" size="3" value="0"  name="s2" /> </td>
       <td><input type="text" size="3" value="0"  name="p2" /> </td>
    </tr>
    <tr align="center">
       <td colspan="1">March</td>
       <td><input type="text" size="3" value="0"  name="o3" /> </td>
       <td><input type="text" size="3" value="0"  name="v3" /> </td>
       <td><input type="text" size="3" value="0"  name="s3" /> </td>
       <td><input type="text" size="3" value="0"  name="p3" /> </td>
   </tr>
  <tr align="center">
       <td colspan="1">April</td>
       <td><input type="text" size="3" value="0"  name="o4" /> </td>
       <td><input type="text" size="3" value="0"  name="v4" /> </td>
       <td><input type="text" size="3" value="0"  name="s4" /> </td>
       <td><input type="text" size="3" value="0"  name="p4" /> </td>
   </tr>
  <tr align="center">
       <td colspan="1">May</td>
       <td><input type="text" size="3" value="0"  name="o5" /> </td>
       <td><input type="text" size="3" value="0"  name="v5" /> </td>
       <td><input type="text" size="3" value="0"  name="s5" /> </td>
       <td><input type="text" size="3" value="0"  name="p5" /> </td>
   </tr>
   <tr align="center">
       <td colspan="1">June</td>
       <td><input type="text" size="3" value="0"  name="o6" /> </td>
       <td><input type="text" size="3" value="0"  name="v6" /> </td>
       <td><input type="text" size="3" value="0"  name="s6" /> </td>
       <td><input type="text" size="3" value="0"  name="p6" /> </td>
   </tr>
    <tr align="center">
       <td colspan="1">July</td>
       <td><input type="text" size="3" value="0"  name="o7" /> </td>
       <td><input type="text" size="3" value="0"  name="v7" /> </td>
       <td><input type="text" size="3" value="0"  name="s7" /> </td>
       <td><input type="text" size="3" value="0"  name="p7" /> </td>
    </tr>
    <tr align="center">
       <td colspan="1">Aug</td>
       <td><input type="text" size="3" value="0"  name="o8" /> </td>
       <td><input type="text" size="3" value="0"  name="v8" /> </td>
       <td><input type="text" size="3" value="0"  name="s8" /> </td>
       <td><input type="text" size="3" value="0"  name="p8" /> </td>
    </tr>
    <tr align="center">
       <td colspan="1">Sep</td>
       <td><input type="text" size="3" value="0"  name="o9" /> </td>
       <td><input type="text" size="3" value="0"  name="v9" /> </td>
       <td><input type="text" size="3" value="0"  name="s9" /> </td>
       <td><input type="text" size="3" value="0"  name="p9" /> </td>
   </tr>
  <tr align="center">
       <td colspan="1">Oct</td>
       <td><input type="text" size="3" value="0"  name="o10" /> </td>
       <td><input type="text" size="3" value="0"  name="v10" /> </td>
       <td><input type="text" size="3" value="0"  name="s10" /> </td>
       <td><input type="text" size="3" value="0"  name="p10" /> </td>
   </tr>
  <tr align="center">
       <td colspan="1">Nov</td>
       <td><input type="text" size="3" value="0"  name="o11" /> </td>
       <td><input type="text" size="3" value="0"  name="v11" /> </td>
       <td><input type="text" size="3" value="0"  name="s11" /> </td>
       <td><input type="text" size="3" value="0"  name="p11" /> </td>
   </tr>
   <tr align="center">
       <td colspan="1">Dec</td>
       <td><input type="text" size="3" value="0"  name="o12" /> </td>
       <td><input type="text" size="3" value="0"  name="v12" /> </td>
       <td><input type="text" size="3" value="0"  name="s12" /> </td>
       <td><input type="text" size="3" value="0"  name="p12" /> </td>
   </tr>
    
   <tr id="trsubhead"><td colspan="5" align="center"><input type="submit" name="submit" onclick="ConfirmChoice(); return false;"  value=" Save    " /> </td> </tr>
   </form>
</table>



  <div id="divsptarget">
     
  </div>

<script type="text/javascript" src="sp.js"></script>
<?php
 include "footer.php";
?>

