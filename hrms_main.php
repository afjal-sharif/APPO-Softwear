<?php
 session_start();
 $mnuid=101;
 include "includes/functions.php";
 include "session.php";  
 include "header.php";
?>

<script language="JavaScript">
function ConfirmAdd()
{
answer = confirm("Are You Sure To Add Data ?")
if (answer !=0)
{
window.submit();
}
}	



function validate_pro(thisform)
{
with (thisform)
  {
  if (validate_required(first,"Error On First Name Field!")==false){first.focus();return false;}
  //if (validate_required(middle,"Error On Middle Name Field!")==false){middle.focus();return false;}
  //if (validate_required(father,"Error On Father Field!")==false){father.focus();return false;}  
  //if (validate_required(mother,"Error On Mother Field!")==false){mother.focus();return false;}
  //if (validate_required(nominee,"Error On Nominee Field!")==false){nominee.focus();return false;}
  //if (validate_required(relation,"Error On Relationship Field!")==false){relation.focus();return false;}
  //if (validate_required(preaddress,"Error On Present Address Field!")==false){preaddress.focus();return false;}
  //if (validate_required(peraddress,"Error On Permanent Address Field!")==false){peraddress.focus();return false;}
  //if (validate_required(demo13,"Error On DOB Field!")==false){demo13.focus();return false;}
  
  
  if (validate_required(empid,"Error On Emp ID Field!")==false){empid.focus();return false;}  
  if (validate_required(designation,"Error On Designation Field!")==false){designation.focus();return false;}
  //if (validate_required(dept,"Error On Department Field!")==false){dept.focus();return false;}
  //if (validate_required(demo11,"Error On DOB Field!")==false){demo11.focus();return false;}
  
  
  //if (validate_required(child,"Error On Child Field!")==false){child.focus();return false;}
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
</script>
 
 
 
<?
   if(@checkmenuaccess($mnuid))
    {
    
    echo "$_GET[msg]";
 ?>

<script type="text/javascript" src="ddtabmenufiles/ddtabmenu.js"></script>
<link rel="stylesheet" type="text/css" href="ddtabmenufiles/ddcolortabs.css" />

<script type="text/javascript">
//SYNTAX: ddtabmenu.definemenu("tab_menu_id", integer OR "auto")
//ddtabmenu.definemenu("ddtabs1", 0) //initialize Tab Menu #1 with 1st tab selected
//ddtabmenu.definemenu("ddtabs2", 1) //initialize Tab Menu #2 with 2nd tab selected
//ddtabmenu.definemenu("ddtabs3", 1) //initialize Tab Menu #3 with 2nd tab selected
ddtabmenu.definemenu("ddtabs4", 1) //initialize Tab Menu #4 with 3rd tab selected
//ddtabmenu.definemenu("ddtabs5", -1) //initialize Tab Menu #5 with NO tabs selected (-1)
</script>
<form name="employee" action="hrms_process.php" method="post" onsubmit="return validate_pro(this)">
  
  <table width="100%" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
    <tr><td colspan="3" id="trsubhead">PERSONAL INFORMATION</td></tr>
    <tr>
      <td>First Name:* <input type="text" name="first" size="20" /> </td>
      <td>Middle Name: <input type="text" name="middle" size="20" /> </td>
      <td>Last Name: <input type="text" name="last" size="20" /> </td>
    </tr>
    <tr>
      <td colspan="3">Father: <input type="text" name="father" size="60" />&nbsp;&nbsp;
          Mother: <input type="text" name="mother" size="60" /> </td>
    </tr>
    
    <tr>
      <td colspan="3">Nominee: <input type="text" name="nominee" size="60" />&nbsp;&nbsp;
          Relationship: <input type="text" name="relation" size="15" /> </td>
    </tr>
       
       
       
    <tr>
     <td colspan="1" v-align="top">Present Address: </td>
     <td colspan="2" align="left"><textarea name="preaddress" rows="5" cols="90"></textarea></td>
    </tr>
    <tr>
      <td colspan="1" v-align="top">Permanent Address:</td>
      <td colspan="2" align="left"><textarea name="peraddress" rows="5" cols="90"></textarea></td>
    </tr>
    
    <tr>
      <td>Sex: 
          <select name="sex"  style="width: 80px;">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
      </td>
      <td colspan="1">Home Phone: <input type="text" name="home" size="15" /></td>
      <td colspan="1">Mobile: <input type="text" name="mobile" size="15" /> </td>
    </tr>
    <tr>    
       <td>
          Date of Birth :*<input type="Text" id="demo13" maxlength="15" size="10"  value="" name="demo13"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo13','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
       </td>
       <td colspan="2">
         Higest Education:<input type="text" name="education" size="60" />
       </td>  
    </tr>
  </table>


  <table width="100%" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
    <tr><td colspan="3" id="trsubhead">PROFESSIONAL INFORMATION</td></tr>
    
    <tr  id="trsubhead">
    <td colspan="2">   
        Current Status:
         <select name="status"  style="width: 100px;">
            <option value="Continue">Continue</option>
            <option value="Hold">Hold</option>
            <option value="Left">Left</option>
            <option value="Retaired">Retaired</option>
          </select>           
        </td>
        <td colspan="1">
        OT Allow:
         <select name="ot"  style="width: 80px;">
            <option value="0">NO</option>
            <option value="1">YES</option>
          </select>           
        </td>
    </tr>
  
    <tr>
      <td>Emp ID:* <input type="text" name="empid" size="20" /> </td>
      <td>Grade: 
         <select name="grade"  style="width: 80px;">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
         </select>
       </td>
      
      <td>Type: 
         <select name="type"  style="width: 100px;">
            <option value="Permanent">Permanent</option>
            <option value="Probition">Probation</option>
            <option value="Contactual">Contactual</option>
            <option value="Intern">Intern</option>
            <option value="Others">Others</option>
         </select>
       </td>     
    </tr>
    <tr>
      <td>Designation:*<input type="text" name="designation" size="20" /></td>
      <td>Department: <input type="text" name="dept" size="20" /> </td>
      <td>Section: <input type="text" name="section" size="20" /> </td>
    </tr>
    
    <tr>  
       <td>
           Joining Date :*<input type="Text" id="demo11" maxlength="15" size="10"  value="<?=date('Y-m-d')?>" name="demo11"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo11','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
       </td>
       <td>
           <?PHP
           $format = 'Y-m-d'; 
           $date = date ( $format ); 
           $date= date ( $format, strtotime ( '6 month' . $date ) ); 
          ?>
           Confirmation Date :<input type="Text" id="demo12" maxlength="15" size="10"  value="<?=$date?>" name="demo12"  onchange="javascript: document.senditem.submit()";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
       </td>
       <td>
        Reporting To:
          <?
           $query_sql = "SELECT pro_empid  FROM tbl_emp_master order by pro_empid";          
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="report"  style="width: 220px;">
         <?
             do { 
           ?>
            <option value="<?php echo $row_sql['pro_empid'];s?>" <?php if($_POST["report"]==$row_sql['pro_empid']) echo "selected";?> ><?php echo $row_sql['pro_empid']?> ::<?php echo $row_sql['per_fname'];echo "&nbsp;".$row_sql['per_mname'];echo "&nbsp;".$row_sql['per_lname']; ?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>   
       </td>
    </tr>
  </table>
   
  <br>  
  <table width="100%" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
     <tr><td colspan="4" id="trsubhead">SALARY INFORMATION.</td></tr>
     <tr>
        <td colspan="2" id="trsubhead">ADDITION</td>
        <td colspan="2" id="trsubhead">SUBSTRUCTION</td>
     </tr>
     <tr>
       <td>Basic:</td>
       <td><input type="text" name="basic" value="0" size="10" /> </td>
       <td>PF:</td>
       <td><input type="text" name="pf" value="0" size="10" /> </td>
     </tr>
     <tr>
       <td>House Rent:</td>
       <td><input type="text" name="houserent" value="0" size="10" /> </td>
       <td>Income Tax:</td>
       <td><input type="text" name="tax" value="0" size="10" /> </td>
     </tr>
     
     <tr>
       <td>Medical:</td>
       <td><input type="text" name="medical" value="0" size="10" /> </td>
       <td>Pick & Drop:</td>
       <td><input type="text" name="pickdrop" value="0" size="10" /> </td>
     </tr>
    
     <tr>
       <td>Convence</td>
       <td><input type="text" name="convence" value="0" size="10" /> </td>
       <td>Others 1</td>
       <td><input type="text" name="others1" value="0" size="10" /> </td>
     </tr>
     
     <tr>
       <td>Any Allowance</td>
       <td><input type="text" name="allowance" value="0" size="10" /> </td>
       <td>Others 2</td>
       <td><input type="text" name="others2" value="0" size="10" /> </td>
     </tr>
     
     
     
     
  </table>
 <br>   
<table width="100%" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
    <tr><td colspan="3" id="trsubhead">OTHERS INFORMATION</td></tr>
    
    <tr>
       <td>Attandance Card ID: <input type="text" name="attanid" size="20" /> </td> 
       <td>National ID: <input type="text" name="nid" size="20" /> </td>
       <td>Passport No: <input type="text" name="passport" size="20" /> </td>
    </tr>
    <tr>
      <td>Blood Group: 
         <select name="blood"  style="width: 100px;">
            <option value="A+">A+</option>
            <option value="A">A</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B">B</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O">O</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
          </select>
       </td>
      
      <td>Maritial Status: 
         <select name="marital"  style="width: 100px;">
            <option value="Un-Married">Un-Married</option>
            <option value="Married">Married</option>
          </select>
       </td>
      
      
      <td>Religion: 
         <select name="religion"  style="width: 100px;">
            <option value="Muslim">Muslim</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddist">Buddist</option>
            <option value="Cristian">Cristian</option>
            <option value="Others">Others</option>
          </select>
       </td>
    </tr>  
    <tr id="trsubhead">
     <td colspan="3">Upload Picture:
      <input type="file" size="60" name="picture"> 
    </tr>
  </table>
  <br>
   <table width="100%" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
     <tr>
       <td colspan="4" id="trsubhead">
        <input type="submit" name="submit" value= "Save Employee Master Info" />
       </td>
     </tr>
   </table>
  
  
</form>

<?php
 }
 else
 {
  echo "<image src='images/unauth.png'><br>";
  echo "<b> Sorry !! $_SESSION[screenName] You Are Not Authorized  To Access This Menu.</b>";
 }
include "footer.php";

?>
