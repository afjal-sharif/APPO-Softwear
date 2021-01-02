
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
 if($cat!='')
  {
 
      $user_query="SELECT head_name,ref_id,date,remarks,deposite,withdraw FROM tbl_account_coa 
                               join tbl_coa on ref_id=tbl_coa.id
                               where tbl_account_coa.type=2  and  tbl_account_coa.ref_id=$cat 
                   order by tbl_account_coa.id desc limit 0,15";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      $combo='<table width=960px align=center bordercolor=#AACCBB bgcolor=#FFFFFF  border=1 cellspacing=5 cellpadding=5 style=border-collapse:collapse;>';
      $combo=$combo.'<tr bgcolor=#FFCCAA align="center">';
      $combo=$combo.'<td>Date</td>';
      $combo=$combo.'<td>Head</td>';
      $combo=$combo.'<td>Remarks</td>';
      $combo=$combo.'<td>Deposite</td>';
      $combo=$combo.'<td>Withdraw</td>';
      $combo=$combo.'</tr>';    

      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       
      $combo=$combo.'<tr align="center">';
      $combo=$combo.'<td>'.$value[date].'</td>';
      $combo=$combo.'<td>'.$value[head_name].'</td>';
      $combo=$combo.'<td>'.$value[remarks].'</td>';
      $combo=$combo.'<td>'.number_format($value[deposite],2).'</td>';
      $combo=$combo.'<td>'.number_format($value[withdraw],2).'</td>';  
      $combo=$combo."</tr>";
	     }
	     }
  	  echo $combo.'</table';
  }              
?>
