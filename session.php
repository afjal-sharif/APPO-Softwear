<?php 
 session_start();
 
 $mode = $_REQUEST['mode'];



 
 if($_SESSION['userName']==''){ 
 
 if(isset($_POST['user'])){
 
 
 
   $user = $_REQUEST['user'];
   $userpwd = $_REQUEST['userpwd'];
   
   
   
   
     if(!empty($user) AND !empty($userpwd) AND $mode=='login')
     {
      $encpasswd = md5($userpwd);
      //$user = mysql_real_escape_string($user);

      $query = "SELECT * FROM hbl_users WHERE (userName='$user') and (userPassword='$encpasswd') AND status='1'";  
      $user_result = safe_query($query);
      if($user = mysql_fetch_assoc($user_result))
      {
       $_SESSION['userId'] = $user['id'];
       $_SESSION['userName'] = $user['userName'];
       $_SESSION['screenName'] = $user['screenName'];
       $_SESSION['userType'] = $user['userType'];     
       $_SESSION['cust_id'] = $user['cust_id']; 
       $_SESSION['super_admin'] = $user['superAdmin'];  
       
       
            // For Date Validation 
      $user_query="select * from tbl_sys_date";
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $_SESSION[dtcompany]=$row_sql[receive];
      $_SESSION['dtcustomer']=$row_sql[sales];
      $_SESSION['dttransection']=$row_sql[cash];
 
       
     
     // For User Access Log..  
      $user_query="Select max(tid)+1 as tid from tbl_user_access"; 
      $users = mysql_query($user_query);
      $row_sql= mysql_fetch_assoc($users);
      $tid=$row_sql[tid];
      
      $_SESSION[tid]=$tid;
      if(is_null($tid))
      {
      $tid=1;
      }
      $ipaddress= $_SERVER['REMOTE_ADDR'];
      $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
      
       
    ob_start(); // Turn on output buffering 
    system('ipconfig /all'); //Execute external program to display output 
    $mycom=ob_get_contents(); // Capture the output into a variable 
    ob_clean(); // Clean (erase) the output buffer 
 
    $findme = "Physical"; 
    $pmac = strpos($mycom, $findme); // Find the position of Physical text 
    $mac=substr($mycom,($pmac+36),17); 
     
      $sql="insert into tbl_user_access(tid,ip,mac,pcname,user)values($tid,'$ipaddress','$mac' ,'$hostname','$_SESSION[userName]')";
      db_query($sql);  
      // End User Access Log.
                      
      }else{  
        $msg = "UnAthorized Access, Please Login!!!";
        header("location: login.php?message=$msg");
      }
      
     }else{        
        $msg = "Something going wrong, Please Login!!!";
        header("location: login.php?message=$msg");     
     }
     
 }else{
  
  $msg = "Session Time Out/Unathorized Access, Please Login!";
  header("location: login.php?message=$msg");
 
 }
 	 
 }elseif($mode=='logout'){
     
      $date=date('Y-m-d H:i:s T');
      $sql="update tbl_user_access set  out_time='$date' where tid=$_SESSION[tid]";
      db_query($sql);
     
      session_destroy();
 
       $_SESSION['userId'] ='';
       $_SESSION['userName'] ='';
       $_SESSION['screenName'] = '';
       $_SESSION['userType'] = '';     
       $_SESSION['cust_id'] = ''; 
       $_SESSION['super_admin'] ='';  
     
      $msg = "Your have successfully logged out!";
      header("location: login.php?message=$msg");  
}

 function checkaccess($scriptname){
  global $adminFiles;
  if(is_numeric($key = array_search($scriptname,$adminFiles)) && $_SESSION['userType']=='A')
  return true;
  else{
    $msg = "UnAthorized Access!";
    header("location: welcome.php?message=$msg");
  }       
 }
 
 function checkmenuaccess($mnuid)
 {
  $user_query="select menuid from tbl_user_menu where menuid='$mnuid' and userid='$_SESSION[userId]'";
  $users = mysql_query($user_query);
  $row_sql= mysql_fetch_assoc($users);
  $menuid=$row_sql[menuid];
     
  if($menuid<>'')
  return true;

  else{
    header("location: no_access.php");
  }       
 } 
 
 
?>
