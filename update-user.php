<?php 
 include_once "includes/functions.php";
 include "session.php";
 
 
 if($_POST['userPassword'])
 $userPassword = md5($_POST['userPassword']);
 
 if($_POST['status'])
  $status = 1;
  else $status = 0;
  
 if($_POST['mode']=='add'){
  
  //check if this user id already used first
 $user_query = "SELECT * FROM hbl_users WHERE userName='$_POST[userName]'";
 $users = mysql_query($user_query);
 if(mysql_num_rows($users)>0){
   
   $_SESSION['msg']="User with same login already exist, try with different login!";
   header("location: manage-users.php");
 
 }else{  
  
  //now insert into database
  $uinsert_query = "INSERT INTO hbl_users (screenName,designation,userName,userPassword,status,createdDate,userType) VALUES
  ('$_POST[screenName]','$_POST[designation]','$_POST[userName]','$userPassword','$status','$global[current_time]','A')";
  db_query($uinsert_query);
  header("location: manage-users.php");
  } 
 }elseif($_POST['mode']=='update' AND is_numeric($_POST['userId'])){
   $pwd_update_q = NULL;
   if($userPassword)
    $pwd_update_q = ",userPassword='$userPassword'";   
   
   $uupdate_query = "UPDATE hbl_users SET screenName='$_POST[screenName]',userName='$_POST[userName]',designation='$_POST[designation]',status='$status',createdDate='$global[current_time]' $pwd_update_q WHERE id=$_POST[userId]";
    db_query($uupdate_query);
   $_SESSION['msg']="User info successfully updated !";
   header("location: manage-users.php"); 
 
 }elseif($_GET['mode']=='delete' AND is_numeric($_GET['userId'])){
   $udelete_query = "DELETE FROM hbl_users WHERE id=$_GET[userId]";
   db_query($udelete_query);
   $_SESSION['msg']="User successfully deleted !";
   header("location: manage-users.php");   
 }

	
?>
