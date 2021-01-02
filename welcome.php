<?php
 session_start();
 include "includes/functions.php";
 $msgmenu="Home";
 include "session.php";  
 include "header.php";
 $_SESSION[constatus]='';
 $msg=$_GET[message];
 echo $msg ;
 echo "<br>";
 ?>
 
 
 <table width="960px" align="center"  bgcolor="#FFFFFF" background="images/bg.png" border="0" bordercolor="#FFFFFF" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
  <tr> 
  <tr align="center" ><td> 
     <p style="font-family: Tangerine,verdana,Palatino Linotype; font-size:15px;color:#C3311A;">
     <b><?=$global['site_name']?></b></p>
  </td>
  </tr>
 </table>
 

 <!--
 <table id="details" width="960px" align="center" bordercolor="#FF0000" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">   
     
     <tr id="trhead">
      <td colspan='2'>
         System Transection Date
      </td>
   </tr>
    
     <tr bgcolor="#FDE1B2">    
       <td>
          Active Date : <? echo date("d-M-Y", strtotime("$_SESSION[dtcompany]"));?> 
          
          <br><br>
          <?  
            if( $curdate==$_SESSION[dtcompany])
                {
                 echo "<img src='images/active.png'>";
                }
             else
                {
                 echo "<img src='images/inactive.png'>";
                }   
            ?> 
          
       </td>
       <?
        if(($_SESSION[userType]=='A'))
        {
         echo "<td align='center'>&nbsp;</td>";
        }
        else
        {
        echo "<td>&nbsp;</td>";
        }
       ?>
       
      </tr>     
    
     <tr bgcolor="#FFCCAA" id="trsubhead">    
       <td><? echo date("d-M-Y", strtotime("$_SESSION[dtcompany]"));?></td>
       
       
       
       <?
        if(($_SESSION[userType]=='A'))
        {
         echo "<td align='center'><a href='sys_date.php'><b>Change Date </b></a></td>";
        }
        else
        {
         echo "<td>&nbsp;</td>";
        }
       ?>
      </tr>     
      <?
        $curdate=date('Y-m-d');
      ?>      
      
     <tr bgcolor="#FFCCAA" id="trsubhead">    
       <td><?  
            if( $curdate==$_SESSION[dtcompany])
                {
                 echo "<img src='images/active.png'>";
                }
             else
                {
                 echo "<img src='images/inactive.png'>";
                }   
            ?>
       </td>
       <td> &nbsp;</td>            
     </tr>      
</table>
-->
        
        <div class="date_head">
        <br>
          <font color="#000000" size="2px"><b>System Transection Date</b></font>  
        </div>
        <div class="date_bg">
          <br>
          <?  
            if( $curdate==$_SESSION[dtcompany])
                {
                 echo "<img src='images/dt_active.png' height='40px' width='50px'>";
                }
             else
                {
                 echo "<img src='images/dt_wrong.png' height='40px' width='50px'>";
                }   
            ?>
          <br><br> 
          
          <font color="#000000" size="4px"><b><? echo date("l M  Y", strtotime("$_SESSION[dtcompany]"));?></b></font>
          
          <br>
             <font color="#FF0000" size="7"><b><i><? echo date("d", strtotime("$_SESSION[dtcompany]"));?></i></b></font>
          <br>
          <?
           if(($_SESSION[userType]=='A'))
           {
             echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='sys_date.php'>Change Date</a>";
             echo "<br><br>";
             echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='update_stock.php' target='_blank'><b>UPDATE STOCK</b></a>";
             
           }
          ?>
        </div>



   <br>
   
   <!--
 <table id="details" width="900px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">Pending Discussion.....</td></tr> 

   <tr bgcolor="#FFCCAA">
       <td>Customer</td>
       <td>Company</td>
       <td>Discussion</td>
       <td>Alarm Date</td>
       <td>Status</td>
       <td>Action</td>
      </tr>     
  
   <?
       $concustomer=" where tbl_discussion.type=0 and comtype=0 and acknow=0";
       $concompany=" where tbl_discussion.type=1 and comtype=0 and acknow=0";
 
       $user_query_customer="select tbl_discussion.id, tbl_customer.name as customer,'' as company,tbl_customer.address,discussion,alarmdate,acknow
                    from tbl_discussion 
                    join tbl_customer on tbl_customer.id=tbl_discussion.customer $concustomer order by tbl_discussion.alarmdate asc"; 
       $users_customer = mysql_query($user_query_customer);
       $total_customer = mysql_num_rows($users_customer);
       
       $user_query_company="select tbl_discussion.id, tbl_company.name as company,'' as customer,tbl_company.address,discussion,alarmdate,acknow
                    from tbl_discussion 
                    join tbl_company on tbl_company.id=tbl_discussion.company  $concompany order by tbl_discussion.alarmdate asc"; 
       $users_company = mysql_query($user_query_company);
       $total_company = mysql_num_rows($users_company);
       
            
      if ($total_customer>0)
      {
       while($value=mysql_fetch_array($users_customer))
       {
       ?>     
       <tr>
          <td><?=$value[customer];?></td>
          <td><?=$value[company];?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[alarmdate];?></td>  
          <? if($value[acknow]==0)
                   {
                    echo "<td>Pending</td>";
                    echo "<td>";
                    ?>
                    <A HREF=javascript:void(0) onclick=window.open('editDiscussion.php?smsId=<?=$value[id];?>','Accounts','width=800,height=450,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit WO Requset Info">
                         <img src="images/edit.png" size="20px" width="20px" title="Edit Request"></a></td>
                   <? 
                   }
                 else
                   {echo "<td bgcolor='#ffee09'>Done</td><td>&nbsp;</td>";}
                   
              ;?>
                 
       </tr>
       <?
       }
      }
      
     
      if ($total_company>0)
      {
       while($value=mysql_fetch_array($users_company))
       {
       ?>     
       <tr>
          <td><?=$value[customer];?></td>
          <td><?=$value[company];?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[alarmdate];?></td>    
          <? if($value[acknow]==0)
                   {
                    echo "<td>Pending</td>";
                    echo "<td>";
                    ?>
                    <A HREF=javascript:void(0) onclick=window.open('editDiscussion.php?smsId=<?=$value[id];?>','Accounts','width=800,height=450,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit WO Requset Info">
                         <img src="images/edit.png" size="20px" width="20px" title="Edit Request"></a></td>
                   <? 
                   }
                 else
                   {echo "<td bgcolor='#ffee09'>Done</td><td>&nbsp;</td>";}
                   
              ;?>
       </tr>
       <?
       }
      }  
   ?>
 </table>  
 
 -->
 
  
   <?
       
       $concompany=" where tbl_discussion.comtype=1 and acknow=0";
        
       $user_query_company="select tbl_discussion.id,discussion,alarmdate,acknow,user,date_time
                    from tbl_discussion 
                    $concompany order by tbl_discussion.date_time asc"; 
       $users_company = mysql_query($user_query_company);
       $total_company = mysql_num_rows($users_company);
       
            
      if ($total_company>0)
      {
      $count=1;
   ?>
 <table id="details" width="900px" align="center" bordercolor="#AACCBB" border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="5">Notes....</td></tr> 
   <tr align="center">
       <td>Sl No</td>
       <td>Post Date</td>
       <td>Discussion</td>
       <td>Add By</td>
       <td>Action</td>
   </tr>       
            
   <?    
       while($value=mysql_fetch_array($users_company))
       {
       ?>     
       <tr align="center">
          <td><?=$count;?></td>
          <td><? echo date("Y-m-d", strtotime("$value[date_time]"));?></td>
          <td><?=$value[discussion];?></td>
          <td><?=$value[user];?></td>
          <? if($value[acknow]==0)
                   {
                    
                    echo "<td>";
                    ?>
                    <A HREF=javascript:void(0) onclick=window.open('editDiscussion.php?smsId=<?=$value[id];?>','Accounts','width=800,height=450,menubar=no,status=no,location=no,toolbar=no,scrollbars=yes') title="Edit WO Requset Info">
                         <img src="images/edit.png" size="20px" width="20px" title="Edit Request"></a></td>
                   <? 
                   }
                 else
                   {echo "<td>&nbsp;</td>";}
                   
           ;?>                   
       </tr>
       <?
       $count=$count+1;
       }
       echo "</table>"; 
      }     
   ?> 
 <?php
 include "footer.php";
?> 
 

