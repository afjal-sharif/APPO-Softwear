<?php
 session_start();
 $mnuid=508;
 include "includes/functions.php";
 $msgmenu="New Customer";
 include "session.php";  
 include "header.php";
 $id=$_GET[id];
?>
<script language="javascript">
function ConfirmSales()
{
answer = confirm("Are You Sure To Delete This Cash Receive.?")
if (answer !=0)
{
 window.submit();
}
}	
</script>

<?
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 


$cheque_amt = 100000 ; 
try
    {
    //echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    echo $e->getMessage();
    }
?>


<? 
 if($id==1)
 {
?>

<form name="newcompany" method="post" action="">
<table width="960px" align="center" bordercolor="#AABBCC" bgcolor="#FFFFFF"  border=2 celspacing=1 cellpadding=5 style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="6">View Existing Customer</td></tr>  
    <tr bgcolor="#FFCCAA">    
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
<form name="po" id="vendor" action="cash_process.php" method="post"> 
<table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <tr id="trhead"><td colspan="8">Display Customer List: To Receive Cash Amount</td></tr> 

 <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Name</td>
       <td>Owner & Address</td>       
       <td>Type</td>
       <td>Cash Amount</td>              
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
            $con=$con. " and codeno like '%$_POST[code]%'" ;
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
            $con=$con. " and sp='$_POST[sp]'"; 
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
            $con=$con. " and tbl_customer.type='$_POST[type]'"; 
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
            $con=$con. " and tbl_customer.btype='$_POST[btype]'"; 
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
        $user_query="select tbl_customer.*,shortname as spname from tbl_customer   
         left join tbl_sp on tbl_customer.sp=tbl_sp.id 
         $con
         order by name asc";
      }
     else
      {
        $user_query="select tbl_customer.*,shortname as spname from tbl_customer 
        left join tbl_sp on tbl_customer.sp=tbl_sp.id
         where tbl_customer.status<>2 order by name asc limit 0,0";  
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
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[owner];?>,<?=$value[address];?></td>
          <td><?=$value[type];?>, <?=$value[btype];?></td>
          <td align="center">
           <input type="text" name="cash[<?=$value[id];?>]" size="8"  value="0" />
           <input name="work[]" type="hidden" value="<?=$value['id'];?>" /> 
           <input name="skill_id[<?=$value[id];?>]" type="hidden" value="<?=$value['id'];?>" />  
          </td>
       </tr>
       <?
         }
       ?>
       <tr align="center" id="trsubhead">
             <td colspan="5">
                    <input type="hidden" name="data_type" value="cash_process">
                    <input type="submit" name="submitqry"  value=" Submit ">
             </td>
        </tr>
       
       <?  
        }
    ?>  
 </table>
 <?
 }
 elseif($id==2)
 {
 ?> 
 <table width="960px" align="center" bordercolor="#AACCBB" bgcolor="#FFFFFF"  border="1" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
   <tr id="trhead"><td colspan="6">Display Receive Amount</td></tr>
   <tr bgcolor="#F3F3F3" align="center">   
       <td>SL No</td> 
       <td>Name</td>
       <td>Owner & Address</td>       
       <td>Cash Amount</td>
       <td>Delete</td>              
 </tr>     
  
 <? 
    $user_query="select tbl_cash_temp.*,name,address,sp from tbl_cash_temp    
                 join tbl_customer on tbl_customer.id=tbl_cash_temp.cust_id 
                 where tbl_cash_temp.user='$_SESSION[userName]'
                 order by name asc";
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
          <td colspan="1"  align="center"><?=$value[name];?></td>
          <td><?=$value[sp];?>,<?=$value[address];?></td>
          <td align="right"><?=number_format($value[cash],2);?></td>
          <td>
             <a href="indelete.php?id=<?=$value['id'];?>&mode=cash_receive" title="Delete" onclick="ConfirmSales(); return false;" ><img src="images/inactive.png" height="15px" width="15px"></a>
          </td>         
       </tr>
       <?
        $totalcash=$totalcash+$value[cash];
         }
       ?>
       <tr align="center" id="trsubhead">
        <td colspan="2">Total Amount</td>
        <td colspan="2" align="right"><?=number_format($totalcash,2);?></td>
        <td>&nbsp;</td>
       </tr>
       <tr align="center" id="trsubhead">
             <td colspan="5">
                  <form name="newcash" method="post" action="process.php">
                    <input type="hidden" name="data_type" value="cash_receive">
                    <input type="submit" name="submitqry"  value=" Confirm Cash Receive ">
                  </form>  
             </td>
        </tr>
       
       <?  
        }
      
 ?>  
 </table>   
 <?
 }if($id==3)
  {
   echo "<b><img src='images/active.png'>Cash Receive Successfully.</b>";
   echo "<br><br>";
   echo "<a href='rec_cash_bulk.php?id=1'><b>Continue with cash Receive</b></a>";
  }
 
 ?>

 
 
<?php
 include "footer.php";
?>

