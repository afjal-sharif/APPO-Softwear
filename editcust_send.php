<?php
 session_start();
 include "includes/functions.php";
 include "session.php";  
?>  
<html>
<head>
  <title><?=$global['site_name']?></title>
  
  <script src="./js/code_regen.js"></script> 
  <link href="skin.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="datetimepicker_css.js"></script>


<?php
$datePicker=true; 
date_default_timezone_set('Asia/Dacca');
if($datePicker){

?>
  
	<link rel="stylesheet" href="css/datepicker.css" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/datepicker.js"></script>

	
	<script type="text/javascript">
	$(document).ready(function() {

      	$('#dtfrom').DatePicker({
      	format:'Y-m-d',
      	date: $('#dtfrom').val(),
      	current: $('#dtfrom').val(),
      	starts: 1,
      	position: 'bottom',
      	onBeforeShow: function(){
      		$('#dtfrom').DatePickerSetDate($('#dtfrom').val(), true);
      	},
      	onChange: function(formated, dates){
      		$('#dtfrom').val(formated);
      	}
      });
      
      	$('#dtto').DatePicker({
      	format:'Y-m-d',
      	date: $('#dtto').val(),
      	current: $('#dtto').val(),
      	starts: 1,
      	position: 'bottom',
      	onBeforeShow: function(){
      		$('#dtto').DatePickerSetDate($('#dtto').val(), true);
      	},
      	onChange: function(formated, dates){
      		$('#dtto').val(formated);
      	}
      });
                  

 });
</script>
<?
}
?>

</head>
<body bgcolor="#FFFFFF" width="1000px" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
 <?
 $flag=false;
  if(isset($_POST["submit"]))
   {
    $id=$_POST[id];
    $sql="update tbl_statment_send set receive_date='$_POST[demo12]',remarks='$_POST[remarks]',status='$_POST[status]',
        receive_user='$_SESSION[userName]'
        where id=$id";
    db_query($sql) or die (mysql_error());
    $flag=true;  
     ?>
     <script type="text/javascript"> 
         opener.location.reload(); 
         window.close(); 
    </script> 
 <?    
   }
 ?>


 <? 
   $id=$_GET[smsId];
   $user_query="SELECT  tbl_statment_send.id,cid,name,pdate,fdate,edate,receive_date,tbl_statment_send.remarks,tbl_statment_send.status
                           FROM tbl_statment_send
                           join tbl_customer on tbl_statment_send.cid=tbl_customer.id where tbl_statment_send.id=$id";
   $users = mysql_query($user_query);
   $total = mysql_num_rows($users);
   $value=mysql_fetch_array($users);
   $flagsms=$value[sms];
  if (($total>0) and ($flag==false))
   { 
    ?>
  <form name="vendor" id="vendor" action="" method="post">
    <table bgcolor="#FFEEFF" width="80%"  border="2" cellspacing="1" cellpadding="5" align="left" style="border-collapse:collapse;">
      <tr><td colspan="2" bgcolor="#FFFFCC"><b>Customer Statement Update Status</b></td></tr>
      
      <tr bgcolor="#FFFFCC" align="center" id="trsubhead">    
         <td width=25%>Customer:</td>
         <td><input type="text"  name="name" size="50"  value="<?=$value['name'];?>"></td>
      </tr>
      <input type="hidden" name="id" value=<?=$value[id];?>>
   
     <tr  align="center"> 
       <td>Send Date </td>
       <td><?=$value['pdate'];?></td>
      </tr>

     <tr  align="center"> 
       <td>Stat Date </td>
       <td><?=$value['fdate'];?> :: <?=$value['edate'];?></td>
    </tr>
    
    <tr  align="center"> 
       <td>Receive Date </td>
       <td>
         <input type="Text" id="demo12" maxlength="15" size="15" value="<?=$value[receive_date]?>" name="demo12";>
           <a href="javascript: NewCssCal('demo12','yyyymmdd','dropdown')"> 
           <img src="images/cal.gif" width="16" height="15" alt="Pick a date"></a>
       </td>
    </tr>
    
       
    
      <tr  align="center"> 
       <td>Remarks</td>
       <td><input type="text"  name="remarks" size="50"  value="<?=$value['remarks'];?>"></td>
      </tr>
    
      <tr  align="center"> 
        <td>Status</td>
        <td>
          <select name="status"  style="width: 180px;">
              <option value="0" <? if($value[status]==0) echo "SELECTED"; ?>>Not Receive Customer</option>
              <option value="1" <? if($value[status]==1) echo "SELECTED"; ?>>Receive Customer Feedback</option>
              <option value="2" <? if($value[status]==2) echo "SELECTED"; ?>>Cancel</option>
          </select> 
        </td>
       </tr>

  
      </table>
 
 
    <table width="80%"  border="1" cellspacing="1" bgcolor="#FFCCEE" cellpadding="5" align="left" style="border-collapse:collapse;">
       <tr align="center">
        <td id="trhead"><input type="submit" name="submit" value="  Update  "></td>
       </tr> 
     </table>
    </form>
    
    <script>
       makePhoneticEditor('bangla'); //pass the textarea Id
    </script>

    
    
   <?}
   else
    {
      if($flag==true)
       {
        echo " <b>Update Successfully $msg</b>.<br><br><br><br>";
       ?>
         <A HREF=javascript:void(0) onclick=window.close() title="Edit"><b>Click Here To Close </b></a>
       <? 
        
       }
    }
   
   ?>   
</body>
</html>
