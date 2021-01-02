<?php
 session_start();
 $mnuid=102;
 include "includes/functions.php";
 $msgmenu="Employee List";
 include "session.php";  
 include "header.php";
  ?>
  
<?

   if(@checkmenuaccess($mnuid))
    {
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">View Employee List</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td colspan="1"> Name: <input type="text"  name="name"  size="20"  value="<? if($_POST[view]){ echo $_POST[name];}  ?>" /> </td>
       <td>Emp.ID:<input type="text" value="<? if($_POST[view]){ echo $_POST[code];}  ?>"  size="10" name="code" /> </td>
       <td colspan="1">   
        Current Status:
         <select name="status"  style="width: 80px;">
            <option value=""></option>
            <option value="Continue" <?php if($_POST["status"]=='Continue') echo "selected";?>>Continue</option>
            <option value="Hold" <?php if($_POST["status"]=='Hold') echo "selected";?>>Hold</option>
            <option value="Left" <?php if($_POST["status"]=='Left') echo "selected";?>>Left</option>
            <option value="Retaired" <?php if($_POST["status"]=='Retaired') echo "selected";?>>Retaired</option>
          </select>           
        </td>   
        <td colspan="1">
        OT:
         <select name="ot"  style="width: 80px;">
            <option value=""></option>
            <option value="0" <?php if($_POST["ot"]=='0') echo "selected";?>>NO</option>
            <option value="1" <?php if($_POST["ot"]=='1') echo "selected";?>>YES</option>
          </select>           
        </td>
        
         <td>Grade: 
         <select name="grade"  style="width: 50px;">
            <option value=""></option>
            <option value="A" <?php if($_POST["grade"]=='A') echo "selected";?> >A</option>
            <option value="B" <?php if($_POST["grade"]=='B') echo "selected";?>>B</option>
            <option value="C" <?php if($_POST["grade"]=='C') echo "selected";?>>C</option>
            <option value="D" <?php if($_POST["grade"]=='D') echo "selected";?>>D</option>
            <option value="E" <?php if($_POST["grade"]=='E') echo "selected";?>>E</option>
         </select>
       </td>
      </tr>
    <tr bgcolor="#FFCCAA">   
      <td>Type: 
         <select name="type"  style="width: 100px;">
            <option value=""></option>
            <option value="Permanent" <?php if($_POST["type"]=='Permanent') echo "selected";?>>Permanent</option>
            <option value="Probition" <?php if($_POST["type"]=='Probition') echo "selected";?>>Probation</option>
            <option value="Contactual" <?php if($_POST["type"]=='Contactual') echo "selected";?>>Contactual</option>
            <option value="Intern" <?php if($_POST["type"]=='Intern') echo "selected";?>>Intern</option>
            <option value="Others" <?php if($_POST["type"]=='Others') echo "selected";?>>Others</option>
         </select>
       </td>     
       <td>
        Report:
          <?
           $query_sql = "SELECT pro_empid,per_fname,per_mname,per_lname  FROM tbl_emp_master order by pro_empid";          
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);
         ?>
           <select name="report"  style="width: 200px;">
             <option value=""></option>
         <?
             do { 
           ?>
            <option value="<?php echo $row_sql['pro_empid'];s?>" <?php if($_POST["report"]==$row_sql['pro_empid']) echo "selected";?> ><?php echo $row_sql['pro_empid']?> :: <?php echo $row_sql['per_fname'];echo "&nbsp;".$row_sql['per_mname'];echo "&nbsp;".$row_sql['per_lname']; ?></option>
         <?
               } while ($row_sql = mysql_fetch_assoc($sql));
         ?>
          </select>   
       </td>

            
       <td>Dept:
          <?
           $query_sql = "SELECT  distinct pro_department  FROM tbl_emp_master order by pro_department asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="department" style="width: 100px;">
                <option value=""></option>          
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['pro_department'];?>" <?php if($_POST["department"]==$row_sql['pro_department']) echo "selected";?> ><?php echo $row_sql['pro_department']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>    
       </td>    
       
       <td>Desg:
          <?
           $query_sql = "SELECT  distinct pro_designation  FROM tbl_emp_master order by pro_designation asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="designation" style="width: 100px;">
              <option value=""></option>         
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['pro_designation'];?>" <?php if($_POST["designation"]==$row_sql['pro_designation']) echo "selected";?> ><?php echo $row_sql['pro_designation']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>    
       </td>    
       <td>Blood Group: 
         <select name="blood"  style="width: 50px;">
            <option value=""></option>
            <option value="A+" <?php if($_POST["blood"]=='A+') echo "selected";?>>A+</option>
            <option value="A" <?php if($_POST["blood"]=='A') echo "selected";?>>A</option>
            <option value="A-" <?php if($_POST["blood"]=='A-') echo "selected";?>>A-</option>
            <option value="B+" <?php if($_POST["blood"]=='B+') echo "selected";?>>B+</option>
            <option value="B" <?php if($_POST["blood"]=='B') echo "selected";?>>B</option>
            <option value="B-" <?php if($_POST["blood"]=='B-') echo "selected";?>>B-</option>
            <option value="O+" <?php if($_POST["blood"]=='O+') echo "selected";?>>O+</option>
            <option value="O" <?php if($_POST["blood"]=='O') echo "selected";?>>O</option>
            <option value="O-" <?php if($_POST["blood"]=='O-') echo "selected";?>>O-</option>
            <option value="AB+" <?php if($_POST["blood"]=='AB+') echo "selected";?>>AB+</option>
            <option value="AB-" <?php if($_POST["blood"]=='AB-') echo "selected";?>>AB-</option>
          </select>
       </td>
       </tr>
    <tr id="trhead">
       <td colspan="5">
         <input type="submit" name="view" value= "    View    "> 
       </td> 
    </tr>
 </table>
</form>





<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="11">Display Employee List</td></tr> 

   <tr bgcolor="#FFCCAA">    
       <td>Emp ID</td>
       <td>Name</td>
       <td>Deaprtment</td>
       <td>Designation</td>
       <td>Date Of Join</td>
       <td>Current Status</td>
       <td>Grade</td>
       <td>Address</td>
       <td>OT Allow</td>
       <td>Blood</td>  
       <td>Action</td>              
   </tr>     

    <?
     if(isset($_POST["view"]))
      {
        $con='';
        if($_POST[name]!='')
         {
          $con=" per_fname like '%$_POST[name]%' or per_mname like '%$_POST[name]%' or per_lname like '%$_POST[name]%'";
         }
        if($_POST[code]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_empid like '%$_POST[code]%'" ;
           }
          else
           {
            $con=" pro_empid like '%$_POST[code]%'"; 
           } 
         } 
        if($_POST[status]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_status='$_POST[status]'"; 
           }
          else
           {
            $con="pro_status='$_POST[status]'"; 
           }
         }
         
         if($_POST[grade]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_grade='$_POST[grade]'"; 
           }
          else
           {
            $con="pro_grade='$_POST[grade]'"; 
           }
         }
         
         if($_POST[department]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_department='$_POST[department]'"; 
           }
          else
           {
            $con="pro_department='$_POST[department]'"; 
           }
         }
         
         if($_POST[designation]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_designation='$_POST[designation]'"; 
           }
          else
           {
            $con="pro_designation='$_POST[designation]'"; 
           }
         }
        
         if($_POST[type]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_type='$_POST[type]'"; 
           }
          else
           {
            $con="pro_type='$_POST[type]'"; 
           }
         }
        
         if($_POST[ot]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_ot='$_POST[ot]'"; 
           }
          else
           {
            $con="pro_ot='$_POST[ot]'"; 
           }
         }
        
         if($_POST[blood]!='')
         {
          if($con!='')
           {
            $con=$con. " and oth_blood='$_POST[blood]'"; 
           }
          else
           {
            $con="oth_blood='$_POST[blood]'"; 
           }
         }
        
        if($_POST[report]!='')
         {
          if($con!='')
           {
            $con=$con. " and pro_report='$_POST[report]'"; 
           }
          else
           {
            $con="pro_report='$_POST[report]'"; 
           }
         } 
         
            
         
         
          
        if($con!='')
           {
            $con="Where $con";
           }
         else
           {
            $con="";
           }  
        $user_query="select * from tbl_emp_master $con  order by pro_empid asc";
      }
     else
      {
        $user_query="select * from tbl_emp_master order by pro_empid asc";  
      }
      
     
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       ?>
       <tr>
          <td><?=$value[pro_empid];?></td>
          <td colspan="1"  align="center"><?=$value[per_fname];?>&nbsp;<?=$value[per_mname];?>&nbsp;<?=$value[per_lname];?> </td>
          <td><?=$value[pro_department];?></td>
          <td><?=$value[pro_designation];?></td>
          <td><?=$value[pro_join];?></td>
          <td><?=$value[pro_status];?></td>
          <td><?=$value[pro_grade];?></td>
          <td><?=$value[per_preaddress];?></td>
          <td><? if ($value[pro_ot]=='0'){echo "No";}else {echo "Yes:";}?></td>
          <td><?=$value[oth_blood];?></td>
          <td>
                <a href="emp_profile.php?SID=<?=$value['id']?>" target="_blank" title="View Profile"><img src="images/view.jpg" height="15px" width="15px"></a>
                &nbsp; | &nbsp;<A HREF=javascript:void(0) onclick=window.open('editemployee.php?smsId=<?=$value[id];?>','Accounts','width=650,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Employee Info"><img src="images/edit.png" height="15px" width="15px"></a>
         </td>          
       </tr>
       <?
         }
        }
    ?>  
  </tr>
 </table>
<?php
  }
 else
 {
  echo "<image src='images/unauth.png'><br>";
  echo "<b> Sorry !! $_SESSION[screenName] You Are Not Authorized  To Access !!--- View Employee List. ---!! </b>";
 }
 include "footer.php";
?>

