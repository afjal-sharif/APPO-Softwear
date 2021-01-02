<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
 //include "rptheader.php";
 $SID=$_REQUEST['SID'];
 $con="where id=$SID";
?>
<link href="skin.css" rel="stylesheet" type="text/css" />
<table width="70%" align="center" border="1"  cellspacing="2" cellpadding="5" style="border-collapse:collapse;">
<?             
   $user_query="Select * from tbl_emp_master  $con";     
   $users = mysql_query($user_query);
   while($value=mysql_fetch_array($users)){ 
?>    
 <tr><td colspan="2" height="30px" align="center"><IMG  alt="logo" src="images/logo.png"  border=0></td></tr>
 <tr><td colspan="2" height="10px" id="dealer" align="left" bgcolor="#FFCC00"><b>EMP ID: <?=$value[pro_empid];?></b></td></tr>
 <tr><td colspan="2" height="10px" align="left" bgcolor="#FFCC00"><?=$value[per_fname];?>&nbsp;<?=$value[per_mname];?>&nbsp;<?=$value[per_lname];?></td></tr>
 
 
 <tr><td colspan="2" height="10px" align="center" bgcolor="#FFCC09"><b>PROFESSIONAL INFORMATION</b></td></tr> 
 <tr>
     <td align="right">
       <table width="100%" align="center" border="1" cellspacing="2" cellpadding="5" style="border-collapse:collapse;">
          <tr>
             <td align="left">Department:</td><td align="left"><b><?=$value['pro_department'];?></b></td>
             <td align="left">Section:</td><td align="left"><?=$value['pro_section'];?></td>
          </tr>
          <tr>
             <td align="left">Desegnation:</td><td align="left"><?=$value['pro_designation'];?></td>
             <td align="left">Date Of Join:</td><td align="left"><?=$value['pro_join'];?></td>
          </tr>
          
          <tr>
             <td align="left">Status:</td><td align="left"><?=$value['pro_status'];?></td>
             <td align="left">Grade:</td><td align="left"><?=$value['pro_grade'];?></td>
          </tr>
          
          <tr>
             <td align="left">Type:</td><td align="left"><?=$value['pro_type'];?></td>
             <td align="left">OT Allow:</td><td align="left"><? if ($value[pro_ot]=='0'){echo "<b>No</b>";}else {echo "<b>Yes</n>";}?></td>
          </tr>
         
          <tr>
             <td align="left">Date Of Confirmation:</td><td align="left"><?=$value['pro_confirm'];?></td>
             <td align="left">Report To:</td><td align="left"><?=$value['pro_report'];?></td>
          </tr>
     </table>
     </td>
     <td width="30%" align="center">
     <? if($value[picture]==''){?>
       <IMG  alt="No Picture" src="employee/noimage.jpg" height="150" width="140"  border="1">
       <?}else{
       ?>
       <IMG  alt="<?=$value[owner];?>" src="employee/<?=$value[picture];?>" height="150" width="140"  border="1">
       <?}?>
     </td>
 </tr>
 
 
 <tr><td colspan="2" height="10px"  align="center" bgcolor="#FFCC09"><b>PERSONAL INFORMATION</b></td></tr>
 <tr>
     <td colspan="2">
       <table width="100%" align="center" border="1" cellspacing="2" cellpadding="5" style="border-collapse:collapse;">
          <tr>
             <td align="left">Father:</td><td align="left"><?=$value['per_father'];?></td>
             <td align="left">Mother:</td><td align="left"><?=$value['per_mother'];?></td>
          </tr>
          
          <tr>
             <td align="left">Nominee:</td><td align="left"><?=$value['per_nominee'];?></td>
             <td align="left">Relationship:</td><td align="left"><?=$value['per_relation'];?></td>
          </tr>
          <tr>
             <td align="left">Present Address:</td><td align="left" colspan="3"><?=$value['per_preaddress'];?></td>  
          </tr>
          <tr>
             <td align="left">Permanent Address:</td><td align="left" colspan="3"><?=$value['per_peraddress'];?></td>  
          </tr>
          <tr>
             <td align="left">DOB:</td><td align="left"><?=$value['per_dob'];?></td>
             <td align="left">Education:</td><td align="left"><?=$value['per_education'];?></td>
          </tr>
           <tr>
             <td align="left">Sex:</td><td align="left"><?=$value['per_sex'];?></td>
             <td align="left">Phone:</td><td align="left"><?=$value['per_home'];?>,<?=$value['per_mobile'];?></td>
          </tr>
       </table>
     </td>
 </tr>
 <?
 if($_SESSION[superAdmin]==1)
 {
 ?>
 <tr><td colspan="2" height="10px"  align="center" bgcolor="#FFCC09"><b>SALARY INFORMATION</b></td></tr>
 <tr>
     <td colspan="2">
       <table width="100%" align="center" border="1" cellspacing="2" cellpadding="5" style="border-collapse:collapse;">
          <tr id="trsubhead" align="center">
            <td colspan="2">ADDITION</td>
            <td colspan="2">SUBSTRUCTION</td>
          </tr>
          <tr>
             <td align="left">BASIC:</td><td align="left"><?=$value['sal_ad_basic'];?></td>
             <td align="left">PF:</td><td align="left"><?=$value['sal_de_pf'];?></td>
          </tr>
          <tr>
             <td align="left">House Rent:</td><td align="left"><?=$value['sal_ad_house'];?></td>
             <td align="left">Income Tax:</td><td align="left"><?=$value['sal_de_tax'];?></td>
          </tr>
          <tr>
             <td align="left">Medical:</td><td align="left"><?=$value['sal_ad_medical'];?></td>
             <td align="left">Pick & Drop:</td><td align="left"><?=$value['sal_de_pickdrop'];?></td>
          </tr>
          <tr>
             <td align="left">Convence:</td><td align="left"><?=$value['sal_ad_convence'];?></td>
             <td align="left">Others 1:</td><td align="left"><?=$value['sal_de_others1'];?></td>
          </tr>
          
          <tr>
             <td align="left">Allowance:</td><td align="left"><?=$value['sal_ad_allowance'];?></td>
             <td align="left">Others 2:</td><td align="left"><?=$value['sal_de_others2'];?></td>
          </tr>
          
          <tr>
             <td align="left">Total:</td><td align="left"><?=number_format($value['sal_ad_allowance']+$value['sal_ad_convence']+$value['sal_ad_medical']+$value['sal_ad_house']+$value['sal_ad_basic'],2);?></td>
             <td align="left">Total:</td><td align="left"><?=number_format($value['sal_de_others2']+$value['sal_de_others1']+$value['sal_de_pickdrop']+$value['sal_de_tax']+$value['sal_de_pf'],2);?></td>
          </tr>
      
          <tr bgcolor="#FFEE09">
      
             <td align="left">Net Salary:</td><td align="center" colspan="3"><?=number_format(($value['sal_ad_allowance']+$value['sal_ad_convence']+$value['sal_ad_medical']+$value['sal_ad_house']+$value['sal_ad_basic'])-($value['sal_de_others2']+$value['sal_de_others1']+$value['sal_de_pickdrop']+$value['sal_de_tax']+$value['sal_de_pf']),2);?></td>
          </tr>
          
          
       </table>
     </td>
 </tr>
<?PHP
 }
?>
 


 <tr><td colspan="2" height="10px"  align="center" bgcolor="#FFCC09"><b>OTHERS INFORMATION</b></td></tr>
 <tr>
     <td colspan="2">
       <table width="100%" align="center" border="1" cellspacing="2" cellpadding="5" style="border-collapse:collapse;">
          <tr>
             <td align="left">Attandance ID:</td><td align="left"><?=$value['oth_attanid'];?></td>
             <td align="left">National ID:</td><td align="left"><?=$value['oth_nid'];?></td>
          </tr>
          <tr>
             <td align="left">Marital Status:</td><td align="left"><?=$value['oth_marital'];?></td>
             <td align="left">religion:</td><td align="left"><?=$value['oth_religion'];?></td>
          </tr>
          <tr>
             <td align="left">Passport:</td><td align="left"><?=$value['oth_passport'];?></td>
             <td align="left">Blood Group:</td><td align="left"><?=$value['oth_blood'];?></td>
          </tr>
       </table>
     </td>
 </tr>
  
<?
}
?>      
</table>  
