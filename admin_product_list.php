
<?php 
include "includes/functions.php"; 
//@$cat=$_GET['category']; 
 $cat=$_REQUEST['ctype'];
 
      $user_query="select tbl_product.id as id, tbl_product_category.name as category,tbl_product.name as product,commission,punit,unit,factor 
                  from tbl_product  
                  join tbl_product_category on tbl_product.category_id=tbl_product_category.id 
                  where tbl_product_category.id=$cat
                  order by tbl_product_category.name";
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      $combo='<table width=960px align=center bordercolor=#AACCBB bgcolor=#FFFFFF  border=1 cellspacing=5 cellpadding=5 style=border-collapse:collapse;>';
      $combo=$combo.'<tr bgcolor=#FFCCAA align="center">';
      $combo=$combo.'<td>Product Category</td>';
      $combo=$combo.'<td>Product</td>';
      $combo=$combo.'<td>Unit Of Measure</td>';
      $combo=$combo.'<td>Edit</td>';
      $combo=$combo.'</tr>';    

      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
       
      $combo=$combo.'<tr align="center">';
      $combo=$combo.'<td>'.$value[category].'</td>';
      $combo=$combo.'<td>'.$value[product].'</td>';
      $combo=$combo.'<td>'.$value[punit].'</td>';
      $combo=$combo.'<td align=center><a href=indelete.php?id='.$value[id].'&mode=product><img src=images/inactive.png height=15px width=15px></a> &nbsp;&nbsp;|&nbsp;&nbsp;';
      
      $combo=$combo.'<a href=editProduct.php?smsId='.$value[id].'&mode=product, target="_blank"><img src=images/edit.png height=15px width=15px></a></td>';  
      $combo=$combo."</tr>";
	     }
	     }
  	  echo $combo.'</table';          
?>
