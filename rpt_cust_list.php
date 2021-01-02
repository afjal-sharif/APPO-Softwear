<?php
 session_start();
 $mnuid=508;
 include "includes/functions.php";
 $msgmenu="New Customer";
 include "session.php";  
 include "header.php";
  ?>
  

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">View Existing Customer</td></tr>  
    <tr bgcolor="#FFCCAA">    
       <td colspan="1"> Name: <input type="text"  name="name"  size="20"  value="<? if($_POST[view]){ echo $_POST[name];}  ?>" /> </td>
       <td> Code No:<input type="text" value="<? if($_POST[view]){ echo $_POST[code];}  ?>"  size="10" name="code" /> </td>
              
       <td>SP:
         

          <?
           $query_sql = "SELECT id as sp,shortname  FROM tbl_sp  order by shortname asc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="sp" style="width: 100px;">       
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['sp'];?>" <?php if($_POST["sp"]==$row_sql['sp']) echo "selected";?> ><?php echo $row_sql['shortname']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>    
       </td>   
       
       <td>
        Type:
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=2 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="type" style="width: 100px;">          
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["type"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
   
        <td>
       Business Type:
       <?
           $query_sql = "SELECT  area_name  FROM tbl_area where status=4 order by area_name desc";
           $sql = mysql_query($query_sql) or die(mysql_error());
           $row_sql = mysql_fetch_assoc($sql);
           $totalRows_sql = mysql_num_rows($sql);    
          ?>
         
         <select name="btype" style="width: 100px;">          
             <option value=""></option>   
              <?
             do {  
             ?>
             <option value="<?php echo $row_sql['area_name'];?>" <?php if($_POST["btype"]==$row_sql['area_name']) echo "selected";?> ><?php echo $row_sql['area_name']?></option>
          <?
               } while ($row_sql = mysql_fetch_assoc($sql));
          ?>
         </select>  
     </td>
       
        
       <td>
         <input type="submit" name="view" value= "  View  "> 
       </td> 
  </tr>
 </table>
</form>





<!--  Company Info Details Here -->
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="10">Display Existing Customer List</td></tr> 

   <tr bgcolor="#FFCCAA" align="center">    
       <td>SL</td>
       <td>ID</td>
       <td>Name</td>
       <td>Owner & Address</td>       
       <td>Mobile</td>
       <td>Mobile 2</td>
       <td>Type</td>
       <td>SP Name</td>
       <td>Remarks</td>
       <td>Company</td>
       <td>Action</td>              
      </tr>     
    <?
     if(isset($_POST["view"]))
      {
        $con='';
        if($_POST[name]!='')
         {
          $con=" name like '%$_POST[name]%'";
         }
        if($_POST[code]!='')
         {
          if($con!='')
           {
            $con=$con. " or codeno like '%$_POST[code]%'" ;
           }
          else
           {
            $con=" codeno like '%$_POST[code]%'"; 
           } 
         } 
        if($_POST[sp]!='')
         {
          if($con!='')
           {
            $con=$con. " or sp='$_POST[sp]'"; 
           }
          else
           {
            $con="sp='$_POST[sp]'"; 
           }
         }
        
        if($_POST[type]!='')
         {
          if($con!='')
           {
            $con=$con. " or tbl_customer.type='$_POST[type]'"; 
           }
          else
           {
            $con="tbl_customer.type='$_POST[type]'"; 
           }
         } 
         
        if($_POST[btype]!='')
         {
          if($con!='')
           {
            $con=$con. " or tbl_customer.btype='$_POST[btype]'"; 
           }
          else
           {
            $con="tbl_customer.btype='$_POST[btype]'"; 
           }
         } 
        
          
          
          
        if($con!='')
           {
            $con="Where $con and tbl_customer.status<>2";
           }
         else
           {
            $con=" where tbl_customer.status<>2";
           }  
        $user_query="select tbl_customer.*,shortname as spname,tbl_company.name as company from tbl_customer   
                     left join tbl_sp on tbl_customer.sp=tbl_sp.id 
                     left join tbl_company on tbl_company.id=tbl_customer.com_id
                     $con
                     order by name asc";
      }
     else
      {
        $user_query="select tbl_customer.*,shortname as spname,tbl_company.name as company from tbl_customer 
                     left join tbl_sp on tbl_customer.sp=tbl_sp.id
                     left join tbl_company on tbl_company.id=tbl_customer.com_id
                     where tbl_customer.status<>2 order by name asc";  
      }
      
     
      $users = mysql_query($user_query);
      $total = mysql_num_rows($users);    
      if ($total>0)
      {
       while($value=mysql_fetch_array($users))
       {
        $count=$count+1;
       ?>
       <tr align="center">
          <td><?=$count;?></td>
          <td><?=$value[codeno];?></td>
          <td colspan="1"  align="left"><a href="cust_profile.php?SID=<?=$value['id']?>" target="_blank" title="View Profile"><?=$value[name];?></a></td>
          <td><?=$value[owner];?>,<?=$value[address];?></td>
          <td><?=$value[mobile];?></td>
          <td><?=$value[tnt];?></td>
          <td><?=$value[type];?>, <?=$value[btype];?></td>
          <td><?=$value[spname];?></td>
          <td><?=$value[remarks];?></td>
          <td><?=$value[company];?></td>
          <td><A HREF=javascript:void(0) onclick=window.open('editcustomer.php?smsId=<?=$value[id];?>','Accounts','width=650,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit Customer Info"><img src="images/edit.png" height="15px" width="15px"></a></td>          
       </tr>
       <?
         }
        }
    ?>  
 </table>
<?php
 include "footer.php";
?>

