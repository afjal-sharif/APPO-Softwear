<?php
include  "includes/functions.php";
include "session.php"; 
if (empty($_POST[first])) 
   {
       $msg="<img src='images/inactive.png' height='15px' width='15px'><b> Error !! Pls give input properly</b>";
       header("location:hrms_main.php?message=$msg");
   }
  else
   {
     $empid=$_POST[empid];
     $doj=$_POST[demo11];
     $status=$_POST[status];
     $type=$_POST[type];
     $grade=$_POST[grade];
     $designation=$_POST[designation];
     $dept=$_POST[dept];
     $section=$_POST[section];
     $doc=$_POST[demo12];
     $report=$_POST[report];
     $ot=$_POST[ot];
     
          
     $fname=$_POST[first];
     $mname=$_POST[middle];
     $lname=$_POST[last];
     $father=$_POST[father];
     $mother=$_POST[mother];
     $nominee=$_POST[nominee];
     $relation=$_POST[relation];
     $preaddress=$_POST[preaddress];
     $peraddress=$_POST[preaddress];
     $dob=$_POST[demo13];
     $sex=$_POST[sex];
     $home=$_POST[home];
     $mobile=$_POST[mobile];
     $education=$_POST[education];
     
     $basic=$_POST[basic];
     $houserent=$_POST[houserent];
     $medical=$_POST[medical];
     $convence=$_POST[convence];
     $allowance=$_POST[allowance];
     
     $pf=$_POST[pf];
     $tax=$_POST[tax];
     $pickdrop=$_POST[pickdrop];
     $others1=$_POST[others1];
     $others2=$_POST[others2];
     
     $attanid=$_POST[attanid];
     $nid=$_POST[nid];
     $passport=$_POST[passport];
     $blood=$_POST[blood];
     $marital=$_POST[marital];
     $religion=$_POST[religion];
     
     
     $sql="insert into tbl_emp_master(date,pro_empid,pro_grade,pro_type,pro_status,pro_designation,pro_department,pro_section,pro_join,pro_confirm,pro_ot,pro_report,
                       per_fname,per_mname,per_lname,per_father,per_mother,per_nominee,per_relation,per_peraddress,per_preaddress,per_dob,
                       per_sex,per_home,per_mobile,per_education,
                       sal_ad_basic,sal_ad_house,sal_ad_medical,sal_ad_convence,sal_ad_allowance,
                       sal_de_pf,sal_de_tax,sal_de_pickdrop,sal_de_others1,sal_de_others2,
                       oth_attanid,oth_nid,oth_passport,oth_blood,oth_marital,oth_religion, 
                       user) 
         value('$_SESSION[dtcustomer]','$empid','$grade','$type','$status', '$designation','$dept','$section','$doj','$doc','$ot','$report',
                     '$fname','$mname','$lname','$father','$mother','$nominee','$relation','$peraddress','$preaddress','$dob',
                     '$sex','$home','$mobile','$education',
                     '$basic','$houserent','$medical','$convence','$allowance',
                     '$pf','$tax','$pickdrop','$others1','$others2',
                     '$attanid','$nid','$passport','$blood','$marital','$religion', 
                     '$_SESSION[userName]')";     
       db_query($sql) or die(mysql_error());   
    $msg="<img src='images/active.png' height='15px' width='15px'><b>Security Information Insert Successfully.</b>";
    header("location:hrms_rpt_emp_list.php?id=$empid");
   } 
?>
