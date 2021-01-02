
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
 if($cat!='')
  {
 
      $user_query="SELECT * from tbl_sp_target where sp=$cat
                               order by year desc,month asc limit 0,12";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      $combo='<table width=960px align=center bordercolor=#AACCBB bgcolor=#FFFFFF  border=1 cellspacing=5 cellpadding=5 style=border-collapse:collapse;>';
      $combo=$combo.'<tr bgcolor=#FFCCAA align="center">';
      $combo=$combo.'<td>Year</td>';
      $combo=$combo.'<td>Month</td>';
      $combo=$combo.'<td>New Outlet</td>';
      $combo=$combo.'<td>Volume</td>';
      $combo=$combo.'<td>Strick</td>';
      $combo=$combo.'<td>Placement</td>';
      $combo=$combo.'<td>&nbsp;</td>';
      $combo=$combo.'</tr>';    

      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       
      $combo=$combo.'<tr align="center">';
      $combo=$combo.'<td>'.$value[year].'</td>';
      $combo=$combo.'<td>'.$value[month].'</td>';
      $combo=$combo.'<td>'.$value[outlet].'</td>';
      $combo=$combo.'<td>'.$value[volume].'</td>';
      $combo=$combo.'<td>'.$value[stick].' %</td>';
      $combo=$combo.'<td>'.$value[placement].'</td>';
      $combo=$combo."<td><A HREF=javascript:void(0) onclick=window.open('edittarget.php?smsId=".$value[id]."')>";
      $combo=$combo.'<img src=images/edit.png width=15px height=15px></a></td>';  
      $combo=$combo."</tr>";
	     }
	     }
  	  echo $combo.'</table>';
  }              
?>
